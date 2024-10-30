<?php

namespace App\Livewire\Dashboard;

use App\Services\TurnoverService;
use Carbon\Carbon;
use Livewire\Component;

class TurnoverMetrics extends Component
{
    public $timeframe = '12m';
    public $groupBy = null;
    public $turnoverData;
    public $trendData;

    public function mount(TurnoverService $turnoverService)
    {
        $this->loadData($turnoverService);
    }

    public function loadData(TurnoverService $turnoverService)
    {
        $endDate = now();
        $startDate = match($this->timeframe) {
            '3m' => now()->subMonths(3),
            '6m' => now()->subMonths(6),
            '12m' => now()->subMonths(12),
            'ytd' => now()->startOfYear(),
            default => now()->subMonths(12),
        };

        $this->turnoverData = $turnoverService->calculateTurnoverRate(
            $startDate,
            $endDate,
            $this->groupBy
        );

        $this->trendData = $turnoverService->getTurnoverTrend(
            Carbon::parse($startDate)->diffInMonths($endDate)
        );
    }

    public function updatedTimeframe(TurnoverService $turnoverService)
    {
        $this->loadData($turnoverService);
    }

    public function updatedGroupBy(TurnoverService $turnoverService)
    {
        $this->loadData($turnoverService);
    }

    public function render()
    {
        return view('livewire.dashboard.turnover-metrics');
    }
}