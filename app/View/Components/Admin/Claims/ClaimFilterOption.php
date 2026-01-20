<?php

namespace App\View\Components\Admin\Claims;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ClaimFilterOption extends Component
{
    public array $filters = [];

    /**
     * Create a new component instance.
     */
    public function __construct($filters)
    {
        $this->filters = $filters;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin.claims.claim-filter-option');
    }
}
