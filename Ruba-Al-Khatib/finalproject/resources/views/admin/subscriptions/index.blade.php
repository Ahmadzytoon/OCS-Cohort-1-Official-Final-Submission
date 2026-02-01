@extends('admin.layout.master')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
  <h3 class="m-0">Subscriptions</h3>

  <div class="d-flex gap-2">
    <a class="btn btn-outline-secondary btn-sm" href="{{ route('admin.subscriptions.index') }}">All</a>
    <a class="btn btn-outline-warning btn-sm" href="{{ route('admin.subscriptions.index', ['status' => 'pending']) }}">Pending</a>
    <a class="btn btn-outline-success btn-sm" href="{{ route('admin.subscriptions.index', ['status' => 'active']) }}">Active</a>
    <a class="btn btn-outline-danger btn-sm" href="{{ route('admin.subscriptions.index', ['status' => 'canceled']) }}">Canceled</a>
  </div>
</div>

@if(session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('error'))
  <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="table-responsive">
  <table class="table table-bordered align-middle">
    <thead class="table-light">
      <tr>
        <th>#</th>
        <th>User</th>
        <th>Type</th>
        <th>Plan</th>
        <th>Status</th>
        <th>Payment</th>
        <th>Starts</th>
        <th>Ends</th>
        <th>Actions</th>
      </tr>
    </thead>

    <tbody>
      @forelse($subs as $sub)
        <tr>
          <td>{{ $sub->id }}</td>
          <td>
            <div style="font-weight:700;">{{ $sub->user->full_name ?? '—' }}</div>
            <div style="opacity:.7; font-size:13px;">{{ $sub->user->email ?? '' }}</div>
          </td>
          <td>{{ $sub->user->account_type ?? '—' }}</td>
          <td>{{ $sub->plan->name ?? '—' }}</td>
          <td>{{ $sub->status }}</td>
          <td>{{ $sub->payment_status ?? '—' }}</td>
          <td>{{ $sub->starts_at }}</td>
          <td>{{ $sub->ends_at }}</td>
          <td class="d-flex gap-2">

            @if($sub->status === 'pending' || ($sub->payment_status ?? null) === 'pending_payment')
              <form action="{{ route('admin.subscriptions.approve', $sub) }}" method="POST">
                @csrf
                <button class="btn btn-success btn-sm" onclick="return confirm('Approve this subscription?')">
                  Approve
                </button>
              </form>
            @endif

            @if($sub->status !== 'canceled')
              <form action="{{ route('admin.subscriptions.cancel', $sub) }}" method="POST">
                @csrf
                <button class="btn btn-danger btn-sm" onclick="return confirm('Cancel this subscription?')">
                  Cancel
                </button>
              </form>
            @endif

          </td>
        </tr>
      @empty
        <tr>
          <td colspan="9" class="text-center">No subscriptions found.</td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>

<div>
  {{ $subs->links() }}
</div>

@endsection
