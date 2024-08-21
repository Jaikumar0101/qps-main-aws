<?php

namespace App\View\Components\Admin\Claims;

use App\Models\InsuranceClaim;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TeamRowTag extends Component
{
    public InsuranceClaim $claim;

    /**
     * Create a new component instance.
     */
    public function __construct($claim)
    {
        $this->claim = $claim;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin.claims.team-row-tag');
    }
}
