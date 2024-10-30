<?php

namespace Tests\Feature\Auth;

use App\Models\UserType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
    }

    public function test_new_users_can_register(): void
    {
        UserType::create(['name' => 'Registrant']);

        $response = $this->post('/register', [
            'username' => 'testuser',
            'email_work' => 'test@spikeup.com',
            'email_personal' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'first_name' => 'Test',
            'last_name' => 'User',
            'phone_number' => '1234567890',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect('/dashboard');
    }
}