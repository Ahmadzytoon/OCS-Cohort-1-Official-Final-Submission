@php
    $isActive = request('category') == $category->id;
    $hasActiveChild = $category->children->contains('id', request('category'));
    $isOpen = $isActive || $hasActiveChild;
@endphp
<li class="nav-item category-item {{ $isOpen ? 'expanded' : '' }}">
    <div class="d-flex align-items-center justify-content-between category-header">
        <a class="nav-link main-category-link {{ $isActive ? 'active' : '' }}"
            href="{{ request()->fullUrlWithQuery(['category' => $category->id, 'page' => null]) }}">
            {{ $category->name }}
        </a>
        @if($category->children->count() > 0)
            <button class="btn-toggle {{ $isOpen ? 'open' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#cat-{{ $category->id }}" aria-expanded="{{ $isOpen ? 'true' : 'false' }}">
                <i class="fas fa-chevron-down"></i>
            </button>
        @endif
    </div>
    
    @if($category->children->count() > 0)
        <div class="collapse {{ $isOpen ? 'show' : '' }}" id="cat-{{ $category->id }}">
            <ul class="nav flex-column ms-3 mt-1 sub-categories text-start">
                @foreach($category->children as $child)
                    <li class="nav-item">
                        <a class="nav-link sub-category-link {{ request('category') == $child->id ? 'active' : '' }}" 
                           href="{{ request()->fullUrlWithQuery(['category' => $child->id, 'page' => null]) }}">
                            <i class="fas fa-angle-right me-2"></i> {{ $child->name }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
</li>
