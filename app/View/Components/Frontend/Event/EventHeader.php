<?php

namespace App\View\Components\Frontend\Event;

use App\Models\Event;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class EventHeader extends Component
{
    public Event $event;

    public string $slug;

    public function __construct($slug,$event)
    {
        $this->slug = $slug;
        $this->event = $event;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.frontend.event.event-header');
    }
}
