<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class BlogPost extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'user_id',
        'title',
        'desc',
        'content',
        'image',
        'post_date',
        'category',
        'format',
        'video_url',
        'video_embed',
        'read_time_format',
        'read_time',
        'layout',

        'status'
    ];

    public static function getInOrder($items = [],$check = false)
    {
        $order = isset($items) && count($items)>0?implode(',',$items):"0";
        return $check?self::whereIn('id',$items)->where('status',1)->orderByRaw("FIELD(id,$order)")->get():
            self::whereIn('id',$items)->orderByRaw("FIELD(id,$order)")->get();
    }

    public function categories():HasManyThrough
    {
        return $this->hasManyThrough(BlogCategory::class,BlogPostAttribute::class,'post_id','id','id','model_id')
            ->where('model',BlogCategory::class);
    }

    public function tags():HasManyThrough
    {
        return $this->hasManyThrough(BlogTag::class,BlogPostAttribute::class,'post_id','id','id','model_id')
            ->where('model',BlogTag::class);
    }

    public function getSlug(): HasOne
    {
        return $this->hasOne(SlugManager::class,'model_id','id')->where('model',self::class);
    }

    public function metaData(): HasOne
    {
        return $this->hasOne(MetaData::class,'model_id','id')->where('model',self::class);
    }

    public function getSlugAttribute():?string
    {
        return $this->getSlug()->exists()?$this->getSlug->slug:"";
    }

    public function displayPostDate($format = "Y-m-d"):string
    {
        try {
            return Carbon::createFromDate($this->post_date)->format($format);
        }
        catch (\Exception $exception){ return ""; }
    }

    public function slugUrl():string
    {
        return "";
    }

    public function draftUrl():string
    {
        return "";
    }


    /* Finding Reading Time */
    private function getEstimateReadingTime($content, $wpm = 200): string
    {

        $wordCount = str_word_count(strip_tags($content));

        $minutes = (int) floor($wordCount / $wpm);
        $seconds = (int) floor($wordCount % $wpm / ($wpm / 60));

        if ($minutes === 0) {
            return $seconds." ".Str::of('second')->plural($seconds);
        } else {
            return $minutes." ".Str::of('minute')->plural($minutes);
        }
    }

    protected function timeToRead(): Attribute {

        return Attribute::make(
            get: function ($value, $attributes) {
                return $attributes['read_time_format']?$attributes['read_time']." min":$this->getEstimateReadingTime($attributes['content']);
            }
        );
    }

}
