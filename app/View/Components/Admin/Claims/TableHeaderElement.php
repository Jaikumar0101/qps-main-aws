<?php

namespace App\View\Components\Admin\Claims;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TableHeaderElement extends Component
{
    /**
     * Create a new component instance.
     */

    public $class = "";

    public $element = "";

    public $label = "";

    public string $currentOrder, $currentSort;

    public function __construct
    (
        $class = "",$element = "",$label = "",$currentOrder = "desc",$currentSort = ""
    )
    {
        $this->class = $class;
        $this->element = $element;
        $this->label = $label;
        $this->currentOrder = $currentOrder;
        $this->currentSort = $currentSort;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin.claims.table-header-element');
    }
}
