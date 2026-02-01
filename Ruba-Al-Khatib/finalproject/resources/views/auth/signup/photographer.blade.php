@extends('layouts.auth.master')

@section('title', 'Signup - Photographer Step 2')

@section('css')
<link rel="stylesheet" href="{{ asset('css/onboarding-styles.css') }}">
@endsection

@section('content')
<main class="main-content">
    <div class="progress-container">
        <h1 class="progress-title">Complete Your Photographer Profile</h1>
        <p class="progress-subtitle">Step 2 of 2 - Add your professional details to start accepting bookings</p>
    </div>

    <div class="onboarding-container">
        @if ($errors->any())
        <div class="response-message error" style="display:block;">
            <strong>Fix these issues:</strong>
            <ul style="margin:10px 0 0 18px;">
                @foreach ($errors->all() as $err)
                <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('signup.photographer.store') }}" enctype="multipart/form-data" class="onboarding-form" id="photographerForm">
            @csrf

            <!-- Profile Photo -->
            <div class="form-section">
                <div class="section-header">
                    <h2 class="section-title"><i class="bi bi-person-circle section-icon"></i> Profile Photo</h2>
                    <p class="section-description">Upload a clear headshot (JPG/PNG/WebP, max 5MB)</p>
                </div>

                <div class="upload-container" id="profileUploadContainer">
                    <div class="upload-icon"><i class="bi bi-camera"></i></div>
                    <h3 class="upload-title">Upload Your Profile Photo</h3>
                    <p class="upload-description">This will appear on your public profile and listings</p>

                    <button type="button" class="upload-btn" id="profileUploadBtn">
                        <i class="bi bi-folder2-open"></i> Browse Photo
                    </button>

                    <input type="file" id="profileFileInput" accept="image/*" style="display:none;">

                    {{-- رح نخزن المسار هون بعد الرفع --}}
                    <input type="hidden" name="profile_image_path" id="profileImagePath" value="{{ old('profile_image_path','') }}">

                    <div class="portfolio-preview" style="margin-top:20px;">
                        <div class="preview-header">
                            <h3 class="preview-title">Preview</h3>
                        </div>

                        <div class="images-grid" id="profilePreviewGrid">
                            <div class="image-item image-placeholder" id="profilePlaceholder">
                                <div class="placeholder-icon"><i class="bi bi-person"></i></div>
                                <span>No photo yet</span>
                            </div>
                        </div>
                    </div>

                    @error('profile_image_path')
                    <div class="error-message" style="display:block;">{{ $message }}</div>
                    @enderror
                </div>
            </div>


            <!-- Portfolio -->
            <div class="form-section">
                <div class="section-header">
                    <h2 class="section-title"><i class="bi bi-images section-icon"></i> Portfolio Showcase</h2>
                    <p class="section-description">Upload 6-12 of your best photos to showcase your work</p>
                </div>

                <div class="upload-container" id="uploadContainer">
                    <div class="upload-icon"><i class="bi bi-cloud-arrow-up"></i></div>
                    <h3 class="upload-title">Drag & Drop Your Photos</h3>
                    <p class="upload-description">Upload JPG, PNG or WebP images (max 5MB each)</p>

                    <button type="button" class="upload-btn" id="uploadBtn">
                        <i class="bi bi-folder2-open"></i> Browse Files
                    </button>

                    <input type="file" id="fileInput" multiple accept="image/*" style="display:none;">
                    <input type="hidden" name="portfolio_paths" id="portfolioPaths" value="{{ old('portfolio_paths','[]') }}">


                    <p class="upload-info">Minimum: 6 images | Maximum: 12 images</p>
                </div>

                @error('portfolio')
                <div class="error-message" style="display:block;">{{ $message }}</div>
                @enderror
                @error('portfolio.*')
                <div class="error-message" style="display:block;">{{ $message }}</div>
                @enderror

                <div class="portfolio-preview" id="portfolioPreview">
                    <div class="preview-header">
                        <h3 class="preview-title">Your Portfolio</h3>
                        <div class="image-count"><span id="imageCount">0</span> / 12 images</div>
                    </div>

                    <div class="images-grid" id="imagesGrid">
                        <div class="image-item image-placeholder">
                            <div class="placeholder-icon"><i class="bi bi-image"></i></div>
                            <span>No images yet</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Professional info -->
            <div class="form-section">
                <div class="section-header">
                    <h2 class="section-title"><i class="bi bi-person-badge section-icon"></i> Professional Information</h2>
                    <p class="section-description">Tell clients about your experience and specialties</p>
                </div>

                <div class="form-group">
                    <label for="bio" class="form-label"><i class="bi bi-card-text"></i><span>Short Bio</span><span class="required">*</span></label>
                    <textarea id="bio" name="bio" class="form-textarea @error('bio') error @enderror" rows="4" required>{{ old('bio') }}</textarea>
                    @error('bio')
                    <div class="error-message" style="display:block;">{{ $message }}</div>
                    @enderror
                </div>

                <!-- ✅ years_of_experience integer -->
                <div class="form-group">
                    <label for="years_of_experience" class="form-label"><i class="bi bi-award"></i><span>Years of Experience</span><span class="required">*</span></label>
                    @php
                    // values are INTEGERS now (good for DB + validation)
                    $expOptions = [
                    0 => '0-1 years (Beginner)',
                    1 => '1-3 years (Intermediate)',
                    3 => '3-5 years (Experienced)',
                    5 => '5-10 years (Professional)',
                    10 => '10+ years (Expert)',
                    ];
                    @endphp
                    <select id="years_of_experience" name="years_of_experience" class="form-select @error('years_of_experience') error @enderror" required>
                        <option value="">Select experience level</option>
                        @foreach ($expOptions as $val => $label)
                        <option value="{{ $val }}" @selected((string)old('years_of_experience')===(string)$val)>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('years_of_experience')
                    <div class="error-message" style="display:block;">{{ $message }}</div>
                    @enderror
                </div>

                <!-- ✅ photography_types as ARRAY -->
                <div class="form-group">
                    <label class="form-label"><i class="bi bi-tags"></i><span>Photography Types</span><span class="required">*</span></label>

                    <div class="multi-select-container">
                        <div class="form-input multi-select" id="photographyTypes">
                            <span id="selectedTypes">Select your specialties</span>
                        </div>

                        <div class="multi-select-options" id="typeOptions">
                            @php
                            $types = [
                            'weddings' => 'Weddings',
                            'graduation' => 'Graduation',
                            'family' => 'Family',
                            'personal-branding' => 'Personal Branding',
                            'events' => 'Events',
                            'products' => 'Products',
                            'portrait' => 'Portrait',
                            'fashion' => 'Fashion',
                            'landscape' => 'Landscape',
                            ];

                            // now old('photography_types') will be array because inputs are photography_types[]
                            $oldTypes = old('photography_types', []);
                            if (!is_array($oldTypes)) $oldTypes = [];
                            @endphp

                            @foreach($types as $val => $label)
                            <div class="select-option @if(in_array($val, $oldTypes)) selected @endif" data-value="{{ $val }}">
                                {{ $label }}
                            </div>
                            @endforeach
                        </div>

                        <!-- ✅ Here we generate real array inputs -->
                        <div id="typesInputs">
                            @foreach($oldTypes as $t)
                            <input type="hidden" name="portfolio_paths" id="portfolioPaths" value="{{ old('portfolio_paths','[]') }}">

                            @endforeach
                        </div>

                        @error('photography_types')
                        <div class="error-message" style="display:block;">{{ $message }}</div>
                        @enderror
                        @error('photography_types.*')
                        <div class="error-message" style="display:block;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <div style="flex:1;">
                        <label for="starting_price" class="form-label"><i class="bi bi-currency-dollar"></i><span>Starting Price</span><span class="required">*</span></label>
                        <input type="number" id="starting_price" name="starting_price" class="form-input @error('starting_price') error @enderror"
                            value="{{ old('starting_price') }}" min="0" step="10" required>
                        @error('starting_price')
                        <div class="error-message" style="display:block;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div style="flex:1;">
                        <label for="city" class="form-label"><i class="bi bi-geo-alt"></i><span>City</span><span class="required">*</span></label>
                        <input type="text" id="city" name="city" class="form-input @error('city') error @enderror" value="{{ old('city') }}" required>
                        @error('city')
                        <div class="error-message" style="display:block;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Social links -->
            <div class="form-section">
                <div class="section-header">
                    <h2 class="section-title"><i class="bi bi-link-45deg section-icon"></i> Social Links</h2>
                    <p class="section-description">Connect your social profiles (optional)</p>
                </div>

                <div class="form-group">
                    <label for="instagram_url" class="form-label"><i class="bi bi-instagram"></i><span>Instagram URL</span></label>
                    <input type="url" id="instagram_url" name="instagram_url" class="form-input @error('instagram_url') error @enderror" value="{{ old('instagram_url') }}">
                    @error('instagram_url')
                    <div class="error-message" style="display:block;">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="website_url" class="form-label"><i class="bi bi-globe"></i><span>Website</span></label>
                    <input type="url" id="website_url" name="website_url" class="form-input @error('website_url') error @enderror" value="{{ old('website_url') }}">
                    @error('website_url')
                    <div class="error-message" style="display:block;">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="behance_url" class="form-label"><i class="bi bi-behance"></i><span>Behance</span></label>
                    <input type="url" id="behance_url" name="behance_url" class="form-input @error('behance_url') error @enderror" value="{{ old('behance_url') }}">
                    @error('behance_url')
                    <div class="error-message" style="display:block;">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-section">
                <button type="submit" class="submit-btn" id="submitBtn">
                    <span>Submit for Review</span>
                    <i class="bi bi-check-circle btn-icon"></i>
                </button>
            </div>
        </form>
    </div>
</main>
@endsection

@section('script')
<script>
    document.addEventListener('DOMContentLoaded', function() {

    /* =======================
   Profile Photo (AJAX) + preview
======================= */
const profileUploadBtn = document.getElementById('profileUploadBtn');
const profileFileInput = document.getElementById('profileFileInput');
const profilePathInput = document.getElementById('profileImagePath');
const profilePreviewGrid = document.getElementById('profilePreviewGrid');

profileUploadBtn?.addEventListener('click', () => profileFileInput.click());

profileFileInput?.addEventListener('change', async () => {
    const file = profileFileInput.files?.[0];
    if (!file) return;

    // ارفع الصورة
    const fd = new FormData();
    fd.append('file', file);

    const res = await fetch("{{ route('upload.photographer.profile') }}", {
        method: "POST",
        headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" },
        body: fd
    });

    const data = await res.json();

    if (data.ok) {
        profilePathInput.value = data.path;
        renderProfilePreview();
    } else {
        alert(data.message || 'Profile upload failed');
    }

    profileFileInput.value = '';
});

async function removeProfilePhoto() {
    const p = profilePathInput.value;
    if (!p) return;

    await fetch("{{ route('upload.photographer.profile.destroy') }}", {
        method: "DELETE",
        headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}",
            "Content-Type": "application/json"
        },
        body: JSON.stringify({ path: p })
    });

    profilePathInput.value = '';
    renderProfilePreview();
}

function renderProfilePreview() {
    const p = profilePathInput.value;

    profilePreviewGrid.innerHTML = '';

    if (!p) {
        profilePreviewGrid.innerHTML = `
        <div class="image-item image-placeholder">
            <div class="placeholder-icon"><i class="bi bi-person"></i></div>
            <span>No photo yet</span>
        </div>`;
        return;
    }

    const url = "{{ asset('storage') }}/" + p;

    const item = document.createElement('div');
    item.className = 'image-item';
    item.innerHTML = `
        <img src="${url}" class="image-preview" alt="profile">
        <button type="button" class="remove-btn" style="margin-top:6px;">Remove</button>
    `;

    item.querySelector('.remove-btn').addEventListener('click', removeProfilePhoto);
    profilePreviewGrid.appendChild(item);
}

renderProfilePreview();

        /* =======================
           Upload (AJAX) + preview
        ======================= */
        const uploadBtn = document.getElementById('uploadBtn');
        const fileInput = document.getElementById('fileInput');
        const imagesGrid = document.getElementById('imagesGrid');
        const imageCount = document.getElementById('imageCount');
        const hiddenPaths = document.getElementById('portfolioPaths');

        let paths = [];
        try {
            paths = JSON.parse(hiddenPaths.value || '[]');
            if (!Array.isArray(paths)) paths = [];
        } catch (e) {
            paths = [];
        }

        uploadBtn.addEventListener('click', () => fileInput.click());

        fileInput.addEventListener('change', async () => {
            const files = Array.from(fileInput.files);

            for (const file of files) {
                await uploadOne(file);
            }

            fileInput.value = '';
            renderImages();
        });

        async function uploadOne(file) {
            const fd = new FormData();
            fd.append('file', file);

            const res = await fetch("{{ route('upload.photographer.portfolio') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: fd
            });

            const data = await res.json();
            if (data.ok) {
                paths.push(data.path);
                hiddenPaths.value = JSON.stringify(paths);
            } else {
                alert('Upload failed');
            }
        }

        async function removeOne(index) {
            const p = paths[index];

            await fetch("{{ route('upload.photographer.portfolio.destroy') }}", {
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    path: p
                })
            });

            paths.splice(index, 1);
            hiddenPaths.value = JSON.stringify(paths);
            renderImages();
        }

        function renderImages() {
            imageCount.textContent = paths.length;
            imagesGrid.innerHTML = '';

            if (paths.length === 0) {
                imagesGrid.innerHTML = `
            <div class="image-item image-placeholder">
                <div class="placeholder-icon"><i class="bi bi-image"></i></div>
                <span>No images yet</span>
            </div>`;
                return;
            }

            paths.forEach((p, idx) => {
                const url = "{{ asset('storage') }}/" + p;

                const item = document.createElement('div');
                item.className = 'image-item';
                item.innerHTML = `
                <img src="${url}" class="image-preview" alt="preview">
                <button type="button" class="remove-btn" style="margin-top:6px;">Remove</button>
            `;

                item.querySelector('.remove-btn').addEventListener('click', () => removeOne(idx));
                imagesGrid.appendChild(item);
            });
        }

        renderImages();


        /* =======================
           Multi-select types (ARRAY inputs)
           (خليه زي ما هو)
        ======================= */
        const photographyTypes = document.getElementById('photographyTypes');
        const typeOptions = document.getElementById('typeOptions');
        const selectedTypesSpan = document.getElementById('selectedTypes');
        const typesInputsWrap = document.getElementById('typesInputs');

        let selected = [];

        typeOptions.querySelectorAll('.select-option.selected').forEach(opt => {
            selected.push(opt.dataset.value);
        });

        function syncHiddenInputs() {
            typesInputsWrap.innerHTML = '';
            selected.forEach(val => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'photography_types[]';
                input.value = val;
                typesInputsWrap.appendChild(input);
            });
        }

        function updateSelectedText() {
            if (selected.length === 0) {
                selectedTypesSpan.textContent = 'Select your specialties';
            } else {
                selectedTypesSpan.textContent = selected.join(', ');
            }
            syncHiddenInputs();
        }

        updateSelectedText();

        photographyTypes.addEventListener('click', () => {
            typeOptions.classList.toggle('show');
        });

        document.addEventListener('click', (e) => {
            if (!photographyTypes.contains(e.target) && !typeOptions.contains(e.target)) {
                typeOptions.classList.remove('show');
            }
        });

        typeOptions.querySelectorAll('.select-option').forEach(opt => {
            opt.addEventListener('click', () => {
                const val = opt.dataset.value;

                if (selected.includes(val)) {
                    selected = selected.filter(x => x !== val);
                    opt.classList.remove('selected');
                } else {
                    selected.push(val);
                    opt.classList.add('selected');
                }

                updateSelectedText();
            });
        });

    });
</script>

@endsection