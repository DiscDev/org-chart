<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TurnoverOverviewSheet implements FromArray, WithHeadings, WithStyles, WithTitle
{
    protected $overview;

    public function __construct(array $overview)
    {
        $this->overview = $overview;
    }

    public function array(): array
    {
        return [[
            $this->overview['departures'],
            $this->overview['average_employees'],
            $this->overview['turnover_rate'],
        ]];
    }

    public function headings(): array
    {
        return [
            'Total Departures',
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
        return 'Overview';
    }
}