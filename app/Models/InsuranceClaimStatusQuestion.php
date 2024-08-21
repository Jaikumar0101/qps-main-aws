<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InsuranceClaimStatusQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'status_id',
        'title',
        'description',
        'position',
        'status',
    ];

    /**
     * Get the status that owns the question.
     */
    public function insuranceStatus():BelongsTo
    {
        return $this->belongsTo(InsuranceClaimStatus::class);
    }
}
