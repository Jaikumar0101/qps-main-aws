<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Larinfo;

class ServerController extends Controller
{
    public function InfoPage()
    {
        $data = Larinfo::getInfo();
        return view('admin.pages.system.server-info',compact('data'));
    }
}
