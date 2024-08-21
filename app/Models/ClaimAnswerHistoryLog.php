<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClaimAnswerHistoryLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'log_id',
        'question',
        'answer'
    ];

    public function claimHistoryLog():BelongsTo
    {
        return $this->belongsTo(ClaimHistoryLog::class, 'log_id');
    }
}
