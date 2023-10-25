<?php

namespace App\Http\Controllers\Backend;

use Intervention\Image\Facades\Image;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;

class BannerController extends Controller
{
    // All Banner
    public function allBanner()
    {
        $allBanner = Banner::latest()->get();
        return view('admin.backend.banner.banner_all', compact('allBanner'));
    }

    // Add Slider
    public function addBanner()
    {
        return view('admin.backend.banner.banner_add');
    }

    // Store Banner
    public function storeBanner(Request $request)
    {
        // Validate banner image
        $request->validate([
            'banner_image' => 'required|string|max:255',
            'banner_image' => 'required|image|mimes:png,jpeg,jpg|max:2048',
        ], [
            'banner_image.required' => 'You must upload a category image',
            'banner_image.image' => 'The category image must be an image',
            'banner_image.mimes' => 'The category image must be a file of type: jpeg, jpg, png',
            'banner_image.max' => 'The category image size must be less than 2MB',
        ]);

        try {
            $image = $request->file('banner_image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $image_path = 'upload/banner_image/' . $name_gen;
            Image::make($image)->resize(768, 450)->save(public_path($image_path));
            $save_url = $image_path;
    
            // Create The Banner
            Banner::create([
                'banner_title' => ucfirst($request->banner_title),
                'banner_url' => ucfirst($request->banner_url),
                'banner_image' => $save_url,
            ]);
    
            // Success message notification
            $not_succ = [
                'message' => 'Banner Created Successfully',
                'alert-type' => 'success',
            ];
    
            return redirect()->route('all.banner')->with($not_succ);

        } catch (\Exception $e) {
            // Handle errors, log them, and return an error response
            $not_error = [
                'message' => 'An error occurred while saving the banner' . $e->getMessage(),
                'alert-type' => 'error',
            ];

            return redirect()->back()->with($not_error);
        }
    }

    // Edit Banner
    public function editBanner($id)
    {
        $editBanner = Banner::findOrFail($id);
        return view('admin.backend.banner.banner_edit', compact('editBanner'));
    }

    // Update Banner
    public function updateBanner(Request $request)
    {
        $banner_id = $request->id;
        $old_image = $request->old_image;

        $request->validate([
            'banner_title' => 'required|string',
            'banner_url' => 'required|string',
        ]);

        try {
            if ($request->hasFile('banner_image')) {
                $image = $request->file('banner_image');
                $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
                $image_path = 'upload/banner_image/' . $name_gen;
                Image::make($image)->resize(768, 450)->save(public_path($image_path));

                if (file_exists($old_image)) {
                    unlink($old_image);
                }

                $save_url = $image_path;
            } else {
                // Use the old image if no new image is uploaded.
                $save_url = $old_image; 
            }

            // Update the brand
            Banner::findOrFail($banner_id)->update([
                'banner_title' => ucfirst($request->banner_title),
                'banner_url' => $request->banner_url,
                'banner_image' => $save_url,
            ]);

            // Success message notification
            if ($request->file('banner_image')) {
                $message = 'Banner Updated with Image Successfully';
                $alertType = 'success';
            } else {
                // Info message notification
                $message = 'Banner Updated without Image Successfully';
                $alertType = 'info';
            }
            $notification = [
                'message' => $message,
                'alert-type' => $alertType,
            ];
            return redirect()->route('all.banner')->with($notification);
        } catch (\Exception $e) {
            // Error message notification
            $not_error = [
                'message' => 'Error updating banner' . $e->getMessage(),
                'alert-type' => 'error',
            ];
            return redirect()->back()->with($not_error);
        }
    }

    // Delete category
    public function deleteBanner($id)
    {
        try {
            $deleteBanner = Banner::findOrFail($id);
            $img = $deleteBanner->banner_image;
            unlink($img);

            $deleteBanner->delete();

            // Success message notification
            $not_succ = [
                'message' => 'Banner Deleted Successfully',
                'alert-type' => 'success',
            ];
            return redirect()->route('all.banner')->with($not_succ);
        } catch (\Exception $e) {
            // Error message notification
            $not_error = [
                'message' => 'Error deleting banner' . $e->getMessage(),
                'alert-type' => 'error',
            ];
            return redirect()->back()->with($not_error);
        }
        
    }
}
