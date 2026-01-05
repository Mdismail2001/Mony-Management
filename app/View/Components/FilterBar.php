<?php

namespace App\View\Components;

use Illuminate\View\Component;

class FilterBar extends Component
{
    public $title;
    public $searchField;
    public $searchPlaceholder;
    public $filters; // array of filter dropdowns
    public $actions; // array of buttons/actions

    public function __construct($title = '', $searchField = '', $searchPlaceholder = '', $filters = [], $actions = [])
    {
        $this->title = $title;
        $this->searchField = $searchField;
        $this->searchPlaceholder = $searchPlaceholder;
        $this->filters = $filters; // Example: ['year' => [2020,2021], 'month' => ['Jan','Feb']]
        $this->actions = $actions; // Example: [['label'=>'Download', 'route'=>'download.route']]
    }

    public function render()
    {
        return view('components.filter-bar');
    }
}
