<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SlugManager extends Model
{
    use HasFactory;

    protected $fillable = [
        'prefix',
        'model',
        'model_id',
        'name',
        'slug'
    ];
}
