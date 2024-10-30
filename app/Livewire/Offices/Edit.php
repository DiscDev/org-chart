<?php

namespace App\Livewire\Offices;

use App\Models\Office;
use Livewire\Component;

class Edit extends Component
{
    public Office $office;

    protected function rules()
    {
        return [
            'office.name' => ['required', 'string', 'max:255'],
            'office.location' => ['required', 'string', 'max:255'],
            'office.description' => ['nullable', 'string'],
        ];
    }

    public function mount(Office $office)
    {
        $this->office = $office;
    }

    public function save()
    {
        $this->validate();

        $this->office->updated_by = auth()->id();
        $this->office->save();

        session()->flash('message', 'Office successfully updated.');
        return redirect()->route('offices');
    }

    public function render()
    {
        return view('livewire.offices.edit')
            ->layout('layouts.app');
    }
}