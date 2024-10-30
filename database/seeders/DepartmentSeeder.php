<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $departments = [
            ['name' => 'Stakeholders', 'description' => 'Company stakeholders and board members'],
            ['name' => 'Senior Officers', 'description' => 'Executive leadership team'],
            ['name' => 'Finance', 'description' => 'Financial management and accounting'],
            ['name' => 'Marketing', 'description' => 'Marketing and promotional activities'],
            ['name' => 'Development', 'description' => 'Software development team'],
            ['name' => 'Business Intelligence', 'description' => 'Data analysis and business insights'],
            ['name' => 'DevOps', 'description' => 'Infrastructure and deployment'],
            ['name' => 'Warmup Accounts', 'description' => 'Account preparation and management'],
            ['name' => 'Affiliates', 'description' => 'Affiliate program management'],
            ['name' => 'Operators', 'description' => 'Operations management'],
            ['name' => 'Human Resources', 'description' => 'HR and personnel management'],
            ['name' => 'Resource Agencies', 'description' => 'External resource management'],
            ['name' => 'Design', 'description' => 'UI/UX and graphic design'],
            ['name' => 'Sales', 'description' => 'Sales and business development'],
            ['name' => 'Operations', 'description' => 'General operations'],
            ['name' => 'Directors', 'description' => 'Department directors'],
            ['name' => 'Officers', 'description' => 'Company officers']
        ];

        foreach ($departments as $department) {
            Department::create($department);
        }
    }
}