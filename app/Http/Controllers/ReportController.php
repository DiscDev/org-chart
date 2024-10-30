<?php

namespace App\Http\Controllers;

use App\Exports\DepartmentCostExport;
use App\Exports\EmployeeDirectoryExport;
use App\Exports\TurnoverReportExport;
use App\Services\DepartmentCostService;
use App\Services\TurnoverService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    protected $departmentCostService;
    protected $turnoverService;

    public function __construct(DepartmentCostService $departmentCostService, TurnoverService $turnoverService)
    {
        $this->departmentCostService = $departmentCostService;
        $this->turnoverService = $turnoverService;
    }

    public function exportDepartmentCosts(Request $request)
    {
        if (!Gate::allows('view_reports')) {
            abort(403);
        }

        $period = $request->input('period', '12m');
        $format = $request->input('format', 'xlsx');
        $filename = 'department_costs_' . now()->format('Y-m-d_His');

        $costs = $this->departmentCostService->getDepartmentCosts($period);
        $export = new DepartmentCostExport($costs);

        return $format === 'csv' 
            ? $export->download($filename . '.csv', \Maatwebsite\Excel\Excel::CSV)
            : $export->download($filename . '.xlsx');
    }

    public function exportEmployeeDirectory(Request $request)
    {
        if (!Gate::allows('view_reports')) {
            abort(403);
        }

        $format = $request->input('format', 'xlsx');
        $filename = 'employee_directory_' . now()->format('Y-m-d_His');

        $export = new EmployeeDirectoryExport();

        return $format === 'csv'
            ? $export->download($filename . '.csv', \Maatwebsite\Excel\Excel::CSV)
            : $export->download($filename . '.xlsx');
    }

    public function exportTurnoverReport(Request $request)
    {
        if (!Gate::allows('view_reports')) {
            abort(403);
        }

        $period = $request->input('period', '12m');
        $groupBy = $request->input('group_by');
        $format = $request->input('format', 'xlsx');
        $filename = 'turnover_report_' . now()->format('Y-m-d_His');

        $endDate = now();
        $startDate = match($period) {
            '3m' => now()->subMonths(3),
            '6m' => now()->subMonths(6),
            '12m' => now()->subMonths(12),
            'ytd' => now()->startOfYear(),
            default => now()->subMonths(12),
        };

        $data = [
            'overview' => $this->turnoverService->calculateTurnoverRate($startDate, $endDate),
            'trends' => $this->turnoverService->getTurnoverTrend($startDate->diffInMonths($endDate)),
            'byGroup' => $groupBy ? $this->turnoverService->calculateTurnoverRate($startDate, $endDate, $groupBy) : null,
        ];

        $export = new TurnoverReportExport($data);

        return $format === 'csv'
            ? $export->download($filename . '.csv', \Maatwebsite\Excel\Excel::CSV)
            : $export->download($filename . '.xlsx');
    }
}