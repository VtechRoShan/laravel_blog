<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Navigation extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'image', 'description', 'image_id'];

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
        return $this->hasOne(Image::class, 'image_id');
    }
}
