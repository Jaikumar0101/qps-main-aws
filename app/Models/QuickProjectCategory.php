<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class QuickProjectCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_id',
        'name',
        'description',
        'position',
        'status',
    ];

    /**
     * Get the parent category.
     */
    public function parent(): HasOne
    {
        return $this->hasOne(QuickProjectCategory::class, 'id','parent_id');
    }

    /**
     * Get the child categories.
     */
    public function children(): HasMany
    {
        return $this->hasMany(QuickProjectCategory::class, 'parent_id','id');
    }

    public function projects(): HasMany
    {
        return $this->hasMany(QuickProject::class, 'category_id','id');
    }

}
