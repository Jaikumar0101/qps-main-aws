<?php

namespace App\Helpers\Role;

use App\Models\Customer;
use App\Models\InsuranceClaim;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Support\Facades\DB;

class RoleHelper
{

    public static function getRoles():array
    {
        return [
            'client::list'=>[
                'name'=>'Client List',
                'description'=>'Can access client list',
            ],
            'client::add'=>[
                'name'=>'Client add',
                'description'=>'Can access for creating new client',
            ],
            'client::update'=>[
                'name'=>'Client Update',
                'description'=>'Can update client',
            ],
            'client::delete'=>[
                'name'=>'Client Delete',
                'description'=>'Can delete client',
            ],
            'client::view'=>[
                'name'=>'Client View',
                'description'=>'Can access for viewing new client',
            ],
            'client::assign'=>[
                'name'=>'Client Assign',
                'description'=>'Can Assign clients',
            ],
            'client::export'=>[
                'name'=>'Client Export',
                'description'=>'Can export clients in excel',
            ],
            'client::access'=>[
                'name'=>'Access all Clients',
                'description'=>'Can access all clients',
            ],
            'claim::access'=>[
                'name'=>'Access all Claims',
                'description'=>'Can access all leads',
            ],
            'claim::list'=>[
                'name'=>'Claims List',
                'description'=>'Can access leads list',
            ],
            'claim::add'=>[
                'name'=>'Claims add',
                'description'=>'Can access for creating new lead',
            ],
            'claim::update'=>[
                'name'=>'Claims update',
                'description'=>'Can access for updating lead',
            ],
            'claim::grouping'=>[
                'name'=>'Claims Grouping',
                'description'=>'Can update claim grouping',
            ],
            'claim::export'=>[
                'name'=>'Claims Export',
                'description'=>'Can export claims in excel',
            ],
            'claim::import'=>[
                'name'=>'Claims Import',
                'description'=>'Can import claims',
            ],
            'claim::assign'=>[
                'name'=>'Claims Assign',
                'description'=>'Can Assign claims',
            ],
            'claim::archived'=>[
                'name'=>'Claims Archive',
                'description'=>'Can Archive claims',
            ],
            'claim::restore'=>[
                'name'=>'Claims Restore',
                'description'=>'Can Restore claims',
            ],
            'claim::delete'=>[
                'name'=>'Claims Delete',
                'description'=>'Can delete lead',
            ],
            'charts::access'=>[
                'name'=>'Charts Access',
                'description'=>'Can access charts',
            ],
            'support::mail'=>[
                'name'=>'Contact Mail',
                'description'=>'Can access support mails',
            ],
            'settings'=>[
                'name'=>'Settings',
                'description'=>'Can access website settings',
            ],

            'tasks::access'=>[
                'name'=>'Project & Tasks',
                'description'=>'Can access task & projects'
            ],
            'tasks::dashboard'=>[
                'name'=>'Project Dashboard Tab',
                'description'=>'Can access task & projects'
            ],
            'tasks::settings'=>[
                'name'=>'Project Settings Tab',
                'description'=>'Can access task & projects'
            ],
            'tasks::people'=>[
                'name'=>'Project People Tab',
                'description'=>'Can access task & projects'
            ],
            'tasks::message'=>[
                'name'=>'Project Message Tab',
                'description'=>'Can access task & projects'
            ],
            'tasks::list'=>[
                'name'=>'Project Task List Tab',
                'description'=>'Can access task & projects'
            ],
        ];
    }

    public static function getRoleDescription($role_id = null): string
    {
        $role = UserRole::find($role_id);

        return $role?->description ??'';
    }


    public static function getClaims(User $user, $search = "",$query = false,$selectColumns = false)
    {
        $data = InsuranceClaim::query();

        if (checkData($selectColumns))
        {
            $data->select($selectColumns);
        }

        if (!$user->canAccess('claim::access'))
        {
            $data->whereHas('assigns',function ($q) use ($user){
                $q->where('user_id',$user->id);
            });
        }

        if (checkData($search))
        {
            $data->where(function ($q) use ($search) {
                $q->orWhere('id', 'like', $search)
                    ->orWhere('ins_name', 'like', "{$search}%")
                    ->orWhere('ins_email', 'like', "%{$search}%");
            });
        }

        if ($query)
        {
            return $data;
        }

        return $data->get();
    }


    public static function getUserCustomers(User $user, $search = "",$query = false,$selectColumns = false)
    {
        $data = Customer::query();

        if (checkData($selectColumns))
        {
            $data->select($selectColumns);
        }

        $data->where('status',1);

        if (!$user->canAccess('claim::access'))
        {
            $data->whereHas('assigns',function ($q) use ($user){
                $q->where('user_id',$user->id);
            });
        }

        if (checkData($search))
        {
            $data->where(function ($q) use ($search) {
                $q->orWhere('id', 'like', $search)
                    ->orWhere('first_name', 'like', "{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere(DB::raw("CONCAT(first_name, ' ', last_name)"), 'like', "%{$search}%");
            });
        }

        if ($query)
        {
            return $data;
        }

        $data->orderBy('first_name','asc');

        return $data->get();
    }

}
