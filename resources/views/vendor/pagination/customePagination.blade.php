@if ($paginator->hasPages())
    <div class="pagination-area text-center">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <a href="javascript:void(0)" aria-disabled="true" aria-label="@lang('pagination.previous')">
                <i class="fas fa-angle-double-left"></i><span>Prev</span>
            </a>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">
                <i class="fas fa-angle-double-left"></i><span>Prev</span>
            </a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <a href="javascript:void(0)" class="disabled" aria-disabled="true">{{ $element }}</a>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <a href="javascript:void(0)" class="active">{{ $page }}</a>
                    @else
                        <a href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">
                <span>Next</span><i class="fas fa-angle-double-right"></i>
            </a>
        @else
            <a href="javascript:void(0)" aria-disabled="true" aria-label="@lang('pagination.next')">
                <span>Next</span><i class="fas fa-angle-double-right"></i>
            </a>
        @endif
    </div>
@endif
