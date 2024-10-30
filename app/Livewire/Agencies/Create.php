<?php

namespace App\Livewire\Agencies;

use App\Models\Agency;
use Livewire\Component;

class Create extends Component
{
    public $name;
    public $description;
    public $agency_fees;

    protected function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'agency_fees' => ['nullable', 'string'],
        ];
    }

    public function save()
    {
        $this->validate();

        Agency::create([
            'name' => $this->name,
            'description' => $this->description,
            'agency_fees' => $this->agency_fees,
            'created_by' => auth()->id(),
            'updated_by' => auth()->id(),
        ]);

        session()->flash('message', 'Agency successfully created.');
        return redirect()->route('agencies');
    }

    public function render()
    {
        return view('livewire.agencies.create')
            ->layout('layouts.app');
    }
}