@if ($paginator->hasPages())
    <div class="pagination-wrapper">
        <nav>
            @if ($paginator->onFirstPage())
                <span class="disabled">« Previous</span>
            @else
                <a href="{{ $paginator->appends($queryParams)->previousPageUrl() }}">« Previous</a>
            @endif

            @php
                $currentPage = $paginator->currentPage();
                $lastPage = $paginator->lastPage();
                $onEachSide = 2;

                $start = max($currentPage - $onEachSide, 1);
                $end = min($currentPage + $onEachSide, $lastPage);

                if ($currentPage <= $onEachSide + 1) {
                    $end = min($onEachSide * 2 + 1, $lastPage);
                }
                if ($currentPage >= $lastPage - $onEachSide) {
                    $start = max($lastPage - ($onEachSide * 2), 1);
                }
            @endphp

            @if ($start > 1)
                <a href="{{ $paginator->appends($queryParams)->url(1) }}">1</a>
                @if ($start > 2)
                    <span class="disabled">...</span>
                @endif
            @endif

            @foreach(range($start, $end) as $page)
                @if ($page == $currentPage)
                    <span class="active">{{ $page }}</span>
                @else
                    <a href="{{ $paginator->appends($queryParams)->url($page) }}">{{ $page }}</a>
                @endif
            @endforeach

            @if ($end < $lastPage)
                @if ($end < $lastPage - 1)
                    <span class="disabled">...</span>
                @endif
                <a href="{{ $paginator->appends($queryParams)->url($lastPage) }}">{{ $lastPage }}</a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->appends($queryParams)->nextPageUrl() }}">Next »</a>
            @else
                <span class="disabled">Next »</span>
            @endif
        </nav>
    </div>
@endif
