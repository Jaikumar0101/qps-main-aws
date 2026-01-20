<?php

namespace App\Livewire\Admin\Tasks;

use App\Models\QuickProjectCategory;
use Livewire\Attributes\On;
use Livewire\Component;

class TasksMainPage extends Component
{
    public $pageTitle = "Projects List";
    public $selectedProject;
    #[On('Quick::main:render')]
    public function render()
    {
        return view('livewire.admin.tasks.tasks-main-page');
    }

}
