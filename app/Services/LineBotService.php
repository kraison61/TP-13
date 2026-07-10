<?php

namespace App\Services;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class LineBotService
{
    public function pushMessage(string $text): void
    {
        $token = config('services.line.access_token');
        $userId = config('services.line.user_id');

        if (blank($token) || blank($userId)) {
            Log::warning('LINE push skipped: missing LINE_CHANNEL_ACCESS_TOKEN or LINE_USER_ID');

            return;
        }

        try {
            $response = $this->client($token)->post('https://api.line.me/v2/bot/message/push', [
                'to' => $userId,
                'messages' => [['type' => 'text', 'text' => $text]],
            ]);

            if ($response->failed()) {
                Log::error('LINE push failed', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
            }
        } catch (Throwable $e) {
            Log::error('LINE push exception', [
                'message' => $e->getMessage(),
            ]);
        }
    }

    private function client(string $token): PendingRequest
    {
        $request = Http::withToken($token);
        $caBundle = config('services.line.ca_bundle');

        if (filled($caBundle) && is_file($caBundle)) {
            return $request->withOptions(['verify' => $caBundle]);
        }

        return $request;
    }
}
