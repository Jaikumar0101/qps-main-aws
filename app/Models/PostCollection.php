<?php

namespace App\Models;

use App\Helpers\Admin\BackendHelper;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostCollection extends Model
{
    use HasFactory;

    protected $table = "post_collections";

    protected $fillable = [
        'title',
        'description',
        'post_items',
        'position',
        'status',
    ];

    protected function getPostAttribute(): Attribute
    {
        return Attribute::make(
            get: fn($value, array $attributes) => $this->getPostsInOrder(),
            set: fn($value) => $value,
        );
    }

    public function getPostsInOrder(): \Illuminate\Support\Collection
    {
        if (checkData($this->post_items))
        {
            $order = $this->post_items;
            $items = BackendHelper::JsonDecode($order);
            return BlogPost::whereIn('id',$items)
                ->where('status',1)
                ->orderByRaw("FIELD('id',$order)")
                ->get();
        }
        return collect([]);
    }

}
