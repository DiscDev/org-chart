<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TurnoverGroupSheet implements FromArray, WithHeadings, WithStyles, WithTitle
{
    protected $groupData;

    public function __construct(array $groupData)
    {
        $this->groupData = $groupData;
    }

    public function array(): array
    {
        return array_map(function ($data) {
            return [
                $data['name'],
                $data['departures'],
                $data['average_employees'],
                $data['turnover_rate'],
            ];
        }, $this->groupData);
    }

    public function headings(): array
    {
        return [
            'Group Name',
            'Departures',
            'Average Employees',
            'Turnover Rate (%)',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }

    public function title(): string
    {
        return 'By Group';
    }
}