<?php

namespace App\Livewire\Frontend\Pages;

use Livewire\Component;

class HomePage extends Component
{
    public function mount()
    {
        $this->redirect(route('admin::login'));
    }

    public function render()
    {
        return view('livewire.frontend.pages.home-page');
    }
}
