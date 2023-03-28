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
        if (!file_exists(public_path('images'))) {
            mkdir(public_path('images'), 0755, true);
       }
       
        $request->image->move(public_path('images'), $fileName);
        if(PHP_OS=='WINNT'){
            $path = public_path('images') . '\\' . $fileName;
        }else{
            $path = public_path('images') . '/' . $fileName;
        }

        //Compression of recentily uploaded File
        $image_path = realpath($path);
        // dd( $path);
        $image = new ImageHelper($image_path);
       
        //For Compressing images PNG AND JPG
        if($image->compress()){
            return back()->with('success', 'Image uploaded Successfully and Compressed!');
        }else{
            return back()->with('error', 'Image uploaded Failed!');
        }

        //For Converting images PNG AND JPG to WEBP
        if ($image->convert_to_webp()) {
            return back()->with('success', 'Image uploaded Successfully and converted!');
        } else {
            return back()->with('error', 'Image uploaded Failed!');
        }
    }
}
