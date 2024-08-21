<?php

namespace App\Helpers\Admin;

use Illuminate\Support\Facades\Session;

class AdminHelper
{
    public static function rememberListPageFilter($selectedClients = []):void
    {
        Session::put('claim.filter.selected_client',$selectedClients);
    }

    public static function retrieveListPageFilter()
    {
        $selectedClient = Session::has('claim.filter.selected_client');

        if (checkData($selectedClient))
        {
            return Session::get('claim.filter.selected_client');
        }

        return [];

    }
}
