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
    public function storeBrand(Request $request)
    {
        // Validate the request
        $request->validate([
            'brand_name' => 'required|string|max:255',
            'brand_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
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
            $not_succ = [
                'message' => 'Brand Inserted Successfully',
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
        return view('backend.brand.brand_edit', compact('editBrand'));
    }

    // Update brand
    public function updateBrand(Request $request)
    {
        $brand_id = $request->id;
        $old_image = $request->old_image;

        $request->validate([
            'brand_name' => 'required|string',
            'brand_image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            if ($request->hasFile('brand_image')) {
                $image = $request->file('brand_image');
                $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
                $image_path = 'upload/brand_image/' . $name_gen;
                Image::make($image)->resize(300, 300)->save(public_path($image_path));

                if (file_exists(public_path($old_image))) {
                    unlink(public_path($old_image));
                }

                $save_url = $image_path;
            } else {
                // Use the old image if no new image is uploaded.
                $save_url = $old_image; 
            }

            // Update the brand
            Brand::findOrFail($brand_id)->update([
                'brand_name' => $request->brand_name,
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
            $notification = [
                'message' => 'Error updating brand' . $e->getMessage(),
                'alert-type' => 'error',
            ];
        }

        return redirect()->route('all.brand')->with($notification);
    }

    // Delete Brand and the Image
    public function deleteBrand($id)
    {
        try {
            $deleteBrand = Brand::findOrFail($id);
            $img = $deleteBrand->brand_image;

            if (file_exists(public_path($img))) {
                unlink(public_path($img));
            }

            $deleteBrand->delete();

            // Success message notification
            $notification = [
                'message' => 'Brand Deleted Successfully',
                'alert-type' => 'success',
            ];
        } catch (\Exception $e) {
            // Error message notification
            $notification = [
                'message' => 'Error deleting brand: ' . $e->getMessage(),
                'alert-type' => 'error',
            ];
        }

        return redirect()->route('all.brand')->with($notification);
    }


}
