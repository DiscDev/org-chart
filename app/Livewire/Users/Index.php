<?php

namespace App\Livewire\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $sortField = 'username';
    public $sortDirection = 'asc';
    public $filters = [
        'user_type' => '',
        'department' => '',
        'team' => '',
        'role' => '',
        'office' => '',
        'agency' => '',
    ];

    protected $queryString = [
        'search' => ['except' => ''],
        'sortField' => ['except' => 'username'],
        'sortDirection' => ['except' => 'asc'],
    ];

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $users = User::query()
            ->when($this->search, function ($query) {
                $query->where(function ($query) {
                    $query->where('username', 'like', '%' . $this->search . '%')
                        ->orWhere('first_name', 'like', '%' . $this->search . '%')
                        ->orWhere('last_name', 'like', '%' . $this->search . '%')
                        ->orWhere('email_work', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->filters['user_type'], function ($query, $userType) {
                $query->where('user_type_id', $userType);
            })
            ->when($this->filters['department'], function ($query, $department) {
                $query->whereHas('departments', function ($query) use ($department) {
                    $query->where('departments.id', $department);
                });
            })
            ->when($this->filters['team'], function ($query, $team) {
                $query->whereHas('teams', function ($query) use ($team) {
                    $query->where('teams.id', $team);
                });
            })
            ->when($this->filters['role'], function ($query, $role) {
                $query->whereHas('roles', function ($query) use ($role) {
                    $query->where('roles.id', $role);
                });
            })
            ->when($this->filters['office'], function ($query, $office) {
                $query->whereHas('offices', function ($query) use ($office) {
                    $query->where('offices.id', $office);
                });
            })
            ->when($this->filters['agency'], function ($query, $agency) {
                $query->where('agency_id', $agency);
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        return view('livewire.users.index', [
            'users' => $users,
        ])->layout('layouts.app');
    }
}