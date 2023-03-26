<?php

namespace App\Http\Controllers;

use App\Helpers\ImageHelper;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    // View File To Upload Image
    public function index()
    { 
        return view('image-form');
    }

    // Store Image
    public function storeImage(Request $request)
    {
        // Image Upload 
        $request->validate([
            'image' => 'required|image|mimes:png,jpg,jpeg'
        ]);
        $fileName = $request->image->getClientOriginalName();
        $request->image->move(public_path('images'), $fileName);
        $path = public_path('images') . '\\' . $fileName;

        //Compression of recentily uploaded File
        $image_path = realpath($path);
        $image = new ImageHelper($image_path);
       
        //For Compressing images PNG AND JPG
        if($image->compress()){
            return back()->with('success', 'Image uploaded Successfully and Compressed!');
        }else{
            return back()->with('error', 'Image uploaded Failed!');
        }

        //For Compressing images PNG AND JPG
        if ($image->convert_to_webp()) {
            return back()->with('success', 'Image uploaded Successfully and converted!');
        } else {
            return back()->with('error', 'Image uploaded Failed!');
        }
    }
}
