<?php

namespace Database\Factories;

use App\Models\Agency;
use App\Models\Timezone;
use App\Models\User;
use App\Models\UserType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        $firstName = $this->faker->firstName();
        $lastName = $this->faker->lastName();
        $username = strtolower($firstName . '.' . $lastName);

        return [
            'username' => $username,
            'email_work' => $username . '@spikeup.com',
            'email_personal' => $this->faker->unique()->safeEmail(),
            'password' => Hash::make('password'),
            'first_name' => $firstName,
            'last_name' => $lastName,
            'start_date' => $this->faker->dateTimeBetween('-2 years', 'now'),
            'end_date' => $this->faker->optional(0.1)->dateTimeBetween('now', '+1 year'),
            'phone_number' => $this->faker->optional()->phoneNumber(),
            'profile' => $this->faker->optional()->text(),
            'activities' => $this->faker->optional()->text(),
            'job_title' => $this->faker->jobTitle(),
            'job_description' => $this->faker->optional()->text(),
            'timezone_id' => Timezone::inRandomOrder()->first()->id,
            'location' => $this->faker->city() . ', ' . $this->faker->country(),
            'photo_url' => $this->faker->optional()->imageUrl(200, 200, 'people'),
            'agency_id' => Agency::inRandomOrder()->first()->id,
            'salary' => $this->faker->optional()->numberBetween(30000, 150000),
            'salary_including_agency_fees' => function (array $attributes) {
                return $attributes['salary'] ? $attributes['salary'] * 1.2 : null;
            },
            'bonus_structure' => $this->faker->optional()->text(),
            'slack' => $this->faker->optional()->userName(),
            'skype' => $this->faker->optional()->userName(),
            'telegram' => $this->faker->optional()->userName(),
            'whatsapp' => $this->faker->optional()->phoneNumber(),
            'user_type_id' => UserType::where('name', 'Employee')->first()->id,
            'remember_token' => Str::random(10),
        ];
    }

    public function superAdmin(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'username' => 'admin',
                'email_work' => 'admin@spikeup.com',
                'email_personal' => 'admin.personal@example.com',
                'first_name' => 'Super',
                'last_name' => 'Admin',
                'user_type_id' => UserType::where('name', 'Super Admin')->first()->id,
                'job_title' => 'System Administrator',
            ];
        });
    }

    public function manager(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'user_type_id' => UserType::where('name', 'Manager')->first()->id,
            ];
        });
    }

    public function viewer(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'user_type_id' => UserType::where('name', 'Viewer')->first()->id,
            ];
        });
    }
}