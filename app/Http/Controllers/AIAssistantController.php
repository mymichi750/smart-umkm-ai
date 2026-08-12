<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use League\CommonMark\CommonMarkConverter;

class AIAssistantController extends Controller
{
    public function index(Request $request)
    {
        $messages = session('ai_chat_messages', []);

        return view('ai-assistant', compact('messages'));
    }

    public function clearChat()
    {
        session()->forget('ai_chat_messages');

        return redirect()
            ->route('ai-assistant.index')
            ->with('success', 'Riwayat chat berhasil dihapus.');
    }

    public function testGemini(Request $request)
    {
        $apiKey = config('services.gemini.key');
        $model = config('services.gemini.model', 'gemini-flash-latest');

        if (blank($apiKey)) {
            return response()->json([
                'success' => false,
                'message' => 'GEMINI_API_KEY belum dikonfigurasi.',
            ], 422);
        }

        try {
            $response = Http::connectTimeout(5)
                ->timeout(15)
                ->retry(3, 750, throw: false)
                ->asJson()
                ->post('https://generativelanguage.googleapis.com/v1beta/models/' . $model . ':generateContent?key=' . $apiKey, [
                    'contents' => [
                        [
                            'parts' => [
                                ['text' => 'Balas singkat: koneksi berhasil.'],
                            ],
                        ],
                    ],
                    'generationConfig' => [
                        'temperature' => 0.2,
                    ],
                ]);

            if (! $response->successful()) {
                Log::error('Gemini API test failed', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'Koneksi ke Gemini gagal.',
                    'status' => $response->status(),
                    'body' => $response->json() ?: $response->body(),
                ], $response->status());
            }

            return response()->json([
                'success' => true,
                'message' => 'Koneksi ke Gemini berhasil.',
                'model' => $model,
                'response' => $response->json(),
            ]);
        } catch (\Throwable $exception) {
            Log::error('Gemini API test exception', [
                'message' => $exception->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi exception saat mencoba terhubung ke Gemini.',
                'error' => $exception->getMessage(),
            ], 500);
        }
    }

    public function send(Request $request)
    {
        $request->validate([
            'message' => ['required', 'string', 'max:2000'],
        ]);

        $userMessage = trim($request->input('message'));
        $messages = session('ai_chat_messages', []);

        $messages[] = [
            'role' => 'user',
            'content' => $userMessage,
            'time' => now()->format('H:i'),
        ];

        session(['ai_chat_messages' => $messages]);

       $reply = $this->generateReply($userMessage);

$converter = new CommonMarkConverter();

$reply = $converter->convert($reply)->getContent();

        $messages[] = [
            'role' => 'assistant',
            'content' => $reply,
            'time' => now()->format('H:i'),
        ];

        session(['ai_chat_messages' => $messages]);

        return response()->json([
            'reply' => $reply,
            'messages' => $messages,
        ]);
    }

    protected function generateReply(string $message): string
    {
        $apiKey = config('services.gemini.key');
        $model = config('services.gemini.model', 'gemini-flash-latest');

        if (blank($apiKey)) {
            return $this->generateFallbackReply($message);
        }

        $systemPrompt = <<<'PROMPT'
Kamu adalah Smart UMKM AI, asisten bisnis digital khusus UMKM Indonesia.

Tugas:
- Membantu analisis penjualan.
- Memberikan ide promosi.
- Membantu menentukan produk terlaris.
- Memberikan strategi pemasaran digital.
- Memberikan saran pengelolaan stok.
- Menjawab dengan bahasa Indonesia yang mudah dipahami.
- Berikan jawaban singkat, jelas, dan praktis.

Batasan ruang lingkup:
- Jawab hanya pertanyaan seputar operasional dan pengembangan UMKM: kasir, transaksi, produk, harga, stok, pelanggan, laporan, penjualan, omzet, keuntungan, promosi, dan pemasaran.
- Untuk pertanyaan di luar ruang lingkup tersebut (misalnya politik, hiburan, pelajaran umum, pemrograman, kesehatan, hukum, atau topik pribadi), jangan jawab substansinya.
- Untuk pertanyaan di luar ruang lingkup, balas persis: "Saya fokus membantu operasional dan analisis bisnis UMKM. Silakan tanyakan seputar kasir, stok, penjualan, laporan, atau promosi bisnis Anda."
PROMPT;

        $businessContext = $this->buildBusinessContext();

        $promptText = $systemPrompt . <<<PROMPT


Data bisnis aktual dari database aplikasi (gunakan sebagai satu-satunya sumber angka):
{$businessContext}

Aturan analisis:
- Gunakan data di atas saat pertanyaan berkaitan dengan penjualan, produk, omzet, atau stok.
- Jangan mengarang angka, nama produk, atau fakta yang tidak tersedia pada data.
- Bila data belum cukup, jelaskan data apa yang belum tersedia.
- Sebutkan periode data saat menyampaikan angka.
- Berikan maksimal 3 rekomendasi yang praktis dan sesuai data.

Pertanyaan pengguna: {$message}
PROMPT;

        try {
            $response = Http::connectTimeout(5)
                ->timeout(15)
                ->retry(3, 750, throw: false)
                ->asJson()
                ->post(
                    'https://generativelanguage.googleapis.com/v1beta/models/' . $model . ':generateContent?key=' . $apiKey,
                    [
                        'contents' => [
                            [
                                'parts' => [
                                    ['text' => $promptText],
                                ],
                            ],
                        ],
                        'generationConfig' => [
                            'temperature' => 0.7,
                        ],
                    ]
                );

            if (! $response->successful()) {
                Log::warning('Gemini AI request failed', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);

                return $this->generateFallbackReply($message);
            }

            $reply = data_get($response->json(), 'candidates.0.content.parts.0.text');

            return ! empty($reply)
                ? trim($reply)
                : $this->generateFallbackReply($message);
        } catch (\Throwable $exception) {
            Log::error('Gemini AI exception', [
                'message' => $exception->getMessage(),
            ]);

            return $this->generateFallbackReply($message);
        }
    }

    /**
     * Keeps the assistant useful when the external AI service is unavailable.
     */
    protected function generateFallbackReply(string $message): string
    {
        $context = json_decode($this->buildBusinessContext(), true) ?: [];
        $normalizedMessage = Str::lower($message);

        if (Str::contains($normalizedMessage, ['stok', 'persediaan'])) {
            $lowStockProducts = collect($context['stok_menipis'] ?? []);

            if ($lowStockProducts->isEmpty()) {
                return 'Stok produk aktif saat ini berada di atas batas pemantauan 5 unit. Tetap pantau stok di dashboard agar ketersediaan produk terjaga.';
            }

            $products = $lowStockProducts
                ->take(3)
                ->map(fn (array $product) => "{$product['nama']} ({$product['stok']} stok)")
                ->implode(', ');

            return "Produk yang perlu segera diperhatikan: {$products}. Prioritaskan pengadaan untuk produk dengan stok paling rendah agar penjualan tidak terhenti.";
        }

        if (Str::contains($normalizedMessage, ['terlaris', 'produk', 'penjualan', 'omzet'])) {
            $topProducts = collect($context['produk_terlaris_30_hari'] ?? []);

            if ($topProducts->isNotEmpty()) {
                $products = $topProducts
                    ->take(3)
                    ->map(fn (array $product) => "{$product['nama']} ({$product['terjual']} terjual)")
                    ->implode(', ');

                return "Berdasarkan data 30 hari terakhir, produk dengan penjualan tertinggi adalah {$products}. Fokuskan ketersediaan stok dan promosi pada produk-produk tersebut.";
            }

            return 'Belum ada data penjualan yang cukup untuk dianalisis. Setelah transaksi tercatat, saya dapat membantu membaca tren produk dan omzet Anda.';
        }

        if (Str::contains($normalizedMessage, ['promosi', 'marketing', 'pemasaran'])) {
            return 'Untuk promosi hari ini: tawarkan paket hemat untuk produk yang sering dibeli bersama, unggah foto produk terlaris ke WhatsApp atau media sosial, dan berikan promo terbatas agar pelanggan terdorong membeli sekarang.';
        }

        return 'Saya siap membantu mengolah data bisnis Anda. Anda dapat menanyakan stok yang perlu diisi, produk terlaris, analisis penjualan, atau ide promosi.';
    }

    /**
     * Mengambil agregat bisnis dari MySQL. Hanya hasil ringkas ini yang dikirim ke Gemini.
     */
    protected function buildBusinessContext(): string
    {
        $now = Carbon::now();
        $today = $now->copy()->startOfDay();
        $last7Start = $now->copy()->subDays(6)->startOfDay();
        $previous7Start = $now->copy()->subDays(13)->startOfDay();
        $previous7End = $now->copy()->subDays(7)->endOfDay();
        $last30Start = $now->copy()->subDays(29)->startOfDay();

        $salesToday = (float) Transaction::whereDate('created_at', $today)->sum('total');
        $transactionsToday = Transaction::whereDate('created_at', $today)->count();
        $salesLast7Days = (float) Transaction::whereBetween('created_at', [$last7Start, $now])->sum('total');
        $salesPrevious7Days = (float) Transaction::whereBetween('created_at', [$previous7Start, $previous7End])->sum('total');
        $salesLast30Days = (float) Transaction::whereBetween('created_at', [$last30Start, $now])->sum('total');

        $growth = $salesPrevious7Days > 0
            ? round((($salesLast7Days - $salesPrevious7Days) / $salesPrevious7Days) * 100, 1)
            : null;

        $topProducts = TransactionDetail::query()
            ->join('products', 'transaction_details.product_id', '=', 'products.id')
            ->whereHas('transaction', fn ($query) => $query->whereBetween('created_at', [$last30Start, $now]))
            ->select('products.name')
            ->selectRaw('SUM(transaction_details.quantity) as quantity_sold')
            ->selectRaw('SUM(transaction_details.subtotal) as revenue')
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('quantity_sold')
            ->limit(5)
            ->get()
            ->map(fn ($product) => [
                'nama' => $product->name,
                'terjual' => (int) $product->quantity_sold,
                'omzet' => (float) $product->revenue,
            ])
            ->values();

        $lowStockProducts = Product::query()
            ->where('active', true)
            ->where('stock', '<=', 5)
            ->orderBy('stock')
            ->limit(10)
            ->get(['name', 'stock'])
            ->map(fn ($product) => [
                'nama' => $product->name,
                'stok' => (int) $product->stock,
            ])
            ->values();

        $dailySales = Transaction::query()
            ->selectRaw('DATE(created_at) as tanggal, SUM(total) as omzet, COUNT(*) as transaksi')
            ->whereBetween('created_at', [$last7Start, $now])
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get()
            ->map(fn ($day) => [
                'tanggal' => Carbon::parse($day->tanggal)->format('d-m-Y'),
                'omzet' => (float) $day->omzet,
                'transaksi' => (int) $day->transaksi,
            ])
            ->values();

        return json_encode([
            'periode_analisis' => [
                'hari_ini' => $today->format('d-m-Y'),
                '7_hari_terakhir' => $last7Start->format('d-m-Y') . ' s.d. ' . $now->format('d-m-Y'),
                '30_hari_terakhir' => $last30Start->format('d-m-Y') . ' s.d. ' . $now->format('d-m-Y'),
            ],
            'ringkasan_penjualan' => [
                'omzet_hari_ini' => $salesToday,
                'jumlah_transaksi_hari_ini' => $transactionsToday,
                'omzet_7_hari_terakhir' => $salesLast7Days,
                'omzet_7_hari_sebelumnya' => $salesPrevious7Days,
                'pertumbuhan_7_hari_persen' => $growth,
                'omzet_30_hari_terakhir' => $salesLast30Days,
            ],
            'produk_terlaris_30_hari' => $topProducts,
            'stok_menipis' => $lowStockProducts,
            'penjualan_harian_7_hari' => $dailySales,
        ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) ?: '{}';
    }
}
