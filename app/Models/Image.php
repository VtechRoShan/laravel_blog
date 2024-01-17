<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $table = 'images';

    protected $fillable = [
        'thumbnail_image',
        'featured_image',
        'image_caption',
        'model',
    ];

    public function blog()
    {
        return $this->hasOne(Blog::class, 'image_id');
    }

    public function navigation()
    {
        return $this->hasOne(Navigation::class, 'image_id');
    }

    public function category()
    {
        return $this->hasOne(Category::class, 'image_id');
    }
    public function tags()
    {
        return $this->hasOne(Tag::class, 'image_id');
    }
}
