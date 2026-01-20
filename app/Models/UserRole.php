<?php

namespace App\Models;

use App\Helpers\Admin\BackendHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'roles',
        'status',
    ];

    public function hasRole($roleName = ""):bool
    {
        $roles = BackendHelper::JsonDecode($this->roles);
        return in_array($roleName,$roles);
    }

}
