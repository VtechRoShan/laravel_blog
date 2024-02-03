<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Navigation extends Model
{
    use HasFactory;
    use Sluggable;

    protected $table = 'navigations';

    protected $fillable = [
        'name',
        'slug',
        'seo_title',
        'meta_desc',
        'image_id',
    ];

    public function blog()
    {
        return $this->hasMany('App\Models\Blog');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_navigation');
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
