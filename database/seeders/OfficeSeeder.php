<?php

namespace Database\Seeders;

use App\Models\Office;
use Illuminate\Database\Seeder;

class OfficeSeeder extends Seeder
{
    public function run(): void
    {
        $offices = [
            [
                'name' => 'Remote Philippines',
                'location' => 'Philippines',
                'description' => 'Remote team based in the Philippines'
            ],
            [
                'name' => 'Remote Russia',
                'location' => 'Russia',
                'description' => 'Remote team based in Russia'
            ],
            [
                'name' => 'Remote Virgin Islands',
                'location' => 'Virgin Islands',
                'description' => 'Remote team based in the Virgin Islands'
            ],
            [
                'name' => 'Los Angeles Office',
                'location' => 'Los Angeles, CA',
                'description' => 'Main US West Coast office'
            ],
            [
                'name' => 'Las Vegas Office',
                'location' => 'Las Vegas, NV',
                'description' => 'US operations center'
            ],
            [
                'name' => 'Malta Office',
                'location' => 'Malta',
                'description' => 'European headquarters'
            ]
        ];

        foreach ($offices as $office) {
            Office::create($office);
        }
    }
}