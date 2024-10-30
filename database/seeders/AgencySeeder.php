<?php

namespace Database\Seeders;

use App\Models\Agency;
use Illuminate\Database\Seeder;

class AgencySeeder extends Seeder
{
    public function run(): void
    {
        $agencies = [
            [
                'name' => 'SpikeUp',
                'description' => 'Primary development agency',
                'agency_fees' => 'Standard rate plus performance bonuses'
            ],
            [
                'name' => 'ASG',
                'description' => 'Specialized development team',
                'agency_fees' => 'Fixed rate per project'
            ],
            [
                'name' => 'DOXA',
                'description' => 'Marketing and content creation',
                'agency_fees' => 'Monthly retainer plus commission'
            ],
            [
                'name' => 'TDG',
                'description' => 'Technical development group',
                'agency_fees' => 'Hourly rate with volume discount'
            ],
            [
                'name' => 'App Society',
                'description' => 'Mobile app development specialists',
                'agency_fees' => 'Project-based pricing'
            ]
        ];

        foreach ($agencies as $agency) {
            Agency::create($agency);
        }
    }
}