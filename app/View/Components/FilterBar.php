<?php

namespace App\View\Components;

use Illuminate\View\Component;

use Carbon\Carbon;

// class FilterBar extends Component
// {
//     public $title;
//     public $searchField;
//     public $searchPlaceholder;
//     public $filters;
//     public $actions;

//     public function __construct(
//         $title = '',
//         $searchField = '',
//         $searchPlaceholder = '',
//         $filters = [],
//         $actions = []
//     ) {
//         $this->title = $title;
//         $this->searchField = $searchField;
//         $this->searchPlaceholder = $searchPlaceholder;
//         $this->actions = $actions;

//         $now = Carbon::now();

//         // ✅ Inject default values ONLY on first load
//         foreach (['year', 'month'] as $key) {
//             if (!request()->exists($key)) {
//                 request()->merge([
//                     // 'year'  => $now->year,
//                     // 'month' => $now->format('F'),
//                     'year'  => $now->year,
//                     'month' => $now->format('F'),

//                 ]);
//             }
//         }

//         $this->filters = $filters;
//     }

//     public function render()
//     {
//         return view('components.filter-bar');
//     }
// }

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

