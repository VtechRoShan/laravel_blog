<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Category;
use App\Models\Navigation;
use App\Models\Shared_attributes;

class frontendController extends Controller
{
    public function index()
    {
        $navigations = Navigation::with('categories')->get();
        $categories = Category::select('id', 'name')->get();
        $blogs = Blog::all();

        return view('welcome', compact('navigations', 'blogs', 'categories'));
    }
}
