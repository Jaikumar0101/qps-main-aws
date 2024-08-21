<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class State extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'country_id',
        'status'
    ];

    protected static function boot():void {
        parent::boot();

        static::deleting(static function($check) {
            $check->cities()->each(function ($city){
                $city->delete();
            });
        });
    }

    public function cities():HasMany
    {
        return $this->hasMany(City::class,'state_id','id');
    }

    public function country():HasOne
    {
        return $this->hasOne(Country::class,'id','country_id');
    }
}
