<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class BlogPostAttribute extends Model
{
    use HasFactory;

    protected $fillable = [
        'model',
        'model_id',
        'post_id',
    ];

    public function post(): BelongsTo
    {
        return $this->belongsTo(BlogPost::class,'id','post_id');
    }

    public function model(): BelongsTo
    {
        return $this->belongsTo($this->model,'id','model_id');
    }


}
