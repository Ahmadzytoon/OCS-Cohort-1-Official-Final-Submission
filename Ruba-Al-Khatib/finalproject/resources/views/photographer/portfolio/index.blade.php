@extends('photographer.layout')

@section('title', 'Manage Portfolio')

@section('styles')
<style>
    :root {
        --accent-brown: #a67c52;
        --accent-light: #c4a484;
        --bg: #faf7f8;
        --white: #fff;
        --text: #232222;
        --muted: #64748b;
        --border: #e5e7eb;
        --shadow: 0 5px 15px rgba(0, 0, 0, .08);
        --danger: #ef4444;
    }

    .page-wrap {
        background: var(--bg);
        min-height: calc(100vh - 70px);
        padding: 2rem 0 3rem;
    }

    .container {
        max-width: 1200px;
        margin: auto;
        padding: 0 2rem;
    }

    .page-title {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
    }

    .page-title h2 {
        margin: 0;
        color: var(--text);
        font-size: 1.6rem;
        letter-spacing: .2px;
    }

    .sub {
        margin: .25rem 0 0;
        color: var(--muted);
        font-weight: 500;
    }

    .card {
        background: var(--white);
        border-radius: 18px;
        border: 1px solid var(--border);
        box-shadow: var(--shadow);
        padding: 1.6rem;
    }

    .alert-success {
        background: #ecfdf5;
        border: 1px solid #4ade80;
        color: #166534;
        padding: 1rem 1.1rem;
        border-radius: 12px;
        margin-bottom: 1.2rem;
        font-weight: 700;
    }

    .btn {
        padding: .7rem 1.25rem;
        border-radius: 12px;
        font-weight: 700;
        border: none;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: .55rem;
        line-height: 1;
        transition: .2s ease;
        background: transparent;
        color: var(--text);
    }

    .btn-outline {
        border: 1px solid var(--border);
        background: #fff;
    }
    .btn-outline:hover { background: #f3f4f6; }

    .btn-primary {
        background: var(--accent-brown);
        color: #fff;
        box-shadow: 0 10px 25px rgba(166,124,82,.18);
    }
    .btn-primary:hover { filter: brightness(.95); transform: translateY(-1px); }

    .btn-danger {
        background: var(--danger);
        color: #fff;
        padding: .55rem .75rem;
        border-radius: 12px;
        border: none;
        cursor: pointer;
        transition: .2s ease;
    }
    .btn-danger:hover { filter: brightness(.95); transform: translateY(-1px); }

    /* Upload box */
    .upload-box {
        border: 2px dashed rgba(166,124,82,.35);
        border-radius: 18px;
        padding: 1.4rem;
        background: rgba(166, 124, 82, .06);
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .upload-left strong {
        display: block;
        color: var(--text);
        font-size: 1.05rem;
    }

    .upload-left .hint {
        margin: .2rem 0 0;
        color: var(--muted);
        font-weight: 600;
    }

    .upload-right {
        display: flex;
        gap: .75rem;
        align-items: center;
        flex-wrap: wrap;
        justify-content: flex-end;
    }

    .category-select {
        padding: .7rem 1rem;
        border: 1px solid var(--border);
        border-radius: 12px;
        background: #fff;
        color: var(--text);
        font-weight: 700;
        min-width: 210px;
        outline: none;
    }
    .category-select:focus {
        border-color: rgba(166,124,82,.6);
        box-shadow: 0 0 0 3px rgba(166,124,82,.12);
    }

    input[type="file"]{
        border: 1px solid var(--border);
        background: #fff;
        padding: .55rem .7rem;
        border-radius: 12px;
        font-weight: 600;
        color: var(--muted);
        max-width: 320px;
    }

    .error {
        margin-top: .6rem;
        color: #b91c1c;
        font-weight: 800;
    }

    /* Category section */
    .category-block {
        margin-top: 1.6rem;
    }

    .category-head {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        gap: 1rem;
        margin: 1.6rem 0 .9rem;
        flex-wrap: wrap;
    }

    .category-title {
        margin: 0;
        color: var(--text);
        font-size: 1.15rem;
        display: inline-flex;
        align-items: center;
        gap: .6rem;
    }

    .category-title .badge {
        font-size: .85rem;
        font-weight: 800;
        color: var(--accent-brown);
        background: rgba(166,124,82,.10);
        border: 1px solid rgba(166,124,82,.25);
        padding: .22rem .6rem;
        border-radius: 999px;
    }

    .grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 1.2rem;
    }

    .image-card {
        position: relative;
        border-radius: 16px;
        overflow: hidden;
        background: #fff;
        border: 1px solid var(--border);
        box-shadow: var(--shadow);
    }

    .image-card img {
        width: 100%;
        height: 220px;
        object-fit: cover;
        display: block;
        transition: .35s ease;
        position: relative;
        z-index: 1;
    }

    .image-card:hover img {
        transform: scale(1.05);
    }

    /* Actions */
    .image-actions {
        position: absolute;
        top: 10px;
        right: 10px;
        z-index: 10;
        opacity: 0;
        transform: translateY(-6px);
        transition: .2s ease;
        pointer-events: none;
    }

    .image-card:hover .image-actions {
        opacity: 1;
        transform: translateY(0);
        pointer-events: auto;
    }

    /* Empty state */
    .empty-state {
        text-align: center;
        padding: 2.2rem 1rem;
        color: var(--muted);
        font-weight: 700;
    }

    /* Delete Modal */
    #deleteModal {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, .45);
        z-index: 9999;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    #deleteModal.show {
        display: flex;
    }

    .delete-box {
        width: min(520px, 92vw);
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: 18px;
        box-shadow: 0 20px 60px rgba(0,0,0,.25);
        padding: 22px 22px 18px;
        animation: pop .18s ease;
    }

    @keyframes pop {
        from { transform: scale(.98); opacity: .6; }
        to   { transform: scale(1);   opacity: 1; }
    }

    .delete-box h3 {
        margin: 0 0 8px;
        color: var(--text);
        font-size: 1.25rem;
    }

    .delete-box p {
        margin: 0;
        color: var(--muted);
        line-height: 1.6;
        font-weight: 600;
    }

    .delete-actions {
        margin-top: 18px;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        flex-wrap: wrap;
    }

    @media (max-width: 768px) {
        .container { padding: 0 1rem; }
        .grid { grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); }
        input[type="file"]{ max-width: 100%; }
        .category-select{ min-width: 100%; }
    }
</style>
@endsection

@section('content')
<div class="page-wrap">
    <div class="container">

        <div class="page-title">
            <div>
                <h2>Manage Portfolio</h2>
                <p class="sub">Upload photos and organize them by category</p>
            </div>

            <a href="{{ route('photographer.profile.show') }}" class="btn btn-outline">
                ← Back to Profile
            </a>
        </div>

        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        <div class="card">

            {{-- Upload --}}
            <form method="POST" action="{{ route('photographer.portfolio.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="upload-box">
                    <div class="upload-left">
                        <strong>Upload Photos</strong>
                        <p class="hint">Choose a category first, then upload multiple images</p>

                        @error('category')
                            <div class="error">{{ $message }}</div>
                        @enderror
                        @error('images')
                            <div class="error">{{ $message }}</div>
                        @enderror
                        @error('images.*')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="upload-right">
                        {{-- Category --}}
                        <select name="category" required class="category-select">
                            <option value="" disabled selected>Select Category</option>
                            <option value="Weddings">Weddings</option>
                            <option value="Graduation">Graduation</option>
                            <option value="Family">Family</option>
                            <option value="Events">Events</option>
                            <option value="Products">Products</option>
                            <option value="Personal Branding">Personal Branding</option>
                            <option value="Portrait">Portrait</option>
                            <option value="Commercial">Commercial</option>
                        </select>

                        <input type="file" name="images[]" multiple required accept="image/*">

                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-upload"></i> Upload
                        </button>
                    </div>
                </div>
            </form>

            {{-- Categories (Grouped) --}}
            <div class="category-block">
                @forelse($items as $category => $photos)
                    <div class="category-head">
                        <h3 class="category-title">
                            <i class="fas fa-images" style="color:var(--accent-brown)"></i>
                            {{ $category ?? 'Uncategorized' }}
                            <span class="badge">{{ $photos->count() }} photos</span>
                        </h3>
                    </div>

                    <div class="grid">
                        @foreach($photos as $photo)
                            <div class="image-card">
                                <img src="{{ asset('storage/'.$photo->image_path) }}" alt="Portfolio">

                                <div class="image-actions">
                                    <button type="button"
                                            class="btn-danger js-delete"
                                            data-action="{{ route('photographer.portfolio.destroy', $photo->id) }}"
                                            title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @empty
                    <div class="empty-state">
                        No photos uploaded yet. Start by selecting a category and uploading your first images.
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</div>

{{-- Delete Modal --}}
<div id="deleteModal">
    <div class="delete-box">
        <h3>Delete Photo</h3>
        <p>
            Are you sure you want to delete this photo?<br>
            <small>This action cannot be undone.</small>
        </p>

        <div class="delete-actions">
            <button type="button" class="btn btn-outline" id="cancelDeleteBtn">Cancel</button>

            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
        </div>
    </div>
</div>

{{-- JS (داخل الصفحة مباشرة عشان يشتغل أكيد) --}}
<script>
    const deleteModal = document.getElementById('deleteModal');
    const deleteForm  = document.getElementById('deleteForm');
    const cancelBtn   = document.getElementById('cancelDeleteBtn');

    // Open modal (Event Delegation) - يشتغل حتى لو ضغطتي على الأيقونة نفسها
    document.addEventListener('click', function(e){
        const btn = e.target.closest('.js-delete');
        if(!btn) return;

        const action = btn.getAttribute('data-action');
        deleteForm.action = action;
        deleteModal.classList.add('show');
    });

    function closeDeleteModal(){
        deleteModal.classList.remove('show');
    }

    cancelBtn.addEventListener('click', closeDeleteModal);

    // Close on outside click
    deleteModal.addEventListener('click', function(e){
        if(e.target === deleteModal) closeDeleteModal();
    });

    // Close with ESC
    document.addEventListener('keydown', function(e){
        if(e.key === 'Escape') closeDeleteModal();
    });
</script>
@endsection
