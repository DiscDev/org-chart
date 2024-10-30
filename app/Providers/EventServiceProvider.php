<?php

namespace App\Providers;

use App\Models\Agency;
use App\Models\Department;
use App\Models\Office;
use App\Models\PerformanceReview;
use App\Models\Role;
use App\Models\Team;
use App\Models\User;
use App\Observers\CacheClearObserver;
use App\Observers\PerformanceReviewObserver;
use App\Observers\UserObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    public function boot(): void
    {
        User::observe([UserObserver::class, CacheClearObserver::class]);
        PerformanceReview::observe([PerformanceReviewObserver::class, CacheClearObserver::class]);
        Department::observe(CacheClearObserver::class);
        Team::observe(CacheClearObserver::class);
        Role::observe(CacheClearObserver::class);
        Agency::observe(CacheClearObserver::class);
        Office::observe(CacheClearObserver::class);
    }
}