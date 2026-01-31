<div class="animate-fade-in">
    <!-- Header & Statistics -->
    <div class="mb-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h2 mb-1" style="font-family: var(--font-heading); font-weight: 700;">Collections</h1>
                <p class="text-muted small mb-0">Manage the thematic structure of your luxury pieces.</p>
            </div>
            <button wire:click="openCreate"
                class="btn btn-dark rounded-pill px-4 shadow-sm border-0 d-flex align-items-center gap-2">
                <i class="fa fa-plus small"></i> New Collection
            </button>
        </div>

        <!-- Filter Bar -->
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body p-3">
                <div class="row g-3 align-items-center">
                    <div class="col-md-6">
                        <div class="position-relative">
                            <input type="text" class="form-control border-0 bg-light rounded-3 ps-5 shadow-sm"
                                placeholder="Search collections..." wire:model.live.debounce.300ms="search">
                            <i
                                class="fa fa-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Collections Table -->
    <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 24px;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr class="bg-light bg-opacity-50 align-top">
                            <th class="ps-4 py-3 border-0 text-uppercase extra-small text-muted fw-bold ls-1"
                                style="width: 60px;">ID</th>
                            <th class="py-3 border-0 text-uppercase extra-small text-muted fw-bold ls-1">Collection Name
                            </th>
                            <th class="py-3 border-0 text-uppercase extra-small text-muted fw-bold ls-1 text-center">
                                Inventory Count</th>
                            <th class="py-3 border-0 text-uppercase extra-small text-muted fw-bold ls-1 text-center">
                                Global Discount</th>
                            <th class="pe-4 py-3 border-0 text-end text-uppercase extra-small text-muted fw-bold ls-1">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        @forelse($categories as $category)
                            <tr class="border-top" style="border-color: rgba(0,0,0,0.02) !important;">
                                <td class="ps-4 text-muted small fw-bold">#{{ $category->id }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center me-3 shadow-sm border-2 border-white overflow-hidden"
                                            style="width: 40px; height: 40px; background: var(--color-cloud);">
                                            @if($category->image)
                                                <img src="{{ $category->image }}" class="w-100 h-100 object-fit-cover">
                                            @else
                                                <span class="text-dark fw-bold small">{{ substr($category->name, 0, 1) }}</span>
                                            @endif
                                        </div>
                                        <div class="fw-bold text-dark">{{ $category->name }}</div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-light text-dark border rounded-pill px-3 py-2 small">
                                        {{ $category->products_count }} items
                                    </span>
                                </td>
                                <td class="text-center">
                                    @if($category->discount_percentage > 0)
                                        <span class="badge bg-danger-subtle text-danger rounded-pill px-3 py-2 small">
                                            -{{ (float) $category->discount_percentage }}%
                                        </span>
                                    @else
                                        <span class="text-muted opacity-50 small">—</span>
                                    @endif
                                </td>
                                <td class="text-end pe-4">
                                    <div class="d-flex justify-content-end gap-2">
                                        <button wire:click="editCategory({{ $category->id }})"
                                            class="btn btn-sm btn-light rounded-pill px-3 py-1 extra-small fw-bold border shadow-sm hover-lift"
                                            title="Edit">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                        <button x-data="confirmAction"
                                            @click="confirm('deleteCategory', {{ $category->id }}, 'Dissolve Collection?', 'This will remove the category and detach all associated products.')"
                                            class="btn btn-sm btn-outline-danger rounded-pill px-3 py-1 extra-small border-0 hover-lift"
                                            title="Delete">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <i class="fa fa-layer-group fa-3x mb-3 opacity-25 text-primary"></i>
                                    <p class="mb-0 fw-bold">No collections found.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($categories->hasPages())
            <div class="card-footer bg-white py-4 border-0 d-flex justify-content-center">
                {{ $categories->links() }}
            </div>
        @endif
    </div>

    <!-- Side Drawer (Collection Editor) -->
    @if($showDrawer)
        <div class="drawer-overlay" wire:click="$set('showDrawer', false)"></div>
        <div class="drawer shadow-lg animate-drawer-in">
            <div
                class="drawer-header p-4 border-bottom d-flex justify-content-between align-items-center bg-white sticky-top">
                <div>
                    <h4 class="fw-bold mb-0 font-heading">{{ $isEditMode ? 'Refine Collection' : 'New Collection' }}</h4>
                    <p class="text-muted extra-small mb-0 text-uppercase ls-1">Archival Parameters</p>
                </div>
                <button wire:click="$set('showDrawer', false)" class="btn-close shadow-none"></button>
            </div>

            <div class="drawer-body p-4">
                <form wire:submit.prevent="save">
                    <div class="row g-4">
                        <div class="col-12">
                            <div class="preview-card bg-dark rounded-4 p-4 text-center text-white mb-2 position-relative overflow-hidden"
                                style="min-height: 180px; display: flex; flex-column; justify-content: center; align-items: center;">
                                <div class="position-absolute top-0 start-0 w-100 h-100 opacity-25"
                                    style="background: url('{{ $image ?: 'https://images.unsplash.com/photo-1441986300917-64674bd600d8?q=80&w=1000&auto=format&fit=crop' }}') center/cover no-repeat;">
                                </div>
                                <div class="position-relative z-index-1">
                                    <h5 class="font-heading mb-1">{{ $name ?: 'Collection Identity' }}</h5>
                                    @if($discount_percentage > 0)
                                        <span
                                            class="badge bg-danger rounded-pill px-3 py-1 extra-small">-{{ $discount_percentage }}%
                                            Global</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold text-uppercase"
                                style="font-size: 0.75rem; letter-spacing: 1px; color: #666;">Identifier</label>
                            <input type="text" wire:model.live="name"
                                class="form-control border-0 bg-light rounded-3 p-3 @error('name') is-invalid @enderror"
                                placeholder="e.g. Ethereal Silk">
                            @error('name') <div class="invalid-feedback ms-2">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold text-uppercase"
                                style="font-size: 0.75rem; letter-spacing: 1px; color: #666;">Archival Visual (URL)</label>
                            <input type="url" wire:model.live="image"
                                class="form-control border-0 bg-light rounded-3 p-3 @error('image') is-invalid @enderror"
                                placeholder="https://image-source.com/photo.jpg">
                            @error('image') <div class="invalid-feedback ms-2">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold text-uppercase"
                                style="font-size: 0.75rem; letter-spacing: 1px; color: #666;">Global Discount (%)</label>
                            <input type="number" step="0.1" wire:model.live="discount_percentage"
                                class="form-control border-0 bg-light rounded-3 p-3 @error('discount_percentage') is-invalid @enderror"
                                placeholder="0">
                            @error('discount_percentage') <div class="invalid-feedback ms-2">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="mt-5">
                        <button type="submit" class="btn btn-dark w-100 rounded-pill py-4 shadow-lg border-0 fw-bold mb-3">
                            <i class="fa {{ $isEditMode ? 'fa-save' : 'fa-plus-circle' }} me-2"></i>
                            {{ $isEditMode ? 'Commit Changes' : 'Manifest Collection' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <style>
        .extra-small {
            font-size: 0.65rem;
        }

        .ls-1 {
            letter-spacing: 1.5px;
        }

        .hover-lift {
            transition: all 0.3s ease;
        }

        .hover-lift:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1) !important;
        }

        .text-primary {
            color: #F6A6B2 !important;
        }

        .drawer-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(4px);
            z-index: 1050;
        }

        .drawer {
            position: fixed;
            top: 0;
            right: 0;
            width: 450px;
            height: 100%;
            background: #fff;
            z-index: 1060;
            overflow-y: auto;
        }

        .animate-drawer-in {
            animation: slideInRight 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes slideInRight {
            from {
                transform: translateX(100%);
            }

            to {
                transform: translateX(0);
            }
        }

        .form-control:focus {
            background-color: #fff !important;
            box-shadow: 0 0 0 4px rgba(246, 166, 178, 0.1) !important;
            border-color: rgba(246, 166, 178, 0.5) !important;
        }
    </style>
</div>