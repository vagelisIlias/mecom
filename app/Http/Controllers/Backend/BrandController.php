<?php

namespace App\Http\Controllers\Backend;

use Intervention\Image\Facades\Image;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use App\Models\Brand;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    // All Brands
    public function allBrand()
    {   
        $allBrand = Brand::latest()->get();
        return view('backend.brand.brand_all', compact('allBrand'));
    }

    // Add Brand
    public function addBrand()
    {
        return view('backend.brand.brand_add');
    }

    // Store Brand
    // public function storeBrand(Request $request)
    // {
    //    $image = $request->file('brand_image');
    //    $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
    //    $image_path = 'upload/brand_image/' . $name_gen;
    //    Image::make($image)->resize(300, 300)->save(public_path($image_path));
    //    $save_url = $image_path;

    //    Brand::create([
    //     'brand_name' => $request->brand_name,
    //     'brand_slug' => strtolower(str_replace(' ', '-', $request->brand_name)),
    //     'brand_image' => $save_url,
    //    ]);

    //    // Creating a message notification
    //    $notification = [
    //     'message' => 'Brand Inserted Successfully',
    //     'alert-type' => 'success',
    //     ];

    //     return redirect()->route('all.brand')->with($notification);
    // }
    
    // Store Brand
    public function storeBrand(Request $request)
    {
        // Validate the request
        $request->validate([
            'brand_name' => 'required|string|max:255',
            'brand_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust the file types and size limit as needed
        ]);
    
        try {
            $image = $request->file('brand_image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $image_path = 'upload/brand_image/' . $name_gen;
            Image::make($image)->resize(300, 300)->save(public_path($image_path));
            $save_url = $image_path;
    
            // Create the brand
            Brand::create([
                'brand_name' => $request->brand_name,
                'brand_slug' => strtolower(str_replace(' ', '-', $request->brand_name)),
                'brand_image' => $save_url,
            ]);
    
            // Success message notification
            $notification = [
                'message' => 'Brand Inserted Successfully',
                'alert-type' => 'success',
            ];
    
            return redirect()->route('all.brand')->with($notification);
        } catch (\Exception $e) {
            // Handle errors, log them, and return an error response
            $notification = [
                'message' => 'An error occurred while saving the brand.',
                'alert-type' => 'error',
            ];
    
            return redirect()->back()->with($notification);
        }
    }
    

}
