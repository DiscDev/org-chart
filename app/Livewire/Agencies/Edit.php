<?php

namespace App\Livewire\Agencies;

use App\Models\Agency;
use Livewire\Component;

class Edit extends Component
{
    public Agency $agency;

    protected function rules()
    {
        return [
            'agency.name' => ['required', 'string', 'max:255'],
            'agency.description' => ['nullable', 'string'],
            'agency.agency_fees' => ['nullable', 'string'],
        ];
    }

    public function mount(Agency $agency)
    {
        $this->agency = $agency;
    }

    public function save()
    {
        $this->validate();

        $this->agency->updated_by = auth()->id();
        $this->agency->save();

        session()->flash('message', 'Agency successfully updated.');
        return redirect()->route('agencies');
    }

    public function render()
    {
        return view('livewire.agencies.edit')
            ->layout('layouts.app');
    }
}