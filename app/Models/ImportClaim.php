<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ImportClaim extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'client_id',
        'name',
        'note',
        'file',
        'status',
    ];


    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function client():BelongsTo
    {
        return $this->belongsTo(Customer::class,'client_id','id');
    }

    public function history():HasMany
    {
        return $this->hasMany(ImportClaimHistory::class,'parent_id','id');
    }

    public function revertHistory():HasMany
    {
        return $this->hasmany(ImportClaimRevertHistory::class,'import_claim_id','id');
    }

    public function getUploadedTime($format = "Y-m-d H:i:s"):string
    {
        try {
            return Carbon::parse($this->created_at)->format($format);
        }
        catch (\Exception $exception){}
        return "";
    }

    public function getFilePath(): string
    {
        return public_path($this->file ??'');
    }
}
