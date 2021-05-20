@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="pager num-pager">
        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span aria-disabled="true">
            <span>{{ $element }}</span>
        </span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="page-btn" aria-current="page">
                    <span>{{ $page }}</span>
                </span>
                    @else
                        <a href="{{ $url }}" class="page-btn" aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach
            @endif
        @endforeach

        <p>
            {!! __('Showing') !!}
            <span >{{ $paginator->firstItem() }}</span>
            {!! __('to') !!}
            <span>{{ $paginator->lastItem() }}</span>
            {!! __('of') !!}
            <span >{{ $paginator->total() }}</span>
            {!! __('results') !!}
        </p>
    </nav>
@endif
