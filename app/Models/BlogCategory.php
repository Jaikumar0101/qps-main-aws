<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class BlogCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_id',
        'name',
        'description',
        'icon',
        'thumbnail',
        'position',
        'status'
    ];

    protected static function boot():void {
        parent::boot();

        static::deleting(static function($check) {
            $check->subCategory()->update(['parent_id'=>null]);
            $check->metaData()->delete();
            $check->getSlug()->delete();
        });
    }

    public static function getInOrder($items = [],$check = false)
    {
        $order = isset($items) && count($items)>0?implode(',',$items):"0";
        return $check?self::whereIn('id',$items)->where('status',1)->orderByRaw("FIELD(id,$order)")->get():
            self::where('status', 1)
                ->orderByRaw("FIELD(id,$order)")
                ->get();
    }

    public function subCategory(): HasMany
    {
        return $this->hasMany(self::class,'parent_id','id');
    }

    public function metaData(): HasOne
    {
        return $this->hasOne(MetaData::class,'model_id','id')->where('model',self::class);
    }

    public function getSlug(): HasOne
    {
        return $this->hasOne(SlugManager::class,'model_id','id')->where('model',self::class);
    }

    public function getSlugAttribute():?string
    {
        return $this->getSlug()->exists()?$this->getSlug->slug:"";
    }

}
