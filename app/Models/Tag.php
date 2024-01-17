<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;
    use Sluggable;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'meta_desc',
        'meta_keyword',
        'image_id',
    ];

    public function blogs()
    {
        return $this->belongsToMany(Blog::class, 'blog_tag');
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
