@extends('site.innerPages.layout.master')

@php
    $role = auth()->user()->role;
@endphp
@section('content')
    <div class="content-header">
        <h1>Company Profile</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Company News</a></li>
                <li class="breadcrumb-item active">Company News</li>
            </ol>
        </nav>
    </div>
    <div class="content-body">
        @if ($role === 'company_owner')
            <!-- Page Header -->
            <div class="row mb-4">
                <div class="col-md-8">
                    <h4 class="mb-2">
                        <i class="fas fa-newspaper text-primary me-2"></i> Company News
                    </h4>
                    <p class="text-muted">Manage company announcements and news articles</p>
                </div>
                <div class="col-md-4 text-end">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createNewsModal">
                        <i class="fas fa-plus me-2"></i> Create News
                    </button>
                </div>
            </div>
        @endif

        @if ($role === 'company_owner')
            <!-- Statistics -->
            <div class="row g-3 mb-4">
                <div class="col-md-3">
                    <div class="news-stat-card">
                        <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                            <i class="fas fa-newspaper"></i>
                        </div>
                        <div class="stat-details">
                            <h3>{{ $total }}</h3>
                            <p>Total News</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="news-stat-card">
                        <div class="stat-icon bg-success bg-opacity-10 text-success">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="stat-details">
                            <h3>{{ $published }}</h3>
                            <p>Published</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="news-stat-card">
                        <div class="stat-icon bg-warning bg-opacity-10 text-warning">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="stat-details">
                            <h3>{{ $scheduled }}</h3>
                            <p>Scheduled</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="news-stat-card">
                        <div class="stat-icon bg-secondary bg-opacity-10 text-secondary">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <div class="stat-details">
                            <h3>{{ $drafts }}</h3>
                            <p>Drafts</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Filters & Search -->
        <form method="GET" action="{{ route('shared.companyNews.index') }}">
            <div class="row g-3 mb-4">
                <div class="col-md-5">
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" name="search" class="form-control" placeholder="Search news articles..."
                            value="{{ request('search') }}">
                    </div>
                </div>

                <div class="col-md-3">
                    <select class="form-select" name="status">
                        <option value="">All Status</option>
                        <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published
                        </option>
                        <option value="scheduled" {{ request('status') === 'scheduled' ? 'selected' : '' }}>Scheduled
                        </option>
                        <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <select class="form-select" name="sort">
                        <option value="">Sort By</option>
                        <option value="newest" {{ request('sort', 'newest') === 'newest' ? 'selected' : '' }}>Newest First
                        </option>
                        <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Oldest First</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <button class="btn btn-outline-secondary w-100" type="submit">
                        <i class="fas fa-filter me-2"></i> Filter
                    </button>
                </div>
            </div>
        </form>


        <!-- News List -->
        <div class="row g-4">


            @foreach ($news as $item)
                @php
                    $img = $item->image ? asset('storage/' . $item->image) : asset('site/images/news-default.png');
                    $status = $item->status; // draft/scheduled/published
                    $badgeClass =
                        $status === 'published' ? 'published' : ($status === 'scheduled' ? 'scheduled' : 'draft');
                    $categoryText =
                        $item->category === 'other'
                            ? $item->custom_category ?? 'Other'
                            : ucfirst($item->category ?? 'General');
                @endphp

                <div class="col-lg-6">
                    <div class="news-card">
                        <div class="news-card-header">
                            <div class="news-status-badge {{ $badgeClass }}">
                                @if ($status === 'published')
                                    <i class="fas fa-check-circle"></i> Published
                                @endif
                                @if ($status === 'scheduled')
                                    <i class="fas fa-clock"></i> Scheduled
                                @endif
                                @if ($status === 'draft')
                                    <i class="fas fa-file-alt"></i> Draft
                                @endif
                            </div>
                            @if (in_array($role, ['department_manager', 'employee']))
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-light" data-bs-toggle="dropdown">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>

                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a class="dropdown-item" href="#" onclick="openViewNews(this)"
                                                data-title="{{ e($item->title) }}" data-content="{{ e($item->content) }}"
                                                data-image="{{ $img }}"
                                                data-date="{{ $item->published_at ? $item->published_at->format('M d, Y') : $item->created_at?->format('M d, Y') }}">
                                                <i class="fas fa-eye me-2"></i> View
                                            </a>
                                        </li>

                                    </ul>
                                </div>
                            @endif
                            @if ($role === 'company_owner')
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-light" data-bs-toggle="dropdown">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>

                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a class="dropdown-item" href="#" onclick="openViewNews(this)"
                                                data-title="{{ e($item->title) }}" data-content="{{ e($item->content) }}"
                                                data-image="{{ $img }}"
                                                data-date="{{ $item->published_at ? $item->published_at->format('M d, Y') : $item->created_at?->format('M d, Y') }}">
                                                <i class="fas fa-eye me-2"></i> View
                                            </a>
                                        </li>

                                        <li>
                                            <a class="dropdown-item" href="#" onclick="openEditNews(this)"
                                                data-id="{{ $item->id }}" data-title="{{ e($item->title) }}"
                                                data-category="{{ $item->category }}"
                                                data-custom="{{ e($item->custom_category) }}"
                                                data-content="{{ e($item->content) }}" data-status="{{ $item->status }}"
                                                data-publishat="{{ $item->publish_at?->format('Y-m-d H:i') }}">
                                                <i class="fas fa-edit me-2"></i> Edit
                                            </a>
                                        </li>


                                        @if ($status === 'published')
                                            <li>
                                                <a class="dropdown-item" href="#"
                                                    onclick="confirmUnpublish({{ $item->id }})">
                                                    <i class="fas fa-pause me-2"></i> Unpublish
                                                </a>
                                            </li>
                                        @endif

                                        @if ($status === 'scheduled')
                                            <li>
                                                <a class="dropdown-item" href="#"
                                                    onclick="confirmPublishNow({{ $item->id }})">
                                                    <i class="fas fa-paper-plane me-2"></i> Publish Now
                                                </a>
                                            </li>
                                        @endif

                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>

                                        <li>
                                            <a class="dropdown-item text-danger" href="#"
                                                onclick="confirmDelete({{ $item->id }})">
                                                <i class="fas fa-trash me-2"></i> Delete

                                            </a>


                                        </li>
                                    </ul>
                                </div>
                            @endif
                        </div>

                        <div class="news-card-body">
                            <div class="news-image">
                                <img src="{{ $img }}" alt="News">
                                <div class="news-category">{{ $categoryText }}</div>
                            </div>

                            <h5 class="news-title">{{ $item->title }}</h5>

                            <p class="news-excerpt">
                                {{ \Illuminate\Support\Str::limit(strip_tags($item->content), 120) }}
                            </p>

                            {{-- الكاتب ثابت: company owner الحالي --}}
                            <div class="news-meta">
                                <div class="meta-item">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}"
                                        class="author-avatar-small" alt="Author">
                                    <span>{{ Auth::user()->name }}</span>
                                </div>

                                <div class="meta-item">
                                    <i class="fas fa-calendar text-primary"></i>
                                    <span>
                                        @if ($status === 'scheduled' && $item->publish_at)
                                            Scheduled: {{ $item->publish_at->format('M d, Y') }}
                                        @elseif($status === 'published' && $item->published_at)
                                            {{ $item->published_at->format('M d, Y') }}
                                        @else
                                            Saved: {{ $item->created_at?->format('M d, Y') }}
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-between align-items-center mt-4">
            <div class="text-muted small">
                Showing {{ $news->firstItem() ?? 0 }}-{{ $news->lastItem() ?? 0 }} of {{ $news->total() }} news
            </div>

            <nav>
                {{ $news->links('pagination::bootstrap-5') }}
            </nav>
        </div>
    </div>

    <!-- Create News Modal -->
    <div class="modal fade" id="createNewsModal" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-newspaper me-2"></i> Create Company News
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="createNewsForm" action="{{ route('shared.companyNews.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-8">
                                <label class="form-label">News Title</label>
                                <input type="text" name="title" class="form-control"
                                    placeholder="Enter news title..." required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Category</label>
                                <select class="form-select" name="category" id="newsCategory"
                                    onchange="toggleCustomCategory()">
                                    <option value="">Select Category</option>
                                    <option value="company">Company Update</option>
                                    <option value="product">Product News</option>
                                    <option value="hr">HR Update</option>
                                    <option value="achievement">Achievement</option>
                                    <option value="announcement">Announcement</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            <div class="col-md-4" id="customCategoryField" style="display: none;">
                                <label class="form-label">Custom Category</label>
                                <input type="text" name="custom_category" class="form-control"
                                    placeholder="Enter custom category...">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Featured Image</label>
                                <input type="file" name="image" class="form-control" accept="image/*">
                                <small class="text-muted">Recommended size: 800x400px</small>
                            </div>
                            <div class="col-12">
                                <label class="form-label">News Content</label>
                                <textarea class="form-control" name="content" rows="8" placeholder="Write your news content here..." required></textarea>
                                <small class="text-muted">You can use formatting for better readability</small>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Publication Type</label>
                                <select class="form-select" name="publication_type" id="publicationType"
                                    onchange="toggleSchedule()">
                                    <option value="now">Publish Immediately</option>
                                    <option value="schedule">Schedule for Later</option>
                                    <option value="draft">Save as Draft</option>
                                </select>
                            </div>
                            <div class="col-md-6" id="scheduleDate" style="display: none;">
                                <label class="form-label">Schedule Date</label>
                                <input type="date" name="schedule_date" class="form-control">
                            </div>
                            <div class="col-md-6" id="scheduleTime" style="display: none;">
                                <label class="form-label">Schedule Time</label>
                                <input type="time" name="schedule_time" class="form-control">
                            </div>
                            <div class="col-12">
                                <div class="form-check">
                                    <input class="form-check-input" name="send_notification" value="1"
                                        type="checkbox" id="sendNotification" checked>
                                    <label class="form-check-label" for="sendNotification">
                                        Send notification to all employees when published
                                    </label>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" form="createNewsForm" class="btn btn-primary">
                        <i class="fas fa-paper-plane me-1"></i> Publish News
                    </button>
                    <button type="button" class="btn btn-outline-primary" onclick="submitDraft()">
                        <i class="fas fa-save me-1"></i> Save as Draft
                    </button>

                </div>
            </div>
        </div>
    </div>


    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Edit News Modal -->
    <div class="modal fade" id="editNewsModal" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-edit me-2"></i> Edit News Article
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="editNewsForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row g-3">
                            <div class="col-md-8">
                                <label class="form-label">News Title</label>
                                <input name="title" id="editTitle" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Category</label>
                                <select name="category" id="editCategory" class="form-select"
                                    onchange="toggleEditCustomCategory()">
                                    <option value="company" selected>Company Update</option>
                                    <option value="product">Product News</option>
                                    <option value="hr">HR Update</option>
                                    <option value="achievement">Achievement</option>
                                    <option value="announcement">Announcement</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            <div class="col-md-4" id="editCustomCategoryField" style="display: none;">
                                <label class="form-label">Custom Category</label>
                                <input name="custom_category" id="editCustom" class="form-control">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Featured Image</label>
                                <input type="file" name="image" class="form-control">
                                <small class="text-muted">Current image will be replaced if you upload a new one</small>
                            </div>
                            <div class="col-12">
                                <label class="form-label">News Content</label>
                                <textarea name="content" id="editContent" class="form-control" rows="8" required></textarea>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Status</label>
                                <select name="status" id="editStatus" class="form-select">
                                    <option value="published" selected>Published</option>
                                    <option value="scheduled">Scheduled</option>
                                    <option value="draft">Draft</option>
                                </select>
                            </div>
                            <div class="col-md-6" id="editScheduleDateWrap" style="display: none;">
                                <label class="form-label">Schedule Date</label>
                                <input type="date" name="schedule_date" id="editScheduleDate" class="form-control">
                            </div>
                            <div class="col-md-6" id="editScheduleTimeWrap" style="display: none;">
                                <label class="form-label">Schedule Time</label>
                                <input type="time" name="schedule_time" id="editScheduleTime" class="form-control">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" form="editNewsForm" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Update News
                    </button>

                </div>
            </div>
        </div>
    </div>



    <!-- View News Modal -->
    <div class="modal fade" id="viewNewsModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <div>
                        <h5 class="modal-title">Q4 Results Exceeded Expectations</h5>
                        <small class="text-muted">Published on Jan 15, 2025 by Ahmad Khaled</small>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <img src="https://via.placeholder.com/800x400/667eea/ffffff?text=Q4+Results" alt="News"
                        class="img-fluid rounded mb-3" style="width: 100% ; height:50%">
                    <div class="news-content-view">
                        <p>We're proud to announce that our Q4 performance has surpassed all targets. Revenue increased by
                            45% compared to last quarter, driven by strong customer demand and successful product launches.
                        </p>
                        <p>Key highlights include:</p>
                        <ul>
                            <li>Revenue growth of 45% quarter-over-quarter</li>
                            <li>Customer base expanded by 30%</li>
                            <li>Successfully launched 3 new products</li>
                            <li>Employee satisfaction scores reached all-time high</li>
                        </ul>
                        <p>This achievement is a testament to the hard work and dedication of our entire team. Thank you all
                            for your continued commitment to excellence.</p>
                    </div>
                    <hr>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="editNewsFromView()">
                        <i class="fas fa-edit me-1"></i> Edit
                    </button>
                </div>
            </div>
        </div>
    </div>

    <form id="deleteForm" method="POST" style="display:none;">
        @csrf @method('DELETE')
    </form>

    <form id="publishNowForm" method="POST" style="display:none;">
        @csrf @method('PATCH')
    </form>

    <form id="unpublishForm" method="POST" style="display:none;">
        @csrf @method('PATCH')
    </form>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // لازم يكون sweetalert محمّل بالـ master layout
        const NEWS_BASE = @json(url('/shared/companyNews'));

        // ===================== Create Modal =====================
        function toggleCustomCategory() {
            const sel = document.getElementById('newsCategory');
            const field = document.getElementById('customCategoryField');
            field.style.display = (sel.value === 'other') ? 'block' : 'none';
        }

        function toggleSchedule() {
            const pubType = document.getElementById('publicationType');
            const dateWrap = document.getElementById('scheduleDate');
            const timeWrap = document.getElementById('scheduleTime');
            const show = pubType.value === 'schedule';
            dateWrap.style.display = show ? 'block' : 'none';
            timeWrap.style.display = show ? 'block' : 'none';
        }

        function submitDraft() {
            document.getElementById('publicationType').value = 'draft';
            document.getElementById('createNewsForm').submit();
        }

        // ===================== Edit Modal =====================
        function toggleEditCustomCategory() {
            const sel = document.getElementById('editCategory');
            const field = document.getElementById('editCustomCategoryField');
            field.style.display = (sel.value === 'other') ? 'block' : 'none';
        }

        function toggleEditSchedule() {
            const status = document.getElementById('editStatus').value;
            const dateWrap = document.getElementById('editScheduleDateWrap');
            const timeWrap = document.getElementById('editScheduleTimeWrap');
            const show = (status === 'scheduled');
            dateWrap.style.display = show ? 'block' : 'none';
            timeWrap.style.display = show ? 'block' : 'none';
        }

        function openEditNews(el) {
            const id = el.dataset.id;
            const title = el.dataset.title || '';
            const category = el.dataset.category || '';
            const custom = el.dataset.custom || '';
            const content = el.dataset.content || '';
            const status = el.dataset.status || 'draft';
            const publishAt = el.dataset.publishat || ''; // "YYYY-MM-DD HH:mm"

            const form = document.getElementById('editNewsForm');
            form.action = `${NEWS_BASE}/${id}`;

            document.getElementById('editTitle').value = title;
            document.getElementById('editContent').value = content;
            document.getElementById('editStatus').value = status;
            document.getElementById('editCategory').value = category;
            document.getElementById('editCustom').value = custom;

            // schedule data fill
            if (publishAt) {
                const [d, t] = publishAt.split(' ');
                document.getElementById('editScheduleDate').value = d || '';
                document.getElementById('editScheduleTime').value = (t || '').slice(0, 5);
            } else {
                document.getElementById('editScheduleDate').value = '';
                document.getElementById('editScheduleTime').value = '';
            }

            // toggle fields correctly
            toggleEditCustomCategory();
            toggleEditSchedule();

            new bootstrap.Modal(document.getElementById('editNewsModal')).show();
        }

        // Edit status change listener
        document.addEventListener('DOMContentLoaded', () => {
            document.getElementById('editStatus')?.addEventListener('change', toggleEditSchedule);
            document.getElementById('editCategory')?.addEventListener('change', toggleEditCustomCategory);
            document.getElementById('publicationType')?.addEventListener('change', toggleSchedule);
            document.getElementById('newsCategory')?.addEventListener('change', toggleCustomCategory);
        });

        // ===================== View Modal =====================
        function openViewNews(el) {
            const title = el.dataset.title || '';
            const content = el.dataset.content || '';
            const image = el.dataset.image || '';
            const date = el.dataset.date || '';

            document.querySelector('#viewNewsModal .modal-title').textContent = title;
            document.querySelector('#viewNewsModal img').src = image;
            document.querySelector('#viewNewsModal small').textContent =
                `Published/Saved on ${date} by {{ Auth::user()->name }}`;

            document.querySelector('#viewNewsModal .news-content-view').innerHTML = content;
            new bootstrap.Modal(document.getElementById('viewNewsModal')).show();
        }

        // ===================== Confirm Actions =====================
        function confirmDelete(id) {
            Swal.fire({
                icon: 'warning',
                title: 'Delete this news?',
                text: 'This action cannot be undone.',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete',
                cancelButtonText: 'Cancel'
            }).then((r) => {
                if (r.isConfirmed) {
                    const form = document.getElementById('deleteForm');
                    form.action = `${NEWS_BASE}/${id}`;
                    form.submit();
                }
            });
        }

        function confirmPublishNow(id) {
            Swal.fire({
                icon: 'question',
                title: 'Publish now?',
                text: 'This scheduled news will be published immediately.',
                showCancelButton: true,
                confirmButtonText: 'Publish',
                cancelButtonText: 'Cancel'
            }).then((r) => {
                if (r.isConfirmed) {
                    const form = document.getElementById('publishNowForm');
                    form.action = `${NEWS_BASE}/${id}/publish-now`;
                    form.submit();
                }
            });
        }

        function confirmUnpublish(id) {
            Swal.fire({
                icon: 'question',
                title: 'Unpublish?',
                text: 'This will move the news back to Draft.',
                showCancelButton: true,
                confirmButtonText: 'Unpublish',
                cancelButtonText: 'Cancel'
            }).then((r) => {
                if (r.isConfirmed) {
                    const form = document.getElementById('unpublishForm');
                    form.action = `${NEWS_BASE}/${id}/unpublish`;
                    form.submit();
                }
            });
        }
    </script>

    @if (session('swal'))
        <script>
            Swal.fire({
                icon: @json(session('swal.type')),
                title: @json(session('swal.title')),
                text: @json(session('swal.text')),
                timer: 1600,
                showConfirmButton: false
            });
        </script>
    @endif
@endsection
