@extends('layouts.master')

@section('title','Favorites')

@section('css')
<style>
  .fav-card{
    border-radius: 16px;
    transition: transform .15s ease, box-shadow .15s ease;
  }
  .fav-card:hover{
    transform: translateY(-2px);
    box-shadow: 0 .75rem 2rem rgba(0,0,0,.08);
  }
  .fav-overlay{
    background: linear-gradient(180deg, rgba(0,0,0,.05) 0%, rgba(0,0,0,.35) 100%);
  }
  .fav-remove{
    border-radius: 12px;
  }
</style>
@endsection

@section('content')
<section class="py-5">
  <div class="container" data-aos="fade-up">

    <div class="text-center mb-4">
      <h3 class="mb-1">My Favorite Teachers</h3>
      <p class="text-muted mb-0">Teachers you saved for quick access</p>

      <div class="mt-3 d-flex justify-content-center">
        <span class="badge bg-light text-dark border px-3 py-2">
          <i class="bi bi-heart-fill text-danger me-1"></i>
          Favorites
        </span>
      </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
      <div class="text-muted small">
        Showing <strong>{{ $favorites->total() }}</strong> favorite teachers
      </div>
    </div>

    <div class="row g-4">
      @forelse($favorites as $fav)
        @php
          $t = $fav->teacherProfile;

          $img = $t->image_path
              ? asset('storage/'.$t->image_path)
              : asset('assets/img/teacher-placeholder.jpg');
        @endphp

        <div class="col-12 col-sm-6 col-lg-4">
          <div class="card h-100 shadow-sm border-0 overflow-hidden fav-card">

            <div class="position-relative">
              <img
                src="{{ $img }}"
                class="w-100"
                alt="Teacher photo"
                style="height:220px;object-fit:cover"
              />

              <div class="position-absolute top-0 start-0 w-100 h-100 fav-overlay"></div>

              <span class="badge bg-light text-dark border position-absolute top-0 start-0 m-3 px-3 py-2">
                <i class="bi bi-heart-fill text-danger me-1"></i> Favorite
              </span>

              <form method="POST" action="{{ route('student.favorites.destroy', $fav->id) }}">
                @csrf
                @method('DELETE')

                <button
                  type="submit"
                  class="btn btn-sm btn-light border position-absolute top-0 end-0 m-3 fav-remove"
                  title="Remove from favorites"
                >
                  <i class="bi bi-trash text-danger"></i>
                </button>
              </form>
            </div>

            <div class="card-body">
              <div class="d-flex justify-content-between align-items-start">
                <div>
                  <h5 class="card-title mb-1">Tr. {{ $t->display_name }}</h5>
                  <div class="text-muted small">
                    {{ $t->subject?->name ?? '—' }} • {{ $t->branch?->name ?? '—' }}
                  </div>
                </div>

                <div class="text-end small">
                  <div class="fw-semibold">
                    <i class="bi bi-star-fill text-warning"></i>
                    {{ number_format($t->reviews_avg_rating ?? 0, 1) }}
                  </div>
                  <div class="text-muted">({{ $t->reviews_count ?? 0 }})</div>
                </div>
              </div>

              <div class="d-grid mt-3">
                <a href="{{ route('student.teacher-details', $t->id) }}" class="btn btn-outline-success">
                  <i class="bi bi-eye me-1"></i>
                  View Details
                </a>
              </div>
            </div>

          </div>
        </div>
      @empty
        <div class="col-12">
          <div class="text-center py-5 border rounded bg-light">
            <i class="bi bi-heart text-danger display-6 d-block mb-2"></i>
            <h4 class="mt-2">No favorites yet</h4>
            <p class="text-muted mb-4">
              Browse teachers and add them to your favorites to see them here.
            </p>
            <a href="{{ route('pages.teachers') }}" class="btn text-white" style="background-color:#5fcf80">
              Browse Teachers
            </a>
          </div>
        </div>
      @endforelse
    </div>

    @if($favorites->hasPages())
      <div class="pagination-wrapper mt-4 d-flex justify-content-center">
        {{ $favorites->links('pagination::bootstrap-5') }}
      </div>
    @endif

    <div class="text-muted small mt-4">
      <i class="bi bi-info-circle me-1"></i>
      Tip: Removing a teacher from favorites will not affect your service requests.
    </div>

  </div>
</section>
@endsection
