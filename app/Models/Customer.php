<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'dob',
        'dos',
        'address',
        'tax_id',
        'npi_number',
        'practice_management_software',
        'status',
    ];

    protected static function boot():void {
        parent::boot();

        static::deleting(static function($check) {
            $check->leads()->forceDelete();
        });
    }

    public static function getInOrder($items = [],$check = false)
    {
        $order = isset($items) && count($items)>0?implode(',',$items):"0";
        return $check?self::whereIn('id',$items)->where('status',1)->orderByRaw("FIELD(id,$order)")->get():
            self::whereIn('id',$items)->orderByRaw("FIELD(id,$order)")->get();
    }

    public function assigns():HasMany
    {
        return $this->hasMany(ClientAssign::class,'customer_id','id');
    }

    public function leads():HasMany
    {
        return $this->hasMany(InsuranceClaim::class,'customer_id','id');
    }

    public function imports():HasMany
    {
        return $this->hasMany(ImportClaim::class,'client_id','id');
    }


    public function fullName($check = false): string
    {
        if ($check){
            return  $this->first_name .' - '.($this->last_name ??'');
        }
        return $this->first_name;
    }

    public function imageUrl():string
    {
        return asset('assets/images/default/client.png');
    }

    public function countLeads($label = false):int|string
    {
        $content = $this->leads()->count();

        if ($label)
        {
            return $content <= 1?($content." Lead"):($content." Leads");
        }

        return $content;
    }

    public function getLastMergeDate($format = "d/m/Y"): ?string
    {
        try
        {
            $lastRecord = $this->imports()->where('status',1)->latest()->first();
            if ($lastRecord)
            {
               return Carbon::parse($lastRecord->created_at)->format($format);
//               $history =  $lastRecord->history()->latest()->first();
//               if ($history)
//               {
//                   return Carbon::parse($history->created_at)->format($format);
//               }
            }
            return null;
        }
        catch (\Exception $exception)
        {
            return null;
        }
    }

}
