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
        // Validate thumbnail image
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
    
            // Create The category
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

    // //Edit Category
    // public function editCategory($id)
    // {
    //     $editCategory = Category::findOrFail($id);
    //     return view('admin.backend.category.category_edit', compact('editCategory'));
    // }

    // // Update Category
    // public function updateCategory(Request $request)
    // {
    //     $category_id = $request->id;
    //     $old_image = $request->old_image;

    //     $request->validate([
    //         'category_name' => 'required|string',
    //     ]);

    //     try {
    //         if ($request->hasFile('category_image')) {
    //             $image = $request->file('category_image');
    //             $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
    //             $image_path = 'upload/category_image/' . $name_gen;
    //             Image::make($image)->resize(120, 120)->save(public_path($image_path));

    //             if (file_exists($old_image)) {
    //                 unlink($old_image);
    //             }

    //             $save_url = $image_path;
    //         } else {
    //             // Use the old image if no new image is uploaded.
    //             $save_url = $old_image; 
    //         }

    //         // Update the brand
    //         Category::findOrFail($category_id)->update([
    //             'category_name' => ucwords($request->category_name),
    //             'category_slug' => strtolower(str_replace(' ', '-', $request->category_name)),
    //             'category_image' => $save_url,
    //         ]);

    //         // Success message notification
    //         if ($request->file('category_image')) {
    //             $message = 'Category Updated with Image Successfully';
    //             $alertType = 'success';
    //         } else {
    //             // Info message notification
    //             $message = 'Category Updated without Image Successfully';
    //             $alertType = 'info';
    //         }
    //         $notification = [
    //             'message' => $message,
    //             'alert-type' => $alertType,
    //         ];
    //     } catch (\Exception $e) {
    //         // Error message notification
    //         $not_error = [
    //             'message' => 'Error updating brand' . $e->getMessage(),
    //             'alert-type' => 'error',
    //         ];

    //         return redirect()->back()->with($not_error);
    //     }
    //     return redirect()->route('all.category')->with($notification);
    // }

    // // Delete category
    // public function deleteCategory($id)
    // {
    //     try {
    //         $deleteCategory = Category::findOrFail($id);
    //         $img = $deleteCategory->category_image;
    //         unlink($img);

    //         $deleteCategory->delete();

    //         // Success message notification
    //         $not_succ = [
    //             'message' => 'Category Deleted Successfully',
    //             'alert-type' => 'success',
    //         ];
    //     } catch (\Exception $e) {
    //         // Error message notification
    //         $not_error = [
    //             'message' => 'Error deleting category' . $e->getMessage(),
    //             'alert-type' => 'error',
    //         ];
    //         return redirect()->back()->with($not_error);
    //     }
        
    //     return redirect()->route('all.category')->with($not_succ);
    // }
}
