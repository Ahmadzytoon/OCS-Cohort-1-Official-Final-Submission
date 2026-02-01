<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Attributes\Title;

#[Layout('layouts.admin')]
#[Title('Clientele Registry')]
class UserManager extends Component
{
    use WithPagination;

    // Search and Filters
    #[Url(as: 'search')]
    public $search = '';

    #[Url(as: 'role')]
    public $roleFilter = '';

    #[Url(as: 'persona')]
    public $personaFilter = '';

    #[Url(as: 'date')]
    public $dateFilter = 'all';

    public $styles = ['Soft Femme', 'Alt Girly', 'Luxury Clean', 'Modern Mix'];

    // User Form / Details
    public $userId;
    public $name;
    public $email;
    public $password;
    public $role = 'user';
    public $style_persona = '';
    public $showUserSidebar = false;
    public $isEditing = false;
    public $selectedUser = null;

    // Sorting
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    // Selection
    public $selectAll = false;
    public $selectedRows = [];

    protected $paginationTheme = 'bootstrap';

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, [
            'name' => 'nullable|min:3|regex:/^[a-zA-Z\s]{2,}$/',
            'email' => 'nullable|email',
        ]);
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }
    public function updatedRoleFilter()
    {
        $this->resetPage();
    }
    public function updatedPersonaFilter()
    {
        $this->resetPage();
    }
    public function updatedDateFilter()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedRows = User::pluck('id')->map(fn($id) => (string) $id)->toArray();
        } else {
            $this->selectedRows = [];
        }
    }

    public function resetFilters()
    {
        $this->reset(['search', 'roleFilter', 'personaFilter', 'dateFilter']);
        $this->resetPage();
    }

    public function openCreate()
    {
        $this->resetForm();
        $this->isEditing = false;
        $this->showUserSidebar = true;
    }

    public function editUser($id)
    {
        $this->resetForm();
        $user = User::findOrFail($id);
        $this->userId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->role;
        $this->style_persona = $user->style_persona ?? '';
        $this->selectedUser = $user;
        $this->isEditing = true;
        $this->showUserSidebar = true;
    }

    public function viewDetails($id)
    {
        $this->selectedUser = User::findOrFail($id);
        $this->showUserSidebar = true;
        $this->isEditing = false;
    }

    public function resetForm()
    {
        $this->reset(['userId', 'name', 'email', 'password', 'role', 'style_persona', 'selectedUser']);
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|min:3',
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($this->userId)],
            'password' => $this->userId ? 'nullable|min:8' : 'required|min:8',
            'role' => 'required|in:user,admin',
            'style_persona' => 'nullable|string',
        ]);

        if ($this->userId) {
            $user = User::findOrFail($this->userId);
            $data = [
                'name' => $this->name,
                'email' => $this->email,
                'role' => $this->role,
                'style_persona' => $this->style_persona,
            ];
            if ($this->password) {
                $data['password'] = Hash::make($this->password);
            }
            $user->update($data);
            $message = 'Client profile updated.';
        } else {
            User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
                'role' => $this->role,
                'style_persona' => $this->style_persona,
            ]);
            $message = 'New luxury profile created.';
        }

        $this->showUserSidebar = false;
        $this->dispatch('swal:success', ['title' => 'Success', 'text' => $message, 'icon' => 'success']);
    }

    public function deleteUser($id)
    {
        if ($id == auth()->id()) {
            $this->dispatch('swal:error', ['title' => 'Protected', 'text' => 'You cannot delete yourself.', 'icon' => 'error']);
            return;
        }

        User::findOrFail($id)->delete();
        $this->dispatch('swal:success', ['title' => 'Removed', 'text' => 'User profile has been removed.', 'icon' => 'success']);
    }

    public function bulkDelete()
    {
        $ids = array_filter($this->selectedRows, fn($id) => $id != auth()->id());
        User::whereIn('id', $ids)->delete();
        $this->selectedRows = [];
        $this->selectAll = false;
        $this->dispatch('swal:success', ['title' => 'Bulk Action', 'text' => count($ids) . ' profiles removed.', 'icon' => 'success']);
    }

    public function bulkUpdateRole($role)
    {
        $ids = array_filter($this->selectedRows, fn($id) => $id != auth()->id());
        User::whereIn('id', $ids)->update(['role' => $role]);
        $this->selectedRows = [];
        $this->selectAll = false;
        $this->dispatch('swal:success', ['title' => 'Bulk Action', 'text' => count($ids) . ' roles updated to ' . $role, 'icon' => 'success']);
    }

    public function render()
    {
        $query = User::query();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->roleFilter) {
            $query->where('role', $this->roleFilter);
        }

        if ($this->personaFilter) {
            $query->where('style_persona', $this->personaFilter);
        }

        if ($this->dateFilter !== 'all') {
            $query->where('created_at', '>=', match ($this->dateFilter) {
                'today' => Carbon::today(),
                'week' => Carbon::now()->subDays(7),
                'month' => Carbon::now()->subMonth(),
                'year' => Carbon::now()->subYear(),
            });
        }

        $users = $query->orderBy($this->sortField, $this->sortDirection)->paginate(10);

        $stats = [
            'total' => User::count(),
            'admins' => User::where('role', 'admin')->count(),
            'clients' => User::where('role', 'user')->count(),
            'personas' => User::whereNotNull('style_persona')->distinct('style_persona')->count(),
        ];

        return view('livewire.admin.user-manager', [
            'users' => $users,
            'stats' => $stats,
            'personas' => $this->styles
        ]);
    }
}
