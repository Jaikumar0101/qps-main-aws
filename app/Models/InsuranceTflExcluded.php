<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InsuranceTflExcluded extends Model
{
    use HasFactory;

    protected $table = "insurance_tfl_excluded";

    protected $fillable = [
        'name',
        'position',
        'status'
    ];
}
