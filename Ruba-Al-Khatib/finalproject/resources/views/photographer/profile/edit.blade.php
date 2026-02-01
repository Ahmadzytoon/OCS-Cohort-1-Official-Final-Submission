@extends('photographer.layout')

@section('title', 'Edit Profile')

@section('styles')
<style>
/* ===== Design System Variables ===== */
:root {
    --primary-accent: #a67c52;
    --secondary-accent: #c4a484;
    --background: #faf7f8;
    --text-dark: #232222;
    --text-gray: #64748b;
    --white: #ffffff;
    --success: #4ade80;
    --error: #f87171;

    --card-bg: #ffffff;
    --border-color: #e5e7eb;
    --light-gray: #f3f4f6;
    --hover-bg: #f9fafb;

    --font-heading: 'Playfair Display', Georgia, serif;
    --font-body: 'Inter', 'Segoe UI', system-ui, sans-serif;

    --spacing-xs: 0.5rem;
    --spacing-sm: 1rem;
    --spacing-md: 1.5rem;
    --spacing-lg: 2rem;
    --spacing-xl: 3rem;

    --radius-sm: 0.5rem;
    --radius-md: 0.75rem;
    --radius-lg: 1rem;

    --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.1);
    --shadow-md: 0 4px 6px rgba(0, 0, 0, 0.1);
    --shadow-lg: 0 10px 15px rgba(0, 0, 0, 0.1);

    --transition-fast: 0.2s ease;
    --transition-normal: 0.3s ease;
}

* { margin: 0; padding: 0; box-sizing: border-box; }

body {
    font-family: var(--font-body);
    color: var(--text-dark);
    background-color: var(--background);
    line-height: 1.6;
}

h1, h2, h3, h4, h5, h6 {
    font-family: var(--font-heading);
    font-weight: 600;
    line-height: 1.3;
    color: var(--text-dark);
}

h1 { font-size: 2.5rem; margin-bottom: var(--spacing-md); }
h3 { font-size: 1.5rem; margin-bottom: var(--spacing-sm); }
p { margin-bottom: var(--spacing-sm); color: var(--text-gray); }

.container {
    max-width: 800px;
    margin: 0 auto;
    padding: 0 var(--spacing-md);
}

/* ===== Buttons ===== */
.btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    border-radius: var(--radius-md);
    font-weight: 600;
    font-size: 1rem;
    border: none;
    cursor: pointer;
    transition: all var(--transition-normal);
    font-family: var(--font-body);
    text-decoration: none;
}

.btn-primary { background-color: var(--primary-accent); color: var(--white); }
.btn-primary:hover { background-color: var(--secondary-accent); transform: translateY(-2px); box-shadow: var(--shadow-md); }

.btn-outline { background-color: transparent; color: var(--text-dark); border: 1px solid var(--border-color); }
.btn-outline:hover { background-color: var(--light-gray); border-color: var(--primary-accent); }

/* ===== Header ===== */
.page-header {
    padding: var(--spacing-xl) 0 var(--spacing-lg);
    background-color: var(--white);
    border-bottom: 1px solid var(--border-color);
    margin-bottom: var(--spacing-xl);
}

.header-content {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    flex-wrap: wrap;
    gap: var(--spacing-md);
}

/* ===== Card ===== */
.card {
    background-color: var(--card-bg);
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-sm);
    padding: var(--spacing-lg);
    border: 1px solid var(--border-color);
    margin-bottom: var(--spacing-xl);
}

/* ===== Form ===== */
.form-group { margin-bottom: var(--spacing-lg); }

.form-label {
    display: block;
    margin-bottom: var(--spacing-xs);
    font-weight: 600;
    color: var(--text-dark);
}

.form-control {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 1px solid var(--border-color);
    border-radius: var(--radius-md);
    font-family: var(--font-body);
    font-size: 1rem;
    transition: border-color var(--transition-fast);
    background-color: var(--white);
}

.form-control:focus {
    outline: none;
    border-color: var(--primary-accent);
    box-shadow: 0 0 0 3px rgba(166, 124, 82, 0.1);
}

textarea.form-control { min-height: 120px; resize: vertical; }

.form-row {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: var(--spacing-md);
}

/* ===== Errors ===== */
.input-error {
    border-color: var(--error) !important;
    box-shadow: 0 0 0 3px rgba(248, 113, 113, 0.12) !important;
}
.error-text {
    margin-top: 0.4rem;
    color: var(--error);
    font-size: 0.875rem;
}

/* ===== Tags ===== */
.tags-input-container {
    display: flex;
    flex-wrap: wrap;
    gap: var(--spacing-xs);
    padding: 0.75rem;
    border: 1px solid var(--border-color);
    border-radius: var(--radius-md);
    min-height: 48px;
    align-items: center;
    background: var(--white);
}

.tag {
    display: inline-flex;
    align-items: center;
    background-color: rgba(166, 124, 82, 0.1);
    color: var(--primary-accent);
    padding: 0.25rem 0.75rem;
    border-radius: 2rem;
    font-size: 0.875rem;
    border: 1px solid rgba(166, 124, 82, 0.2);
}
.tag-remove { margin-left: 0.5rem; cursor: pointer; color: var(--primary-accent); }

.tags-input {
    border: none;
    outline: none;
    flex: 1;
    min-width: 160px;
    font-family: var(--font-body);
    font-size: 1rem;
    padding: 0.25rem;
    background: transparent;
}

/* ===== Actions ===== */
.form-actions {
    display: flex;
    justify-content: flex-end;
    gap: var(--spacing-sm);
    padding-top: var(--spacing-lg);
    border-top: 1px solid var(--border-color);
    margin-top: var(--spacing-lg);
}

@media (max-width: 768px) {
    .header-content { flex-direction: column; align-items: flex-start; }
    h1 { font-size: 2rem; }
    .form-actions { flex-direction: column; }
    .form-actions .btn { width: 100%; }
}
</style>
@endsection

@section('content')
<header class="page-header">
    <div class="container">
        <div class="header-content">
            <div>
                <h1>Edit Profile</h1>
                <p class="mb-0">Update your profile information</p>
            </div>
            <a href="{{ url('/photographer/profile') }}" class="btn btn-outline">
                <i class="fas fa-arrow-left"></i> Back to Profile
            </a>
        </div>
    </div>
</header>

<main class="main-content">
    <div class="container">
        <div class="card">
            {{-- عدّل action للروت اللي عندك --}}
            <form id="profileForm" method="POST" action="{{ url('/photographer/profile') }}">
                @csrf
                @method('PUT')

                {{-- Basic Information --}}
                <div class="form-group">
                    <h3 class="mb-3">Basic Information</h3>

                    <div class="form-row mb-3">
                        <div class="form-group">
                            <label class="form-label" for="fullName">Full Name *</label>
                            <input type="text"
                                   class="form-control @error('fullName') input-error @enderror"
                                   id="fullName" name="fullName"
                                   value="{{ old('fullName', $user->name ?? '') }}" required>
                            @error('fullName') <div class="error-text">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label" for="bio">Bio *</label>
                        <textarea class="form-control @error('bio') input-error @enderror"
                                  id="bio" name="bio" required>{{ old('bio', $photographer->bio ?? '') }}</textarea>
                        <small style="color: var(--text-gray); font-size: 0.875rem;">Tell clients about your experience and style</small>
                        @error('bio') <div class="error-text">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-row mb-3">
                        <div class="form-group">
                            <label class="form-label" for="city">City *</label>
                            <input type="text"
                                   class="form-control @error('city') input-error @enderror"
                                   id="city" name="city"
                                   value="{{ old('city', $photographer->city ?? '') }}" required>
                            @error('city') <div class="error-text">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="years_of_experience">Years of Experience *</label>
                            <input type="number"
                                   class="form-control @error('years_of_experience') input-error @enderror"
                                   id="years_of_experience" name="years_of_experience"
                                   value="{{ old('years_of_experience', $photographer->years_of_experience ?? 0) }}"
                                   min="0" max="50" required>
                            @error('years_of_experience') <div class="error-text">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>

                {{-- Photography Types --}}
                <div class="form-group">
                    <h3 class="mb-3">Photography Specialties</h3>

                    <label class="form-label">Photography Types *</label>

                    <div class="tags-input-container" id="tagsContainer">
                        <input type="text" class="tags-input" id="tagsInput" placeholder="Type a specialty and press Enter...">
                    </div>

                    {{-- هذا الحقل اللي بنبعثه للباك اند --}}
                    <input type="hidden" name="photography_types" id="photographyTypesHidden"
                           value="{{ old('photography_types', $photographer->photography_types ?? '') }}">

                    <small style="color: var(--text-gray); font-size: 0.875rem;">Add your photography specialties</small>
                    @error('photography_types') <div class="error-text">{{ $message }}</div> @enderror
                </div>

                {{-- Pricing --}}
                <div class="form-group">
                    <h3 class="mb-3">Pricing</h3>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label" for="starting_price">Starting Price ($/hour) *</label>
                            <div style="position: relative;">
                                <span style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: var(--text-gray);">$</span>
                                <input type="number"
                                       class="form-control @error('starting_price') input-error @enderror"
                                       id="starting_price" name="starting_price"
                                       value="{{ old('starting_price', $photographer->starting_price ?? 0) }}"
                                       min="0" step="10" style="padding-left: 2.5rem;" required>
                            </div>
                            @error('starting_price') <div class="error-text">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>

                {{-- Social Links --}}
                <div class="form-group">
                    <h3 class="mb-3">Social Links</h3>

                    <div class="form-row mb-3">
                        <div class="form-group">
                            <label class="form-label" for="instagram_url">Instagram URL</label>
                            <input type="url" class="form-control @error('instagram_url') input-error @enderror"
                                   id="instagram_url" name="instagram_url"
                                   value="{{ old('instagram_url', $photographer->instagram_url ?? '') }}"
                                   placeholder="https://instagram.com/username">
                            @error('instagram_url') <div class="error-text">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="website_url">Website URL</label>
                            <input type="url" class="form-control @error('website_url') input-error @enderror"
                                   id="website_url" name="website_url"
                                   value="{{ old('website_url', $photographer->website_url ?? '') }}"
                                   placeholder="https://example.com">
                            @error('website_url') <div class="error-text">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label" for="behance_url">Behance URL</label>
                            <input type="url" class="form-control @error('behance_url') input-error @enderror"
                                   id="behance_url" name="behance_url"
                                   value="{{ old('behance_url', $photographer->behance_url ?? '') }}"
                                   placeholder="https://behance.net/username">
                            @error('behance_url') <div class="error-text">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <a class="btn btn-outline" href="{{ url('/photographer/profile') }}">Cancel</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</main>
@endsection

@section('script')
<script>
    // tags from hidden input (comma separated)
    function parseTags(str) {
        if (!str) return [];
        return str.split(',')
                 .map(t => t.trim())
                 .filter(Boolean);
    }

    let currentTags = parseTags(document.getElementById('photographyTypesHidden').value);

    const tagsContainer = document.getElementById('tagsContainer');
    const tagsInput = document.getElementById('tagsInput');
    const hidden = document.getElementById('photographyTypesHidden');

    function syncHidden() {
        hidden.value = currentTags.join(', ');
    }

    function renderTags() {
        // remove all tag spans (keep the input)
        tagsContainer.querySelectorAll('.tag').forEach(el => el.remove());

        currentTags.forEach(tag => {
            const el = document.createElement('span');
            el.className = 'tag';
            el.innerHTML = `${tag}<span class="tag-remove" data-tag="${tag}">&times;</span>`;
            tagsContainer.insertBefore(el, tagsInput);
        });

        syncHidden();
    }

    tagsInput.addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            const value = this.value.trim();
            if (value && !currentTags.map(t => t.toLowerCase()).includes(value.toLowerCase())) {
                currentTags.push(value);
                this.value = '';
                renderTags();
            }
        }
    });

    tagsContainer.addEventListener('click', function(e) {
        const btn = e.target.closest('.tag-remove');
        if (!btn) return;
        const tag = btn.getAttribute('data-tag');
        currentTags = currentTags.filter(t => t !== tag);
        renderTags();
    });

    document.addEventListener('DOMContentLoaded', renderTags);
</script>
@endsection
