@extends('layouts.auth.master')

@section('title', 'Signup - Studio Step 2')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/onboarding-styles.css') }}">
@endsection

@section('content')
<main class="main-content">
    <div class="progress-container">
        <h1 class="progress-title">Complete Your Studio Profile</h1>
        <p class="progress-subtitle">Step 2 of 2 - Add your studio details to start accepting bookings</p>
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

        <form method="POST" action="{{ route('signup.studio.store') }}" enctype="multipart/form-data" class="onboarding-form" id="studioForm">
            @csrf

            <!-- Studio Information -->
            <div class="form-section">
                <div class="section-header">
                    <h2 class="section-title"><i class="bi bi-building section-icon"></i> Studio Information</h2>
                    <p class="section-description">Tell us about your photography studio</p>
                </div>

                <div class="form-group">
                    <label for="studio_name" class="form-label"><i class="bi bi-shop"></i><span>Studio Name</span><span class="required">*</span></label>
                    <input type="text" id="studio_name" name="studio_name" class="form-input @error('studio_name') error @enderror"
                           value="{{ old('studio_name') }}" required>
                    @error('studio_name')<div class="error-message" style="display:block;">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label for="description" class="form-label"><i class="bi bi-card-text"></i><span>Studio Description</span><span class="required">*</span></label>
                    <textarea id="description" name="description" class="form-textarea @error('description') error @enderror" rows="4" required>{{ old('description') }}</textarea>
                    @error('description')<div class="error-message" style="display:block;">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label for="phone_number" class="form-label"><i class="bi bi-telephone"></i><span>Phone Number</span><span class="required">*</span></label>
                    <input type="tel" id="phone_number" name="phone_number" class="form-input @error('phone_number') error @enderror"
                           value="{{ old('phone_number') }}" required>
                    @error('phone_number')<div class="error-message" style="display:block;">{{ $message }}</div>@enderror
                </div>
            </div>

            <!-- Location -->
            <div class="form-section">
                <div class="section-header">
                    <h2 class="section-title"><i class="bi bi-geo-alt section-icon"></i> Location</h2>
                    <p class="section-description">Where is your studio located?</p>
                </div>

                <div class="form-group">
                    <label for="address" class="form-label"><i class="bi bi-house-door"></i><span>Full Address</span><span class="required">*</span></label>
                    <input type="text" id="address" name="address" class="form-input @error('address') error @enderror"
                           value="{{ old('address') }}" required>
                    @error('address')<div class="error-message" style="display:block;">{{ $message }}</div>@enderror
                </div>
            </div>

            <!-- Services -->
            <div class="form-section">
                <div class="section-header">
                    <h2 class="section-title"><i class="bi bi-list-check section-icon"></i> Services</h2>
                    <p class="section-description">What services does your studio offer?</p>
                </div>

                @php
                    $servicesMap = [
                        'wedding' => 'Wedding Photography',
                        'portrait' => 'Portrait Sessions',
                        'family' => 'Family Photography',
                        'maternity' => 'Maternity Sessions',
                        'newborn' => 'Newborn Photography',
                        'corporate' => 'Corporate Headshots',
                        'product' => 'Product Photography',
                        'event' => 'Event Coverage',
                        'boudoir' => 'Boudoir Photography',
                    ];
                    $oldServices = old('services', []);
                    if (!is_array($oldServices)) $oldServices = [];
                @endphp

                <div class="form-group">
                    <label class="form-label"><i class="bi bi-camera"></i><span>Available Session Types</span><span class="required">*</span></label>

                    <div style="display:flex; flex-wrap:wrap; gap:10px;">
                        @foreach($servicesMap as $val => $label)
                            <label style="display:flex; gap:8px; align-items:center;">
                                <input type="checkbox" name="services[]" value="{{ $val }}" @checked(in_array($val, $oldServices))>
                                <span>{{ $label }}</span>
                            </label>
                        @endforeach
                    </div>

                    @error('services')<div class="error-message" style="display:block;">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label for="team_size" class="form-label"><i class="bi bi-people"></i><span>Team Size</span><span class="required">*</span></label>
                    <select id="team_size" name="team_size" class="form-select @error('team_size') error @enderror" required>
                        <option value="">Select team size</option>
                        @foreach (['1-3','4-6','7-10','10+'] as $opt)
                            <option value="{{ $opt }}" @selected(old('team_size')===$opt)>{{ $opt }}</option>
                        @endforeach
                    </select>
                    @error('team_size')<div class="error-message" style="display:block;">{{ $message }}</div>@enderror
                </div>

                {{-- Equipment tags (optional) --}}
                <div class="form-group">
                    <label class="form-label"><i class="bi bi-tools"></i><span>Equipment (Optional)</span></label>

                    <input type="text" id="equipmentInput" class="form-input" placeholder="Add equipment and press Add">
                    <button type="button" class="upload-btn" id="addEquipmentBtn" style="margin-top:10px;">Add</button>

                    <div class="tags-container" id="equipmentTags" style="margin-top:10px;"></div>
                    <input type="hidden" name="equipment_tags" id="equipmentTagsHidden" value="{{ old('equipment_tags','[]') }}">
                </div>
            </div>

            <!-- Working hours (save JSON string in hidden input) -->
            <div class="form-section">
                <div class="section-header">
                    <h2 class="section-title"><i class="bi bi-clock section-icon"></i> Working Hours</h2>
                    <p class="section-description">When is your studio open for bookings?</p>
                </div>
                
                <input type="hidden" name="working_hours" id="workingHoursHidden" value="{{ old('working_hours','{}') }}">

                <p style="color:var(--lydia-gray); font-size:.95rem;">
                   
                </p>

                <div class="working-hours">
                    @php $days = ['monday','tuesday','wednesday','thursday','friday','saturday','sunday']; @endphp
                    @foreach($days as $d)
                        <div class="hour-group">
                            <div class="day-label">{{ ucfirst($d) }}</div>
                            <div class="time-inputs">
                                <input type="time" id="{{ $d }}Open" class="form-input">
                                <span>to</span>
                                <input type="time" id="{{ $d }}Close" class="form-input">
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Portfolio -->
            <div class="form-section">
                <div class="section-header">
                    <h2 class="section-title"><i class="bi bi-images section-icon"></i> Studio Portfolio</h2>
                    <p class="section-description">Upload photos (max 5MB each)</p>
                </div>

                <div class="upload-container" id="uploadContainer">
                    <div class="upload-icon"><i class="bi bi-cloud-arrow-up"></i></div>
                    <h3 class="upload-title">Drag & Drop Studio Photos</h3>
                    <p class="upload-description">Upload JPG, PNG or WebP images (max 5MB each)</p>

                    <button type="button" class="upload-btn" id="uploadBtn">
                        <i class="bi bi-folder2-open"></i> Browse Files
                    </button>

                    <input type="file" id="fileInput" multiple accept="image/*" style="display:none;">
                    <input type="hidden" name="portfolio_paths" id="portfolioPaths" value="[]">


                    <p class="upload-info">Minimum: 6 images | Maximum: 15 images</p>
                </div>

                @error('portfolio')<div class="error-message" style="display:block;">{{ $message }}</div>@enderror
                @error('portfolio.*')<div class="error-message" style="display:block;">{{ $message }}</div>@enderror

                <div class="portfolio-preview" id="portfolioPreview">
                    <div class="preview-header">
                        <h3 class="preview-title">Studio Portfolio</h3>
                        <div class="image-count"><span id="imageCount">0</span> / 15 images</div>
                    </div>

                    <div class="images-grid" id="imagesGrid">
                        <div class="image-item image-placeholder">
                            <div class="placeholder-icon"><i class="bi bi-image"></i></div>
                            <span>No images yet</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-section">
                <button type="submit" class="submit-btn" id="submitBtn">
                    <span>Submit Studio for Review</span>
                    <i class="bi bi-check-circle btn-icon"></i>
                </button>
            </div>
        </form>
    </div>
</main>
@endsection

@section('script')
<script>

document.addEventListener('DOMContentLoaded', function () {
    const uploadBtn = document.getElementById('uploadBtn');
    const fileInput = document.getElementById('fileInput');
    const imagesGrid = document.getElementById('imagesGrid');
    const imageCount = document.getElementById('imageCount');
    const pathsHidden = document.getElementById('portfolioPaths');

    let uploadedItems = []; // [{path,url}]

    // helpers
    function csrf() {
        return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';
    }

    function setHidden() {
        pathsHidden.value = JSON.stringify(uploadedItems.map(x => x.path));
    }

    function render() {
        imageCount.textContent = uploadedItems.length;
        imagesGrid.innerHTML = '';

        if (!uploadedItems.length) {
            imagesGrid.innerHTML = `
                <div class="image-item image-placeholder">
                    <div class="placeholder-icon"><i class="bi bi-image"></i></div>
                    <span>No images yet</span>
                </div>`;
            return;
        }

        uploadedItems.forEach((it, idx) => {
            const div = document.createElement('div');
            div.className = 'image-item';
            div.innerHTML = `
                <div style="position:relative;">
                    <img src="${it.url}" class="image-preview" alt="preview">
                    <button type="button" data-i="${idx}"
                        style="position:absolute;top:8px;right:8px;border:none;border-radius:8px;padding:6px 10px;cursor:pointer;">
                        ✕
                    </button>
                </div>`;
            imagesGrid.appendChild(div);
        });

        imagesGrid.querySelectorAll('button[data-i]').forEach(btn => {
            btn.addEventListener('click', async () => {
                const i = parseInt(btn.getAttribute('data-i'));
                const item = uploadedItems[i];
                if (!item) return;

                // delete from server
                await fetch("{{ route('signup.studio.upload.destroy') }}", {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrf(),
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ path: item.path })
                });

                uploadedItems.splice(i, 1);
                setHidden();
                render();
            });
        });
    }

    async function uploadOne(file) {
        const fd = new FormData();
        fd.append('file', file);

        const res = await fetch("{{ route('signup.studio.upload') }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrf(),
                'Accept': 'application/json',
            },
            body: fd
        });

        if (!res.ok) {
            // لو السيرفر رجّع validation errors
            let msg = 'Upload failed';
            try {
                const data = await res.json();
                msg = data?.message || msg;
            } catch (e) {}
            throw new Error(msg);
        }

        return await res.json(); // {ok,path,url}
    }

    uploadBtn.addEventListener('click', () => fileInput.click());

    fileInput.addEventListener('change', async () => {
        const files = Array.from(fileInput.files || []);
        if (!files.length) return;

        // limit total 15
        const remaining = 15 - uploadedItems.length;
        const toUpload = files.slice(0, remaining);

        try {
            for (const f of toUpload) {
                const data = await uploadOne(f);
                if (data?.ok) uploadedItems.push({ path: data.path, url: data.url });
            }
            setHidden();
            render();
        } catch (e) {
            alert(e.message || 'Upload error');
        } finally {
            // reset input so selecting same file again triggers change
            fileInput.value = '';
        }
    });

    // before submit: ensure hidden updated + basic min images
    document.getElementById('studioForm').addEventListener('submit', function(e) {
        setHidden();
        if (uploadedItems.length < 6) {
            e.preventDefault();
            alert('Please upload at least 6 images.');
        }
    });

    render();


    // equipment tags -> JSON in hidden
    const addBtn = document.getElementById('addEquipmentBtn');
    const input = document.getElementById('equipmentInput');
    const tagsWrap = document.getElementById('equipmentTags');
    const hidden = document.getElementById('equipmentTagsHidden');

    let equipment = [];
    try {
        equipment = JSON.parse(hidden.value || '[]');
        if (!Array.isArray(equipment)) equipment = [];
    } catch(e){ equipment = []; }

    function paintTags(){
        tagsWrap.innerHTML = '';
        equipment.forEach((t, idx) => {
            const tag = document.createElement('div');
            tag.className = 'tag';
            tag.innerHTML = `${t} <span class="remove-tag-btn" data-i="${idx}">&times;</span>`;
            tagsWrap.appendChild(tag);
        });
        hidden.value = JSON.stringify(equipment);

        tagsWrap.querySelectorAll('.remove-tag-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const i = parseInt(btn.getAttribute('data-i'));
                equipment.splice(i, 1);
                paintTags();
            });
        });
    }

    paintTags();

    addBtn.addEventListener('click', () => {
        const val = (input.value || '').trim();
        if(!val) return;
        equipment.push(val);
        input.value = '';
        paintTags();
    });

    // working hours -> JSON
    const workingHidden = document.getElementById('workingHoursHidden');
    const days = ['monday','tuesday','wednesday','thursday','friday','saturday','sunday'];

    function buildHours(){
        const obj = {};
        days.forEach(d => {
            const o = document.getElementById(d+'Open').value;
            const c = document.getElementById(d+'Close').value;
            obj[d] = { open: o, close: c, closed: (!o && !c) };
        });
        workingHidden.value = JSON.stringify(obj);
    }

    // update before submit
    document.getElementById('studioForm').addEventListener('submit', () => buildHours());
});
</script>
@endsection
