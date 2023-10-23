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
        // Checking the latest data added
        $allBrand = Brand::latest()->get();
        return view('admin.backend.brand.brand_all', compact('allBrand'));
    }

    // Add Brand
    public function addBrand()
    {
        return view('admin.backend.brand.brand_add');
    }
    
    // Store Brand
    public function storeBrand(Request $request)
    {
        // Validate the request
        $request->validate([
            'brand_name' => 'required|string|max:255',
            'brand_name' => 'required|image|mimes:png,jpeg,jpg|max:2048',
        ], [
            'brand_name.required' => 'You must upload a category image',
            'brand_name.image' => 'The category image must be an image',
            'brand_name.mimes' => 'The category image must be a file of type: jpeg, jpg, png',
            'brand_name.max' => 'The category image size must be less than 2MB',
        ]);

        try {
            $image = $request->file('brand_image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $image_path = 'upload/brand_image/' . $name_gen;
            Image::make($image)->resize(300, 300)->save(public_path($image_path));
            $save_url = $image_path;
    
            // Create The rand
            Brand::create([
                'brand_name' => ucwords($request->brand_name),
                'brand_slug' => strtolower(str_replace(' ', '-', $request->brand_name)),
                'brand_image' => $save_url,
            ]);
    
            // Success message notification
            $not_succ = [
                'message' => 'Brand Created Successfully',
                'alert-type' => 'success',
            ];
    
            return redirect()->route('all.brand')->with($not_succ);

        } catch (\Exception $e) {
            // Handle errors, log them, and return an error response
            $not_error = [
                'message' => 'An error occurred while saving the brand' . $e->getMessage(),
                'alert-type' => 'error',
            ];

            return redirect()->back()->with($not_error);
        }
    }

    // Edit Brand
    public function editBrand($id)
    {
        $editBrand = Brand::findOrFail($id);
        return view('admin.backend.brand.brand_edit', compact('editBrand'));
    }

    // Update brand
    public function updateBrand(Request $request)
    {
        $brand_id = $request->id;
        $old_image = $request->old_image;

        $request->validate([
            'brand_name' => 'required|string',
        ]);

        try {
            if ($request->hasFile('brand_image')) {
                $image = $request->file('brand_image');
                $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
                $image_path = 'upload/brand_image/' . $name_gen;
                Image::make($image)->resize(300, 300)->save(public_path($image_path));

                if (file_exists($old_image)) {
                    unlink($old_image);
                }

                $save_url = $image_path;
            } else {
                // Use the old image if no new image is uploaded.
                $save_url = $old_image; 
            }

            // Update the brand
            Brand::findOrFail($brand_id)->update([
                'brand_name' => ucwords($request->brand_name),
                'brand_slug' => strtolower(str_replace(' ', '-', $request->brand_name)),
                'brand_image' => $save_url,
            ]);

            // Success message notification
            if ($request->file('brand_image')) {
                $message = 'Brand Updated with Image Successfully';
                $alertType = 'success';
            } else {
                // Info message notification
                $message = 'Brand Updated without Image Successfully';
                $alertType = 'info';
            }
            $notification = [
                'message' => $message,
                'alert-type' => $alertType,
            ];
        } catch (\Exception $e) {
            // Error message notification
            $not_error = [
                'message' => 'Error updating brand' . $e->getMessage(),
                'alert-type' => 'error',
            ];

            return redirect()->back()->with($not_error);
        }
        return redirect()->route('all.brand')->with($notification);
    }

    // Delete Brand
    public function deleteBrand($id)
    {
        try {
            $deleteBrand = Brand::findOrFail($id);
            $img = $deleteBrand->brand_image;
            unlink($img);

            $deleteBrand->delete();

            // Success message notification
            $not_succ = [
                'message' => 'Brand Deleted Successfully',
                'alert-type' => 'success',
            ];
        } catch (\Exception $e) {
            // Error message notification
            $not_error = [
                'message' => 'Error deleting brand' . $e->getMessage(),
                'alert-type' => 'error',
            ];
            return redirect()->back()->with($not_error);
        }
        
        return redirect()->route('all.brand')->with($not_succ);
    }
}
