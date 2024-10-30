<?php

namespace App\Notifications;

use App\Services\ChatService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class OrganizationUpdate extends Notification implements ShouldQueue
{
    use Queueable;

    protected $message;
    protected $details;
    protected $type;

    public function __construct(string $message, array $details = [], string $type = 'info')
    {
        $this->message = $message;
        $this->details = $details;
        $this->type = $type;
    }

    public function via($notifiable): array
    {
        return ['database', 'slack', 'microsoft-teams'];
    }

    public function toSlack($notifiable)
    {
        $attachments = [[
            'color' => $this->getColorForType(),
            'fields' => collect($this->details)->map(function ($value, $key) {
                return [
                    'title' => ucfirst(str_replace('_', ' ', $key)),
                    'value' => $value,
                    'short' => true,
                ];
            })->values()->toArray(),
        ]];

        app(ChatService::class)->sendToSlack($this->message, $attachments);
    }

    public function toMicrosoftTeams($notifiable)
    {
        $sections = [[
            'facts' => collect($this->details)->map(function ($value, $key) {
                return [
                    'name' => ucfirst(str_replace('_', ' ', $key)),
                    'value' => $value,
                ];
            })->values()->toArray(),
        ]];

        app(ChatService::class)->sendToTeams($this->message, $sections);
    }

    public function toArray($notifiable): array
    {
        return [
            'message' => $this->message,
            'details' => $this->details,
            'type' => $this->type,
        ];
    }

    protected function getColorForType(): string
    {
        return match($this->type) {
            'success' => '#36a64f',
            'warning' => '#ffcc00',
            'error' => '#ff0000',
            default => '#0076D7',
        };
    }
}