<?php

namespace Tests\Feature;

use App\Models\Department;
use App\Models\User;
use App\Models\UserType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DepartmentManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        UserType::create(['name' => 'Super Admin']);
    }

    public function test_admin_can_view_departments(): void
    {
        $admin = User::factory()->create([
            'user_type_id' => UserType::where('name', 'Super Admin')->first()->id,
        ]);

        $response = $this->actingAs($admin)->get('/departments');
        $response->assertStatus(200);
    }

    public function test_admin_can_create_department(): void
    {
        $admin = User::factory()->create([
            'user_type_id' => UserType::where('name', 'Super Admin')->first()->id,
        ]);

        $departmentData = [
            'name' => 'New Department',
            'description' => 'Department Description',
        ];

        $response = $this->actingAs($admin)->post('/departments', $departmentData);
        $response->assertRedirect();
        $this->assertDatabaseHas('departments', ['name' => 'New Department']);
    }

    public function test_admin_can_update_department(): void
    {
        $admin = User::factory()->create([
            'user_type_id' => UserType::where('name', 'Super Admin')->first()->id,
        ]);

        $department = Department::create([
            'name' => 'Old Name',
            'description' => 'Old Description',
        ]);

        $response = $this->actingAs($admin)->put("/departments/{$department->id}", [
            'name' => 'Updated Name',
            'description' => 'Updated Description',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('departments', ['name' => 'Updated Name']);
    }
}