<?php

namespace App\Livewire\Roles;

use App\Models\Role;
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

        Role::create([
            'name' => $this->name,
            'description' => $this->description,
            'created_by' => auth()->id(),
            'updated_by' => auth()->id(),
        ]);

        session()->flash('message', 'Role successfully created.');
        return redirect()->route('roles');
    }

    public function render()
    {
        return view('livewire.roles.create')
            ->layout('layouts.app');
    }
}