<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model
{
    use HasFactory;
    use Sluggable;
    use SoftDeletes; 

    protected $fillable = ['title', 'slug', 'publish_at', 'nav_bar_id', 'shared_attributes_id', 'image_id'];

    public function Sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title',
                'onUpdate' => true,
            ],
        ];
    }

    public function navigation()
    {
        return $this->belongsTo('App\Models\Navigation', 'nav_bar_id', 'id');
    }

    public function category()
    {
        return $this->belongsToMany(Category::class)->as('blog_category');
    }

    public function sharedAttributes()
    {
        return $this->hasOne(Shared_attributes::class, 'shared_attributes_id');
    }

    public function images()
    {
        return $this->hasOne(Image::class, 'image_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class)->as('blog_tag');
    }
}
