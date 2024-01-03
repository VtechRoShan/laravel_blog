<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shared_attributes extends Model
{
    use HasFactory;

    protected $table = 'shared_attributes';

    // Define fillable properties if you plan to use mass assignment
    protected $fillable = [
        'status',
        'post_body',
        'keyword',
        'seo_title',
        'meta_desc',
        'summary',
        'reading_time',
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
}
