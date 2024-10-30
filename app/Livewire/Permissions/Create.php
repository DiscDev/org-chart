<?php

namespace App\Livewire\Permissions;

use App\Models\Permission;
use Livewire\Component;

class Create extends Component
{
    public $name;
    public $description;

    protected function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:permissions'],
            'description' => ['nullable', 'string'],
        ];
    }

    public function save()
    {
        $this->validate();

        Permission::create([
            'name' => $this->name,
            'description' => $this->description,
            'created_by' => auth()->id(),
            'updated_by' => auth()->id(),
        ]);

        session()->flash('message', 'Permission successfully created.');
        return redirect()->route('permissions');
    }

    public function render()
    {
        return view('livewire.permissions.create')
            ->layout('layouts.app');
    }
}