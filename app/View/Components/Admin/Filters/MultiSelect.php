<?php

namespace App\View\Components\Admin\Filters;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class MultiSelect extends Component
{
    public array $options;


    /**
     * Create a new component instance.
     */
    public function __construct($options = [])
    {
        $this->options = $options;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin.filters.multi-select');
    }
}
