<?php

namespace App\Livewire\Teams;

use App\Models\Team;
use Livewire\Component;

class Edit extends Component
{
    public Team $team;

    protected function rules()
    {
        return [
            'team.name' => ['required', 'string', 'max:255'],
            'team.description' => ['nullable', 'string'],
        ];
    }

    public function mount(Team $team)
    {
        $this->team = $team;
    }

    public function save()
    {
        $this->validate();

        $this->team->updated_by = auth()->id();
        $this->team->save();

        session()->flash('message', 'Team successfully updated.');
        return redirect()->route('teams');
    }

    public function render()
    {
        return view('livewire.teams.edit')
            ->layout('layouts.app');
    }
}