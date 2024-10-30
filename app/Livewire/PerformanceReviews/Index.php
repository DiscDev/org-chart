<?php

namespace App\Livewire\PerformanceReviews;

use App\Models\PerformanceReview;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $status = '';
    public $dateRange = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'status' => ['except' => ''],
        'dateRange' => ['except' => ''],
    ];

    public function render()
    {
        $reviews = PerformanceReview::query()
            ->with(['user', 'reviewer'])
            ->when($this->search, function ($query) {
                $query->whereHas('user', function ($q) {
                    $q->where('first_name', 'like', '%' . $this->search . '%')
                        ->orWhere('last_name', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->status, function ($query) {
                $query->where('status', $this->status);
            })
            ->when($this->dateRange, function ($query) {
                // Parse date range and apply filter
                $dates = explode(' - ', $this->dateRange);
                if (count($dates) === 2) {
                    $query->whereBetween('scheduled_date', $dates);
                }
            })
            ->orderBy('scheduled_date')
            ->paginate(10);

        return view('livewire.performance-reviews.index', [
            'reviews' => $reviews,
        ])->layout('layouts.app');
    }
}