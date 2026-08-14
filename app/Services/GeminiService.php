<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiService
{
    public function generate($prompt)
    {
        $apiKey = config('services.gemini.key');
        $model = config('services.gemini.model', 'gemini-3.5-flash-lite');

        if (!$apiKey) {
            return [
                'error' => true,
                'message' => 'GEMINI_API_KEY belum dikonfigurasi.'
            ];
        }

        $response = Http::timeout(60)
            ->withHeaders([
                'Content-Type' => 'application/json',
            ])
            ->post(
                "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}",
                [
                    'contents' => [
                        [
                            'parts' => [
                                [
                                    'text' => $prompt
                                ]
                            ]
                        ]
                    ],
                    'generationConfig' => [
                        'maxOutputTokens' => 1000,
                    ],
                ]
            );

        if (!$response->successful()) {

            Log::error('Gemini API Error', [
                'status' => $response->status(),
                'response' => $response->body()
            ]);

            return [
                'error' => true,
                'message' => 'Gagal terhubung dengan Gemini API.',
                'status' => $response->status(),
                'detail' => $response->json()
            ];
        }

        $data = $response->json();

        $text = $data['candidates'][0]['content']['parts'][0]['text'] ?? null;

        if (!$text) {
            return [
                'error' => true,
                'message' => 'Gemini tidak memberikan jawaban.',
                'detail' => $data
            ];
        }

        return [
            'error' => false,
            'text' => $text
        ];
    }
}
