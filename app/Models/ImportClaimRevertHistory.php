<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ImportClaimRevertHistory extends Model
{
    use HasFactory;

    const TYPES = [
        'trash','added','updated'
    ];

    const TYPE_TRASH = 'trash';
    const TYPE_ADDED = 'added';
    const TYPE_UPDATED = 'updated';

    protected $table = 'import_claim_revert_histories';

    protected $fillable = [
        'import_claim_id',
        'claim_id',
        'type',
        'is_reverted',
    ];

    /**
     * Get the import claim associated with the revert history.
     */
    public function importClaim():BelongsTo
    {
        return $this->belongsTo(ImportClaim::class);
    }

    /**
     * Get the claim associated with the revert history.
     */
    public function claim():BelongsTo
    {
        return $this->belongsTo(InsuranceClaim::class,'claim_id','id');
    }

}
