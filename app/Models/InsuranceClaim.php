<?php

namespace App\Models;

use App\Helpers\ClaimHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class InsuranceClaim extends Model
{
    use HasFactory,SoftDeletes;

    const METHOD_TYPES = [
        'call','portal','both'
    ];

    protected $fillable = [
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
        'follow_up_status',
        'pms_note',
        'task_id',
        'task_subject',
        'task_note',
        'task_reason',
        'method',
    ];

    public function code($prefix = "#")
    {
        return $prefix."INC-".$this->id;
    }

    public function customer():BelongsTo
    {
        return $this->belongsTo(Customer::class,'customer_id');
    }

    public function assignedClients():HasMany
    {
        return $this->hasMany(ClientAssign::class,'customer_id','customer_id');
    }

    public function assigns():HasMany
    {
        return $this->hasMany(ClaimAssign::class,'claim_id','id');
    }

    public function users():HasManyThrough
    {
        return $this->hasManyThrough(
            User::class,
            ClaimAssign::class,
            'claim_id', // Foreign key on ReservationAssignedUser table
            'id',             // Foreign key on User table
            'id',             // Local key on Reservation table
            'user_id'         // Local key on ReservationAssignedUser table
        );
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

    public function taskModal():HasOne
    {
        return $this->hasOne(InsuranceClaimTask::class, 'id','task_id');
    }

    public function followUpModal():BelongsTo
    {
        return $this->belongsTo(InsuranceFollowUp::class,'follow_up_status');
    }

    public function answers():HasMany
    {
       return $this->hasMany(InsuranceClaimAnswer::class,'claim_id','id');
    }


    public function userNotes():HasMany
    {
        return $this->hasMany(UserNote::class,'claim_id','id');
    }

    public function isClosed(): bool
    {
        return in_array($this->followUpModal?->name ??'',ClaimHelper::closedFollowUp());
    }

}
