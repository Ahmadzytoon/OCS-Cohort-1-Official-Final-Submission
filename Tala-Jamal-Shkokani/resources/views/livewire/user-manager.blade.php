<div>
    @if (session()->has('success'))
        <x-alert type="success" class="mb-4">
            {{ session('success') }}
        </x-alert>
    @endif
    @if (session()->has('error'))
        <x-alert type="danger" class="mb-4">
            {{ session('error') }}
        </x-alert>
    @endif

    <div class="card shadow-sm border-0 mb-4" style="border-radius: 20px;">
        <div class="card-header bg-white py-3 border-0">
            <h5 class="mb-0 fw-bold" style="font-family: 'Playfair Display', serif;">
                {{ $userId ? 'Refine User Details' : 'Onboard New User' }}
            </h5>
        </div>
        <div class="card-body pt-0">
            <form wire:submit.prevent="save">
                <div class="row">
                    <div class="col-md-3">
                        <x-input label="Full Name" name="name" wire:model="name" placeholder="e.g. Sarah Johnson" />
                    </div>
                    <div class="col-md-3">
                        <x-input label="Email Address" name="email" type="email" wire:model="email"
                            placeholder="sarah@chic.co" />
                    </div>
                    <div class="col-md-3">
                        <x-input label="Password" name="password" type="password" wire:model="password"
                            placeholder="{{ $userId ? 'Leave blank to keep current' : 'Min 8 characters' }}" />
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-uppercase"
                                style="letter-spacing: 0.5px; color: var(--color-soft-gray);">Role</label>
                            <select wire:model="role" class="form-control border-0 shadow-sm px-3 py-2"
                                style="background: rgba(0,0,0,0.02); border-radius: 10px;">
                                <option value="user">User</option>
                                <option value="admin">Admin</option>
                            </select>
                            @error('role') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <x-button type="submit">
                        <span wire:loading wire:target="save" class="spinner-border spinner-border-sm me-1"
                            role="status"></span>
                        {{ $userId ? 'Update Profile' : 'Create Profile' }}
                    </x-button>
                    @if($userId)
                        <x-button variant="outline-secondary" wire:click="cancel">Cancel</x-button>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm border-0" style="border-radius: 20px;">
        <div class="card-header bg-white py-4 d-flex justify-content-between align-items-center border-0">
            <h5 class="mb-0 fw-bold" style="font-family: 'Playfair Display', serif;">Community Directory</h5>
            <div class="position-relative" style="width: 250px;">
                <input type="text" class="form-control border-0 shadow-sm ps-5" placeholder="Search community..."
                    wire:model.live.debounce.300ms="search"
                    style="background: rgba(0,0,0,0.02); border-radius: 10px; font-size: 0.9rem;">
                <i class="fa fa-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"
                    style="font-size: 0.8rem;"></i>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background: rgba(0,0,0,0.01);">
                        <tr>
                            <th class="ps-4 border-0 text-uppercase small text-muted fw-bold"
                                style="letter-spacing: 1px; cursor: pointer;" wire:click="sortBy('name')">
                                Name
                                @if($sortField === 'name')
                                    <i class="fa fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ms-1 text-dark"></i>
                                @else
                                    <i class="fa fa-sort ms-1 opacity-25"></i>
                                @endif
                            </th>
                            <th class="border-0 text-uppercase small text-muted fw-bold"
                                style="letter-spacing: 1px; cursor: pointer;" wire:click="sortBy('email')">
                                Email
                                @if($sortField === 'email')
                                    <i class="fa fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ms-1 text-dark"></i>
                                @else
                                    <i class="fa fa-sort ms-1 opacity-25"></i>
                                @endif
                            </th>
                            <th class="border-0 text-uppercase small text-muted fw-bold" style="letter-spacing: 1px;">
                                Role
                            </th>
                            <th class="border-0 text-uppercase small text-muted fw-bold"
                                style="letter-spacing: 1px; cursor: pointer;" wire:click="sortBy('created_at')">
                                Joined
                                @if($sortField === 'created_at')
                                    <i class="fa fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ms-1 text-dark"></i>
                                @else
                                    <i class="fa fa-sort ms-1 opacity-25"></i>
                                @endif
                            </th>
                            <th class="text-end pe-4 border-0 text-uppercase small text-muted fw-bold"
                                style="letter-spacing: 1px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr wire:key="user-{{ $user->id }}" class="border-top"
                                style="border-color: rgba(0,0,0,0.02) !important;">
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-light rounded-circle d-flex align-items-center justify-content-center me-3"
                                            style="width: 35px; height: 35px; font-size: 0.8rem; font-weight: 600;">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                        <span class="fw-medium text-dark">{{ $user->name }}</span>
                                    </div>
                                </td>
                                <td class="text-muted small">{{ $user->email }}</td>
                                <td class="small">
                                    <span
                                        class="badge {{ $user->role === 'admin' ? 'bg-dark' : 'bg-light text-dark' }} rounded-pill">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td class="text-muted small">{{ $user->created_at->diffForHumans() }}</td>
                                <td class="text-end pe-4">
                                    <button wire:click="edit({{ $user->id }})" class="btn btn-sm text-primary p-2"
                                        title="Edit">
                                        <i class="fa fa-pen-to-square"></i>
                                    </button>
                                    <button wire:click="delete({{ $user->id }})"
                                        wire:confirm="Are you sure you want to remove this user from the directory?"
                                        class="btn btn-sm text-danger p-2" title="Delete">
                                        <i class="fa fa-trash-can"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-5">
                                    <img src="https://illustrations.popsy.co/gray/searching.svg" alt="Empty"
                                        style="width: 150px;" class="mb-3 opacity-50">
                                    <p class="text-muted mb-0">No community members found.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($users->hasPages())
            <div class="card-footer bg-white py-4 border-0 d-flex justify-content-center">
                {{ $users->links() }}
            </div>
        @endif
    </div>

    <!-- Loading Overlay -->
    <div wire:loading.delay wire:target="search, sortBy, delete, save"
        class="position-fixed top-0 start-50 translate-middle-x mt-3" style="z-index: 9999;">
        <div class="bg-white shadow-sm py-2 px-4 d-flex align-items-center"
            style="border-radius: 50px; border: 1px solid rgba(0,0,0,0.05);">
            <div class="spinner-border spinner-border-sm text-primary me-3" role="status"></div>
            <span class="small fw-medium text-dark">Updating experience...</span>
        </div>
    </div>
</div>