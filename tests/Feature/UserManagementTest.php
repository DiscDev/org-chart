<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\UserType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create required user types
        UserType::create(['name' => 'Super Admin']);
        UserType::create(['name' => 'Employee']);
    }

    public function test_admin_can_view_users_list(): void
    {
        $admin = User::factory()->create([
            'user_type_id' => UserType::where('name', 'Super Admin')->first()->id,
        ]);

        $response = $this->actingAs($admin)->get('/users');
        $response->assertStatus(200);
    }

    public function test_non_admin_cannot_view_users_list(): void
    {
        $user = User::factory()->create([
            'user_type_id' => UserType::where('name', 'Employee')->first()->id,
        ]);

        $response = $this->actingAs($user)->get('/users');
        $response->assertStatus(403);
    }

    public function test_admin_can_create_user(): void
    {
        $admin = User::factory()->create([
            'user_type_id' => UserType::where('name', 'Super Admin')->first()->id,
        ]);

        $userData = [
            'username' => 'newuser',
            'email_work' => 'newuser@spikeup.com',
            'email_personal' => 'newuser@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'first_name' => 'New',
            'last_name' => 'User',
            'start_date' => now()->format('Y-m-d'),
            'job_title' => 'Developer',
            'timezone_id' => 1,
            'location' => 'Remote',
            'agency_id' => 1,
            'user_type_id' => UserType::where('name', 'Employee')->first()->id,
        ];

        $response = $this->actingAs($admin)->post('/users', $userData);
        $response->assertRedirect();
        $this->assertDatabaseHas('users', ['username' => 'newuser']);
    }
}