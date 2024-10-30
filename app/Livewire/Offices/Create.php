<?php

namespace App\Livewire\Offices;

use App\Models\Office;
use Livewire\Component;

class Create extends Component
{
    public $name;
    public $location;
    public $description;

    protected function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ];
    }

    public function save()
    {
        $this->validate();

        Office::create([
            'name' => $this->name,
            'location' => $this->location,
            'description' => $this->description,
            'created_by' => auth()->id(),
            'updated_by' => auth()->id(),
        ]);

        session()->flash('message', 'Office successfully created.');
        return redirect()->route('offices');
    }

    public function render()
    {
        return view('livewire.offices.create')
            ->layout('layouts.app');
    }
}