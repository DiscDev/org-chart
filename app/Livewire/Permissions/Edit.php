<?php

namespace App\Livewire\Permissions;

use App\Models\Permission;
use Livewire\Component;

class Edit extends Component
{
    public Permission $permission;

    protected function rules()
    {
        return [
            'permission.name' => ['required', 'string', 'max:255', 'unique:permissions,name,' . $this->permission->id],
            'permission.description' => ['nullable', 'string'],
        ];
    }

    public function mount(Permission $permission)
    {
        $this->permission = $permission;
    }

    public function save()
    {
        $this->validate();

        $this->permission->updated_by = auth()->id();
        $this->permission->save();

        session()->flash('message', 'Permission successfully updated.');
        return redirect()->route('permissions');
    }

    public function render()
    {
        return view('livewire.permissions.edit')
            ->layout('layouts.app');
    }
}