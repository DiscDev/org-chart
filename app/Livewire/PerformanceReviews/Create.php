<?php

namespace App\Livewire\PerformanceReviews;

use App\Models\PerformanceReview;
use App\Models\User;
use Livewire\Component;

class Create extends Component
{
    public $user_id;
    public $reviewer_id;
    public $scheduled_date;
    public $objectives;

    protected function rules()
    {
        return [
            'user_id' => ['required', 'exists:users,id'],
            'reviewer_id' => ['required', 'exists:users,id'],
            'scheduled_date' => ['required', 'date', 'after:today'],
            'objectives' => ['required', 'string'],
        ];
    }

    public function save()
    {
        $this->validate();

        PerformanceReview::create([
            'user_id' => $this->user_id,
            'reviewer_id' => $this->reviewer_id,
            'scheduled_date' => $this->scheduled_date,
            'objectives' => $this->objectives,
            'status' => 'scheduled',
            'created_by' => auth()->id(),
            'updated_by' => auth()->id(),
        ]);

        session()->flash('message', 'Performance review scheduled successfully.');
        return redirect()->route('performance-reviews');
    }

    public function render()
    {
        $users = User::orderBy('first_name')->get();
        $reviewers = User::whereHas('userType', function ($query) {
            $query->whereIn('name', ['Admin', 'Manager']);
        })->orderBy('first_name')->get();

        return view('livewire.performance-reviews.create', [
            'users' => $users,
            'reviewers' => $reviewers,
        ])->layout('layouts.app');
    }
}