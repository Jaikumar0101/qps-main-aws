<?php

namespace App\View\Components\Admin\Claims;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FilterTagInput extends Component
{
    /**
     * Create a new component instance.
     */

    public array $suggestions = [];

    public function __construct($suggestions = [])
    {
        $this->suggestions = $suggestions;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin.claims.filter-tag-input');
    }
}
