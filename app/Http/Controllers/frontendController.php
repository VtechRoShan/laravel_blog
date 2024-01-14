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
        $blogs = Blog::all();

        return view('welcome', compact('navigations', 'blogs', 'categories'));
    }
    public function view_post($slug)
    {
        $navigations = Navigation::with('categories')->get();
        $categories = Category::select('id', 'name')->get();
        $blog = Blog::where('slug', $slug) ->first();

        return view('view_post', compact('navigations', 'blog', 'categories'));
    }
}
