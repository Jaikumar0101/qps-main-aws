<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InsuranceClaimStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'note',
        'position',
        'status',
    ];

    public function questions():HasMany
    {
        return $this->hasMany(InsuranceClaimStatusQuestion::class,'status_id','id');
    }

    public function tlfExcluded(): HasMany
    {
        return $this->hasMany(InsuranceTflExcluded::class,'name','name');
    }

}
