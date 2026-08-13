<?php

namespace App\Http\Controllers;

use App\Models\CashFlow;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
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
        $model = config('services.gemini.model', 'gemini-3.5-flash-lite');

        if (blank($apiKey)) {
            return response()->json([
                'success' => false,
                'message' => 'GEMINI_API_KEY belum dikonfigurasi.',
            ], 422);
        }

        try {
            $response = Http::timeout(60)
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
        $model = config('services.gemini.model', 'gemini-3.5-flash-lite');

        if (blank($apiKey)) {
            return 'Maaf, API key Gemini belum dikonfigurasi. Silakan isi GEMINI_API_KEY di file .env agar fitur AI bisa berjalan.';
        }

        $systemPrompt = <<<'PROMPT'
Kamu adalah Smart UMKM AI, asisten bisnis digital khusus UMKM Indonesia.

Tugas:
- Membantu analisis penjualan.
- Memberikan ide promosi.
- Membantu menentukan produk terlaris.
- Membantu mengenali pelanggan yang melakukan pembelian dan pola belanjanya.
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
- Data pelanggan hanya boleh digunakan untuk menjawab operasional bisnis. Jangan tampilkan email, nomor telepon, alamat, atau data sensitif pelanggan.
- Bila data belum cukup, jelaskan data apa yang belum tersedia.
- Sebutkan periode data saat menyampaikan angka.
- Berikan maksimal 3 rekomendasi yang praktis dan sesuai data.

Pertanyaan pengguna: {$message}
PROMPT;

        try {
            $response = Http::timeout(60)
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

                return 'Maaf, layanan AI saat ini sudah mencapai batas penggunaan. Anda perlu menggunakan paket premium untuk dapat mengajukan pertanyaan lagi.';
            }

            $reply = data_get($response->json(), 'candidates.0.content.parts.0.text');

            return ! empty($reply)
                ? trim($reply)
                : 'Maaf, saya belum bisa merespons permintaan Anda saat ini.';
        } catch (\Throwable $exception) {
            Log::error('Gemini AI exception', [
                'message' => $exception->getMessage(),
            ]);

            return 'Maaf, terjadi kesalahan saat menghubungkan AI. Silakan coba lagi.';
        }
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

        $customerPurchases = Customer::query()
            ->join('transactions', 'customers.id', '=', 'transactions.customer_id')
            ->whereBetween('transactions.created_at', [$last30Start, $now])
            ->select('customers.id', 'customers.name')
            ->selectRaw('COUNT(DISTINCT transactions.id) as jumlah_transaksi')
            ->selectRaw('SUM(transactions.total) as total_belanja')
            ->selectRaw('MAX(transactions.created_at) as pembelian_terakhir')
            ->groupBy('customers.id', 'customers.name')
            ->orderByDesc('total_belanja')
            ->limit(20)
            ->get();

        $customerProductRows = TransactionDetail::query()
            ->join('transactions', 'transaction_details.transaction_id', '=', 'transactions.id')
            ->join('customers', 'transactions.customer_id', '=', 'customers.id')
            ->join('products', 'transaction_details.product_id', '=', 'products.id')
            ->whereBetween('transactions.created_at', [$last30Start, $now])
            ->select('customers.id as customer_id', 'products.name as product_name')
            ->selectRaw('SUM(transaction_details.quantity) as quantity')
            ->groupBy('customers.id', 'products.id', 'products.name')
            ->orderByDesc('quantity')
            ->get()
            ->groupBy('customer_id')
            ->map(fn ($products) => $products->take(3)->map(fn ($product) => [
                'nama' => $product->product_name,
                'jumlah' => (int) $product->quantity,
            ])->values()->all());

        $customerPurchases = $customerPurchases->map(fn ($customer) => [
            'nama' => $customer->name,
            'jumlah_transaksi' => (int) $customer->jumlah_transaksi,
            'total_belanja' => (float) $customer->total_belanja,
            'pembelian_terakhir' => Carbon::parse($customer->pembelian_terakhir)->format('d-m-Y H:i'),
            'produk_dibeli' => $customerProductRows->get($customer->id, []),
        ])->values();

        $cashFlowLast30Days = CashFlow::query()
            ->whereBetween('created_at', [$last30Start, $now])
            ->select('type')
            ->selectRaw('SUM(amount) as total')
            ->groupBy('type')
            ->pluck('total', 'type');

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
            'pelanggan' => [
                'total_pelanggan_terdaftar' => Customer::count(),
                'pelanggan_bertransaksi_30_hari' => $customerPurchases->count(),
                'daftar_pelanggan_pembeli_30_hari' => $customerPurchases,
            ],
            'arus_kas_30_hari' => [
                'penambahan_dana' => (float) ($cashFlowLast30Days[CashFlow::CAPITAL] ?? 0),
                'pengeluaran_operasional' => (float) ($cashFlowLast30Days[CashFlow::EXPENSE] ?? 0),
                'pembelian_stok' => (float) ($cashFlowLast30Days[CashFlow::STOCK_PURCHASE] ?? 0),
            ],
        ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) ?: '{}';
    }
}
