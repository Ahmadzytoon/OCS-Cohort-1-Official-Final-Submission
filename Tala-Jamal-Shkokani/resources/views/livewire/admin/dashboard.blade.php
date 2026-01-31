<div class="animate-fade-in">
    <!-- Header & Actions -->
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h1 class="h2 mb-1" style="font-family: var(--font-heading); font-weight: 700;">Curator Analytics</h1>
            <p class="text-muted small mb-0">High-fidelity overview of your luxury collection performance.</p>
        </div>
        <div class="d-flex gap-3">
            <!-- Actions removed as requested -->
        </div>
    </div>

    <!-- Widgets -->
    <div class="row g-4 mb-5">
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100 p-2 stat-card rounded-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="p-3 rounded-4" style="background: rgba(246, 166, 178, 0.1);">
                            <i class="fas fa-sack-dollar text-primary" style="font-size: 1.2rem;"></i>
                        </div>
                        <div class="text-success extra-small fw-bold bg-success bg-opacity-10 px-2 py-1 rounded-pill">
                            <i class="fa-solid fa-arrow-up"></i> {{ $stats['revenue_change'] }}%
                        </div>
                    </div>
                    <div class="extra-small text-muted fw-bold text-uppercase ls-1 mb-2">Total Revenue</div>
                    <div class="h3 mb-0 fw-bold" style="letter-spacing: -1px;">
                        {{ number_format($stats['total_revenue'], 0) }} <span
                            class="fs-6 fw-normal text-muted">JOD</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100 p-2 stat-card rounded-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="p-3 rounded-4" style="background: rgba(30, 30, 30, 0.05);">
                            <i class="fas fa-boxes-packing text-dark" style="font-size: 1.2rem;"></i>
                        </div>
                        <div class="text-primary extra-small fw-bold bg-soft-blush px-2 py-1 rounded-pill">
                            Active
                        </div>
                    </div>
                    <div class="extra-small text-muted fw-bold text-uppercase ls-1 mb-2">Active Orders</div>
                    <div class="h3 mb-0 fw-bold" style="letter-spacing: -1px;">{{ $stats['active_orders'] }}</div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100 p-2 stat-card rounded-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="p-3 rounded-4" style="background: #FEFAE0;">
                            <i class="fas fa-gem" style="font-size: 1.2rem; color: #B9975B !important;"></i>
                        </div>
                        <div
                            class="text-warning extra-small fw-bold bg-warning bg-opacity-10 px-2 py-1 rounded-pill border border-warning border-opacity-25">
                            Premium
                        </div>
                    </div>
                    <div class="extra-small text-muted fw-bold text-uppercase ls-1 mb-2">Avg. Order Value</div>
                    <div class="h3 mb-0 fw-bold" style="letter-spacing: -1px;">
                        {{ number_format($stats['avg_order_value'], 0) }} <span
                            class="fs-6 fw-normal text-muted">JOD</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100 p-2 stat-card rounded-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="p-3 rounded-4" style="background: rgba(228, 139, 154, 0.1);">
                            <i class="fas fa-users-viewfinder"
                                style="font-size: 1.2rem; color: var(--color-dusty-rose);"></i>
                        </div>
                        <div class="text-dark extra-small fw-bold bg-light px-2 py-1 rounded-pill border">
                            Growth
                        </div>
                    </div>
                    <div class="extra-small text-muted fw-bold text-uppercase ls-1 mb-2">Conversion Rate</div>
                    <div class="h3 mb-0 fw-bold" style="letter-spacing: -1px;">{{ $stats['conversion_rate'] }}%</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 h-100 rounded-4 overflow-hidden">
                <div class="card-header py-4 bg-white border-0 px-4">
                    <h6 class="m-0 fw-bold text-dark text-uppercase extra-small ls-1">Performance Dynamics</h6>
                </div>
                <div class="card-body px-4 pb-4">
                    <div class="chart-area" style="height: 350px;">
                        <canvas id="myAreaChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm border-0 h-100 rounded-4 overflow-hidden">
                <div class="card-header py-4 bg-white border-0 px-4">
                    <h6 class="m-0 fw-bold text-dark text-uppercase extra-small ls-1">Style DNA Mix</h6>
                </div>
                <div class="card-body d-flex flex-column align-items-center px-4 pb-4">
                    <div class="chart-pie pt-4 pb-2" style="height: 250px; width: 100%;">
                        <canvas id="myPieChart"></canvas>
                    </div>
                    <div class="mt-4 text-center small w-100">
                        <div class="d-flex flex-wrap justify-content-around gap-2 px-1">
                            @foreach($styleDistribution['labels'] as $index => $label)
                                <span class="d-flex align-items-center extra-small fw-bold text-uppercase ls-1">
                                    <i class="fas fa-circle me-2"
                                        style="color: {{ ['#F6A6B2', '#1E1E1E', '#C9A24D', '#A52A2A'][$index % 4] }}; font-size: 8px;"></i>
                                    {{ $label }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Insights & Recent Activity -->
    <div class="row g-4 mb-5">
        <div class="col-lg-4">
            <!-- Customer of the Month -->
            <div class="card shadow-sm border-0 h-100 rounded-4 overflow-hidden mb-4">
                <div class="card-header py-3 bg-white border-0 px-4">
                    <h6 class="m-0 fw-bold text-dark text-uppercase extra-small ls-1">Star Client</h6>
                </div>
                <div
                    class="card-body px-4 pb-4 pt-0 d-flex flex-column align-items-center justify-content-center text-center">
                    @if($customerOfTheMonth)
                        <div class="bg-soft-blush rounded-circle d-flex align-items-center justify-content-center mb-3"
                            style="width: 80px; height: 80px; border: 4px solid white; box-shadow: 0 5px 15px rgba(246,166,178,0.2);">
                            <span class="h2 mb-0 fw-bold text-dark">{{ substr($customerOfTheMonth->name, 0, 1) }}</span>
                        </div>
                        <h5 class="fw-bold mb-1">{{ $customerOfTheMonth->name }}</h5>
                        <p class="text-muted small mb-3">{{ $customerOfTheMonth->email }}</p>
                        <div class="d-flex gap-2">
                            <span class="badge bg-warning text-dark rounded-pill px-3 py-2 border shadow-sm">
                                <i class="fa fa-crown me-1 text-dark"></i> Top Spender
                            </span>
                            <span class="badge bg-light text-dark rounded-pill px-3 py-2 border">
                                JOD {{ number_format($customerOfTheMonth->monthly_spend, 0) }}
                            </span>
                        </div>
                    @else
                        <div class="text-muted small italic">No sales data for this month yet.</div>
                    @endif
                </div>
            </div>

            <!-- Best Seller -->
            <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
                <div class="card-header py-3 bg-white border-0 px-4">
                    <h6 class="m-0 fw-bold text-dark text-uppercase extra-small ls-1">Trending Piece</h6>
                </div>
                <div class="card-body px-4 pb-4 pt-0">
                    @if($bestSeller)
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-3 overflow-hidden shadow-sm d-flex align-items-center justify-content-center bg-light"
                                style="width: 70px; height: 70px;">
                                <img src="{{ $bestSeller->image ?: 'https://via.placeholder.com/150' }}"
                                    class="w-100 h-100 object-fit-cover">
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1 small">{{ $bestSeller->name }}</h6>
                                <p class="text-muted extra-small mb-1 text-uppercase">
                                    {{ $bestSeller->category->name ?? 'Collection' }}
                                </p>
                                <span class="badge bg-dark rounded-pill extra-small">
                                    {{ $bestSeller->total_sold }} Sold / 30 Days
                                </span>
                            </div>
                        </div>
                    @else
                        <div class="text-muted small italic">No sales trend data available.</div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card shadow-sm border-0 h-100 rounded-4 overflow-hidden">
                <div class="card-header py-4 bg-white border-0 px-4 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 fw-bold text-dark text-uppercase extra-small ls-1">Recent Acquisitions</h6>
                    <a href="{{ route('admin.orders.index') }}"
                        class="btn btn-link p-0 text-muted extra-small text-decoration-none hover-lift">View All
                        Orders</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light bg-opacity-50 align-top">
                                <tr>
                                    <th class="ps-4 py-3 border-0 text-uppercase extra-small text-muted fw-bold ls-1">ID
                                    </th>
                                    <th class="py-3 border-0 text-uppercase extra-small text-muted fw-bold ls-1">Client
                                    </th>
                                    <th class="py-3 border-0 text-uppercase extra-small text-muted fw-bold ls-1">Amount
                                    </th>
                                    <th
                                        class="py-3 border-0 text-uppercase extra-small text-muted fw-bold ls-1 text-center">
                                        Status</th>
                                    <th
                                        class="pe-4 py-3 border-0 text-end text-uppercase extra-small text-muted fw-bold ls-1">
                                        Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentPurchases as $order)
                                                            <tr class="border-top" style="border-color: rgba(0,0,0,0.02) !important;">
                                                                <td class="ps-4 small fw-bold text-muted">#{{ $order->order_number }}</td>
                                                                <td>
                                                                    <div class="d-flex align-items-center gap-2">
                                                                        <div class="bg-light rounded-circle d-flex align-items-center justify-content-center text-muted fw-bold"
                                                                            style="width: 24px; height: 24px; font-size: 0.6rem;">
                                                                            {{ substr($order->user->name ?? 'G', 0, 1) }}
                                                                        </div>
                                                                        <span
                                                                            class="small fw-bold text-dark">{{ $order->user->name ?? 'Guest' }}</span>
                                                                    </div>
                                                                </td>
                                                                <td class="text-dark fw-bold small">{{ number_format($order->total_amount, 0) }} JOD
                                                                </td>
                                                                <td class="text-center">
                                                                    <span
                                                                        class="badge rounded-pill px-2 py-1 extra-small border 
                                                                                                                                                                                            {{ $order->status === 'delivered' ? 'bg-success-subtle text-success border-success-subtle' :
                                    ($order->status === 'pending' ? 'bg-warning-subtle text-warning border-warning-subtle' : 'bg-light text-dark') }}">
                                                                        {{ ucfirst($order->status) }}
                                                                    </span>
                                                                </td>
                                                                <td class="text-end pe-4 text-muted extra-small">
                                                                    {{ $order->created_at->diffForHumans() }}
                                                                </td>
                                                            </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4 text-muted small">No recent acquisitions
                                            found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Fast Access Management -->
    <div class="mb-4 d-flex align-items-center gap-3">
        <h4 class="mb-0 fw-bold" style="font-family: var(--font-heading);">Inventory Control</h4>
        <div class="flex-grow-1 border-bottom opacity-10"></div>
    </div>

    <livewire:admin.product-manager />

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('livewire:navigated', function () {
            initCharts();
        });

        function initCharts() {
            const trendData = @json($salesTrend);
            const styleData = @json($styleDistribution);

            // Area Chart
            const ctxArea = document.getElementById("myAreaChart");
            if (ctxArea) {
                new Chart(ctxArea, {
                    type: 'line',
                    data: {
                        labels: trendData.labels,
                        datasets: [{
                            label: "Revenue",
                            lineTension: 0.4,
                            backgroundColor: "rgba(246, 166, 178, 0.1)",
                            borderColor: "#F6A6B2",
                            borderWidth: 3,
                            pointRadius: 4,
                            pointBackgroundColor: "#F6A6B2",
                            pointBorderColor: "#fff",
                            pointBorderWidth: 2,
                            fill: true,
                            data: trendData.data,
                        }],
                    },
                    options: {
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false } },
                        scales: {
                            x: { grid: { display: false }, ticks: { font: { size: 10 } } },
                            y: { grid: { color: 'rgba(0,0,0,0.03)' }, ticks: { callback: value => 'JOD ' + value, font: { size: 10 } } }
                        }
                    }
                });
            }

            // Pie Chart
            const ctxPie = document.getElementById("myPieChart");
            if (ctxPie) {
                new Chart(ctxPie, {
                    type: 'doughnut',
                    data: {
                        labels: styleData.labels,
                        datasets: [{
                            data: styleData.data,
                            backgroundColor: ['#F6A6B2', '#1E1E1E', '#C9A24D', '#A52A2A'],
                            borderWidth: 0,
                            hoverOffset: 15
                        }],
                    },
                    options: {
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false } },
                        cutout: '80%',
                    }
                });
            }
        }

        // Initial call
        initCharts();
    </script>
</div>