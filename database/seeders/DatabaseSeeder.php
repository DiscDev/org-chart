<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            TimezoneSeeder::class,
            UserTypeSeeder::class,
            PermissionSeeder::class,
            UserTypePermissionSeeder::class,
            AgencySeeder::class,
            OfficeSeeder::class,
            TeamSeeder::class,
            DepartmentSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
        ]);
    }
}