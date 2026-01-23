<?php

namespace App\View\Components;

use Illuminate\View\Component;

use Carbon\Carbon;


class FilterBar extends Component
{
    public $title;
    public $searchField;
    public $searchPlaceholder;
    public $filters;
    public $actions;

    public function __construct(
        $title = '',
        $searchField = '',
        $searchPlaceholder = '',
        $filters = [],
        $actions = []
    ) {
        $this->title = $title;
        $this->searchField = $searchField;
        $this->searchPlaceholder = $searchPlaceholder;
        $this->filters = $filters;
        $this->actions = $actions;
    }

    public function render()
    {
        return view('components.filter-bar');
    }
}

