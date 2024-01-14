<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Models\Navigation;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class NavigationController extends Controller
{
    protected $fileLocation = 'navigations';

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $navigations = Navigation::all();

        return view('admin.navigation.index', compact('navigations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.navigation.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $inputData = $request->all();
            $validator = Validator::make($inputData, [
                'name' => 'required|max:100',
                'seo_title' => 'required|string',
                'meta_desc' => 'required|string',
                'featured_image' => 'sometimes|image|mimes:jpg,jpeg,png,gif|max:4096|dimensions:min_width=100,min_height=100,max_width=5000,max_height=5000',
                'thumbnail_image' => 'sometimes|image|mimes:jpg,jpeg,png,gif|max:1024|dimensions:min_width=50,min_height=50,max_width=1000,max_height=1000',
                'image_caption' => 'required|string',

            ]);
            $validatedData = $validator->validated();

            $imageData = $request->only(['image_caption']);
            $imageData['model'] = 'Navigation';
            if ($request->hasFile('featured_image')) {
                $imageData['featured_image'] = Storage::disk('public')->put($this->fileLocation, $request->file('featured_image'));
            }

            if ($request->hasFile('thumbnail_image')) {
                $imageData['thumbnail_image'] = Storage::disk('public')->put($this->fileLocation, $request->file('thumbnail_image'));
            }
            $image = Image::create($imageData);

            // Create a new blog post instance without shared attributes fields
            $navData = $request->only(['name', 'seo_title', 'meta_desc']);
            $navData['image_id'] = $image->id;
            Navigation::create($navData);

            DB::commit();
            $notification = [
                'message' => 'Item Added in Navigations',
                'alert-type' => 'success',
            ];

            return redirect()->route('navigation.index')->with($notification);
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback the transaction on error

            $notification = [
                'message' => 'Failed to create blog post: '.$e->getMessage(),
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

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $navigation = Navigation::with('images')->find($id);

        return view('admin.navigation.edit', compact('navigation'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        DB::beginTransaction();
        try {
            $navigation = Navigation::findOrFail($id);
            $inputData = $request->all();

            $validator = Validator::make($inputData, [
                'name' => 'required|max:100',
                'seo_title' => 'required|string',
                'meta_desc' => 'required|string',
                'featured_image' => 'sometimes|image|mimes:jpg,jpeg,png,gif|max:4096|dimensions:min_width=100,min_height=100,max_width=5000,max_height=5000',
                'thumbnail_image' => 'sometimes|image|mimes:jpg,jpeg,png,gif|max:1024|dimensions:min_width=50,min_height=50,max_width=1000,max_height=1000',
                'image_caption' => 'required|string',
            ]);
            $validatedData = $validator->validated();

            $navigationData = Arr::except($validatedData, ['featured_image', 'thumbnail_image', 'image_caption']);
            $navigation->update($navigationData);
            // Update Image
            // Update Image
            $imageData = [];
            if ($request->hasFile('thumbnail_image')) {
                if ($navigation->images && Storage::disk('public')->exists($navigation->images->thumbnail_image)) {
                    Storage::disk('public')->delete($navigation->images->thumbnail_image);
                }
                $imageData['thumbnail_image'] = Storage::disk('public')->put($this->fileLocation, $request->file('thumbnail_image'));
            }
            if ($request->hasFile('featured_image')) {
                if ($navigation->images && Storage::disk('public')->exists($navigation->images->featured_image)) {
                    Storage::disk('public')->delete($navigation->images->featured_image);
                }
                $imageData['featured_image'] = Storage::disk('public')->put($this->fileLocation, $request->file('featured_image'));
            }
            // Update Image record only if there's new image data
            if (! empty($imageData)) {
                $navigation->images->update($imageData);
            }
            DB::commit();
            $notification = [
                'message' => 'Item Edited in Navigations',
                'alert-type' => 'success',
            ];

            return redirect()->route('navigation.index')->with($notification);
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();
        try {
            $navigation = Navigation::with('images')->findOrFail($id);

            // Check if there are associated images and delete them from storage
            if ($navigation->images) {
                if (Storage::disk('public')->exists($navigation->images->featured_image)) {
                    Storage::disk('public')->delete($navigation->images->featured_image);
                }
                if (Storage::disk('public')->exists($navigation->images->thumbnail_image)) {
                    Storage::disk('public')->delete($navigation->images->thumbnail_image);
                }

                // Delete the image records from the database
                $navigation->images->delete();
            }

            // Delete the navigation record
            $navigation->delete();

            DB::commit();
            $notification = [
                'message' => 'Item Deleted From Navigations',
                'alert-type' => 'success',
            ];

            return redirect()->route('navigation.index')->with($notification);
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
