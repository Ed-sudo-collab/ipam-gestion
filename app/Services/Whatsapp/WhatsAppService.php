<?php

namespace App\Services\WhatsApp;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    public function send(string $numero, string $message): bool
    {
        try {
            $response = Http::withToken(config('services.evolution.key'))
                ->post(config('services.evolution.url'), [
                    'instance' => config('services.evolution.instance'),
                    'number'   => $numero,
                    'message'  => $message,
                ]);

            if ($response->failed()) {
                Log::error('WhatsApp send failed', [
                    'numero' => $numero,
                    'response' => $response->body(),
                ]);
                return false;
            }

            return true;
        } catch (\Exception $e) {
            Log::error('WhatsApp exception', [
                'message' => $e->getMessage(),
            ]);
            return false;
        }
    }
}
