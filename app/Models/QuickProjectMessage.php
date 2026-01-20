<?php

namespace App\Models;

use App\Helpers\Admin\BackendHelper;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuickProjectMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'project_id',
        'category_id',
        'subject',
        'content',
        'tags',
        'files',
        'notified',
        'notified_people',
        'people_access',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'notified' => 'boolean',
        'people_access' => 'boolean',
    ];

    /**
     * Get the user that owns the message.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the project that owns the message.
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(QuickProject::class, 'project_id');
    }

    public function postDate($format = 'm/d/Y')
    {
        return Carbon::parse($this->created_at)->diffForHumans();
    }

    public function getFiles():array
    {
        return BackendHelper::JsonDecode($this->files);
    }

}
