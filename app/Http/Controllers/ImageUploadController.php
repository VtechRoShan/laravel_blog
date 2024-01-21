<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageUploadController extends Controller
{
    private $fileLocation = 'blogs';

    // Upload Image By File
    public function uploadByFile(Request $request)
    {
        // Validate the incoming request if needed
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $file = $request->image;
        $uuid = Str::uuid()->toString();
        // Generate a file name for the uploaded image
        $fileName = 'image_'.$uuid.'_'.date('YmdHis').'.'.'png';

        // Define the file path within the public bucket
        $imageFilePath = $this->fileLocation.'/'.$fileName;

        $fileContents = file_get_contents($file->getRealPath());

        // Store the file in public bucket
        Storage::disk('public')->put($imageFilePath, $fileContents);
        // Get the URL of the stored file
        $fileUrl = Storage::disk('public')->url($imageFilePath);

        $res = [
            'success' => 1,
            'file' => (object) [
                'url' => $fileUrl,
                'file' => $imageFilePath,

            ],
        ];

        return response()->json($res);
    }

    // Upload Image By URL
    public function uploadByUrl(Request $request)
    {
        $request->validate([
            'url' => 'required|url',
        ]);

        $url = $request->url;

        // Get the image content from the URL
        $contents = file_get_contents($url);
        $uuid = Str::uuid()->toString();
        // Generate a file name for the uploaded image
        $fileName = 'image_'.$uuid.'_'.date('YmdHis').'.'.'png';

        // Define the file path within the public bucket
        $imageFilePath = $this->fileLocation.'/'.$fileName;

        // Upload the image content to public
        Storage::disk('public')->put($imageFilePath, $contents);

        // Get the URL of the stored image
        $fileUrl = Storage::disk('public')->url($imageFilePath);

        $res = [
            'success' => 1,
            'file' => (object) [
                'url' => $fileUrl,
                'file' => $imageFilePath,
            ],
        ];

        return response()->json($res);
    }

    // Function to delete Image from public bucket
    public function delete(Request $request)
    {
        $fileUrl = $request->input('file_url'); // Assuming the file URL is sent in the request

        // Extract the path from the URL to locate the file in the public bucket
        $parsedUrl = parse_url($fileUrl);
        $filePath = ltrim($parsedUrl['path'], '/');

        // Check if the file exists in the public bucket
        if (Storage::disk('public')->exists($filePath)) {
            // Delete the file from the public bucket
            Storage::disk('public')->delete($filePath);

            // Prepare a success response
            $res = [
                'success' => 1,
                'message' => 'File deleted successfully',
            ];
        } else {
            // Prepare an error response if the file doesn't exist
            $res = [
                'success' => 0,
                'message' => 'File not found or already deleted',
            ];
        }

        return response()->json($res);
    }
}
