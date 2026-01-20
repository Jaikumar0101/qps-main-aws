<?php

namespace App\Models;

use App\Helpers\ClaimHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ClaimHistoryLog extends Model
{
    use HasFactory;

    const LOG_TYPE = ['old','import','merged'];

    protected $fillable = [
        'parent_id',
        'import_id',
        'type',
        'customer_id',
        'ins_name',
        'ins_phone',
        'sub_id',
        'sub_name',
        'patent_id',
        'patent_name',
        'dob',
        'dos',
        'sent',
        'total',
        'days',
        'days_r',
        'prov_nm',
        'location',
        'claim_status',
        'status_description',
        'note',
        'claim_action',
        'cof',
        'nxt_flup_dt',
        'eob_dl',
        'team_worked',
        'worked_by',
        'worked_dt',
        'follow_up_status'
    ];

    public function claim():BelongsTo
    {
        return $this->belongsTo(InsuranceClaim::class,'parent_id','id');
    }

    public function importHistory():BelongsTo
    {
        return $this->belongsTo(ImportClaimHistory::class,'import_id','id');
    }

    public function colorType():string
    {
        return match ($this->type){
            'old'=>'danger',
            'import'=>'primary',
            default=>'success',
        };
    }

    public function getTypeName():string
    {
        return match ($this->type){
            'old'=>'Before Import',
            'import'=>'Import',
            default=>'Merged',
        };
    }

    public function customer():BelongsTo
    {
        return $this->belongsTo(Customer::class,'customer_id');
    }

    public function assigns():HasMany
    {
        return $this->hasMany(ClientAssign::class,'customer_id','customer_id');
    }

    public function claimStatusModal():BelongsTo
    {
        return $this->belongsTo(InsuranceClaimStatus::class,'claim_status');
    }

    public function eobDlModal():BelongsTo
    {
        return $this->belongsTo(InsuranceEobDl::class,'eob_dl');
    }

    public function teamModal():HasOne
    {
        return $this->hasOne(InsuranceWorkedBy::class, 'id','team_worked');
    }

    public function followUpModal():BelongsTo
    {
        return $this->belongsTo(InsuranceFollowUp::class,'follow_up_status');
    }

    public function answers():HasMany
    {
        return $this->hasMany(ClaimAnswerHistoryLog::class,'log_id','id');
    }

    public function isClosed(): bool
    {
        return in_array($this->followUpModal?->name ??'',ClaimHelper::closedFollowUp());
    }

}
