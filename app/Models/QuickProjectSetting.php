<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuickProjectSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'key',
        'value'
    ];

    public function project():BelongsTo
    {
        return $this->belongsTo(QuickProject::class, 'project_id');
    }

    public static function getByKeys($project_id = null,$keys = []):array
    {
        return self::where('project_id',$project_id)
            ->whereIn('key',$keys)
            ->pluck('value','key')
            ->toArray();
    }

    public static function getByKey($project_id = null,$key = null)
    {
        return self::where('project_id',$project_id)
            ->where('key',$key)
            ->first();
    }
}
