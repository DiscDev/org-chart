<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class TurnoverReportExport implements WithMultipleSheets
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function sheets(): array
    {
        $sheets = [
            'Overview' => new TurnoverOverviewSheet($this->data['overview']),
            'Monthly Trends' => new TurnoverTrendsSheet($this->data['trends']),
        ];

        if ($this->data['byGroup']) {
            $sheets['By Group'] = new TurnoverGroupSheet($this->data['byGroup']);
        }

        return $sheets;
    }
}