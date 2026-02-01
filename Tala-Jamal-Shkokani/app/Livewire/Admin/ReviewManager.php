<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Review;
use Livewire\WithPagination;
use Carbon\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Attributes\Title;

#[Layout('layouts.admin')]
#[Title('Impression Moderation')]
class ReviewManager extends Component
{
    use WithPagination;

    // Filters
    #[Url(as: 'search')]
    public $search = '';

    #[Url(as: 'status')]
    public $statusFilter = ''; // approved, pending

    #[Url(as: 'rating')]
    public $ratingFilter = '';

    #[Url(as: 'date')]
    public $dateFilter = 'all';

    // Sorting
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    // Selection
    public $selectAll = false;
    public $selectedRows = [];

    // Details/Moderation
    public $selectedReview = null;
    public $showReviewSidebar = false;

    protected $paginationTheme = 'bootstrap';

    public function updatedSearch()
    {
        $this->resetPage();
    }
    public function updatedStatusFilter()
    {
        $this->resetPage();
    }
    public function updatedRatingFilter()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedRows = Review::pluck('id')->map(fn($id) => (string) $id)->toArray();
        } else {
            $this->selectedRows = [];
        }
    }

    public function resetFilters()
    {
        $this->reset(['search', 'statusFilter', 'ratingFilter', 'dateFilter']);
        $this->resetPage();
    }

    public function toggleApproval($id)
    {
        $review = Review::findOrFail($id);
        $review->update(['is_approved' => !$review->is_approved]);

        if ($this->selectedReview && $this->selectedReview->id == $id) {
            $this->selectedReview = $review->fresh(['user', 'product']);
        }

        $this->dispatch('swal:success', ['title' => 'Updated', 'text' => 'Impression status changed.', 'icon' => 'success']);
    }

    public function viewDetails($id)
    {
        $this->selectedReview = Review::with(['user', 'product'])->findOrFail($id);
        $this->showReviewSidebar = true;
    }

    public function deleteReview($id)
    {
        Review::findOrFail($id)->delete();
        $this->showReviewSidebar = false;
        $this->dispatch('swal:success', ['title' => 'Removed', 'text' => 'Impression has been deleted.', 'icon' => 'success']);
    }

    public function bulkApprove()
    {
        Review::whereIn('id', $this->selectedRows)->update(['is_approved' => true]);
        $this->resetSelection();
        $this->dispatch('swal:success', ['title' => 'Bulk Action', 'text' => 'Selected reviews approved.', 'icon' => 'success']);
    }

    public function bulkDelete()
    {
        Review::whereIn('id', $this->selectedRows)->delete();
        $this->resetSelection();
        $this->dispatch('swal:success', ['title' => 'Bulk Action', 'text' => 'Selected reviews removed.', 'icon' => 'success']);
    }

    private function resetSelection()
    {
        $this->selectedRows = [];
        $this->selectAll = false;
    }

    public function render()
    {
        $query = Review::with(['user', 'product']);

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('comment', 'like', '%' . $this->search . '%')
                    ->orWhereHas('user', function ($u) {
                        $u->where('name', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('product', function ($p) {
                        $p->where('name', 'like', '%' . $this->search . '%');
                    });
            });
        }

        if ($this->statusFilter) {
            $query->where('is_approved', $this->statusFilter === 'approved');
        }

        if ($this->ratingFilter) {
            $query->where('rating', $this->ratingFilter);
        }

        if ($this->dateFilter !== 'all') {
            $query->where('created_at', '>=', match ($this->dateFilter) {
                'today' => Carbon::today(),
                'week' => Carbon::now()->subDays(7),
                'month' => Carbon::now()->subMonth(),
                'year' => Carbon::now()->subYear(),
            });
        }

        $reviews = $query->orderBy($this->sortField, $this->sortDirection)->paginate(10);

        $stats = [
            'total' => Review::count(),
            'pending' => Review::where('is_approved', false)->count(),
            'average' => round(Review::avg('rating'), 1),
        ];

        return view('livewire.admin.review-manager', [
            'reviews' => $reviews,
            'stats' => $stats
        ]);
    }
}
