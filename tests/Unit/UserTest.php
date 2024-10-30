<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\UserType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        UserType::create(['name' => 'Employee']);
    }

    public function test_full_name_attribute(): void
    {
        $user = User::factory()->create([
            'first_name' => 'John',
            'last_name' => 'Doe',
        ]);

        $this->assertEquals('John Doe', $user->full_name);
    }

    public function test_user_can_have_manager(): void
    {
        $manager = User::factory()->create();
        $employee = User::factory()->create([
            'manager_id' => $manager->id,
        ]);

        $this->assertTrue($employee->manager->is($manager));
        $this->assertTrue($manager->subordinates->contains($employee));
    }

    public function test_user_can_belong_to_multiple_departments(): void
    {
        $user = User::factory()->create();
        $departments = ['Development', 'Marketing'];

        foreach ($departments as $name) {
            $department = \App\Models\Department::create(['name' => $name]);
            $user->departments()->attach($department);
        }

        $this->assertEquals(2, $user->departments->count());
        $this->assertTrue($user->departments->pluck('name')->contains('Development'));
        $this->assertTrue($user->departments->pluck('name')->contains('Marketing'));
    }
}