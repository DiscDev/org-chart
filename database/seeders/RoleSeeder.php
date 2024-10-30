<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['name' => 'Stakeholder', 'description' => 'Company stakeholder'],
            ['name' => 'Chief Executive Officer', 'description' => 'CEO'],
            ['name' => 'Chief Financial Officer', 'description' => 'CFO'],
            ['name' => 'Chief Technology Officer', 'description' => 'CTO'],
            ['name' => 'Business Intelligence Director', 'description' => 'BI Director'],
            ['name' => 'Machine Learning Engineer', 'description' => 'ML Engineer'],
            ['name' => 'Artificial Intelligence Engineer', 'description' => 'AI Engineer'],
            ['name' => 'Data Engineer', 'description' => 'Data processing and pipeline specialist'],
            ['name' => 'Data Reports', 'description' => 'Data analysis and reporting'],
            ['name' => 'AI Prompt Engineer', 'description' => 'AI prompt optimization specialist'],
            ['name' => 'Project Manager', 'description' => 'Project management'],
            ['name' => 'Project Manager Assistant', 'description' => 'PM support'],
            ['name' => 'Product Manager', 'description' => 'Product development and strategy'],
            ['name' => 'Product Owner', 'description' => 'Product ownership and vision'],
            ['name' => 'General Manager', 'description' => 'General management'],
            ['name' => 'SEO Director', 'description' => 'SEO strategy lead'],
            ['name' => 'SEO Tech Director', 'description' => 'Technical SEO lead'],
            ['name' => 'SEO Project Manager', 'description' => 'SEO project management'],
            ['name' => 'SEO Senior Wordpress Developer', 'description' => 'Senior WP development'],
            ['name' => 'SEO Wordpress Developer', 'description' => 'WP development'],
            ['name' => 'SEO Content Writer', 'description' => 'SEO content creation'],
            ['name' => 'SEO AI Content Specialist', 'description' => 'AI-powered content optimization'],
            ['name' => 'DevOps Director', 'description' => 'DevOps team lead'],
            ['name' => 'Senior DevOps Engineer', 'description' => 'Senior infrastructure specialist'],
            ['name' => 'DevOps Engineer', 'description' => 'Infrastructure management'],
            ['name' => 'Senior Full Stack Software Developer', 'description' => 'Senior full stack development'],
            ['name' => 'Full Stack Software Developer', 'description' => 'Full stack development'],
            ['name' => 'Senior Front End Software Developer', 'description' => 'Senior frontend development'],
            ['name' => 'Front End Software Developer', 'description' => 'Frontend development'],
            ['name' => 'App Developer', 'description' => 'Mobile app development'],
            ['name' => 'User Interface Designer', 'description' => 'UI design'],
            ['name' => 'User Experience Designer', 'description' => 'UX design'],
            ['name' => 'Graphics Designer', 'description' => 'Graphic design'],
            ['name' => 'Marketing', 'description' => 'Marketing specialist'],
            ['name' => 'Email/SMS Marketing', 'description' => 'Email and SMS campaign management'],
            ['name' => 'Senior Affiliate Manager', 'description' => 'Senior affiliate management'],
            ['name' => 'Affiliate Manager', 'description' => 'Affiliate management'],
            ['name' => 'Human Resources', 'description' => 'HR management'],
            ['name' => 'Finance', 'description' => 'Financial operations'],
            ['name' => 'Accounting', 'description' => 'Accounting operations'],
            ['name' => 'Monetization Manager', 'description' => 'Revenue optimization'],
            ['name' => 'Conversion Rate Optimization', 'description' => 'CRO specialist']
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}