<?php

namespace Database\Seeders;

use App\Models\Team;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    public function run(): void
    {
        $teams = [
            [
                'name' => 'Bankrolls.com',
                'description' => 'BRC team focused on bankroll management platform'
            ],
            [
                'name' => 'Bankrolls.tools',
                'description' => 'BRT team developing auxiliary tools'
            ],
            [
                'name' => 'SpikeUp.com',
                'description' => 'Core platform development team'
            ],
            [
                'name' => 'AI Content SaaS',
                'description' => 'AI-powered content generation platform team'
            ],
            [
                'name' => 'Marketing',
                'description' => 'Central marketing team'
            ],
            [
                'name' => 'Marketing Sites (BH)',
                'description' => 'Marketing sites team - Black Hat'
            ],
            [
                'name' => 'Marketing Sites (WH)',
                'description' => 'Marketing sites team - White Hat'
            ],
            [
                'name' => 'Marketing Apps',
                'description' => 'Marketing applications development team'
            ],
            [
                'name' => 'SEO Site Lines',
                'description' => 'SEO team for Lines platform'
            ],
            [
                'name' => 'SEO Site Clovr',
                'description' => 'SEO team for Clovr platform'
            ],
            [
                'name' => 'SEO site Esportivaposta',
                'description' => 'SEO team for Esportivaposta'
            ],
            [
                'name' => 'SEO site CasinoRoom',
                'description' => 'SEO team for CasinoRoom'
            ],
            [
                'name' => 'Warmup Accounts',
                'description' => 'Account management and preparation team'
            ],
            [
                'name' => 'Affiliate Managers',
                'description' => 'Affiliate program management team'
            ]
        ];

        foreach ($teams as $team) {
            Team::create($team);
        }
    }
}