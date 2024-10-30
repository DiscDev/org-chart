<?php

namespace App\Observers;

use App\Models\ActivityLog;
use App\Models\User;
use App\Notifications\OrganizationUpdate;
use App\Notifications\UserUpdated;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class UserObserver
{
    public function created(User $user)
    {
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'created',
            'model_type' => User::class,
            'model_id' => $user->id,
            'description' => "Created user {$user->full_name}",
        ]);

        // Notify admins about new user
        User::whereHas('userType', function ($query) {
            $query->where('name', 'Admin');
        })->each(function ($admin) use ($user) {
            $admin->notify(new UserUpdated($user, 'created'));
        });

        // Send to Slack/Teams
        Notification::route('slack', config('services.slack.webhook_url'))
            ->route('microsoft-teams', config('services.microsoft.teams.webhook_url'))
            ->notify(new OrganizationUpdate(
                "New team member joined: {$user->full_name}",
                [
                    'name' => $user->full_name,
                    'position' => $user->job_title,
                    'department' => $user->departments->pluck('name')->join(', '),
                    'team' => $user->teams->pluck('name')->join(', '),
                ],
                'success'
            ));
    }

    public function updated(User $user)
    {
        $changes = $user->getChanges();
        unset($changes['updated_at']);

        if (!empty($changes)) {
            ActivityLog::create([
                'user_id' => Auth::id(),
                'action' => 'updated',
                'model_type' => User::class,
                'model_id' => $user->id,
                'description' => "Updated user {$user->full_name}",
                'changes' => $changes,
            ]);

            // Notify relevant users about the update
            if ($user->manager) {
                $user->manager->notify(new UserUpdated($user, 'updated'));
            }

            // Send to Slack/Teams if significant changes
            if (array_intersect_key($changes, array_flip(['job_title', 'manager_id', 'end_date']))) {
                $updateDetails = [];
                
                if (isset($changes['job_title'])) {
                    $updateDetails['new_position'] = $changes['job_title'];
                }
                if (isset($changes['manager_id'])) {
                    $newManager = User::find($changes['manager_id']);
                    $updateDetails['new_manager'] = $newManager ? $newManager->full_name : 'None';
                }
                if (isset($changes['end_date'])) {
                    $updateDetails['status'] = $changes['end_date'] ? 'Inactive' : 'Active';
                }

                Notification::route('slack', config('services.slack.webhook_url'))
                    ->route('microsoft-teams', config('services.microsoft.teams.webhook_url'))
                    ->notify(new OrganizationUpdate(
                        "Organization update for {$user->full_name}",
                        $updateDetails,
                        'info'
                    ));
            }
        }
    }

    public function deleted(User $user)
    {
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'deleted',
            'model_type' => User::class,
            'model_id' => $user->id,
            'description' => "Deleted user {$user->full_name}",
        ]);

        // Send to Slack/Teams
        Notification::route('slack', config('services.slack.webhook_url'))
            ->route('microsoft-teams', config('services.microsoft.teams.webhook_url'))
            ->notify(new OrganizationUpdate(
                "Team member removed: {$user->full_name}",
                [
                    'name' => $user->full_name,
                    'previous_position' => $user->job_title,
                    'previous_department' => $user->departments->pluck('name')->join(', '),
                ],
                'warning'
            ));
    }
}