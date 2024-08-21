<?php

namespace App\View\Components\Admin\Claims;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FilterRangeInput extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin.claims.filter-range-input');
    }
}
