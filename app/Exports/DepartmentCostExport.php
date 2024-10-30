<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DepartmentCostExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $costs;

    public function __construct($costs)
    {
        $this->costs = $costs;
    }

    public function collection()
    {
        return $this->costs;
    }

    public function headings(): array
    {
        return [
            'Department',
            'Employee Count',
            'Average Salary',
            'Average Agency Fees',
            'Total Salary',
            'Total Agency Fees',
            'Total Cost',
        ];
    }

    public function map($row): array
    {
        return [
            $row->name,
            $row->employee_count,
            $row->avg_salary,
            $row->avg_agency_fees,
            $row->total_salary,
            $row->agency_fees,
            $row->total_cost,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}