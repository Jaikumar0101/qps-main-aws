<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InsuranceClaimAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'claim_id',
        'question_id',
        'question',
        'answer',
    ];

    /**
     * Get the insurance claim that owns the answer.
     */
    public function insuranceClaim():BelongsTo
    {
        return $this->belongsTo(InsuranceClaim::class, 'claim_id');
    }

    public function question():BelongsTo
    {
        return $this->belongsTo(InsuranceClaimStatusQuestion::class,'question_id');
    }

}
