<?php

namespace App\Livewire\Roles;

use App\Models\Role;
use Livewire\Component;

class Edit extends Component
{
    public Role $role;

    protected function rules()
    {
        return [
            'role.name' => ['required', 'string', 'max:255'],
            'role.description' => ['nullable', 'string'],
        ];
    }

    public function mount(Role $role)
    {
        $this->role = $role;
    }

    public function save()
    {
        $this->validate();

        $this->role->updated_by = auth()->id();
        $this->role->save();

        session()->flash('message', 'Role successfully updated.');
        return redirect()->route('roles');
    }

    public function render()
    {
        return view('livewire.roles.edit')
            ->layout('layouts.app');
    }
}