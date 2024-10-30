<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\UserType;
use Illuminate\Database\Seeder;

class UserTypePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Super Admin gets all permissions
        $superAdmin = UserType::where('name', 'Super Admin')->first();
        $allPermissions = Permission::all();
        $superAdmin->permissions()->attach($allPermissions->pluck('id'));

        // Admin permissions
        $admin = UserType::where('name', 'Admin')->first();
        $adminPermissions = Permission::whereIn('name', [
            'view_dashboard',
            'create_users', 'edit_users', 'view_users', 'delete_users',
            'create_employees', 'edit_employees', 'view_employees', 'delete_employees',
            'view_employee_salary',
            'create_departments', 'edit_departments', 'view_departments', 'delete_departments',
            'create_teams', 'edit_teams', 'view_teams', 'delete_teams',
            'create_roles', 'edit_roles', 'view_roles', 'delete_roles',
            'create_agencies', 'edit_agencies', 'view_agencies', 'delete_agencies',
            'create_offices', 'edit_offices', 'view_offices', 'delete_offices',
            'view_org_chart'
        ])->get();
        $admin->permissions()->attach($adminPermissions->pluck('id'));

        // Manager permissions
        $manager = UserType::where('name', 'Manager')->first();
        $managerPermissions = Permission::whereIn('name', [
            'view_dashboard',
            'view_employees', 'edit_employees',
            'view_employee_salary',
            'view_departments',
            'view_teams',
            'view_roles',
            'view_agencies',
            'view_offices',
            'view_org_chart'
        ])->get();
        $manager->permissions()->attach($managerPermissions->pluck('id'));

        // Employee permissions
        $employee = UserType::where('name', 'Employee')->first();
        $employeePermissions = Permission::whereIn('name', [
            'view_dashboard',
            'view_employees',
            'view_departments',
            'view_teams',
            'view_roles',
            'view_agencies',
            'view_offices',
            'view_org_chart'
        ])->get();
        $employee->permissions()->attach($employeePermissions->pluck('id'));

        // Viewer permissions
        $viewer = UserType::where('name', 'Viewer')->first();
        $viewerPermissions = Permission::whereIn('name', [
            'view_dashboard',
            'view_employees',
            'view_departments',
            'view_teams',
            'view_roles',
            'view_agencies',
            'view_offices',
            'view_org_chart'
        ])->get();
        $viewer->permissions()->attach($viewerPermissions->pluck('id'));

        // Registrant has no initial permissions
    }
}