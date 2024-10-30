<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatService
{
    public function sendToSlack(string $message, array $attachments = []): bool
    {
        try {
            $response = Http::post(config('services.slack.webhook_url'), [
                'text' => $message,
                'attachments' => $attachments,
            ]);

            return $response->successful();
        } catch (\Exception $e) {
            Log::error('Slack notification failed: ' . $e->getMessage());
            return false;
        }
    }

    public function sendToTeams(string $message, array $sections = []): bool
    {
        try {
            $card = [
                '@type' => 'MessageCard',
                '@context' => 'http://schema.org/extensions',
                'summary' => 'Organization Update',
                'themeColor' => '0076D7',
                'title' => 'Organization Update',
                'text' => $message,
                'sections' => $sections,
            ];

            $response = Http::post(config('services.microsoft.teams.webhook_url'), $card);

            return $response->successful();
        } catch (\Exception $e) {
            Log::error('Teams notification failed: ' . $e->getMessage());
            return false;
        }
    }
}