<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class Pagination extends Component
{
    public ?LengthAwarePaginator $paginator;

    public function __construct(?LengthAwarePaginator $paginator = null)
    {
        $this->paginator = $paginator;
    }

    public function render()
    {
        return view('components.pagination');
    }
}
