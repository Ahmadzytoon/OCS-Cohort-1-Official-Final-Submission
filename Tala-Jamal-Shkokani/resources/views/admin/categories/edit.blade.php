@extends('layouts.admin')

@section('content')
    <div class="animate-fade-in">
        <!-- Header -->
        <div class="mb-5 d-flex justify-content-between align-items-end">
            <div>
                <h1 class="h2 mb-1" style="font-family: var(--font-heading); font-weight: 700;">Refine Collection</h1>
                <p class="text-muted small mb-0">Adjust the thematic essence and global parameters of this archive.</p>
            </div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 extra-small text-uppercase ls-1">
                    <li class="breadcrumb-item"><a href="{{ route('admin.categories.index') }}"
                            class="text-decoration-none text-muted">Archives</a></li>
                    <li class="breadcrumb-item active text-dark fw-bold">Editor</li>
                </ol>
            </nav>
        </div>

        <div class="row justify-content-center">
            <div class="col-xl-8">
                <div class="card border-0 shadow-lg overflow-hidden rounded-4">
                    <div class="row g-0">
                        <!-- Left Side: Preview -->
                        <div class="col-lg-5 bg-dark d-flex flex-column" style="min-height: 400px;">
                            <div
                                class="p-5 flex-grow-1 d-flex flex-column justify-content-center text-center text-white position-relative overflow-hidden">
                                <!-- Background Pattern/Image -->
                                <div class="position-absolute top-0 start-0 w-100 h-100 opacity-25" id="categoryPreviewBg"
                                    style="background: url('{{ $category->image ?? 'https://images.unsplash.com/photo-1441986300917-64674bd600d8?q=80&w=1000&auto=format&fit=crop' }}') center/cover no-repeat;">
                                </div>

                                <div class="position-relative z-index-1">
                                    <span class="extra-small text-uppercase ls-2 fw-bold opacity-50 mb-3 d-block">Collection
                                        Preview</span>
                                    <h2 class="font-heading mb-3 display-6" id="categoryPreviewName">{{ $category->name }}
                                    </h2>
                                    <div
                                        class="badge bg-primary-subtle text-primary border-0 rounded-pill px-4 py-2 text-uppercase extra-small ls-1 fw-bold">
                                        {{ $category->products()->count() }} Curated Pieces
                                    </div>
                                    <div class="mt-4" id="discountBadge"
                                        style="{{ $category->discount_percentage > 0 ? '' : 'display: none;' }}">
                                        <span class="badge bg-danger rounded-pill px-3 py-2 small shadow-sm">
                                            -{{ (float) $category->discount_percentage }}% Global Event
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Side: Form -->
                        <div class="col-lg-7 bg-white">
                            <div class="p-5">
                                <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="row g-4">
                                        <div class="col-12">
                                            <label class="form-label fw-bold text-uppercase"
                                                style="font-size: 0.75rem; letter-spacing: 1px; color: #666;">Collection
                                                Identity</label>
                                            <input type="text" name="name" id="nameInput"
                                                class="form-control border-0 bg-light rounded-3 p-3 @error('name') is-invalid @enderror"
                                                value="{{ old('name', $category->name) }}" placeholder="e.g. Ethereal Silk">
                                            @error('name') <div class="invalid-feedback ms-2">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="col-12">
                                            <label class="form-label fw-bold text-uppercase"
                                                style="font-size: 0.75rem; letter-spacing: 1px; color: #666;">Archival
                                                Visual (URL)</label>
                                            <input type="url" name="image" id="imageInput"
                                                class="form-control border-0 bg-light rounded-3 p-3 @error('image') is-invalid @enderror"
                                                value="{{ old('image', $category->image) }}"
                                                placeholder="https://image-source.com/photo.jpg">
                                            <div class="form-text extra-small mt-2 opacity-50">Provide a high-resolution
                                                link to define the collection's atmosphere.</div>
                                            @error('image') <div class="invalid-feedback ms-2">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-12">
                                            <label class="form-label fw-bold text-uppercase"
                                                style="font-size: 0.75rem; letter-spacing: 1px; color: #666;">Privilege
                                                Discount (%)</label>
                                            <input type="number" step="0.1" name="discount_percentage" id="discountInput"
                                                class="form-control border-0 bg-light rounded-3 p-3 @error('discount_percentage') is-invalid @enderror"
                                                value="{{ old('discount_percentage', $category->discount_percentage) }}"
                                                placeholder="0">
                                            <div class="form-text extra-small mt-2 opacity-50">Reward all acquisitions in
                                                this collection with a shared discount.</div>
                                            @error('discount_percentage') <div class="invalid-feedback ms-2">{{ $message }}
                                            </div> @enderror
                                        </div>
                                    </div>

                                    <div class="mt-5 d-flex gap-3">
                                        <button type="submit"
                                            class="btn btn-dark flex-grow-1 rounded-pill py-3 shadow-lg border-0 fw-bold">
                                            <i class="fa fa-save me-2"></i> Commit Changes
                                        </button>
                                        <a href="{{ route('admin.categories.index') }}"
                                            class="btn btn-outline-secondary rounded-pill px-4 py-3 border-0 bg-light text-dark fw-bold">
                                            Cancel
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .extra-small {
            font-size: 0.65rem;
        }

        .ls-1 {
            letter-spacing: 1.5px;
        }

        .ls-2 {
            letter-spacing: 2px;
        }

        .text-primary {
            color: #F6A6B2 !important;
        }

        .bg-primary-subtle {
            background: rgba(246, 166, 178, 0.15) !important;
        }

        .form-control:focus {
            background-color: #fff !important;
            box-shadow: 0 0 0 4px rgba(246, 166, 178, 0.1) !important;
            border-color: rgba(246, 166, 178, 0.5) !important;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const nameInput = document.getElementById('nameInput');
            const imageInput = document.getElementById('imageInput');
            const discountInput = document.getElementById('discountInput');

            const previewName = document.getElementById('categoryPreviewName');
            const previewBg = document.getElementById('categoryPreviewBg');
            const discountBadge = document.getElementById('discountBadge');

            nameInput.addEventListener('input', (e) => {
                previewName.textContent = e.target.value || 'New Collection';
            });

            imageInput.addEventListener('input', (e) => {
                if (e.target.value) {
                    previewBg.style.backgroundImage = `url('${e.target.value}')`;
                }
            });

            discountInput.addEventListener('input', (e) => {
                const val = parseFloat(e.target.value);
                if (val > 0) {
                    discountBadge.style.display = 'block';
                    discountBadge.querySelector('span').textContent = `-${val}% Global Event`;
                } else {
                    discountBadge.style.display = 'none';
                }
            });
        });
    </script>
@endsection