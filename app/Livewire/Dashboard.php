<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Department;
use App\Models\Team;
use App\Models\Office;
use App\Models\Agency;
use App\Models\Role;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Dashboard extends Component
{
    public $salaryGroupBy = 'department';
    public $showAgencyFees = false;

    public function getSalaryData()
    {
        $query = User::query()
            ->whereNotNull('salary')
            ->select(
                DB::raw('AVG(salary) as avg_salary'),
                DB::raw('AVG(salary_including_agency_fees) as avg_total_salary'),
                DB::raw('COUNT(*) as total_users')
            );

        switch ($this->salaryGroupBy) {
            case 'department':
                return User::join('users_departments', 'users.id', '=', 'users_departments.user_id')
                    ->join('departments', 'users_departments.department_id', '=', 'departments.id')
                    ->whereNotNull('salary')
                    ->groupBy('departments.id', 'departments.name')
                    ->select(
                        'departments.name',
                        DB::raw('AVG(salary) as avg_salary'),
                        DB::raw('AVG(salary_including_agency_fees) as avg_total_salary'),
                        DB::raw('COUNT(*) as total_users')
                    )
                    ->get();

            case 'team':
                return User::join('users_teams', 'users.id', '=', 'users_teams.user_id')
                    ->join('teams', 'users_teams.team_id', '=', 'teams.id')
                    ->whereNotNull('salary')
                    ->groupBy('teams.id', 'teams.name')
                    ->select(
                        'teams.name',
                        DB::raw('AVG(salary) as avg_salary'),
                        DB::raw('AVG(salary_including_agency_fees) as avg_total_salary'),
                        DB::raw('COUNT(*) as total_users')
                    )
                    ->get();

            case 'agency':
                return User::join('agencies', 'users.agency_id', '=', 'agencies.id')
                    ->whereNotNull('salary')
                    ->groupBy('agencies.id', 'agencies.name')
                    ->select(
                        'agencies.name',
                        DB::raw('AVG(salary) as avg_salary'),
                        DB::raw('AVG(salary_including_agency_fees) as avg_total_salary'),
                        DB::raw('COUNT(*) as total_users')
                    )
                    ->get();

            case 'role':
                return User::join('users_roles', 'users.id', '=', 'users_roles.user_id')
                    ->join('roles', 'users_roles.role_id', '=', 'roles.id')
                    ->whereNotNull('salary')
                    ->groupBy('roles.id', 'roles.name')
                    ->select(
                        'roles.name',
                        DB::raw('AVG(salary) as avg_salary'),
                        DB::raw('AVG(salary_including_agency_fees) as avg_total_salary'),
                        DB::raw('COUNT(*) as total_users')
                    )
                    ->get();
        }
    }

    public function getStatistics()
    {
        return [
            'total_users' => User::count(),
            'active_users' => User::whereNull('end_date')->count(),
            'departments_count' => Department::count(),
            'teams_count' => Team::count(),
            'offices_count' => Office::count(),
            'agencies_count' => Agency::count(),
        ];
    }

    public function getDepartmentDistribution()
    {
        return Department::withCount('users')
            ->orderBy('users_count', 'desc')
            ->take(5)
            ->get();
    }

    public function getTeamDistribution()
    {
        return Team::withCount('users')
            ->orderBy('users_count', 'desc')
            ->take(5)
            ->get();
    }

    public function getOfficeDistribution()
    {
        return Office::withCount('users')
            ->orderBy('users_count', 'desc')
            ->get();
    }

    public function getRecentUsers()
    {
        return User::with(['departments', 'teams', 'roles'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
    }

    public function render()
    {
        $salaryData = $this->getSalaryData();
        
        return view('livewire.dashboard', [
            'statistics' => $this->getStatistics(),
            'departmentDistribution' => $this->getDepartmentDistribution(),
            'teamDistribution' => $this->getTeamDistribution(),
            'officeDistribution' => $this->getOfficeDistribution(),
            'recentUsers' => $this->getRecentUsers(),
            'salaryData' => $salaryData,
        ])->layout('layouts.app');
    }
}