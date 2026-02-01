@extends('layouts.master')

@section('title','Admin Dashboard')

@section('css')
<style>
  .stat-card{
    border: 0;
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 .35rem 1.2rem rgba(0,0,0,.06);
  }
  .stat-icon{
    width: 44px;
    height: 44px;
    border-radius: 14px;
    display:flex;
    align-items:center;
    justify-content:center;
    background: rgba(95,207,128,.14);
    color:#2f9b55;
    font-size: 1.25rem;
  }
  .stat-value{
    font-size: 1.6rem;
    font-weight: 800;
    letter-spacing: .2px;
  }
  .soft-badge{
    border-radius: 999px;
    padding: .35rem .65rem;
    font-size: .78rem;
  }
  .card-title-mini{
    font-weight: 700;
    letter-spacing: .2px;
  }
  .chart-card{
    border: 0;
    border-radius: 18px;
    box-shadow: 0 .35rem 1.2rem rgba(0,0,0,.06);
  }
</style>
@endsection

@section('content')
<section class="py-4">
  <div class="container-fluid container-xl" data-aos="fade-up">
    <div class="row g-4">

      {{-- Sidebar --}}
      @include('layouts.partials.side')

      {{-- Content --}}
      <div class="col-12 col-lg-9">

        {{-- Header --}}
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
          <div>
            <h3 class="mb-1">Admin Dashboard</h3>
            <div class="text-muted small">Overview of your platform statistics</div>
          </div>

          <div class="d-flex gap-2">
            <a href="{{ route('admin.teacher-profiles') }}" class="btn btn-sm btn-light border" style="border-radius:12px;">
              <i class="bi bi-person-badge me-1"></i>
              Teacher Profiles
            </a>
            <a href="{{ route('admin.subjects-branches') }}" class="btn btn-sm text-white" style="background-color:#5fcf80;border-radius:12px;">
              <i class="bi bi-diagram-3 me-1"></i>
              Subjects & Branches
            </a>
          </div>
        </div>

        {{-- Flash --}}
        @if (session('success'))
          <div class="alert alert-success small">{{ session('success') }}</div>
        @endif

        {{-- Stats --}}
        <div class="row g-3 mb-4">

          {{-- Students --}}
          <div class="col-12 col-md-4">
            <div class="card stat-card">
              <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                  <div class="stat-icon">
                    <i class="bi bi-mortarboard"></i>
                  </div>
                  <span class="soft-badge bg-light text-dark border">
                    <i class="bi bi-graph-up me-1"></i> Total
                  </span>
                </div>
                <div class="stat-value">{{ $studentsCount ?? 0 }}</div>
                <div class="text-muted small">Students</div>
              </div>
            </div>
          </div>

          {{-- Teachers --}}
          <div class="col-12 col-md-4">
            <div class="card stat-card">
              <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                  <div class="stat-icon">
                    <i class="bi bi-person-workspace"></i>
                  </div>
                  <span class="soft-badge bg-light text-dark border">
                    <i class="bi bi-people me-1"></i> Total
                  </span>
                </div>
                <div class="stat-value">{{ $teachersCount ?? 0 }}</div>
                <div class="text-muted small">Teachers</div>
              </div>
            </div>
          </div>

          {{-- Pending Profiles --}}
          <div class="col-12 col-md-4">
            <div class="card stat-card">
              <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                  <div class="stat-icon">
                    <i class="bi bi-hourglass-split"></i>
                  </div>
                  <span class="soft-badge text-white" style="background-color:#5fcf80;">
                    <i class="bi bi-shield-check me-1"></i> Needs action
                  </span>
                </div>
                <div class="stat-value">{{ $pendingProfilesCount ?? 0 }}</div>
                <div class="text-muted small">Pending Teacher Profiles</div>
              </div>
            </div>
          </div>

        </div>

        {{-- Chart + Quick cards --}}
        <div class="row g-3">

          {{-- Chart --}}
          <div class="col-12 col-lg-8">
            <div class="card chart-card">
              <div class="card-body p-4">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
                  <div>
                    <div class="card-title-mini mb-0">New Users (Last Months)</div>
                    <div class="text-muted small">Students + Teachers registrations</div>
                  </div>
                  <span class="soft-badge bg-light text-dark border">
                    <i class="bi bi-bar-chart me-1"></i> Chart
                  </span>
                </div>

                <div style="height: 280px;">
                  <canvas id="usersChart"></canvas>
                </div>
              </div>
            </div>
          </div>

          {{-- Right side small panels --}}
          <div class="col-12 col-lg-4">
            <div class="card chart-card mb-3">
              <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-2">
                  <div class="card-title-mini mb-0">Quick Links</div>
                  <i class="bi bi-lightning-charge text-success"></i>
                </div>

                <div class="d-grid gap-2">
                  <a href="{{ route('admin.teacher-profiles') }}" class="btn btn-light border" style="border-radius:12px;">
                    <i class="bi bi-person-badge me-1"></i> Manage Teacher Profiles
                  </a>
                  <a href="{{ route('admin.reviews') }}" class="btn btn-light border" style="border-radius:12px;">
                    <i class="bi bi-star me-1"></i> Manage Reviews
                  </a>
                  <a href="{{ route('admin.subjects-branches') }}" class="btn btn-light border" style="border-radius:12px;">
                    <i class="bi bi-diagram-3 me-1"></i> Subjects & Branches
                  </a>
                </div>
              </div>
            </div>

            <div class="card chart-card">
              <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-2">
                  <div class="card-title-mini mb-0">Status</div>
                  <span class="soft-badge bg-light text-dark border">System</span>
                </div>

                <div class="small text-muted mb-2">
                  Everything looks good. Keep approving teacher profiles to grow the platform.
                </div>

                <div class="d-flex align-items-center gap-2">
                  <span class="badge text-white" style="background-color:#5fcf80;border-radius:999px;">
                    <i class="bi bi-check-circle me-1"></i> Online
                  </span>
                  <span class="text-muted small">
                    Updated: {{ now()->format('M d, Y') }}
                  </span>
                </div>
              </div>
            </div>

          </div>
        </div>

      </div>
    </div>
  </div>
</section>
@endsection

@section('js')
  {{-- Chart.js CDN --}}
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <script>
    // بيانات من السيرفر (لازم تكون Arrays)
    const labels = @json($months ?? []);
    const dataVals = @json($monthlyNewUsers ?? []);

    const ctx = document.getElementById('usersChart');

    // إذا ما في بيانات، لا تعمل كراش
    if (ctx) {
      new Chart(ctx, {
        type: 'line',
        data: {
          labels: labels,
          datasets: [{
            label: 'New Users',
            data: dataVals,
            tension: 0.35,
            fill: true,
            borderWidth: 2,
            pointRadius: 3
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: { display: true }
          },
          scales: {
            y: { beginAtZero: true }
          }
        }
      });
    }
  </script>
@endsection
