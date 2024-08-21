<?php

namespace App\Livewire\Admin\Analytics;

use Livewire\Component;

class MainAnalyticsPage extends Component
{
    public $currentTab = "claim_status";

    public function render()
    {
        return view('livewire.admin.analytics.main-analytics-page');
    }
}
