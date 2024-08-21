<?php

namespace App\Helpers\Admin;

class Breadcrumb
{

    public static function Load($data = [],$actions = []): string
    {
        return view('_particles.admin.components.breadcrumb',compact('data','actions'))->render();
    }

}
