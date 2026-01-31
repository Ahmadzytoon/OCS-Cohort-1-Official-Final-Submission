<?php

namespace App\Livewire\Provider;

use App\Models\Booking;
use Livewire\Component;
use Livewire\WithPagination;

class BookingsTable extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public string $status = '';

    protected $queryString = [
        'status' => ['except' => ''],
    ];

    public function updatedStatus(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $providerId = auth()->id();

        $bookings = Booking::query()
            ->where('provider_user_id', $providerId)
            ->when($this->status, fn ($q) => $q->where('status', $this->status))
            ->with(['customer:id,name', 'category:id,code,name', 'slot:id,start_time,end_time'])
            ->orderByDesc('id')
            ->paginate(10);

        $statusClass = [
            'pending' => 'cc-badge-pending',
            'accepted' => 'cc-badge-confirmed',
            'completed' => 'cc-badge-upcoming',
            'rejected' => 'cc-badge-cancel',
        ];

        return view('livewire.provider.bookings-table', [
            'bookings' => $bookings,
            'statusClass' => $statusClass,
        ]);
    }
}
