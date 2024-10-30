<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            // Dashboard permissions
            ['name' => 'view_dashboard', 'description' => 'Can view dashboard'],
            
            // User permissions
            ['name' => 'create_users', 'description' => 'Can create users'],
            ['name' => 'edit_users', 'description' => 'Can edit users'],
            ['name' => 'view_users', 'description' => 'Can view users'],
            ['name' => 'delete_users', 'description' => 'Can delete users'],
            
            // Employee permissions
            ['name' => 'create_employees', 'description' => 'Can create employees'],
            ['name' => 'edit_employees', 'description' => 'Can edit employees'],
            ['name' => 'view_employees', 'description' => 'Can view employees'],
            ['name' => 'delete_employees', 'description' => 'Can delete employees'],
            ['name' => 'view_employee_salary', 'description' => 'Can view employee salary information'],
            
            // Department permissions
            ['name' => 'create_departments', 'description' => 'Can create departments'],
            ['name' => 'edit_departments', 'description' => 'Can edit departments'],
            ['name' => 'view_departments', 'description' => 'Can view departments'],
            ['name' => 'delete_departments', 'description' => 'Can delete departments'],
            
            // Team permissions
            ['name' => 'create_teams', 'description' => 'Can create teams'],
            ['name' => 'edit_teams', 'description' => 'Can edit teams'],
            ['name' => 'view_teams', 'description' => 'Can view teams'],
            ['name' => 'delete_teams', 'description' => 'Can delete teams'],
            
            // Role permissions
            ['name' => 'create_roles', 'description' => 'Can create roles'],
            ['name' => 'edit_roles', 'description' => 'Can edit roles'],
            ['name' => 'view_roles', 'description' => 'Can view roles'],
            ['name' => 'delete_roles', 'description' => 'Can delete roles'],
            
            // Agency permissions
            ['name' => 'create_agencies', 'description' => 'Can create agencies'],
            ['name' => 'edit_agencies', 'description' => 'Can edit agencies'],
            ['name' => 'view_agencies', 'description' => 'Can view agencies'],
            ['name' => 'delete_agencies', 'description' => 'Can delete agencies'],
            
            // Office permissions
            ['name' => 'create_offices', 'description' => 'Can create offices'],
            ['name' => 'edit_offices', 'description' => 'Can edit offices'],
            ['name' => 'view_offices', 'description' => 'Can view offices'],
            ['name' => 'delete_offices', 'description' => 'Can delete offices'],
            
            // Organization Chart permissions
            ['name' => 'view_org_chart', 'description' => 'Can view organization chart'],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
    }
}