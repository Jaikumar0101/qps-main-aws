<?php

namespace App\Helpers\Traits\Base;

use App\Models\User;

trait WithAdminAuthUser
{
    public ?User $adminUser = null;

    public function initAdminAuthentication()
    {
        $this->adminUser = User::find(auth()->user()->id);
    }
}
