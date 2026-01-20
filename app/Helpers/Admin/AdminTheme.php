<?php

namespace App\Helpers\Admin;

class AdminTheme
{
    public static function Spinner($data = []):string
    {
        return view('_particles.admin.components.spinner',compact('data'))->render();
    }
}
