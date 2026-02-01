@if ($paginator->hasPages())
    <div class="d-flex justify-content-center align-items-center w-100 py-3">
        <!-- Pagination Links -->
        <div>
            <ul class="pagination mb-0 d-flex gap-2 align-items-center p-0" style="list-style: none;">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <li class="page-item disabled">
                        <span
                            class="page-link rounded-circle border-0 d-flex align-items-center justify-content-center bg-light text-muted"
                            style="width: 38px; height: 38px; cursor: not-allowed; opacity: 0.5;">
                            <i class="fa-solid fa-chevron-left" style="font-size: 0.75rem;"></i>
                        </span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link rounded-circle border-0 d-flex align-items-center justify-content-center bg-white shadow-sm hover-lift text-dark"
                            href="{{ $paginator->previousPageUrl() }}" rel="prev" wire:navigate
                            style="width: 38px; height: 38px; transition: all 0.3s ease;">
                            <i class="fa-solid fa-chevron-left" style="font-size: 0.75rem;"></i>
                        </a>
                    </li>
                @endif

                {{-- Pagination Elements --}}
                <div class="d-flex bg-white rounded-pill px-2 py-1 shadow-sm border align-items-center">
                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <li class="page-item disabled">
                                <span
                                    class="page-link border-0 fw-bold text-muted bg-transparent d-flex align-items-center justify-content-center"
                                    style="width: 34px; height: 34px; font-size: 0.85rem;">{{ $element }}</span>
                            </li>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <li class="page-item active">
                                        <span
                                            class="page-link rounded-circle border-0 fw-bold d-flex align-items-center justify-content-center bg-dark text-white shadow-sm"
                                            style="width: 34px; height: 34px; font-size: 0.85rem;">{{ $page }}</span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link rounded-circle border-0 fw-bold d-flex align-items-center justify-content-center text-muted bg-transparent hover-bg-light"
                                            href="{{ $url }}" wire:navigate
                                            style="width: 34px; height: 34px; font-size: 0.85rem; transition: all 0.2s ease;">{{ $page }}</a>
                                    </li>
                                @endif
                            @endforeach
                        @endif
                    @endforeach
                </div>

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <li class="page-item">
                        <a class="page-link rounded-circle border-0 d-flex align-items-center justify-content-center bg-white shadow-sm hover-lift text-dark"
                            href="{{ $paginator->nextPageUrl() }}" rel="next" wire:navigate
                            style="width: 38px; height: 38px; transition: all 0.3s ease;">
                            <i class="fa-solid fa-chevron-right" style="font-size: 0.75rem;"></i>
                        </a>
                    </li>
                @else
                    <li class="page-item disabled">
                        <span
                            class="page-link rounded-circle border-0 d-flex align-items-center justify-content-center bg-light text-muted"
                            style="width: 38px; height: 38px; cursor: not-allowed; opacity: 0.5;">
                            <i class="fa-solid fa-chevron-right" style="font-size: 0.75rem;"></i>
                        </span>
                    </li>
                @endif
            </ul>
        </div>
    </div>

    <style>
        .hover-lift:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12) !important;
            background-color: #F6A6B2 !important;
            color: white !important;
        }

        .hover-bg-light:hover {
            background-color: rgba(0, 0, 0, 0.04) !important;
            color: #1E1E1E !important;
        }

        .pagination .page-link:focus {
            box-shadow: none;
            outline: none;
        }

        .pagination .page-link {
            text-decoration: none;
        }
    </style>
@endif