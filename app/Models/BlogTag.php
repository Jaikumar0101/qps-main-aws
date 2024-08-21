<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BlogTag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'status',
    ];

    public static function findByName($name = ""): ?self
    {
        return self::where('name',$name)->first();
    }

}
