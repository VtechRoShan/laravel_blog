<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;
    use Sluggable;

    protected $fillable = ['title', 'slug', 'status', 'publish_at', 'post_body', 'keyword', 'seo_title', 'blog_meta_desc', 'summary', 'featured_image', 'thumnail_image', 'image_caption', 'nav_bar_id', 'reading_time'];

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

    public function tags()
    {
        return $this->belongsToMany(Tag::class)->as('blog_tag');
    }
}
