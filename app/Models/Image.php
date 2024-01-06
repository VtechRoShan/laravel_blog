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

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function blog()
    {
        return $this->belongsTo(Blog::class);
    }

    public function navigation()
    {
        return $this->hasOne(Navigation::class, 'image_id');
    }
}
