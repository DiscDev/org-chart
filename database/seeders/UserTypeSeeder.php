<?php

namespace Database\Seeders;

use App\Models\UserType;
use Illuminate\Database\Seeder;

class UserTypeSeeder extends Seeder
{
    public function run(): void
    {
        $userTypes = [
            ['name' => 'Super Admin'],
            ['name' => 'Admin'],
            ['name' => 'Manager'],
            ['name' => 'Employee'],
            ['name' => 'Registrant'],
            ['name' => 'Viewer'],
        ];

        foreach ($userTypes as $userType) {
            UserType::create($userType);
        }
    }
}