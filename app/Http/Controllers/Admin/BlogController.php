<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Navigation;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class BlogController extends Controller
{
    protected $fileLocation = 'blogs';

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blogs = Blog::latest()->paginate(20);

        return view('admin.blog.index', compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tags = Tag::all();
        $navigations = Navigation::all();
        $categories = Category::all();

        return view('admin.blog.create', compact('categories', 'navigations', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request);
        // Validate the request
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'status' => 'required|in:Draft,Published',
            'publish_at' => 'required|date',
            'post_body' => 'required',
            'keyword' => 'required|string',
            'seo_title' => 'required|string',
            'blog_meta_desc' => 'required|string',
            'summary' => 'required|string',
            'featured_image' => 'sometimes|image|mimes:jpg,jpeg,png,gif|max:4096|dimensions:min_width=100,min_height=100,max_width=5000,max_height=5000',
            'thumnail_image' => 'sometimes|image|mimes:jpg,jpeg,png,gif|max:1024|dimensions:min_width=50,min_height=50,max_width=1000,max_height=1000',
            'image_caption' => 'required|string',
            'nav_bar_id' => 'required|integer|exists:navigations,id',
            'category_id' => 'required|array',
            'category_id.*' => 'integer|exists:categories,id',
            'tag_id' => 'required|array',
            'tag_id.*' => 'integer|exists:tags,id',

        ]);
        //  dd($validatedData);

        // Create a new blog post instance
        $blogData = Arr::except($validatedData, ['featured_image', 'thumnail_image', 'tag_id', 'category_id']);
        $blog = Blog::create($blogData);

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            $blog->featured_image = Storage::disk('public')->put($this->fileLocation, $request->file('featured_image'));
        }

        // Handle thumbnail image upload
        if ($request->hasFile('thumnail_image')) {
            $blog->thumnail_image = Storage::disk('public')->put($this->fileLocation, $request->file('thumnail_image'));
        }
        $blog->reading_time = calculateReadingTime($blog->post_body);

        $blog->save();
        if (isset($validatedData['category_id'])) {
            $blog->category()->sync($validatedData['category_id']);
        }
        if (isset($validatedData['tag_id'])) {
            $blog->tags()->sync($validatedData['tag_id']);
        }
        if (isset($validatedData['nav_bar_id']) && isset($validatedData['category_id'])) {
            $navigation = Navigation::find($validatedData['nav_bar_id']);
            $categories = Category::whereIn('id', $validatedData['category_id'])->get();
        
            foreach ($categories as $category) {
                // Check if the entry already exists for the same navigation and category
                $existingEntry = $navigation->categories()
                    ->where('category_id', $category->id)
                    ->first();
        
                if ($existingEntry) {
                    // Entry exists, increment the count
                    $existingEntry->pivot->increment('count');
                } else {
                    // Entry does not exist, create a new one with a count of 1
                    $navigation->categories()->attach($category->id, ['count' => 1]);
                }
            }
        }
        return redirect()->route('blog.index')->with('success', 'Blog post created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
