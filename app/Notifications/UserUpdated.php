<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserUpdated extends Notification
{
    use Queueable;

    protected $user;
    protected $action;

    public function __construct(User $user, string $action)
    {
        $this->user = $user;
        $this->action = $action;
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("User {$this->action}: {$this->user->full_name}")
            ->line("User {$this->user->full_name} has been {$this->action}.")
            ->line("Details:")
            ->line("- Username: {$this->user->username}")
            ->line("- Work Email: {$this->user->email_work}")
            ->line("- Job Title: {$this->user->job_title}")
            ->action('View User', url("/users/{$this->user->id}"));
    }
}