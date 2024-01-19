<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class TagController extends Controller
{   
    protected $fileLocation = 'tags';

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tags = Tag::all();

        return view('admin.tag.index', compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.tag.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:100',

                'post_body' => 'required',
                'keyword' => 'required|string',
                'meta_desc' => 'required|string',

                'featured_image' => 'required|image|mimes:jpg,jpeg,png,gif|max:4096|dimensions:min_width=100,min_height=100,max_width=5000,max_height=5000',
                'thumbnail_image' => 'required|image|mimes:jpg,jpeg,png,gif|max:1024|dimensions:min_width=50,min_height=50,max_width=1000,max_height=1000',
                'image_caption' => 'required|string',
            ]);
            $validatedData = $validator->validated();
            // dd($validatedData);
            // Create a new instance for shared attributes

            $imageData = $request->only(['image_caption']);
            $imageData['model'] = 'Tag';
            if ($request->hasFile('featured_image')) {
                $imageData['featured_image'] = Storage::disk('public')->put($this->fileLocation, $request->file('featured_image'));
            }

            if ($request->hasFile('thumbnail_image')) {
                $imageData['thumbnail_image'] = Storage::disk('public')->put($this->fileLocation, $request->file('thumbnail_image'));
            }
            $image = Image::create($imageData);

            // Create a new blog post instance without shared attributes fields
            $tagData = Arr::except($validatedData, ['image_caption', 'featured_image', 'thumbnail_image']);
            $tagData['image_id'] = $image->id;
            $tags = Tag::create($tagData);

            DB::commit();
            $notification = [
                'message' => 'Item Added in tag',
                'alert-type' => 'success',
            ];

            return redirect()->route('tag.index')->with($notification);
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback the transaction on error

            $notification = [
                'message' => 'Failed to create tag: '.$e->getMessage(),
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
