<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [];

    public function boot(): void
    {
        Gate::define('view_users', fn(User $user) => $user->hasPermission('view_users'));
        Gate::define('create_users', fn(User $user) => $user->hasPermission('create_users'));
        Gate::define('edit_users', fn(User $user) => $user->hasPermission('edit_users'));
        Gate::define('delete_users', fn(User $user) => $user->hasPermission('delete_users'));

        Gate::define('view_departments', fn(User $user) => $user->hasPermission('view_departments'));
        Gate::define('create_departments', fn(User $user) => $user->hasPermission('create_departments'));
        Gate::define('edit_departments', fn(User $user) => $user->hasPermission('edit_departments'));
        Gate::define('delete_departments', fn(User $user) => $user->hasPermission('delete_departments'));

        Gate::define('view_teams', fn(User $user) => $user->hasPermission('view_teams'));
        Gate::define('create_teams', fn(User $user) => $user->hasPermission('create_teams'));
        Gate::define('edit_teams', fn(User $user) => $user->hasPermission('edit_teams'));
        Gate::define('delete_teams', fn(User $user) => $user->hasPermission('delete_teams'));

        Gate::define('view_roles', fn(User $user) => $user->hasPermission('view_roles'));
        Gate::define('create_roles', fn(User $user) => $user->hasPermission('create_roles'));
        Gate::define('edit_roles', fn(User $user) => $user->hasPermission('edit_roles'));
        Gate::define('delete_roles', fn(User $user) => $user->hasPermission('delete_roles'));

        Gate::define('view_agencies', fn(User $user) => $user->hasPermission('view_agencies'));
        Gate::define('create_agencies', fn(User $user) => $user->hasPermission('create_agencies'));
        Gate::define('edit_agencies', fn(User $user) => $user->hasPermission('edit_agencies'));
        Gate::define('delete_agencies', fn(User $user) => $user->hasPermission('delete_agencies'));

        Gate::define('view_offices', fn(User $user) => $user->hasPermission('view_offices'));
        Gate::define('create_offices', fn(User $user) => $user->hasPermission('create_offices'));
        Gate::define('edit_offices', fn(User $user) => $user->hasPermission('edit_offices'));
        Gate::define('delete_offices', fn(User $user) => $user->hasPermission('delete_offices'));

        Gate::define('view_org_chart', fn(User $user) => $user->hasPermission('view_org_chart'));
    }
}