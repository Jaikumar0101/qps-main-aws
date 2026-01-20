<?php

namespace App\View\Components\Admin\Filters;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class MultiOptionSelect extends Component
{
    public array $options = [];
    public string $optionLabel;
    public string $optionValue;

    /**
     * Create a new component instance.
     */
    public function __construct($options = [], $optionValue = "key", $optionLabel = "label")
    {
        $this->options = $options;
        $this->optionValue = $optionValue;
        $this->optionLabel = $optionLabel;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin.filters.multi-option-select');
    }
}
