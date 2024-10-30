<?php

namespace App\Services;

use App\Models\Department;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DepartmentCostService
{
    public function getDepartmentCosts($period = '12m')
    {
        $endDate = now();
        $startDate = match($period) {
            '3m' => now()->subMonths(3),
            '6m' => now()->subMonths(6),
            '12m' => now()->subMonths(12),
            'ytd' => now()->startOfYear(),
            default => now()->subMonths(12),
        };

        return Department::select(
            'departments.id',
            'departments.name',
            DB::raw('COUNT(DISTINCT users.id) as employee_count'),
            DB::raw('AVG(users.salary) as avg_salary'),
            DB::raw('AVG(users.salary_including_agency_fees) as avg_total_cost'),
            DB::raw('SUM(users.salary) as total_salary'),
            DB::raw('SUM(users.salary_including_agency_fees) as total_cost')
        )
        ->join('users_departments', 'departments.id', '=', 'users_departments.department_id')
        ->join('users', 'users.id', '=', 'users_departments.user_id')
        ->where(function ($query) use ($startDate, $endDate) {
            $query->whereNull('users.end_date')
                ->orWhere('users.end_date', '>=', $startDate);
        })
        ->where('users.start_date', '<=', $endDate)
        ->groupBy('departments.id', 'departments.name')
        ->get()
        ->map(function ($dept) {
            $dept->agency_fees = $dept->total_cost - $dept->total_salary;
            $dept->avg_agency_fees = $dept->avg_total_cost - $dept->avg_salary;
            return $dept;
        });
    }

    public function getCostTrends($departmentId, $months = 12)
    {
        $trends = [];
        $end = now()->endOfMonth();
        $start = $end->copy()->subMonths($months)->startOfMonth();
        
        for ($date = $start->copy(); $date <= $end; $date->addMonth()) {
            $monthStart = $date->copy()->startOfMonth();
            $monthEnd = $date->copy()->endOfMonth();

            $costs = Department::select(
                DB::raw('SUM(users.salary) as total_salary'),
                DB::raw('SUM(users.salary_including_agency_fees) as total_cost')
            )
            ->join('users_departments', 'departments.id', '=', 'users_departments.department_id')
            ->join('users', 'users.id', '=', 'users_departments.user_id')
            ->where('departments.id', $departmentId)
            ->where(function ($query) use ($monthStart, $monthEnd) {
                $query->whereNull('users.end_date')
                    ->orWhere('users.end_date', '>=', $monthStart);
            })
            ->where('users.start_date', '<=', $monthEnd)
            ->first();

            $trends[] = [
                'month' => $date->format('M Y'),
                'total_salary' => $costs->total_salary ?? 0,
                'total_cost' => $costs->total_cost ?? 0,
                'agency_fees' => ($costs->total_cost ?? 0) - ($costs->total_salary ?? 0),
            ];
        }

        return $trends;
    }

    public function getAgencyDistribution($departmentId)
    {
        return DB::table('users')
            ->select(
                'agencies.name as agency_name',
                DB::raw('COUNT(DISTINCT users.id) as employee_count'),
                DB::raw('SUM(users.salary) as total_salary'),
                DB::raw('SUM(users.salary_including_agency_fees) as total_cost')
            )
            ->join('users_departments', 'users.id', '=', 'users_departments.user_id')
            ->join('agencies', 'users.agency_id', '=', 'agencies.id')
            ->where('users_departments.department_id', $departmentId)
            ->whereNull('users.end_date')
            ->groupBy('agencies.id', 'agencies.name')
            ->get()
            ->map(function ($agency) {
                $agency->agency_fees = $agency->total_cost - $agency->total_salary;
                return $agency;
            });
    }
}