<?php

namespace Tests\Feature;

use App\Models\Permission;
use App\Models\User;
use App\Models\UserType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PermissionTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create user types
        $adminType = UserType::create(['name' => 'Super Admin']);
        $employeeType = UserType::create(['name' => 'Employee']);

        // Create permissions
        $viewUsers = Permission::create(['name' => 'view_users']);
        $createUsers = Permission::create(['name' => 'create_users']);

        // Assign permissions to admin
        $adminType->permissions()->attach([$viewUsers->id, $createUsers->id]);
    }

    public function test_admin_has_correct_permissions(): void
    {
        $admin = User::factory()->create([
            'user_type_id' => UserType::where('name', 'Super Admin')->first()->id,
        ]);

        $this->assertTrue($admin->hasPermission('view_users'));
        $this->assertTrue($admin->hasPermission('create_users'));
    }

    public function test_employee_does_not_have_admin_permissions(): void
    {
        $employee = User::factory()->create([
            'user_type_id' => UserType::where('name', 'Employee')->first()->id,
        ]);

        $this->assertFalse($employee->hasPermission('view_users'));
        $this->assertFalse($employee->hasPermission('create_users'));
    }
}