<?php

namespace App\Livewire\Admin\Modal;

use Livewire\Component;

class VideoPlayModal extends Component
{
    public $showModal = false;
    public $videoUrl = "";

    protected $listeners = [
        'open::modal:video'=>'OpenVideoModal',
    ];

    public function mount(): void
    {
        $this->videoUrl = asset('assets/images/default/sample.mp4');
    }

    public function render()
    {
        return view('livewire.admin.modal.video-play-modal');
    }

    public function OpenVideoModal($video = ""): void
    {
        $this->videoUrl = $video;
        $this->dispatch('showVideoModal');
    }

}
