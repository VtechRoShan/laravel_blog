<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Category;
use App\Models\Navigation;
use App\Models\Tag;

class frontendController extends Controller
{
    public function index()
    {
        $navigations = Navigation::with('categories')->get();
        $categories = Category::all();
        $tags = Tag::select('id', 'name', 'slug')->withCount('blogs')->having('blogs_count', '>=', 1)->orderBy('created_at', 'desc')->get();
        $blogs = Blog::all();

        return view('welcome', compact('navigations', 'blogs', 'tags', 'categories'));
    }
    public function navbar($slug)
    {   
        // dd($name);
        $navigations = Navigation::with('categories')->get();
        $navigation = $navigations->where('slug', $slug)->first();        
        if (!$navigation) {
            abort(404); 
        }
        $blogs = Blog::where('nav_bar_id', $navigation->id)->get();
        $name = $navigation->name;
        return view('view_post_by_navigation', compact('navigations','navigation', 'blogs'));
    }
    public function nav_cat_blog($navigationName, $categoryName)
    {   
        $navigations = Navigation::with('categories')->get();
        $navigation = $navigations->where('slug', $navigationName)->first();        
        if (!$navigation) {
            abort(404); 
        }else{
            $category = Category::where('slug', $categoryName)->first();        
            if (!$category) {
                abort(404); 
            }else{
                $blogs = Blog::whereHas('navigation', function ($query) use ($navigation) {
                    $query->where('id', $navigation->id);})->whereHas('category', function ($query) use ($categoryName) {
                    $query->where('slug', $categoryName);})->get();
            }
        }


        return view('view_post_by_nav_cat', compact('navigations', 'navigation', 'category','blogs'));  
    }

    public function getRelatedPosts($postId)
    {
        $post = Blog::with(['category', 'tags'])->findOrFail($postId);

        $categoryIds = $post->category->pluck('id');
        $tagIds = $post->tags->pluck('id');

        $relatedPosts = Blog::where('id', '<>', $postId)
            ->whereHas('category', function ($query) use ($categoryIds) {
                $query->whereIn('blog_category.category_id', $categoryIds); // Referencing the pivot table
            })
            ->withCount(['tags' => function ($query) use ($tagIds) {
                $query->whereIn('blog_tag.tag_id', $tagIds); // Referencing the pivot table
            }])
            ->orderBy('tags_count', 'desc') // Order by the count of matching tags
            ->take(11)
            ->get();

        return $relatedPosts;
    }

    public function view_post($slug)
    {
        $navigations = Navigation::with('categories')->get();
        $blog = Blog::where('slug', $slug)->first();

        $relatedPosts = $this->getRelatedPosts($blog->id);

        return view('view_post', compact('navigations', 'blog', 'relatedPosts'));
    }

    public function view_post_by_tag($slug)
    {   
        // dd($slug);
        $navigations = Navigation::with('categories')->get();
        $tags = Tag::with('blogs')
            ->where('slug', $slug)
            ->first();
        $categories = Category::all();
        // Retrieve all categories except the current one and shuffle them
        $alltags = Tag::where('id', '!=', $tags->id ?? null)
            ->inRandomOrder()
            ->get();

        return view('view_post_by_tag', compact('navigations', 'tags', 'categories', 'alltags'));
    }

    public function view_post_by_category($slug)
    {
        // dd($slug);
        $navigations = Navigation::with('categories')->get();
        $categoryWithBlogs = Category::with('blogs')
            ->where('slug', $slug)
            ->first();

        // Retrieve all categories except the current one and shuffle them
        $categories = Category::where('id', '!=', $categoryWithBlogs->id ?? null)
            ->inRandomOrder()
            ->get();
        return view('view_post_by_category', compact('navigations', 'categoryWithBlogs', 'categories'));
    }
    public function all_tag()
    {
        // dd($slug);
        $navigations = Navigation::with('categories')->get();
        $all_tags = Tag::all();
        return view('view_all_tags', compact('navigations', 'all_tags'));
    }
}
