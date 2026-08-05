<?php

namespace App\Http\Controllers;

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

    public function testGemini(Request $request)
    {
        $apiKey = config('services.gemini.key');
        $model = config('services.gemini.model', 'gemini-2.0-flash');

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
        $model = config('services.gemini.model', 'gemini-2.0-flash');

        if (blank($apiKey)) {
            return 'Maaf, API key Gemini belum dikonfigurasi. Silakan isi GEMINI_API_KEY di file .env agar fitur AI bisa berjalan.';
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
PROMPT;

        $promptText = $systemPrompt . "\n\nPertanyaan pengguna: " . $message;

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

                return 'Maaf, saya tidak dapat terhubung ke Gemini saat ini. Silakan cek key API atau coba beberapa saat lagi.';
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
}
