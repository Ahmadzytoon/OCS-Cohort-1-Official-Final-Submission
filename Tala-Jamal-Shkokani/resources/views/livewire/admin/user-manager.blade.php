<div class="animate-fade-in">
    <!-- Header & Statistics -->
    <div class="mb-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h2 mb-1" style="font-family: var(--font-heading); font-weight: 700;">User Management</h1>
                <p class="text-muted small mb-0">Control center for luxury client profiles and administrative access.
                </p>
            </div>
            <div class="d-flex gap-3 align-items-center">
                <div class="d-flex gap-2">
                    <div class="bg-white px-3 py-2 rounded-4 shadow-sm border text-center">
                        <div class="extra-small text-muted fw-bold text-uppercase ls-1">Total Users</div>
                        <div class="h5 mb-0 fw-bold">{{ $stats['total'] }}</div>
                    </div>
                    <div class="bg-white px-3 py-2 rounded-4 shadow-sm border text-center">
                        <div class="extra-small text-muted fw-bold text-uppercase ls-1">Admins</div>
                        <div class="h5 mb-0 fw-bold text-primary">{{ $stats['admins'] }}</div>
                    </div>
                    <div class="bg-white px-3 py-2 rounded-4 shadow-sm border text-center">
                        <div class="extra-small text-muted fw-bold text-uppercase ls-1">Personas</div>
                        <div class="h5 mb-0 fw-bold text-info">{{ $stats['personas'] }}</div>
                    </div>
                </div>
                <button wire:click="openCreate"
                    class="btn btn-dark rounded-pill px-4 shadow-sm border-0 d-flex align-items-center gap-2">
                    <i class="fa fa-plus small"></i> New User
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
                                placeholder="Search by name or email..." wire:model.live.debounce.300ms="search">
                            <i
                                class="fa fa-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <select wire:model.live="roleFilter" class="form-select border-0 bg-light rounded-3 shadow-sm">
                            <option value="">All Roles</option>
                            <option value="admin">Admins</option>
                            <option value="user">Users</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select wire:model.live="personaFilter"
                            class="form-select border-0 bg-light rounded-3 shadow-sm">
                            <option value="">All Personas</option>
                            @foreach($personas as $persona)
                                <option value="{{ $persona }}">{{ $persona }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select wire:model.live="dateFilter" class="form-select border-0 bg-light rounded-3 shadow-sm">
                            <option value="all">Any Joined Date</option>
                            <option value="today">Today</option>
                            <option value="week">This Week</option>
                            <option value="month">This Month</option>
                            <option value="year">This Year</option>
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
                <div class="dropdown">
                    <button class="btn btn-sm btn-outline-dark border-0 rounded-pill dropdown-toggle"
                        data-bs-toggle="dropdown">
                        Bulk Action
                    </button>
                    <ul class="dropdown-menu shadow border-0 rounded-4">
                        <li><a class="dropdown-item small py-2" href="#"
                                wire:click.prevent="bulkUpdateRole('admin')">Promote to Admin</a></li>
                        <li><a class="dropdown-item small py-2" href="#" wire:click.prevent="bulkUpdateRole('user')">Demote
                                to Client</a></li>
                        <li>
                            <hr class="dropdown-divider opacity-50">
                        </li>
                        <li><a class="dropdown-item small py-2 text-danger" href="#" wire:click.prevent="bulkDelete">Delete
                                Selected</a></li>
                    </ul>
                </div>
            </div>
        @endif
    </div>

    <!-- Users Table -->
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
                                User @if($sortField === 'name') <i
                                    class="fa fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} text-primary"></i>
                                @else <i class="fa fa-sort opacity-25"></i> @endif
                            </th>
                            <th class="py-3 border-0 text-uppercase extra-small text-muted fw-bold ls-1 cursor-pointer"
                                wire:click="sortBy('email')">
                                Email @if($sortField === 'email') <i
                                    class="fa fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} text-primary"></i>
                                @else <i class="fa fa-sort opacity-25"></i> @endif
                            </th>
                            <th class="py-3 border-0 text-uppercase extra-small text-muted fw-bold ls-1">Role</th>
                            <th class="py-3 border-0 text-uppercase extra-small text-muted fw-bold ls-1">Persona</th>
                            <th class="py-3 border-0 text-uppercase extra-small text-muted fw-bold ls-1 text-end cursor-pointer"
                                wire:click="sortBy('created_at')">
                                Joined @if($sortField === 'created_at') <i
                                    class="fa fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} text-primary"></i>
                                @else <i class="fa fa-sort opacity-25"></i> @endif
                            </th>
                            <th class="pe-4 py-3 border-0 text-end text-uppercase extra-small text-muted fw-bold ls-1">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        @forelse($users as $user)
                            <tr wire:key="user-row-{{ $user->id }}" class="border-top"
                                style="border-color: rgba(0,0,0,0.02) !important;">
                                <td class="ps-4">
                                    <div class="form-check">
                                        <input class="form-check-input shadow-none cursor-pointer" type="checkbox"
                                            value="{{ $user->id }}" wire:model.live="selectedRows">
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-soft-blush rounded-circle d-flex align-items-center justify-content-center me-3 text-dark fw-bold"
                                            style="width: 40px; height: 40px; font-size: 0.85rem; border: 2px solid white; box-shadow: 0 4px 10px rgba(0,0,0,0.05);">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark small" style="letter-spacing: -0.2px;">
                                                {{ $user->name }}
                                            </div>
                                            <div class="extra-small text-muted">ID: #{{ $user->id }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="small">{{ $user->email }}</td>
                                <td>
                                    <span
                                        class="badge rounded-pill px-3 py-2 border-0 extra-small {{ $user->role === 'admin' ? 'bg-dark text-white' : 'bg-light text-muted border' }}">
                                        {{ strtoupper($user->role) }}
                                    </span>
                                </td>
                                <td>
                                    @if($user->style_persona)
                                        <span
                                            class="badge bg-soft-blush text-primary rounded-pill px-3 py-2 extra-small">{{ $user->style_persona }}</span>
                                    @else
                                        <span class="text-muted opacity-50 small">—</span>
                                    @endif
                                </td>
                                <td class="text-muted small">{{ $user->created_at->format('M d, Y') }}</td>
                                <td class="text-end pe-4">
                                    <div class="d-flex justify-content-end gap-2">
                                        <button wire:click="editUser({{ $user->id }})"
                                            class="btn btn-sm btn-light rounded-pill px-3 py-2 extra-small fw-bold border shadow-sm">
                                            Edit
                                        </button>
                                        <button wire:click="deleteUser({{ $user->id }})"
                                            wire:confirm="Remove this user profile forever?"
                                            class="btn btn-sm btn-outline-danger rounded-pill px-2 py-2 extra-small border-0">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="fa fa-users fa-3x mb-3 opacity-25 text-primary"></i>
                                    <p class="mb-0 fw-bold">No clients match your filter criteria.</p>
                                    <button wire:click="resetFilters" class="btn btn-link text-primary btn-sm mt-2">Clear
                                        all filters</button>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($users->count() > 0)
            <div class="card-footer bg-white py-4 border-0 d-flex justify-content-center">
                {{ $users->links() }}
            </div>
        @endif
    </div>

    <!-- User Sidebar (Livewire Driven) -->
    @if($showUserSidebar)
        <div class="position-fixed inset-0 bg-dark bg-opacity-50 blur-bg" style="z-index: 1060;"
            wire:click="$set('showUserSidebar', false)"></div>
        <div class="bg-white position-fixed top-0 end-0 h-100 shadow-lg animate-slide-in"
            style="width: 450px; z-index: 1070; border-left: 1px solid rgba(0,0,0,0.05);">
            <div class="h-100 d-flex flex-column">
                <div class="p-4 border-bottom d-flex justify-content-between align-items-center bg-light bg-opacity-50">
                    <h5 class="mb-0 fw-bold" style="font-family: 'Playfair Display';">
                        {{ $isEditing ? 'Edit Client Profile' : 'New Luxury Profile' }}
                    </h5>
                    <button class="btn-close" wire:click="$set('showUserSidebar', false)"></button>
                </div>

                <div class="flex-grow-1 overflow-auto p-4">
                    <form wire:submit.prevent="save">
                        <div class="mb-4 text-center">
                            <div class="bg-soft-blush rounded-circle d-inline-flex align-items-center justify-content-center mx-auto mb-3"
                                style="width: 80px; height: 80px; font-size: 2rem; border: 4px solid white; shadow: 0 10px 20px rgba(0,0,0,0.05);">
                                {{ $name ? substr($name, 0, 1) : '?' }}
                            </div>
                            @if($selectedUser && $selectedUser->style_persona)
                                <div class="badge bg-dark rounded-pill px-3 py-2 small d-block mx-auto mb-2"
                                    style="width: fit-content;">{{ $selectedUser->style_persona }}</div>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label class="extra-small text-muted text-uppercase fw-bold ls-1 mb-2">Display Name</label>
                            <input type="text" wire:model.live.debounce.500ms="name"
                                class="form-control border-0 bg-light rounded-3 p-3 shadow-sm @error('name') is-invalid @enderror"
                                placeholder="Full name">
                            @error('name') <span class="text-danger extra-small">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="extra-small text-muted text-uppercase fw-bold ls-1 mb-2">Email Identity</label>
                            <input type="email" wire:model.live.debounce.500ms="email"
                                class="form-control border-0 bg-light rounded-3 p-3 shadow-sm @error('email') is-invalid @enderror"
                                placeholder="client@chic.co">
                            @error('email') <span class="text-danger extra-small">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="extra-small text-muted text-uppercase fw-bold ls-1 mb-2">Secure Access
                                (Password)</label>
                            <input type="password" wire:model.live.debounce.500ms="password"
                                class="form-control border-0 bg-light rounded-3 p-3 shadow-sm @error('password') is-invalid @enderror"
                                placeholder="{{ $isEditing ? 'Leave blank to keep' : 'Minimum 8 characters' }}">
                            @error('password') <span class="text-danger extra-small">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="extra-small text-muted text-uppercase fw-bold ls-1 mb-2">Style Persona</label>
                            <select wire:model="style_persona"
                                class="form-select border-0 bg-light rounded-3 p-3 shadow-sm">
                                <option value="">No Persona Selected</option>
                                @foreach($styles as $style)
                                    <option value="{{ $style }}">{{ $style }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="extra-small text-muted text-uppercase fw-bold ls-1 mb-2">Access Level</label>
                            <div class="d-flex gap-2">
                                <button type="button" wire:click="$set('role', 'user')"
                                    class="btn flex-grow-1 rounded-3 py-3 border {{ $role === 'user' ? 'btn-dark' : 'btn-light' }}">
                                    <i class="fa fa-user me-2"></i> Client
                                </button>
                                <button type="button" wire:click="$set('role', 'admin')"
                                    class="btn flex-grow-1 rounded-3 py-3 border {{ $role === 'admin' ? 'btn-primary text-white border-0' : 'btn-light' }}">
                                    <i class="fa fa-shield-alt me-2"></i> Admin
                                </button>
                            </div>
                        </div>

                        @if($selectedUser)
                            <div class="card border-0 bg-light rounded-4 mb-4">
                                <div class="card-body p-3">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="extra-small text-muted text-uppercase fw-bold">Joined</span>
                                        <span class="small fw-bold">{{ $selectedUser->created_at->format('M d, Y') }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="extra-small text-muted text-uppercase fw-bold">Last Activity</span>
                                        <span class="small fw-bold">Active</span>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <button type="submit" class="btn btn-dark w-100 rounded-pill py-3 shadow-lg border-0 fw-bold mb-3">
                            {{ $isEditing ? 'Update Profile' : 'Create Luxury Account' }}
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
    </style>
</div>