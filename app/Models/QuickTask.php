<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuickTask extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'parent_id',
        'name',
        'subject',
        'content',
        'start_date',
        'end_date',
        'status',
        'is_completed',
    ];

    public function project():HasOneThrough
    {
        return $this->hasOneThrough(
            QuickProject::class,
            QuickTaskCategory::class,
            'id',
            'id',
            'parent_id',
            'project_id'
        );
    }

    /**
     * The category that owns the quick task.
     */
    public function category():BelongsTo
    {
        return $this->belongsTo(QuickTaskCategory::class, 'parent_id','id');
    }

    public function displayDate($start = true,$customFormat = false,$format = 'm/d/Y'): ?string
    {
        $key = $start?'start_date':'end_date';
        try
        {
            return checkData($this->$key)?Carbon::createFromDate($this->$key)->format($format):null;
        }
        catch (\Exception $exception){}
        return null;
    }
}
