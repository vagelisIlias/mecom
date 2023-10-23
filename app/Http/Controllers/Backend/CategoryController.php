<?php

namespace App\Http\Controllers\Backend;

use Intervention\Image\Facades\Image;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use App\Models\Category;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    // All Category
    public function allCategory()
    {   
        // Checking the latest data added
        $allCategory = Category::latest()->get();
        return view('admin.backend.category.category_all', compact('allCategory'));
    }

    // Add Category
    public function addCategory()
    {
        return view('admin.backend.category.category_add');
    }

    // Store Category
    public function storeCategory(Request $request)
    {
        // Validate the request
        $request->validate([
            'category_name' => 'required|string|max:255',
        ]);

        try {
            $image = $request->file('category_image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $image_path = 'upload/category_image/' . $name_gen;
            Image::make($image)->resize(120, 120)->save(public_path($image_path));
            $save_url = $image_path;
    
            // Create The category
            Category::create([
                'category_name' => ucwords($request->category_name),
                'category_slug' => strtolower(str_replace(' ', '-', $request->category_name)),
                'category_image' => $save_url,
            ]);
    
            // Success message notification
            $not_succ = [
                'message' => 'Category Created Successfully',
                'alert-type' => 'success',
            ];
    
            return redirect()->route('all.category')->with($not_succ);

        } catch (\Exception $e) {
            // Handle errors, log them, and return an error response
            $not_error = [
                'message' => 'An error occurred while saving the category' . $e->getMessage(),
                'alert-type' => 'error',
            ];

            return redirect()->back()->with($not_error);
        }
    }

    //Edit Category
    public function editCategory($id)
    {
        $editCategory = Category::findOrFail($id);
        return view('admin.backend.category.category_edit', compact('editCategory'));
    }

    // Update Category
    public function updateCategory(Request $request)
    {
        $category_id = $request->id;
        $old_image = $request->old_image;

        $request->validate([
            'category_name' => 'required|string',
        ]);

        try {
            if ($request->hasFile('category_image')) {
                $image = $request->file('category_image');
                $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
                $image_path = 'upload/category_image/' . $name_gen;
                Image::make($image)->resize(120, 120)->save(public_path($image_path));

                if (file_exists($old_image)) {
                    unlink($old_image);
                }

                $save_url = $image_path;
            } else {
                // Use the old image if no new image is uploaded.
                $save_url = $old_image; 
            }

            // Update the brand
            Category::findOrFail($category_id)->update([
                'category_name' => ucwords($request->category_name),
                'category_slug' => strtolower(str_replace(' ', '-', $request->category_name)),
                'category_image' => $save_url,
            ]);

            // Success message notification
            if ($request->file('category_image')) {
                $message = 'Category Updated with Image Successfully';
                $alertType = 'success';
            } else {
                // Info message notification
                $message = 'Category Updated without Image Successfully';
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
        return redirect()->route('all.category')->with($notification);
    }

    // Delete category
    public function deleteCategory($id)
    {
        try {
            $deleteCategory = Category::findOrFail($id);
            $img = $deleteCategory->category_image;
            unlink($img);

            $deleteCategory->delete();

            // Success message notification
            $not_succ = [
                'message' => 'Category Deleted Successfully',
                'alert-type' => 'success',
            ];
        } catch (\Exception $e) {
            // Error message notification
            $not_error = [
                'message' => 'Error deleting category' . $e->getMessage(),
                'alert-type' => 'error',
            ];
            return redirect()->back()->with($not_error);
        }
        
        return redirect()->route('all.category')->with($not_succ);
    }

}


