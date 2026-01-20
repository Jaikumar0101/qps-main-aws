<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuickProject extends Model
{
    use HasFactory, SoftDeletes;


    const STATUS_ACTIVE = "Active";
    const STATUS_CLOSED = "Closed";

    public static array $statusList = [
        'Active',
        'Processing',
        'Closed',
    ];

    protected $fillable = [
        'user_id',
        'client_id',
        'name',
        'description',
        'content',
        'image',
        'start_date',
        'end_date',
        'company',
        'project_report',
        'emails',
        'tags',
        'status',
    ];

    public static function findByClient($client_id = null)
    {
        return self::where('client_id',$client_id)->first();
    }

    public function user():HasOne
    {
        return $this->hasOne(User::class,'id','user_id');
    }

    public function assignedTeam():HasManyThrough
    {
        return $this->hasManyThrough(
            User::class,
            QuickProjectAssign::class,
            'project_id',
            'id',
            'id',
            'user_id'
        );
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(QuickProjectCategory::class, 'category_id','id');
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'client_id','id');
    }

    public function displayDate($key = "start_date",$format = "m-d-Y"):string
    {
        try
        {
            return checkData($this->$key)?Carbon::createFromDate($this->$key)->format($format):'';
        }
        catch (\Exception $exception)
        {
            return "";
        }
    }

    public function getTags():array
    {
        try
        {
            return explode(',', $this->tags);
        }
        catch (\Exception $exception)
        {
            return [];
        }
    }

}
