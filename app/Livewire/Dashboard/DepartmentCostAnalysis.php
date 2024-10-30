<?php

namespace App\Livewire\Dashboard;

use App\Services\DepartmentCostService;
use Livewire\Component;

class DepartmentCostAnalysis extends Component
{
    public $period = '12m';
    public $selectedDepartment = null;
    public $showAgencyFees = true;

    public function mount(DepartmentCostService $costService)
    {
        $this->loadData($costService);
    }

    public function loadData(DepartmentCostService $costService)
    {
        $this->departmentCosts = $costService->getDepartmentCosts($this->period);
        
        if ($this->selectedDepartment) {
            $this->costTrends = $costService->getCostTrends(
                $this->selectedDepartment,
                match($this->period) {
                    '3m' => 3,
                    '6m' => 6,
                    '12m' => 12,
                    'ytd' => now()->month,
                    default => 12,
                }
            );
            
            $this->agencyDistribution = $costService->getAgencyDistribution($this->selectedDepartment);
        }
    }

    public function updatedPeriod(DepartmentCostService $costService)
    {
        $this->loadData($costService);
    }

    public function updatedSelectedDepartment(DepartmentCostService $costService)
    {
        $this->loadData($costService);
    }

    public function render()
    {
        return view('livewire.dashboard.department-cost-analysis');
    }
}