<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InsuranceEobDl extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'position',
        'status'
    ];

    public static function getName($id = null, $default = null)
    {
        return self::find($id)?->name ??$default;
    }
}
