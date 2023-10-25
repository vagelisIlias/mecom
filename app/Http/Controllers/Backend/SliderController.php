<?php

namespace App\Http\Controllers\Backend;

use Intervention\Image\Facades\Image;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slider;


class SliderController extends Controller
{   
    // All Sliders
    public function allSlider()
    {
        $allSlider = Slider::latest()->get();
        return view('admin.backend.slider.slider_all', compact('allSlider'));
    }

    // Add Slider
    public function addSlider()
    {
        return view('admin.backend.slider.slider_add');
    }

    // Store Slider
    public function storeSlider(Request $request)
    {
        // Validate slider image
        $request->validate([
            'slider_image' => 'required|string|max:255',
            'slider_image' => 'required|image|mimes:png,jpeg,jpg|max:2048',
        ], [
            'slider_image.required' => 'You must upload a category image',
            'slider_image.image' => 'The category image must be an image',
            'slider_image.mimes' => 'The category image must be a file of type: jpeg, jpg, png',
            'slider_image.max' => 'The category image size must be less than 2MB',
        ]);

        try {
            $image = $request->file('slider_image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $image_path = 'upload/slider_image/' . $name_gen;
            Image::make($image)->resize(2376, 807)->save(public_path($image_path));
            $save_url = $image_path;
    
            // Create The slider
            Slider::create([
                'slider_title' => ucfirst($request->slider_title),
                'short_title' => ucfirst($request->short_title),
                'slider_image' => $save_url,
            ]);
    
            // Success message notification
            $not_succ = [
                'message' => 'Slider Created Successfully',
                'alert-type' => 'success',
            ];
    
            return redirect()->route('all.slider')->with($not_succ);

        } catch (\Exception $e) {
            // Handle errors, log them, and return an error response
            $not_error = [
                'message' => 'An error occurred while saving the slider' . $e->getMessage(),
                'alert-type' => 'error',
            ];

            return redirect()->back()->with($not_error);
        }
    }

    // Edit Slider
    public function editSlider($id)
    {
        $editSlider = Slider::findOrFail($id);
        return view('admin.backend.slider.slider_edit', compact('editSlider'));
    }

    // Update Slider
    public function updateSlider(Request $request)
    {
        $slider_id = $request->id;
        $old_image = $request->old_image;

        $request->validate([
            'slider_title' => 'required|string',
            'short_title' => 'required|string',
        ]);

        try {
            if ($request->hasFile('slider_image')) {
                $image = $request->file('slider_image');
                $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
                $image_path = 'upload/slider_image/' . $name_gen;
                Image::make($image)->resize(2376, 807)->save(public_path($image_path));

                if (file_exists($old_image)) {
                    unlink($old_image);
                }

                $save_url = $image_path;
            } else {
                // Use the old image if no new image is uploaded.
                $save_url = $old_image; 
            }

            // Update the slider
            Slider::findOrFail($slider_id)->update([
                'slider_title' => ucfirst($request->slider_title),
                'short_title' => ucfirst($request->short_title),
                'slider_image' => $save_url,
            ]);

            // Success message notification
            if ($request->file('slider_image')) {
                $message = 'Slider Updated with Image Successfully';
                $alertType = 'success';
            } else {
                // Info message notification
                $message = 'Slider Updated without Image Successfully';
                $alertType = 'info';
            }
            $notification = [
                'message' => $message,
                'alert-type' => $alertType,
            ];
            return redirect()->route('all.slider')->with($notification);
        } catch (\Exception $e) {
            // Error message notification
            $not_error = [
                'message' => 'Error updating slider' . $e->getMessage(),
                'alert-type' => 'error',
            ];
            return redirect()->back()->with($not_error);
        }
    }

    // Delete Slider
    public function deleteSlider($id)
    {
        try {
            $deleteSlider = Slider::findOrFail($id);
            $img = $deleteSlider->slider_image;
            unlink($img);

            $deleteSlider->delete();

            // Success message notification
            $not_succ = [
                'message' => 'Slider Deleted Successfully',
                'alert-type' => 'success',
            ];
            return redirect()->route('all.slider')->with($not_succ);
        } catch (\Exception $e) {
            // Error message notification
            $not_error = [
                'message' => 'Error deleting slider' . $e->getMessage(),
                'alert-type' => 'error',
            ];
            return redirect()->back()->with($not_error);
        }
        
    }
}
