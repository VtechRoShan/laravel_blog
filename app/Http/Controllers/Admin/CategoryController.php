<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Image;
use App\Models\Shared_attributes;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    protected $fileLocation = 'category';

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();

        return view('admin.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:255',
                'cat_icon' => 'required|string',

                'status' => 'required|in:Draft,Published',
                'post_body' => 'required',
                'keyword' => 'required|string',
                'seo_title' => 'required|string',
                'meta_desc' => 'required|string',
                'summary' => 'required|string',

                'featured_image' => 'required|image|mimes:jpg,jpeg,png,gif|max:4096|dimensions:min_width=100,min_height=100,max_width=5000,max_height=5000',
                'thumbnail_image' => 'required|image|mimes:jpg,jpeg,png,gif|max:1024|dimensions:min_width=50,min_height=50,max_width=1000,max_height=1000',
                'image_caption' => 'required|string',
            ]);
            $validatedData = $validator->validated();
            // dd($validatedData);
            // Create a new instance for shared attributes
            $sharedAttributesData = $request->only(['keyword', 'status', 'seo_title', 'post_body', 'meta_desc', 'summary']);
            $sharedAttributesData['reading_time'] = calculateReadingTime($request->input('post_body'));
            $sharedAttributesData['model'] = 'Category';
            $sharedAttributes = Shared_attributes::create($sharedAttributesData);

            $imageData = $request->only(['image_caption']);
            $imageData['model'] = 'Category';
            if ($request->hasFile('featured_image')) {
                $imageData['featured_image'] = Storage::disk('public')->put($this->fileLocation, $request->file('featured_image'));
            }

            if ($request->hasFile('thumbnail_image')) {
                $imageData['thumbnail_image'] = Storage::disk('public')->put($this->fileLocation, $request->file('thumbnail_image'));
            }
            $image = Image::create($imageData);

            // Create a new blog post instance without shared attributes fields
            $categoryData = Arr::except($validatedData, ['keyword', 'status', 'seo_title', 'post_body', 'meta_desc', 'summary', 'image_caption', 'featured_image', 'thumbnail_image', 'tag_id', 'category_id']);
            $categoryData['shared_attributes_id'] = $sharedAttributes->id;
            $categoryData['image_id'] = $image->id;
            $category = Category::create($categoryData);

            DB::commit();
            $notification = [
                'message' => 'Item Added in Category',
                'alert-type' => 'success',
            ];

            return redirect()->route('category.index')->with($notification);
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback the transaction on error

            $notification = [
                'message' => 'Failed to create category: '.$e->getMessage(),
                'alert-type' => 'error',
            ];

            // Handle the error, e.g., return an error response or redirect with an error message
            return redirect()->back()->with($notification);
        }
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
        $category = Category::with('images', 'sharedAttributes')->find($id);

        return view('admin.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        DB::beginTransaction();
        try {
            $category = Category::findOrFail($id);
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:255',
                'cat_icon' => 'required|string',

                'status' => 'required|in:Draft,Published',
                'post_body' => 'required',
                'keyword' => 'required|string',
                'seo_title' => 'required|string',
                'meta_desc' => 'required|string',
                'summary' => 'required|string',

                'featured_image' => 'sometimes|image|mimes:jpg,jpeg,png,gif|max:4096|dimensions:min_width=100,min_height=100,max_width=5000,max_height=5000',
                'thumbnail_image' => 'sometimes|image|mimes:jpg,jpeg,png,gif|max:1024|dimensions:min_width=50,min_height=50,max_width=1000,max_height=1000',
                'image_caption' => 'required|string',
            ]);
            $validatedData = $validator->validated();
            // dd($validatedData);
            // Create a new instance for shared attributes
            $sharedAttributesData = Arr::except($validatedData, ['name', 'cat_icon', 'featured_image', 'thumbnail_image', 'image_caption']);
            $sharedAttributesData['reading_time'] = calculateReadingTime($request->input('post_body'));
            $category->sharedAttributes->update($sharedAttributesData);

            $imageData = $request->only(['image_caption']);
            if ($request->hasFile('thumbnail_image')) {
                if ($category->images && Storage::disk('public')->exists($category->images->thumbnail_image)) {
                    Storage::disk('public')->delete($category->images->thumbnail_image);
                }
                $imageData['thumbnail_image'] = Storage::disk('public')->put($this->fileLocation, $request->file('thumbnail_image'));
            }
            if ($request->hasFile('featured_image')) {
                if ($category->images && Storage::disk('public')->exists($category->images->featured_image)) {
                    Storage::disk('public')->delete($category->images->featured_image);
                }
                $imageData['featured_image'] = Storage::disk('public')->put($this->fileLocation, $request->file('featured_image'));
            }
            // Update Image record only if there's new image data
            if (! empty($imageData)) {
                $category->images->update($imageData);
            }

            $categoryData = Arr::except($validatedData, ['status', 'post_body', 'keyword', 'seo_title', 'summary', 'meta_desc', 'featured_image', 'thumbnail_image', 'image_caption']);
            $category->update($categoryData);

            DB::commit();
            $notification = [
                'message' => 'Item Edited in Category',
                'alert-type' => 'success',
            ];

            return redirect()->route('category.index')->with($notification);
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback the transaction on error

            $notification = [
                'message' => 'Failed to Edit category: '.$e->getMessage(),
                'alert-type' => 'error',
            ];

            // Handle the error, e.g., return an error response or redirect with an error message
            return redirect()->back()->with($notification);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();
        try {
            $category = Category::with('images', 'sharedAttributes')->findOrFail($id);

            if ($category->images) {
                if ($category->images->featured_image && Storage::disk('public')->exists($category->images->featured_image)) {
                    Storage::disk('public')->delete($category->images->featured_image);
                }

                if ($category->images->thumbnail_image && Storage::disk('public')->exists($category->images->thumbnail_image)) {
                    Storage::disk('public')->delete($category->images->thumbnail_image);
                }
                // Delete the image records from the database
                $category->images->delete();
            }

            $category->sharedAttributes->delete();

            // Delete the navigation record
            $category->delete();

            DB::commit();
            $notification = [
                'message' => 'Item Deleted From Navigations',
                'alert-type' => 'success',
            ];

            return redirect()->route('category.index')->with($notification);
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback the transaction on error

            $notification = [
                'message' => 'Failed to cedit navigation: '.$e->getMessage(),
                'alert-type' => 'error',
            ];

            // Handle the error, e.g., return an error response or redirect with an error message
            return redirect()->back()->with($notification);
        }
    }
}
