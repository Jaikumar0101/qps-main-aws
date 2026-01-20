<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClaimAssign extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'claim_id',
    ];

    /**
     * Get the user that owns the claim assignment.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the claim that is assigned to the user.
     */
    public function claim()
    {
        return $this->belongsTo(InsuranceClaim::class);
    }

}
