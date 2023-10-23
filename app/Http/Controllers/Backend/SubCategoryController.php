<?php

namespace App\Http\Controllers\Backend;

use Intervention\Image\Facades\Image;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use App\Models\SubCategory;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class SubCategoryController extends Controller
{
    // All SubCategory
    public function allSubCategory()
    {   
        // Creating a join to subcategory and category
        $allSubCategory = SubCategory::with('category')
                ->orderBy('created_at', 'desc')
                ->get();
                //dd($allSubCategory);

        return view('admin.backend.subcategory.subcategory_all', compact('allSubCategory'));
    }


    // Add SubCategory
    public function addSubCategory()
    {   
        $categories = Category::orderBy('category_name', 'asc')->get();
        return view('admin.backend.subcategory.subcategory_add', compact('categories'));
    }

    // Store SubCategory
    public function storeSubCategory(Request $request)
    {
        // Validate the request
        $request->validate([
            'category_id' => 'required',
            'sub_category_name' => 'required|string|max:255',
        ]);
        
        try {
            // Create method to save the into subcategory
            SubCategory::create([
                'category_id' => $request->category_id,
                'sub_category_name' => ucwords($request->sub_category_name),
                'sub_category_slug' => strtolower(str_replace(' ', '-', $request->sub_category_name)),
            ]);
    
            // Success message notification
            $not_succ = [
                'message' => 'Sub Category Created Successfully',
                'alert-type' => 'success',
            ];
    
            return redirect()->route('all.subcategory')->with($not_succ);

        } catch (\Exception $e) {
            // Handle errors, log them, and return an error response
            $not_error = [
                'message' => 'An error occurred while saving the subcategory' . $e->getMessage(),
                'alert-type' => 'error',
            ];

            return redirect()->back()->with($not_error);
        }
    }

    // Edit Sub Category
    public function editSubcategory($id)
    {   
        // Retrieve a list of categories and order them by name in ascending order
        $categories = Category::orderBy('category_name', 'asc')->get();
        
        // Find the subcategory to be edited based on the provided $id
        $editSubcategory = SubCategory::findOrFail($id);

        // Return a view for editing the subcategory, passing the subcategory and categories as data
        return view('admin.backend.subcategory.subcategory_edit', compact('editSubcategory', 'categories'));
    }


    // Update Sub Category
    public function updateSubcategory(Request $request)
    {   
        // Request the id of the subcategory
        $subcat_id = $request->id;

        // Validate the request
        $request->validate([
            'category_id' => 'required',
            'sub_category_name' => 'required|string|max:255',
        ]);

        try {
            // Update the the subcategory
            SubCategory::findOrFail($subcat_id)->update([
                'category_id' => $request->category_id,
                'sub_category_name' => ucwords($request->sub_category_name),
                'sub_category_slug' => strtolower(str_replace(' ', '-', $request->sub_category_name)),
            ]);

            // Success message notification
            $not_succ = [
                'message' => 'Sub Category Updated Successfully',
                'alert-type' => 'success',
            ];

        } catch(\Exception $e){
            // Error message notification
            $not_error = [
                'message' => 'Error updating subcategory' . $e->getMessage(),
                'alert-type' => 'error',
            ];

            return redirect()->back()->with($not_error);
        }

        return redirect()->route('all.subcategory')->with($not_succ);
    }

    // Delete Sub Category
    public function deleteSubCategory($id)
    {
        try {
            // Find or fail the id
            $deleteSubCategory = SubCategory::findOrFail($id);
          
            // Delete the subcategory with specific id
            $deleteSubCategory->delete();

            // Success message notification
            $not_succ = [
                'message' => 'Sub Category Deleted Successfully',
                'alert-type' => 'success',
            ];
        } catch(\Exception $e) {
            // Error message notification
            $not_error = [
                'message' => 'Error deleting subcategory' . $e->getMessage(),
                'alert-type' => 'error',
            ];
            return redirect()->back()->with($not_error);
        }

        return redirect()->route('all.subcategory')->with($not_succ);
    }

    // Return the list of subcategories when category picked
    public function getSubCategoryAjax($category_id)
    {
        $subcat = SubCategory::where('category_id', $category_id)  
                                ->orderBy('sub_category_name', 'asc')
                                ->get();
        return json_encode($subcat);                        
    }
}
