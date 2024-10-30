<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class EmployeeDirectoryExport implements FromQuery, WithHeadings, WithMapping, WithStyles
{
    public function query()
    {
        return User::query()
            ->with(['departments', 'teams', 'roles', 'offices', 'agency', 'userType', 'manager'])
            ->whereNull('end_date')
            ->orderBy('first_name');
    }

    public function headings(): array
    {
        return [
            'Name',
            'Job Title',
            'Department(s)',
            'Team(s)',
            'Role(s)',
            'Office(s)',
            'Agency',
            'Manager',
            'Location',
            'Work Email',
            'Phone Number',
            'Start Date',
            'Slack',
            'Skype',
            'Telegram',
            'WhatsApp',
        ];
    }

    public function map($user): array
    {
        return [
            $user->full_name,
            $user->job_title,
            $user->departments->pluck('name')->join(', '),
            $user->teams->pluck('name')->join(', '),
            $user->roles->pluck('name')->join(', '),
            $user->offices->pluck('name')->join(', '),
            $user->agency->name,
            $user->manager ? $user->manager->full_name : 'N/A',
            $user->location,
            $user->email_work,
            $user->phone_number,
            $user->start_date->format('Y-m-d'),
            $user->slack,
            $user->skype,
            $user->telegram,
            $user->whatsapp,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}