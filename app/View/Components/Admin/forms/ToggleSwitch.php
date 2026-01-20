<?php

namespace App\View\Components\Admin\forms;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ToggleSwitch extends Component
{
    public bool $checked;

    public mixed $label;

    public function __construct($checked  = false, $label = "")
    {
        $this->checked = $checked;
        $this->label = $label;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin.forms.toggle-switch');
    }
}
