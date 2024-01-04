<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Navigation;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class NavigationController extends Controller
{   
    protected $fileLocation = 'navigations';
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
            $inputData['model'] = 'Blog';
            $validator = Validator::make($inputData, [
                'name' => 'required|max:100',
                'model' => 'required',
                'seo_title' => 'required|string',
                'meta_desc' => 'required|string',
                'featured_image' => 'sometimes|image|mimes:jpg,jpeg,png,gif|max:4096|dimensions:min_width=100,min_height=100,max_width=5000,max_height=5000',
                'thumnail_image' => 'sometimes|image|mimes:jpg,jpeg,png,gif|max:1024|dimensions:min_width=50,min_height=50,max_width=1000,max_height=1000',
                'image_caption' => 'required|string',

            ]);
            $validatedData = $validator->validated();

            $imageData = $request->only(['image_caption', 'model']);
            if ($request->hasFile('featured_image')) {
                $imageData['featured_image'] = Storage::disk('public')->put($this->fileLocation, $request->file('featured_image'));
            }

            if ($request->hasFile('thumnail_image')) {
                $imageData['thumnail_image'] = Storage::disk('public')->put($this->fileLocation, $request->file('thumnail_image'));
            }
            $image = Image::create($imageData);

            // Create a new blog post instance without shared attributes fields
            $navData = Arr::except($validatedData, ['model', 'image_caption', 'featured_image', 'thumnail_image']);
            $navData['image_id'] = $image->id;
            Navigation::create($navData);

            DB::commit();
            $notification = array(
                'message' => 'Item Added in Navigations',
                'alert-type' => 'success'
            );
            return redirect()->route('navigation.index')->with($notification);
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback the transaction on error

            $notification = array(
                'message' => 'Failed to create blog post: '.$e->getMessage(),
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
