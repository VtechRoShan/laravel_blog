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
        $categories = Category::select('id', 'name')->get();
        $tags = Tag::select('id', 'name', 'slug')->withCount('blogs')->having('blogs_count', '>=', 1)->orderBy('created_at', 'desc')->get();
        $blogs = Blog::all();

        return view('welcome', compact('navigations', 'blogs','tags', 'categories'));
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
        $blog = Blog::where('slug', $slug) ->first();

        $relatedPosts = $this->getRelatedPosts($blog->id);

        return view('view_post', compact('navigations', 'blog', 'relatedPosts'));
    }
    public function view_post_by_tag($slug)
    {
        $navigations = Navigation::with('categories')->get();
        $tags = Tag::with('blogs')
            ->where('slug', $slug)
            ->first();
        $categories = Category::select('id', 'name')->get();

        return view('view_post_by_tag', compact('navigations', 'tags', 'categories'));
    }
}
