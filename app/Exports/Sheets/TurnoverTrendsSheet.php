<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TurnoverTrendsSheet implements FromArray, WithHeadings, WithStyles, WithTitle
{
    protected $trends;

    public function __construct(array $trends)
    {
        $this->trends = $trends;
    }

    public function array(): array
    {
        return array_map(function ($trend) {
            return [
                $trend['month'],
                $trend['departures'],
                $trend['turnover_rate'],
            ];
        }, $this->trends);
    }

    public function headings(): array
    {
        return [
            'Month',
            'Departures',
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
        return 'Monthly Trends';
    }
}