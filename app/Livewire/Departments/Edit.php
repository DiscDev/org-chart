<?php

namespace App\Livewire\Departments;

use App\Models\Department;
use Livewire\Component;

class Edit extends Component
{
    public Department $department;

    protected function rules()
    {
        return [
            'department.name' => ['required', 'string', 'max:255'],
            'department.description' => ['nullable', 'string'],
        ];
    }

    public function mount(Department $department)
    {
        $this->department = $department;
    }

    public function save()
    {
        $this->validate();

        $this->department->updated_by = auth()->id();
        $this->department->save();

        session()->flash('message', 'Department successfully updated.');
        return redirect()->route('departments');
    }

    public function render()
    {
        return view('livewire.departments.edit')
            ->layout('layouts.app');
    }
}