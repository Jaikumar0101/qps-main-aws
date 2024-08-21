<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advertisement extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'name',
        'type',
        'image',
        'embed_code',
        'url',
        'open_new_tab',
        'position',
        'status',
        'location',
        'expire_at',
    ];


}
