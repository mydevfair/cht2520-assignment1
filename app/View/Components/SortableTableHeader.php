<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SortableTableHeader extends Component
{
    public $column;
    public $label;
    public $currentSortBy;
    public $currentSortOrder;
    public $search;

    public function __construct($column, $label, $currentSortBy = 'id', $currentSortOrder = 'asc', $search = null)
    {
        $this->column = $column;
        $this->label = $label;
        $this->currentSortBy = $currentSortBy;
        $this->currentSortOrder = $currentSortOrder;
        $this->search = $search;
    }

    public function render()
    {
        return view('components.sortable-table-header');
    }
}
