<?php

namespace App\Http\Livewire\Users;

use App\Models\Department;
use App\Models\Team;
use App\Models\User;
use Livewire\Component;

class BulkActions extends Component
{
    public $selected = [];
    public $selectAll = false;
    public $action = '';
    public $targetDepartment;
    public $targetTeam;

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selected = User::pluck('id')->map(fn($id) => (string) $id)->toArray();
        } else {
            $this->selected = [];
        }
    }

    public function executeAction()
    {
        if (empty($this->selected) || empty($this->action)) {
            session()->flash('error', 'Please select users and an action to perform.');
            return;
        }

        $users = User::whereIn('id', $this->selected);

        switch ($this->action) {
            case 'add_to_department':
                if ($this->targetDepartment) {
                    $users->each(function ($user) {
                        $user->departments()->syncWithoutDetaching([$this->targetDepartment]);
                    });
                    session()->flash('message', 'Users added to department successfully.');
                }
                break;

            case 'add_to_team':
                if ($this->targetTeam) {
                    $users->each(function ($user) {
                        $user->teams()->syncWithoutDetaching([$this->targetTeam]);
                    });
                    session()->flash('message', 'Users added to team successfully.');
                }
                break;

            case 'deactivate':
                $users->update(['end_date' => now()]);
                session()->flash('message', 'Users deactivated successfully.');
                break;
        }

        $this->selected = [];
        $this->selectAll = false;
        $this->action = '';
        $this->targetDepartment = null;
        $this->targetTeam = null;

        $this->emit('refreshUsers');
    }

    public function render()
    {
        return view('livewire.users.bulk-actions', [
            'departments' => Department::orderBy('name')->get(),
            'teams' => Team::orderBy('name')->get(),
        ]);
    }
}