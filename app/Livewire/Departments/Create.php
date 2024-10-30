<?php

namespace App\Livewire\Departments;

use App\Models\Department;
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

        Department::create([
            'name' => $this->name,
            'description' => $this->description,
            'created_by' => auth()->id(),
            'updated_by' => auth()->id(),
        ]);

        session()->flash('message', 'Department successfully created.');
        return redirect()->route('departments');
    }

    public function render()
    {
        return view('livewire.departments.create')
            ->layout('layouts.app');
    }
}