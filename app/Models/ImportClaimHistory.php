<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ImportClaimHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_id',
        'total',
        'imported',
        'errors',
        'status',
    ];


    public function parent():BelongsTo
    {
        return $this->belongsTo(ImportClaim::class, 'parent_id');
    }

}
