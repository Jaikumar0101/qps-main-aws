<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuickTaskLabel extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'name',
    ];

    public function project():BelongsTo
    {
        return $this->belongsTo(QuickProject::class);
    }
}
