<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MetaData extends Model
{
    use HasFactory;

    protected $fillable = [
        'model',
        'model_id',
        'title',
        'description',
        'os_image',
        'keywords',
        'author',
    ];
}
