<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class DashboardController extends Controller
{
    public function DashboardPage()
    {
        return view('admin.pages.dashboard');
    }

    public function BoostUp(Artisan $artisan)
    {
        $artisan::call('route:clear');
        $artisan::call('view:clear');
        $artisan::call('config:clear');
        $artisan::call('cache:clear');

        return redirect()->back()->with('message',trans('System is boosted up'));
    }
}
