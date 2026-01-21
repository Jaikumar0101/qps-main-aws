<?php

namespace App\View\Components\Forms;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class MultiChoiceDropdown extends Component
{
    public $options = [];

    public $optionLabel = 'name';
    public $optionValue = 'id';

    /**
     * Create a new component instance.
     */
    public function __construct(
        $options = [],
        $optionLabel = 'name',
        $optionValue = 'id'
    )
    {
        $this->options = $options;
        $this->optionLabel = $optionLabel;
        $this->optionValue = $optionValue;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.forms.multi-choice-dropdown');
    }
}
