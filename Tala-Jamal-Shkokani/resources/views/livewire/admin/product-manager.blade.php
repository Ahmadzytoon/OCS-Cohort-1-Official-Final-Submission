<div class="animate-fade-in">
    <!-- Header & Statistics -->
    <div class="mb-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h2 mb-1" style="font-family: var(--font-heading); font-weight: 700;">Product Gallery</h1>
                <p class="text-muted small mb-0">Curate and manage your luxury collection.</p>
            </div>
            <div class="d-flex gap-3 align-items-center">
                <div class="d-flex gap-2">
                    <div class="bg-white px-3 py-2 rounded-4 shadow-sm border text-center">
                        <div class="extra-small text-muted fw-bold text-uppercase ls-1">Total Pieces</div>
                        <div class="h5 mb-0 fw-bold">{{ $stats['total'] }}</div>
                    </div>
                    <div class="bg-white px-3 py-2 rounded-4 shadow-sm border text-center">
                        <div class="extra-small text-muted fw-bold text-uppercase ls-1">Inventory Sum</div>
                        <div class="h5 mb-0 fw-bold text-primary">{{ $stats['stock'] }}</div>
                    </div>
                    <div class="bg-white px-3 py-2 rounded-4 shadow-sm border text-center">
                        <div class="extra-small text-muted fw-bold text-uppercase ls-1">Featured</div>
                        <div class="h5 mb-0 fw-bold text-success">{{ $stats['featured'] }}</div>
                    </div>
                </div>
                <button wire:click="openCreate"
                    class="btn btn-dark rounded-pill px-4 shadow-sm border-0 d-flex align-items-center gap-2">
                    <i class="fa fa-plus small"></i> Release Piece
                </button>
            </div>
        </div>

        <!-- Filter Bar -->
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body p-3">
                <div class="row g-3 align-items-center">
                    <div class="col-md-3">
                        <div class="position-relative">
                            <input type="text" class="form-control border-0 bg-light rounded-3 ps-5 shadow-sm"
                                placeholder="Search by name..." wire:model.live.debounce.300ms="search">
                            <i
                                class="fa fa-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <select wire:model.live="categoryFilter"
                            class="form-select border-0 bg-light rounded-3 shadow-sm">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select wire:model.live="aestheticFilter"
                            class="form-select border-0 bg-light rounded-3 shadow-sm">
                            <option value="">All Aesthetics</option>
                            <option value="soft">Soft Femme</option>
                            <option value="alt">Alt Girly</option>
                            <option value="luxury">Luxury Clean</option>
                            <option value="mix">Modern Mix</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select wire:model.live="statusFilter"
                            class="form-select border-0 bg-light rounded-3 shadow-sm">
                            <option value="">All Statuses</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                    <div class="col-md-3 text-end">
                        <button wire:click="resetFilters" class="btn btn-light rounded-3 px-3 shadow-sm border-0">
                            <i class="fa fa-undo-alt me-2 text-muted"></i> Reset
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bulk Actions -->
        @if(count($selectedRows) > 0)
            <div class="d-flex align-items-center gap-3 animate-fade-in bg-white p-2 rounded-pill shadow border px-4 mb-4">
                <span class="small fw-bold text-primary">{{ count($selectedRows) }} selected</span>
                <div class="vr"></div>
                <button x-data="confirmAction"
                    @click="confirm('bulkDelete', null, 'Delete Selection?', 'This will permanently remove selected items.')"
                    class="btn btn-sm btn-outline-danger border-0 rounded-pill">
                    <i class="fa fa-trash me-2"></i> Delete Selected
                </button>
            </div>
        @endif
    </div>

    <!-- Inventory Table -->
    <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 24px;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr class="bg-light bg-opacity-50 align-top">
                            <th class="ps-4 py-3 border-0" style="width: 40px;">
                                <div class="form-check">
                                    <input class="form-check-input shadow-none cursor-pointer" type="checkbox"
                                        wire:model.live="selectAll">
                                </div>
                            </th>
                            <th class="py-3 border-0 text-uppercase extra-small text-muted fw-bold ls-1 cursor-pointer"
                                wire:click="sortBy('name')">
                                Piece @if($sortField === 'name') <i
                                    class="fa fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} text-primary"></i>
                                @else <i class="fa fa-sort opacity-25"></i> @endif
                            </th>
                            <th class="py-3 border-0 text-uppercase extra-small text-muted fw-bold ls-1">Categorization
                            </th>
                            <th class="py-3 border-0 text-uppercase extra-small text-muted fw-bold ls-1 cursor-pointer"
                                wire:click="sortBy('price')">
                                Investment @if($sortField === 'price') <i
                                    class="fa fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} text-primary"></i>
                                @else <i class="fa fa-sort opacity-25"></i> @endif
                            </th>
                            <th class="py-3 border-0 text-uppercase extra-small text-muted fw-bold ls-1">Discount</th>
                            <th class="py-3 border-0 text-uppercase extra-small text-muted fw-bold ls-1">Colors</th>
                            <th class="py-3 border-0 text-uppercase extra-small text-muted fw-bold ls-1 text-center cursor-pointer"
                                wire:click="sortBy('stock')">
                                Stock @if($sortField === 'stock') <i
                                    class="fa fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} text-primary"></i>
                                @else <i class="fa fa-sort opacity-25"></i> @endif
                            </th>
                            <th class="py-3 border-0 text-uppercase extra-small text-muted fw-bold ls-1 text-center">
                                Status</th>
                            <th class="pe-4 py-3 border-0 text-end text-uppercase extra-small text-muted fw-bold ls-1">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        @forelse($products as $product)
                            <tr wire:key="product-row-{{ $product->id }}" class="border-top product-row"
                                style="border-color: rgba(0,0,0,0.02) !important;">
                                <td class="ps-4">
                                    <div class="form-check">
                                        <input class="form-check-input shadow-none cursor-pointer" type="checkbox"
                                            value="{{ $product->id }}" wire:model.live="selectedRows">
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-light rounded-3 p-1 me-3 shadow-sm"
                                            style="width: 50px; height: 60px;">
                                            <img src="{{ $product->image }}" class="rounded-2 object-fit-cover w-100 h-100">
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark small">{{ $product->name }}</div>
                                            <div class="text-muted extra-small">
                                                <span
                                                    class="badge bg-soft-blush text-primary border-0 extra-small px-2">{{ $product->aesthetic }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <a href="{{ route('admin.categories.index') }}" wire:navigate
                                        class="text-decoration-none">
                                        <span class="small text-primary fw-bold hover-underline">
                                            {{ $product->category->name ?? 'Uncategorized' }}
                                        </span>
                                    </a>
                                </td>
                                <td>
                                    <div class="fw-bold text-dark small">
                                        {{ number_format($product->price, 0) }} <span
                                            class="text-muted extra-small fw-normal">JOD</span>
                                    </div>
                                </td>
                                <td>
                                    @if($product->discount_percentage > 0)
                                        <span class="badge bg-danger-subtle text-danger rounded-pill px-2 py-1 extra-small">
                                            -{{ (float) $product->discount_percentage }}%
                                        </span>
                                    @else
                                        <span class="text-muted opacity-50 extra-small">—</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex gap-1">
                                        @if($product->colors && count($product->colors) > 0)
                                            @foreach(array_slice($product->colors, 0, 4) as $color)
                                                <div class="rounded-circle border"
                                                    style="width: 14px; height: 14px; background-color: {{ $color }};"
                                                    title="{{ $color }}"></div>
                                            @endforeach
                                            @if(count($product->colors) > 4)
                                                <span class="text-muted extra-small">+{{ count($product->colors) - 4 }}</span>
                                            @endif
                                        @else
                                            <span class="text-muted opacity-50 extra-small">—</span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <span
                                        class="badge {{ $product->stock < 5 ? 'bg-danger-subtle text-danger' : ($product->stock < 20 ? 'bg-warning-subtle text-warning' : 'bg-success-subtle text-success') }} rounded-pill px-3 py-1 extra-small border-0">
                                        {{ $product->stock }} units
                                    </span>
                                </td>
                                <td>
                                    @if($product->status === 'active')
                                        <span
                                            class="badge bg-dark text-white rounded-pill px-3 py-1 extra-small border-0">ACTIVE</span>
                                    @else
                                        <span
                                            class="badge bg-light text-muted border rounded-pill px-3 py-1 extra-small">INACTIVE</span>
                                    @endif
                                </td>
                                <td class="text-end pe-4" x-data="confirmAction">
                                    <div class="d-flex justify-content-end gap-2">
                                        <button wire:click="editProduct({{ $product->id }})"
                                            class="btn btn-sm btn-light rounded-pill px-3 py-2 extra-small fw-bold border shadow-sm hover-lift">
                                            Edit
                                        </button>
                                        <button
                                            @click="confirm('deleteProduct', {{ $product->id }}, 'Delete Piece?', 'This cannot be undone.')"
                                            class="btn btn-sm btn-outline-danger rounded-pill px-2 py-2 extra-small border-0">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5 text-muted">
                                    <i class="fa fa-box-open fa-3x mb-3 opacity-25 text-primary"></i>
                                    <p class="mb-0 fw-bold">No products match your criteria.</p>
                                    <button wire:click="resetFilters" class="btn btn-link text-primary btn-sm mt-2">Clear
                                        all filters</button>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($products->count() > 0)
            <div class="card-footer bg-white py-4 border-0 d-flex justify-content-center">
                {{ $products->links() }}
            </div>
        @endif
    </div>

    <!-- Product Sidebar (Livewire Driven) -->
    @if($showProductSidebar)
        <div class="position-fixed inset-0 bg-dark bg-opacity-50 blur-bg" style="z-index: 1060;"
            wire:click="$set('showProductSidebar', false)"></div>
        <div class="bg-white position-fixed top-0 end-0 h-100 shadow-lg animate-slide-in"
            style="width: 550px; z-index: 1070; border-left: 1px solid rgba(0,0,0,0.05);">
            <div class="h-100 d-flex flex-column">
                <div class="p-4 border-bottom d-flex justify-content-between align-items-center"
                    style="background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);">
                    <div>
                        <h5 class="mb-1 fw-bold" style="font-family: 'Playfair Display'; font-size: 1.5rem;">
                            {{ $isEditMode ? 'Edit Product' : 'Add New Product' }}
                        </h5>
                        <p class="text-muted small mb-0">
                            {{ $isEditMode ? 'Update product details' : 'Create a new luxury piece' }}
                        </p>
                    </div>
                    <button class="btn-close" wire:click="$set('showProductSidebar', false)"></button>
                </div>

                <div class="flex-grow-1 overflow-auto p-4">
                    <form wire:submit.prevent="save">
                        <div class="mb-4">
                            <label class="form-label fw-bold text-uppercase mb-3"
                                style="font-size: 0.75rem; letter-spacing: 1px; color: #666;">Product Image</label>
                            <div class="d-flex justify-content-center mb-3">
                                <div class="product-image-preview">
                                    <img src="{{ $image ?: 'https://via.placeholder.com/300' }}"
                                        class="w-100 h-100 object-fit-cover rounded-4 shadow-sm">
                                </div>
                            </div>
                            <input type="text" wire:model.live="image" class="form-control border-0 bg-light rounded-3 p-3"
                                placeholder="Enter main image URL...">
                        </div>

                        <!-- Gallery Images -->
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <label class="form-label fw-bold text-uppercase mb-0"
                                    style="font-size: 0.75rem; letter-spacing: 1px; color: #666;">Archive Gallery</label>
                                <button type="button" wire:click="addGalleryImage"
                                    class="btn btn-sm btn-outline-dark rounded-pill extra-small px-3">
                                    <i class="fa fa-plus me-1"></i> Add View
                                </button>
                            </div>

                            <div class="d-flex flex-column gap-3">
                                @foreach($galleries as $index => $gUrl)
                                    <div class="d-flex gap-2 align-items-center animate-fade-in"
                                        wire:key="gallery-{{ $index }}">
                                        <div class="bg-light rounded-3 overflow-hidden shadow-sm"
                                            style="width: 50px; height: 50px; flex-shrink: 0;">
                                            <img src="{{ $gUrl ?: 'https://via.placeholder.com/100' }}"
                                                class="w-100 h-100 object-fit-cover">
                                        </div>
                                        <div class="flex-grow-1">
                                            <input type="text" wire:model.live="galleries.{{ $index }}"
                                                class="form-control border-0 bg-light rounded-3 p-2 extra-small"
                                                placeholder="View detail URL...">
                                        </div>
                                        <button type="button" wire:click="removeGalleryImage({{ $index }})"
                                            class="btn btn-sm btn-outline-danger border-0 rounded-pill p-2">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </div>
                                @endforeach
                            </div>

                            @if(count($galleries) === 0)
                                <div class="text-center p-3 rounded-4 bg-light border border-dashed extra-small text-muted">
                                    No archival views selected.
                                </div>
                            @endif
                        </div>

                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label fw-bold text-uppercase"
                                    style="font-size: 0.75rem; letter-spacing: 1px; color: #666;">Product Name</label>
                                <input type="text" wire:model="name" class="form-control border-0 bg-light rounded-3 p-3"
                                    placeholder="Enter product name">
                                @error('name') <span class="text-danger small d-block mt-1">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold text-uppercase"
                                    style="font-size: 0.75rem; letter-spacing: 1px; color: #666;">Category</label>
                                <select wire:model="category_id" class="form-select border-0 bg-light rounded-3 p-3">
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold text-uppercase"
                                    style="font-size: 0.75rem; letter-spacing: 1px; color: #666;">Aesthetic</label>
                                <select wire:model="aesthetic" class="form-select border-0 bg-light rounded-3 p-3">
                                    <option value="">Select Aesthetic</option>
                                    <option value="soft">Soft Femme</option>
                                    <option value="alt">Alt Girly</option>
                                    <option value="luxury">Luxury Clean</option>
                                    <option value="mix">Modern Mix</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold text-uppercase"
                                    style="font-size: 0.75rem; letter-spacing: 1px; color: #666;">Price (JOD)</label>
                                <input type="number" step="0.01" wire:model.live.debounce.500ms="price"
                                    class="form-control border-0 bg-light rounded-3 p-3 @error('price') is-invalid @enderror"
                                    placeholder="0.00">
                                @error('price') <div class="invalid-feedback ms-2">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold text-uppercase"
                                    style="font-size: 0.75rem; letter-spacing: 1px; color: #666;">Discount (%)</label>
                                <input type="number" step="0.1" wire:model.live.debounce.500ms="discount_percentage"
                                    class="form-control border-0 bg-light rounded-3 p-3 @error('discount_percentage') is-invalid @enderror"
                                    placeholder="0">
                                @error('discount_percentage') <div class="invalid-feedback ms-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12">
                                <label
                                    class="form-label fw-bold text-uppercase d-flex justify-content-between align-items-center"
                                    style="font-size: 0.75rem; letter-spacing: 1px; color: #666;">
                                    <span>Stock Quantity</span>
                                    @if(count($colors ?? []) > 0)
                                        <span class="badge bg-soft-blush text-primary extra-small border-0">Auto-calculated from
                                            colors</span>
                                    @endif
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text border-0 bg-light p-3">
                                        <i
                                            class="fa fa-boxes-stacked {{ count($colors ?? []) > 0 ? 'text-primary' : 'text-muted' }}"></i>
                                    </span>
                                    <input type="number" wire:model.live.debounce.500ms="stock"
                                        class="form-control border-0 bg-light rounded-end-3 p-3 @error('stock') is-invalid @enderror"
                                        placeholder="0" {{ count($colors ?? []) > 0 ? 'readonly' : '' }}>
                                </div>
                                @if(count($colors ?? []) > 0)
                                    <div class="form-text extra-small mt-1 text-primary">
                                        <i class="fa fa-info-circle me-1"></i> Total stock is locked while colors are selected.
                                    </div>
                                @endif
                                @error('stock') <div class="invalid-feedback ms-2">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-bold text-uppercase mb-3"
                                    style="font-size: 0.75rem; letter-spacing: 1px; color: #666;">Available Sizes</label>
                                <div class="d-flex flex-wrap gap-2 mb-3">
                                    @foreach(['XXS', 'XS', 'S', 'M', 'L', 'XL', 'XXL'] as $size)
                                        <div class="form-check form-check-inline p-0 m-0">
                                            <input type="checkbox" wire:model.live="sizes" value="{{ $size }}"
                                                id="size-{{ $size }}" class="btn-check">
                                            <label class="size-picker-btn" for="size-{{ $size }}">
                                                {{ $size }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-bold text-uppercase mb-3"
                                    style="font-size: 0.75rem; letter-spacing: 1px; color: #666;">Available Colors</label>
                                <div class="d-flex flex-wrap gap-2 mb-3">
                                    @foreach(['#000000', '#F5F5DC', '#FFFFFF', '#808080', '#A52A2A', '#000080', '#2E8B57', '#C0C0C0', '#FFD700'] as $c)
                                        <div class="form-check form-check-inline p-0 m-0">
                                            <input type="checkbox" wire:model.live="colors" value="{{ $c }}"
                                                id="color-{{ str_replace('#', '', $c) }}" class="btn-check">
                                            <label class="color-picker-btn" for="color-{{ str_replace('#', '', $c) }}"
                                                style="background-color: {{ $c }}; border: 3px solid {{ in_array($c, $colors ?? []) ? '#000' : '#e0e0e0' }};">
                                                @if(in_array($c, $colors ?? []))
                                                    <i
                                                        class="fa-solid fa-check {{ in_array($c, ['#FFFFFF', '#F5F5DC', '#FFD700', '#C0C0C0']) ? 'text-dark' : 'text-white' }}"></i>
                                                @endif
                                            </label>
                                        </div>
                                    @endforeach
                                </div>

                                @if(count($colors ?? []) > 0 && count($sizes ?? []) > 0)
                                    <div class="mt-4 p-4 rounded-4 border bg-white shadow-sm animate-fade-in"
                                        style="border-style: dashed !important; border-width: 2px !important;">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h6 class="extra-small text-muted text-uppercase fw-bold ls-1 mb-0">Variant
                                                Inventory Control</h6>
                                            <button type="button" wire:click="$set('colors', [])"
                                                class="btn btn-link p-0 extra-small text-danger text-decoration-none">
                                                <i class="fa fa-times"></i> Clear All
                                            </button>
                                        </div>

                                        <div class="row g-4">
                                            @foreach($colors as $c)
                                                <div class="col-12" wire:key="variant-group-{{ $c }}">
                                                    <div class="d-flex align-items-center mb-2 padding-bottom-2 border-bottom pb-2">
                                                        <div class="rounded-circle border shadow-sm me-2"
                                                            style="width: 20px; height: 20px; background-color: {{ $c }};"></div>
                                                        <span class="small fw-bold text-dark">{{ $c }} Variants</span>
                                                    </div>

                                                    <div class="d-flex flex-wrap gap-2">
                                                        @foreach($sizes as $size)
                                                            @php $key = "$c|$size"; @endphp
                                                            <div class="flex-grow-1" style="min-width: 100px;">
                                                                <div class="input-group input-group-sm">
                                                                    <span
                                                                        class="input-group-text bg-light border-0 fw-bold small">{{ $size }}</span>
                                                                    <input type="number" wire:model.live="variant_stock.{{ $key }}"
                                                                        class="form-control border-0 bg-light text-center fw-bold"
                                                                        placeholder="0">
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                        <div class="mt-3 text-center border-top pt-3 opacity-75">
                                            <span class="extra-small text-muted">
                                                <i class="fa fa-calculator me-1"></i>
                                                Sum calculation:
                                                <strong>{{ $stock }} units</strong>
                                            </span>
                                        </div>
                                    </div>
                                @else
                                    <div
                                        class="mt-3 p-3 rounded-4 bg-light text-center border border-dashed text-muted extra-small">
                                        <i class="fa fa-layer-group me-2"></i> Select both <strong>Colors</strong> and
                                        <strong>Sizes</strong> above to configure inventory.
                                    </div>
                                @endif
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-bold text-uppercase"
                                    style="font-size: 0.75rem; letter-spacing: 1px; color: #666;">Description</label>
                                <textarea wire:model.live.debounce.500ms="description"
                                    class="form-control border-0 bg-light rounded-3 p-3 @error('description') is-invalid @enderror"
                                    rows="4" placeholder="Describe this luxury piece..."></textarea>
                                @error('description') <div class="invalid-feedback ms-2">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-12 mt-4">
                                <label class="form-label fw-bold text-uppercase mb-3"
                                    style="font-size: 0.75rem; letter-spacing: 1px; color: #666;">Status</label>
                                <div class="d-flex gap-3">
                                    <button type="button" wire:click="$set('status', 'active')"
                                        class="btn flex-grow-1 rounded-pill py-3 {{ $status === 'active' ? 'btn-dark' : 'btn-outline-secondary' }}">
                                        <i class="fa fa-check-circle me-2"></i> Active
                                    </button>
                                    <button type="button" wire:click="$set('status', 'inactive')"
                                        class="btn flex-grow-1 rounded-pill py-3 {{ $status === 'inactive' ? 'btn-dark' : 'btn-outline-secondary' }}">
                                        <i class="fa fa-times-circle me-2"></i> Inactive
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="form-check form-switch mt-4 mb-4 p-3 bg-light rounded-3">
                            <input class="form-check-input" type="checkbox" wire:model="is_featured" id="featSwitch"
                                style="width: 3rem; height: 1.5rem;">
                            <label class="form-check-label fw-bold ms-3" for="featSwitch" style="font-size: 0.95rem;">
                                <i class="fa fa-star text-warning me-2"></i> Feature this product
                            </label>
                        </div>

                        <button type="submit" class="btn btn-dark w-100 rounded-pill py-4 shadow-lg border-0 fw-bold mb-3"
                            style="font-size: 1.1rem;">
                            <i class="fa {{ $isEditMode ? 'fa-save' : 'fa-plus-circle' }} me-2"></i>
                            {{ $isEditMode ? 'Save Changes' : 'Create Product' }}
                        </button>
                    </form>
                </div>
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

        .cursor-pointer {
            cursor: pointer;
        }

        .bg-soft-blush {
            background: rgba(246, 166, 178, 0.15);
        }

        .bg-success-subtle {
            background: rgba(25, 135, 84, 0.1);
            color: #198754 !important;
        }

        .bg-danger-subtle {
            background: rgba(220, 53, 69, 0.1);
            color: #dc3545 !important;
        }

        .bg-info-subtle {
            background: rgba(13, 202, 240, 0.1);
            color: #0dcaf0 !important;
        }

        .bg-warning-subtle {
            background: rgba(255, 193, 7, 0.1);
            color: #f59e0b !important;
        }

        @keyframes slideIn {
            from {
                transform: translateX(100%);
            }

            to {
                transform: translateX(0);
            }
        }

        .animate-slide-in {
            animation: slideIn 0.6s cubic-bezier(0.23, 1, 0.32, 1);
        }

        .form-check-input:checked {
            background-color: #F6A6B2;
            border-color: #F6A6B2;
        }

        .blur-bg {
            backdrop-filter: blur(5px);
        }

        .text-primary {
            color: #F6A6B2 !important;
        }

        .btn-primary {
            background-color: #F6A6B2;
            border-color: #F6A6B2;
        }

        .product-image-preview {
            width: 200px;
            height: 240px;
            overflow: hidden;
            border-radius: 12px;
            border: 3px solid #f0f0f0;
            transition: all 0.3s ease;
        }

        .product-image-preview:hover {
            border-color: #F6A6B2;
            transform: scale(1.02);
        }

        .color-picker-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .color-picker-btn:hover {
            transform: scale(1.15);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .hover-border-primary:hover {
            border-color: #F6A6B2 !important;
        }

        .transition-all {
            transition: all 0.3s ease;
        }

        .hover-lift:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .size-picker-btn {
            min-width: 45px;
            height: 45px;
            border-radius: 12px;
            border: 1px solid #e0e0e0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.8rem;
            color: #666;
            background: #fff;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .size-picker-btn:hover {
            background: rgba(0, 0, 0, 0.05);
            color: #333;
            transform: translateY(-2px);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        .btn-check:checked+.size-picker-btn {
            background: #1a1a1a;
            color: #fff;
            border-color: #1a1a1a;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            transform: translateY(-1px);
        }
    </style>
</div>