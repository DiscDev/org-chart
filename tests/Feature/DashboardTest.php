<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\UserType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        UserType::create(['name' => 'Employee']);
    }

    public function test_dashboard_screen_can_be_rendered(): void
    {
        $user = User::factory()->create([
            'user_type_id' => UserType::where('name', 'Employee')->first()->id,
        ]);

        $response = $this->actingAs($user)->get('/dashboard');
        $response->assertStatus(200);
    }

    public function test_dashboard_cannot_be_rendered_for_guests(): void
    {
        $response = $this->get('/dashboard');
        $response->assertRedirect('/login');
    }

    public function test_dashboard_shows_correct_user_info(): void
    {
        $user = User::factory()->create([
            'user_type_id' => UserType::where('name', 'Employee')->first()->id,
            'first_name' => 'John',
            'last_name' => 'Doe',
        ]);

        $response = $this->actingAs($user)->get('/dashboard');
        $response->assertSee('John Doe');
    }
}