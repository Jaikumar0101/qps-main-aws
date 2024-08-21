<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Subscriber extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'newsletter',
        'status',
    ];

    public function user(): HasOne
    {
        return $this->hasOne(User::class,'email','email');
    }
}
