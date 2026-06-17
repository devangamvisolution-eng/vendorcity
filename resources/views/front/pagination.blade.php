@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between custom-new-pagination">
        {{-- Left side: Page X of Y --}}
        <div class="pagination-info">
            Page {{ $paginator->currentPage() }} of {{ $paginator->lastPage() }}
        </div>

        {{-- Right side: Numbers and Next --}}
        <div class="pagination-links">
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <span class="pagination-ellipsis">{{ $element }}</span>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="pagination-active">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="pagination-link">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="pagination-next">NEXT</a>
            @else
                <span class="pagination-next disabled">NEXT</span>
            @endif
        </div>
    </nav>
@endif
