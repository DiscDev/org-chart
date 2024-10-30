<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;

class OrgChart extends Component
{
    public $filters = [
        'department' => '',
        'team' => '',
        'role' => '',
        'office' => '',
        'agency' => '',
    ];

    protected function buildHierarchy(?int $managerId = null): array
    {
        $users = User::query()
            ->when($managerId === null, fn($query) => $query->whereNull('manager_id'))
            ->when($managerId !== null, fn($query) => $query->where('manager_id', $managerId))
            ->when($this->filters['department'], function($query, $department) {
                $query->whereHas('departments', fn($q) => $q->where('departments.id', $department));
            })
            ->when($this->filters['team'], function($query, $team) {
                $query->whereHas('teams', fn($q) => $q->where('teams.id', $team));
            })
            ->when($this->filters['role'], function($query, $role) {
                $query->whereHas('roles', fn($q) => $q->where('roles.id', $role));
            })
            ->when($this->filters['office'], function($query, $office) {
                $query->whereHas('offices', fn($q) => $q->where('offices.id', $office));
            })
            ->when($this->filters['agency'], function($query, $agency) {
                $query->where('agency_id', $agency);
            })
            ->with(['departments', 'teams', 'roles', 'offices'])
            ->get();

        return $users->map(function($user) {
            return [
                'id' => $user->id,
                'name' => $user->full_name,
                'title' => $user->job_title,
                'photo' => $user->photo_url,
                'departments' => $user->departments->pluck('name'),
                'teams' => $user->teams->pluck('name'),
                'roles' => $user->roles->pluck('name'),
                'children' => $this->buildHierarchy($user->id),
            ];
        })->toArray();
    }

    public function render()
    {
        $hierarchy = $this->buildHierarchy();

        return view('livewire.org-chart', [
            'hierarchy' => $hierarchy,
            'departments' => \App\Models\Department::orderBy('name')->get(),
            'teams' => \App\Models\Team::orderBy('name')->get(),
            'roles' => \App\Models\Role::orderBy('name')->get(),
            'offices' => \App\Models\Office::orderBy('name')->get(),
            'agencies' => \App\Models\Agency::orderBy('name')->get(),
        ])->layout('layouts.app');
    }
}