<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class City extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'state_id',
        'status'
    ];

    public function state():HasOne
    {
        return $this->hasOne(State::class,'id','state_id');
    }

    public function country():HasOneThrough
    {
        return $this->hasOneThrough(Country::class,State::class,'id','id','state_id','country_id');
    }

    public function countyName():string
    {
        return $this->state->country->nicename ??'';
    }
}
