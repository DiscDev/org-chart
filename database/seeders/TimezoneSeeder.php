<?php

namespace Database\Seeders;

use App\Models\Timezone;
use Illuminate\Database\Seeder;

class TimezoneSeeder extends Seeder
{
    public function run(): void
    {
        $timezones = [
            ['name' => 'GMT-12', 'utc_offset' => '-12:00', 'description' => 'Baker Island Time'],
            ['name' => 'GMT-11', 'utc_offset' => '-11:00', 'description' => 'Niue Time'],
            ['name' => 'GMT-10', 'utc_offset' => '-10:00', 'description' => 'Hawaii-Aleutian Standard Time'],
            ['name' => 'GMT-9:30', 'utc_offset' => '-09:30', 'description' => 'Marquesas Islands Time'],
            ['name' => 'GMT-9', 'utc_offset' => '-09:00', 'description' => 'Alaska Standard Time'],
            ['name' => 'GMT-8', 'utc_offset' => '-08:00', 'description' => 'Pacific Standard Time'],
            ['name' => 'GMT-7', 'utc_offset' => '-07:00', 'description' => 'Mountain Standard Time'],
            ['name' => 'GMT-6', 'utc_offset' => '-06:00', 'description' => 'Central Standard Time'],
            ['name' => 'GMT-5', 'utc_offset' => '-05:00', 'description' => 'Eastern Standard Time'],
            ['name' => 'GMT-4', 'utc_offset' => '-04:00', 'description' => 'Atlantic Standard Time'],
            ['name' => 'GMT-3:30', 'utc_offset' => '-03:30', 'description' => 'Newfoundland Standard Time'],
            ['name' => 'GMT-3', 'utc_offset' => '-03:00', 'description' => 'Argentina Standard Time'],
            ['name' => 'GMT-2', 'utc_offset' => '-02:00', 'description' => 'Fernando de Noronha Time'],
            ['name' => 'GMT-1', 'utc_offset' => '-01:00', 'description' => 'Azores Standard Time'],
            ['name' => 'GMT+0', 'utc_offset' => '+00:00', 'description' => 'Greenwich Mean Time'],
            ['name' => 'GMT+1', 'utc_offset' => '+01:00', 'description' => 'Central European Time'],
            ['name' => 'GMT+2', 'utc_offset' => '+02:00', 'description' => 'Eastern European Time'],
            ['name' => 'GMT+3', 'utc_offset' => '+03:00', 'description' => 'Moscow Standard Time'],
            ['name' => 'GMT+3:30', 'utc_offset' => '+03:30', 'description' => 'Iran Standard Time'],
            ['name' => 'GMT+4', 'utc_offset' => '+04:00', 'description' => 'Gulf Standard Time'],
            ['name' => 'GMT+4:30', 'utc_offset' => '+04:30', 'description' => 'Afghanistan Time'],
            ['name' => 'GMT+5', 'utc_offset' => '+05:00', 'description' => 'Pakistan Standard Time'],
            ['name' => 'GMT+5:30', 'utc_offset' => '+05:30', 'description' => 'Indian Standard Time'],
            ['name' => 'GMT+5:45', 'utc_offset' => '+05:45', 'description' => 'Nepal Time'],
            ['name' => 'GMT+6', 'utc_offset' => '+06:00', 'description' => 'Bangladesh Standard Time'],
            ['name' => 'GMT+6:30', 'utc_offset' => '+06:30', 'description' => 'Myanmar Time'],
            ['name' => 'GMT+7', 'utc_offset' => '+07:00', 'description' => 'Indochina Time'],
            ['name' => 'GMT+8', 'utc_offset' => '+08:00', 'description' => 'China Standard Time'],
            ['name' => 'GMT+8:45', 'utc_offset' => '+08:45', 'description' => 'Australian Central Western Standard Time'],
            ['name' => 'GMT+9', 'utc_offset' => '+09:00', 'description' => 'Japan Standard Time'],
            ['name' => 'GMT+9:30', 'utc_offset' => '+09:30', 'description' => 'Australian Central Standard Time'],
            ['name' => 'GMT+10', 'utc_offset' => '+10:00', 'description' => 'Australian Eastern Standard Time'],
            ['name' => 'GMT+10:30', 'utc_offset' => '+10:30', 'description' => 'Lord Howe Standard Time'],
            ['name' => 'GMT+11', 'utc_offset' => '+11:00', 'description' => 'Solomon Islands Time'],
            ['name' => 'GMT+12', 'utc_offset' => '+12:00', 'description' => 'New Zealand Standard Time'],
            ['name' => 'GMT+12:45', 'utc_offset' => '+12:45', 'description' => 'Chatham Standard Time'],
            ['name' => 'GMT+13', 'utc_offset' => '+13:00', 'description' => 'Phoenix Islands Time'],
            ['name' => 'GMT+14', 'utc_offset' => '+14:00', 'description' => 'Line Islands Time'],
            
            // Common named timezones
            ['name' => 'PST', 'utc_offset' => '-08:00', 'description' => 'Pacific Standard Time'],
            ['name' => 'PDT', 'utc_offset' => '-07:00', 'description' => 'Pacific Daylight Time'],
            ['name' => 'MST', 'utc_offset' => '-07:00', 'description' => 'Mountain Standard Time'],
            ['name' => 'MDT', 'utc_offset' => '-06:00', 'description' => 'Mountain Daylight Time'],
            ['name' => 'CST', 'utc_offset' => '-06:00', 'description' => 'Central Standard Time'],
            ['name' => 'CDT', 'utc_offset' => '-05:00', 'description' => 'Central Daylight Time'],
            ['name' => 'EST', 'utc_offset' => '-05:00', 'description' => 'Eastern Standard Time'],
            ['name' => 'EDT', 'utc_offset' => '-04:00', 'description' => 'Eastern Daylight Time'],
            ['name' => 'AST', 'utc_offset' => '-04:00', 'description' => 'Atlantic Standard Time'],
            ['name' => 'NST', 'utc_offset' => '-03:30', 'description' => 'Newfoundland Standard Time'],
            ['name' => 'WET', 'utc_offset' => '+00:00', 'description' => 'Western European Time'],
            ['name' => 'CET', 'utc_offset' => '+01:00', 'description' => 'Central European Time'],
            ['name' => 'EET', 'utc_offset' => '+02:00', 'description' => 'Eastern European Time'],
            ['name' => 'MSK', 'utc_offset' => '+03:00', 'description' => 'Moscow Time'],
            ['name' => 'IST', 'utc_offset' => '+05:30', 'description' => 'Indian Standard Time'],
            ['name' => 'CST', 'utc_offset' => '+08:00', 'description' => 'China Standard Time'],
            ['name' => 'JST', 'utc_offset' => '+09:00', 'description' => 'Japan Standard Time'],
            ['name' => 'KST', 'utc_offset' => '+09:00', 'description' => 'Korea Standard Time'],
            ['name' => 'AEST', 'utc_offset' => '+10:00', 'description' => 'Australian Eastern Standard Time'],
            ['name' => 'NZST', 'utc_offset' => '+12:00', 'description' => 'New Zealand Standard Time'],
            ['name' => 'PHT', 'utc_offset' => '+08:00', 'description' => 'Philippine Time'],
        ];

        foreach ($timezones as $timezone) {
            Timezone::create($timezone);
        }
    }
}