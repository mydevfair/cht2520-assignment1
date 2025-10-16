<th>
    <a href="{{ route('patients.index', [
        'search' => $search,
        'sort_by' => $column,
        'sort_order' => ($currentSortBy == $column && $currentSortOrder == 'asc') ? 'desc' : 'asc'
    ]) }}" class="sortable" title="Click to sort by {{ $label }}">
        {{ $label }}
        @if($currentSortBy == $column)
            <span class="sort-arrow">{{ $currentSortOrder == 'asc' ? '↑' : '↓' }}</span>
        @endif
    </a>
</th>
