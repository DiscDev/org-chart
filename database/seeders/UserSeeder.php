<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Office;
use App\Models\Role;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create super admin user
        $superAdmin = User::factory()->superAdmin()->create();

        // Create some managers
        $managers = User::factory()
            ->manager()
            ->count(5)
            ->create([
                'created_by' => $superAdmin->id,
                'updated_by' => $superAdmin->id,
            ]);

        // Create regular employees
        $employees = User::factory()
            ->count(30)
            ->create([
                'created_by' => $superAdmin->id,
                'updated_by' => $superAdmin->id,
                'manager_id' => fn() => $managers->random()->id,
            ]);

        // Create viewers
        $viewers = User::factory()
            ->viewer()
            ->count(5)
            ->create([
                'created_by' => $superAdmin->id,
                'updated_by' => $superAdmin->id,
            ]);

        // Collect all users
        $allUsers = collect([$superAdmin])
            ->merge($managers)
            ->merge($employees)
            ->merge($viewers);

        // Assign random offices to users
        $offices = Office::all();
        $allUsers->each(function ($user) use ($offices) {
            $user->offices()->attach(
                $offices->random(rand(1, 2))->pluck('id')->toArray()
            );
        });

        // Assign random departments to users
        $departments = Department::all();
        $allUsers->each(function ($user) use ($departments) {
            $user->departments()->attach(
                $departments->random(rand(1, 3))->pluck('id')->toArray()
            );
        });

        // Assign random roles to users
        $roles = Role::all();
        $allUsers->each(function ($user) use ($roles) {
            $user->roles()->attach(
                $roles->random(rand(1, 2))->pluck('id')->toArray()
            );
        });

        // Assign random teams to users
        $teams = Team::all();
        $allUsers->each(function ($user) use ($teams) {
            $user->teams()->attach(
                $teams->random(rand(1, 3))->pluck('id')->toArray()
            );
        });
    }
}