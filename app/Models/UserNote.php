<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class UserNote extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'claim_id',
        'title',
        'note',
        'due_date',
    ];

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getNoteTitle($limit = 10): ?string
    {
        return checkData($this->title)
            ?Str::limit($this->title,$limit)
            :Str::limit($this->note,$limit);
    }

}
