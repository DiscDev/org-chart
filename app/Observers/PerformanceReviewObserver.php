<?php

namespace App\Observers;

use App\Models\PerformanceReview;
use App\Notifications\OrganizationUpdate;
use Illuminate\Support\Facades\Notification;

class PerformanceReviewObserver
{
    public function created(PerformanceReview $review)
    {
        Notification::route('slack', config('services.slack.webhook_url'))
            ->route('microsoft-teams', config('services.microsoft.teams.webhook_url'))
            ->notify(new OrganizationUpdate(
                "New performance review scheduled",
                [
                    'employee' => $review->user->full_name,
                    'reviewer' => $review->reviewer->full_name,
                    'scheduled_date' => $review->scheduled_date->format('M d, Y'),
                ],
                'info'
            ));
    }

    public function updated(PerformanceReview $review)
    {
        if ($review->isDirty('status') && $review->status === 'completed') {
            Notification::route('slack', config('services.slack.webhook_url'))
                ->route('microsoft-teams', config('services.microsoft.teams.webhook_url'))
                ->notify(new OrganizationUpdate(
                    "Performance review completed",
                    [
                        'employee' => $review->user->full_name,
                        'reviewer' => $review->reviewer->full_name,
                        'rating' => $review->rating ?? 'Not rated',
                    ],
                    'success'
                ));
        }
    }
}