<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class QuickTaskCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'name',
        'description',
        'position',
        'status',
    ];

    public function tasks():HasMany
    {
        return $this->hasMany(QuickTask::class,'parent_id','id');
    }
}
