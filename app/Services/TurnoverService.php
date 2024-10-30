<?php

namespace App\Services;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TurnoverService
{
    public function calculateTurnoverRate($startDate, $endDate, $groupBy = null)
    {
        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);

        $baseQuery = User::query()
            ->where(function ($query) use ($start, $end) {
                // Include users who left during the period
                $query->whereNotNull('end_date')
                    ->whereBetween('end_date', [$start, $end]);
            });

        $avgEmployeesQuery = User::query()
            ->where(function ($query) use ($start, $end) {
                // Active during the period
                $query->where(function ($q) use ($start, $end) {
                    $q->whereNull('end_date')
                        ->where('start_date', '<=', $end);
                })->orWhere(function ($q) use ($start, $end) {
                    $q->whereNotNull('end_date')
                        ->where('end_date', '>=', $start)
                        ->where('start_date', '<=', $end);
                });
            });

        if ($groupBy) {
            switch ($groupBy) {
                case 'department':
                    return $this->calculateGroupedTurnover($baseQuery, $avgEmployeesQuery, 'departments');
                case 'team':
                    return $this->calculateGroupedTurnover($baseQuery, $avgEmployeesQuery, 'teams');
                case 'office':
                    return $this->calculateGroupedTurnover($baseQuery, $avgEmployeesQuery, 'offices');
            }
        }

        $departures = $baseQuery->count();
        $avgEmployees = $avgEmployeesQuery->count();

        return [
            'departures' => $departures,
            'average_employees' => $avgEmployees,
            'turnover_rate' => $avgEmployees > 0 ? ($departures / $avgEmployees) * 100 : 0,
        ];
    }

    protected function calculateGroupedTurnover($baseQuery, $avgEmployeesQuery, $relation)
    {
        $departedUsers = clone $baseQuery;
        $avgUsers = clone $avgEmployeesQuery;

        $departures = $departedUsers
            ->join("{$relation} as r1", function ($join) {
                $join->on('users.id', '=', 'r1.user_id');
            })
            ->groupBy('r1.id', 'r1.name')
            ->select('r1.id', 'r1.name', DB::raw('COUNT(*) as departures'))
            ->get();

        $averages = $avgUsers
            ->join("{$relation} as r2", function ($join) {
                $join->on('users.id', '=', 'r2.user_id');
            })
            ->groupBy('r2.id', 'r2.name')
            ->select('r2.id', 'r2.name', DB::raw('COUNT(*) as total'))
            ->get();

        return $departures->map(function ($dept) use ($averages) {
            $avg = $averages->firstWhere('id', $dept->id);
            return [
                'name' => $dept->name,
                'departures' => $dept->departures,
                'average_employees' => $avg ? $avg->total : 0,
                'turnover_rate' => $avg && $avg->total > 0 ? ($dept->departures / $avg->total) * 100 : 0,
            ];
        });
    }

    public function getTurnoverTrend($months = 12)
    {
        $end = now()->endOfMonth();
        $start = $end->copy()->subMonths($months)->startOfMonth();
        
        $monthlyData = [];
        $current = $start->copy();

        while ($current <= $end) {
            $monthStart = $current->copy()->startOfMonth();
            $monthEnd = $current->copy()->endOfMonth();

            $stats = $this->calculateTurnoverRate($monthStart, $monthEnd);
            
            $monthlyData[] = [
                'month' => $current->format('M Y'),
                'turnover_rate' => $stats['turnover_rate'],
                'departures' => $stats['departures'],
            ];

            $current->addMonth();
        }

        return $monthlyData;
    }
}