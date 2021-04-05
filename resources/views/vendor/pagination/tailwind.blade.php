@if ($paginator->hasPages())
    <ul class="pagination pagination-rounded justify-content-end my-2">

        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <a class="page-link" href="javascript: void(0);" aria-label="Previous">
                <span aria-hidden="true">«</span>
                <span class="sr-only">{!! __('pagination.previous') !!}</span>
            </a>
        @else
            <a class="page-link" href="{{ $paginator->previousPageUrl() }}" aria-label="Previous">
                <span aria-hidden="true">«</span>
                <span class="sr-only">{!! __('pagination.previous') !!}</span>
            </a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="page-item"><a class="page-link" href="javascript: void(0);"> {{ $element }}
                    </a></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="page-item active"><a  aria-current="page" class="page-link" href="javascript: void(0);">{{ $page }}</a></li>
                    @else
                        <li class="page-item"><a class="page-link" href="{{ $url }}" aria-label="{{ __('Go to page :page', ['page' => $page]) }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())

            <li class="page-item">
                <a class="page-link" href="{{ $paginator->nextPageUrl() }}" aria-label="Next">
                    <span aria-hidden="true">»</span>
                    <span class="sr-only">Next</span>
                </a>
            </li>

        @else
            <li class="page-item">
                <a class="page-link" href="javascript: void(0);" aria-label="Next">
                    <span aria-hidden="true">»</span>
                    <span class="sr-only">Next</span>
                </a>
            </li>
        @endif
    </ul>
@endif
