<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Category;
use App\Models\Navigation;

class frontendController extends Controller
{
    public function index()
    {
        $navigations = Navigation::with('categories')->get();
        $categories = Category::select('id', 'name')->get();
        $blogs = Blog::with(['category' => function ($query) {
            $query->select('id', 'name'); // Select only necessary fields in the related category model
        }])
            ->select('id', 'title', 'publish_at', 'reading_time', 'thumnail_image', 'summary')
            ->latest()
            ->get();

        return view('welcome', compact('navigations', 'blogs', 'categories'));
    }
}
