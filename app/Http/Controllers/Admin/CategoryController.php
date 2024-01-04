<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Image;
use App\Models\Navigation;
use App\Models\Shared_attributes;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{   
    protected $fileLocation = 'category';
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
            $inputData = $request->all();
            $inputData['model'] = 'Blog';
            $validator = Validator::make($inputData, [
                'name' => 'required|max:255',
                'cat_icon' => 'required|string',

                'status' => 'required|in:Draft,Published',
                'post_body' => 'required',
                'model' => 'required',
                'keyword' => 'required|string',
                'seo_title' => 'required|string',
                'meta_desc' => 'required|string',
                'summary' => 'required|string',

                'featured_image' => 'sometimes|image|mimes:jpg,jpeg,png,gif|max:4096|dimensions:min_width=100,min_height=100,max_width=5000,max_height=5000',
                'thumnail_image' => 'sometimes|image|mimes:jpg,jpeg,png,gif|max:1024|dimensions:min_width=50,min_height=50,max_width=1000,max_height=1000',
                'image_caption' => 'required|string',

            ]);
            $validatedData = $validator->validated();
            // dd($validatedData);

            // Create a new instance for shared attributes
            $sharedAttributesData = $request->only(['keyword', 'status', 'seo_title', 'post_body', 'meta_desc', 'summary', 'model']);
            $sharedAttributesData['reading_time'] = calculateReadingTime($request->input('post_body'));
            $sharedAttributes = Shared_attributes::create($sharedAttributesData);

            $imageData = $request->only(['image_caption', 'model']);
            if ($request->hasFile('featured_image')) {
                $imageData['featured_image'] = Storage::disk('public')->put($this->fileLocation, $request->file('featured_image'));
            }

            if ($request->hasFile('thumnail_image')) {
                $imageData['thumnail_image'] = Storage::disk('public')->put($this->fileLocation, $request->file('thumnail_image'));
            }
            $image = Image::create($imageData);

            // Create a new blog post instance without shared attributes fields
            $categoryData = Arr::except($validatedData, ['keyword', 'status', 'seo_title', 'post_body', 'meta_desc', 'summary', 'image_caption', 'featured_image', 'thumnail_image', 'tag_id', 'category_id']);
            $categoryData['shared_attributes_id'] = $sharedAttributes->id;
            $categoryData['image_id'] = $image->id;
            $category = Category::create($categoryData);

            DB::commit();
            $notification = array(
                'message' => 'Item Added in Category',
                'alert-type' => 'success'
            );

            return redirect()->route('category.index')->with($notification);
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback the transaction on error

            $notification = array(
                'message' => 'Failed to create category: '.$e->getMessage(),
                'alert-type' => 'error'
            );
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
