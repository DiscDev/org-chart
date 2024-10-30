<?php

namespace App\Livewire\Teams;

use App\Models\Team;
use Livewire\Component;

class Create extends Component
{
    public $name;
    public $description;

    protected function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ];
    }

    public function save()
    {
        $this->validate();

        Team::create([
            'name' => $this->name,
            'description' => $this->description,
            'created_by' => auth()->id(),
            'updated_by' => auth()->id(),
        ]);

        session()->flash('message', 'Team successfully created.');
        return redirect()->route('teams');
    }

    public function render()
    {
        return view('livewire.teams.create')
            ->layout('layouts.app');
    }
}