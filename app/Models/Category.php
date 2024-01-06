<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    use Sluggable;

    protected $table = 'categories';

    protected $fillable = [
        'name',
        'slug',
        'cat_icon',
        'shared_attributes_id',
        'image_id',
    ];

    public function blogs()
    {
        return $this->belongsToMany(Blog::class, 'blog_category');
    }

    public function navigations()
    {
        return $this->belongsToMany(Navigation::class, 'category_navigation');
    }

    public function sharedAttributes()
    {
        return $this->belongsTo(Shared_attributes::class, 'shared_attributes_id');
    }

    public function images()
    {
        return $this->belongsTo(Image::class, 'image_id');
    }

    public function Sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
                'onUpdate' => true,
            ],
        ];
    }
}
