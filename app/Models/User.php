<?php

namespace App\Models;

use App\Helpers\Admin\BackendHelper;
use App\Helpers\Role\RoleHelper;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    const roles = [
        'admin'=>'Admin',
        'sub_admin'=>'Manager',
        'manager'=>'Staff',
        'user'=>'User'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'role_id',
        'user_type',
        'roles',
        'salutation',
        'name',
        'last_name',
        'email',
        'phone',
        'country',
        'state',
        'city',
        'address',
        'avatar',
        'password',
        'registration_ip',
        'ip_check',
        'ip_allowed',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function getInOrder($items = [],$check = false)
    {
        $order = isset($items) && count($items)>0?implode(',',$items):"0";
        return $check?self::whereIn('id',$items)->where('status',1)->orderByRaw("FIELD(id,$order)")->get():
            self::whereIn('id',$items)->orderByRaw("FIELD(id,$order)")->get();
    }

    public function getCountry(): HasOne
    {
        return $this->hasOne(Country::class,'id','country');
    }
    public function getState(): HasOne
    {
        return $this->hasOne(State::class,'id','state');
    }
    public function getCity(): HasOne
    {
        return $this->hasOne(City::class,'id','city');
    }

    public function role():HasOne
    {
        return $this->hasOne(UserRole::class,'id','role_id');
    }

    public function isOnline():bool { return Cache::has('user-is-online-'.$this->id); }
    public function isUser():bool { return $this->user_type ==="user"; }
    public function isAdmin():bool { return $this->user_type !=="user"; }
    public function isSubAdmin():bool { return $this->user_type ==="sub_admin"; }
    public function isMasterAdmin():bool{ return $this->user_type ==="admin"; }

    public function isStaff():bool{ return $this->user_type === "manager"; }

    public function getAddressLine(): ?string
    {
        $addressLine  = $this->getCountry()->exists()?$this->getCountry->nicename.",":"";
        $addressLine .= $this->getState()->exists()?$this->getState->name.",":"";
        $addressLine .= $this->getCity()->exists()?$this->getCity->name:"";
        return $addressLine!==""?$addressLine:null;
    }

    public function fullName($salutation = false):string
    {
        return ($salutation?$this->salutation." ":'').$this->name." ".$this->last_name;
    }

    public function userType():string
    {
       return self::roles[$this->user_type];
    }

    public function avatarUrl():string
    {
        return isset($this->avatar) && $this->avatar!==""?asset($this->avatar):asset('assets/images/default/user.png');
    }

    public function displayAddress():string
    {
        try{
            $address = "";
            if ($this->getCity()->exists())
            {
                $address.=$this->getCity->name.", ";
            }
            if ($this->getState()->exists())
            {
                $address.=$this->getState->name.", ";
            }
            if ($this->getCountry()->exists())
            {
                $address.=$this->getCountry->nicename."";
            }
            return $address;
        }
        catch (\Exception $exception)
        {
            return "";
        }
    }

    public function roleName():?string
    {
        return $this->role?->name ??null;
    }

    public function canAccess($role = ""):bool
    {
        $roleName = $this->roleName();

        if ($this->isMasterAdmin() ||  $roleName == "Super Admin")
        {
            return true;
        }

        if ($roleName == "Manager" && $role != 'settings')
        {
            return true;
        }

        if ($this->role()->exists())
        {
            return $this->role->hasRole($role);
        }

        return false;
    }

}
