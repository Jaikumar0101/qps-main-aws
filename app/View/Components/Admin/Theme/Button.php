<?php

namespace App\View\Components\Admin\Theme;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Arr;
use Illuminate\View\Component;

class Button extends Component
{
    public array $buttonColors = [
        'dark'=>'btn btn-dark',
        'light'=>'btn btn-light ',
        'primary'=>'btn btn-primary ',
        'secondary'=>'btn btn-secondary ',
        'warning'=>'btn btn-warning ',
        'danger'=>'btn btn-danger ',
        'info'=>'btn btn-info ',
        'success'=>'btn btn-success '
    ];

    public ?string $class;
    public ?string $label;
    public ?string $icon;

    public ?string $spinner;

    public ?string $link;

    public bool $sm = false;

    public function __construct(
        $color = "light",
        $label = "",
        $spinner = null,
        $icon = null,
        $link = null,
    )
    {
        $this->label = $label;
        $this->spinner = $spinner;
        $this->icon = $icon;
        $this->link = $link;

        if (Arr::has($this->buttonColors,$color))
        {
            $this->class = $this->buttonColors[$color];
        }
        else
        {
            $this->class = $this->buttonColors['light'];
        }

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin.theme.button');
    }
}
