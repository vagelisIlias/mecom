<?php

namespace App\Http\Controllers\Backend;

use Intervention\Image\Facades\Image;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Models\SubCategory;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
use App\Models\MultiImage;
use App\Models\User;
use App\Models\TemporaryFile;
use Illuminate\Support\Facades\Log;


class ProductController extends Controller
{
    // All Products
    public function allProduct()
    {
        $allProduct = Product::latest()->get();
        return view('backend.product.product_all', compact('allProduct'));
    }

    // Add Product
    public function addProduct()
    {   
        $activeVendor = User::where('status', 'active')
                                ->where('role', 'vendor')
                                ->latest()
                                ->get();    
        $brands = Brand::latest()->get();
        $categories = Category::latest()->get();
        $subcategories = SubCategory::latest()->get();
        return view('backend.product.product_add', compact('brands','categories','subcategories','activeVendor'));
    }

    // Store Product
    public function storeProduct(Request $request)
    {   
        $tmp_file = TemporaryFile::where('folder', $request->image)->first(); 
        try {
            if($tmp_file){
                $image = $request->file('product_thambnail');
                $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
                $image_path = 'upload/products/thambnail/' . $name_gen;
                Image::make($image)->resize(800, 800)->save(public_path($image_path));
                $save_url = $image_path;
            }
            
            // Create Product
            $product = Product::create([
                'product_name' => ucwords($request->product_name),
                'product_short_description' => ucfirst($request->product_short_description),
                'product_long_description' => $request->product_long_description,
                'product_thambnail' => $save_url,
                'product_price' => $request->product_price,
                'product_discount' => $request->product_discount,
                'product_code' => $request->product_code,
                'product_qty' => $request->product_qty,
                'product_brand_id' => $request->product_brand_id,
                'product_category_id' => $request->product_category_id,
                'product_subcategory_id' => $request->product_subcategory_id,
                'product_vendor_id' => $request->product_vendor_id,
                'product_color' => $request->product_color,
                'product_size' => $request->product_size,
                'product_tags' => $request->product_tags,
                'product_hot_deals' => $request->product_hot_deals,
                'product_featured' => $request->product_featured,
                'product_special_offer' => $request->product_special_offer,
                'product_special_deals' => $request->product_special_deals,
                'product_status' => 'active',
                'product_slug' => strtolower(str_replace(' ', '-', $request->product_name)),
            ]);

            // Image validaation
            $request->validate([
                'multi_image' => 'required',
            ]);

            // Retrieve the product's ID from the model instance
            $product_id = $product->id;

            // Multiple Images
            $umlti_images = $request->file('multi_image');
            foreach($umlti_images as $img) 
            {
                $make_name = hexdec(uniqid()) . '.' . $img->getClientOriginalExtension();
                $multi_image_path = 'upload/products/multi_image/' . $make_name;
                Image::make($img)->resize(800, 800)->save(public_path($multi_image_path));
                $save_multi_url = $multi_image_path;

                MultiImage::create([
                    'product_id' => $product_id,
                    'multi_image' => $save_multi_url,
                ]);
            }

            // Success message notification
            $not_succ = [
                'message' => 'Product Created Successfully',
                'alert-type' => 'success',
            ];

            return redirect()->route('all.product')->with($not_succ);

        } catch (\Exception $e){
            // Handle errors, log them, and return an error response
            $not_error = [
                'message' => 'An error occurred while saving the product' . $e->getMessage(),
                'alert-type' => 'error',
            ];

            return redirect()->back()->with($not_error);
        }
    }

    // Creating a route for temporary images 
    public function tmpThumbnailImage(Request $request)
    {
        if ($request->hasFile('product_thambnail')) {
            $image = $request->file('product_thambnail');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $image_path = 'upload/tmp/' . $name_gen;
            Image::make($image)->resize(800, 800)->save(public_path($image_path));
            
            // Store the image in the public/upload/products/thambnail directory
            $image->move(public_path($image_path), $name_gen);
        
            // Create a record in your database if needed
            TemporaryFile::create([
                'folder' => $image_path,
                'file' => $name_gen
            ]);
        
            return $$save_ur;
        }

        // Return an empty string as text/plain response is required
        return '';
    }

    // Create Method to Check Product Name Existence in Database
    public function checkProductExistence(Request $request)
    {
        try
            {
            // Retrieve the product name and product_vendor_id from the request
            $productName = $request->product_name;

            // Initialize the vendorShopName variable
            $vendorShopName = '';

            // Check if a product with the same name already exists
            $exists = Product::where('product_name', $productName)
                                ->exists();

            if ($exists) {
                // Get the vendor ID associated with the product
                $product = Product::where('product_name', $productName)->first();
                $vendorId = $product->product_vendor_id;

                // Get the vendor's shop name based on the vendor ID
                $vendor = User::find($vendorId);
                $vendorShopName = $vendor->vendor_shop_name;
            } 

            // Return a JSON response indicating whether the product exists and the vendor's shop name
            return response()->json(['exists' => $exists, 'vendor_shop_name' => $vendorShopName]);

        } catch (\Exception $e){
            return response()->json(['error' => 'An error occurred while checking product existence.']);
        }        
    }

    // Edit Product
    public function editProduct($id)
    {   
        // Return all the Models 
        $activeVendor = User::where('status', 'active')
                                ->where('role', 'vendor')
                                ->latest()
                                ->get();    
        $brands = Brand::latest()->get();
        $categories = Category::latest()->get();
        $subcategories = SubCategory::latest()->get();
        $product = Product::findOrFail($id);
        $mutliImages = MultiImage::where('product_id', $product->id)
                                    ->get();
        return view('backend.product.product_edit', compact('brands','categories','subcategories','activeVendor', 'product', 'mutliImages'));
    }

    // Update Product
    public function updateProduct(Request $request)
    {
        try{
            // Update the product using the validated data
            $product_id = $request->id;
            $old_thambnail = $request->old_thambnail;

            // validate the image
            $request->validate([
                'product_thambnail' => 'nullable|image|mimes:png,jpeg,jpg|max:2048',
            ],
            [
                'product_thambnail.image' => 'The image you trying to upload is not valid or the format is not supported. Make sure the maximum file size is 2MB',
                'product_thambnail.max' => 'The image size must be less than 2MB, please resize the image and try again',
            ]);

            // Checking the image existance and creating path
            if ($request->hasFile('product_thambnail')) {
                $image = $request->file('product_thambnail');
                $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
                $image_path = 'upload/products/thambnail/' . $name_gen;

                // Resize and save the image
                Image::make($image)->resize(800, 800)
                                ->save(public_path($image_path));

                $save_url = file_exists($old_thambnail) ? (unlink($old_thambnail) ? $image_path : $old_thambnail) : $image_path;    
            };
           
            // Create Product
            Product::findOrFail($product_id)->update([
                'product_name' => ucwords($request->product_name),
                'product_short_description' => ucfirst($request->product_short_description),
                'product_long_description' => $request->product_long_description,
                'product_thambnail' => $save_url,
                'product_price' => $request->product_price,
                'product_discount' => $request->product_discount,
                'product_code' => $request->product_code,
                'product_qty' => $request->product_qty,
                'product_brand_id' => $request->product_brand_id,
                'product_category_id' => $request->product_category_id,
                'product_subcategory_id' => $request->product_subcategory_id,
                'product_vendor_id' => $request->product_vendor_id,
                'product_color' => $request->product_color,
                'product_size' => $request->product_size,
                'product_tags' => $request->product_tags,
                'product_hot_deals' => $request->product_hot_deals,
                'product_featured' => $request->product_featured,
                'product_special_offer' => $request->product_special_offer,
                'product_special_deals' => $request->product_special_deals,
                'product_slug' => strtolower(str_replace(' ', '-', $request->product_name)),
            ]);

            // // Validate the image
            // $request->validate([
            //     "multi_image.*" => "nullable|image|mimes:png,jpeg,jpg|max:2048",
            // ], [
            //     "multi_image.*.image" => 'One or more multi images you are trying to upload are not valid or the format is not supported. Make sure the maximum file size is 2MB',
            //     "multi_image.*.max" => 'One or more multi images size must be less than 2MB, please resize the image and try again',
            // ]);

            // // Requested the multi images
            // $multi_images = $request->multi_image;

            // foreach($multi_images as $id => $multi_img) 
            // {   
            //     $imgFindOrFail = MultiImage::findOrFail($id);

            //     // Checking the image existance and creating path
            //     if ($multi_img) {
            //         // Generate a unique file name
            //         $make_name = hexdec(uniqid()) . '.' . $multi_img->getClientOriginalExtension();
            //         $multi_image_path = 'upload/products/multi_image/' . $make_name;

            //         // Resize and save the image
            //         Image::make($multi_img)->resize(800, 800)
            //                     ->save(public_path($multi_image_path));

            //         // Checking if the image exists and unlink it
            //         $save_multi_url = file_exists($imgFindOrFail->multi_image) ? (unlink($imgFindOrFail->multi_image) ? $multi_image_path : $multi_img) : $multi_img;
                    
            //         $imgFindOrFail->where("id", $id)->update([
            //             'multi_image' => $save_multi_url,
            //         ]);
            //     }
            // }

            //Set the success message
            $message = $request->hasFile('product_thambnail')
            ? 'Product with Image Updated Successfully'
            : 'Product without Image Updated Successfully';

            $alertType = $request->hasFile('product_thambnail') ? 'success' : 'info';

            $notification = [
                'message' => $message,
                'alert-type' => $alertType,
            ];

            return redirect()->route('all.product')->with($notification);

            return redirect()->route('all.product');
        } catch (\Exception $e) {
            // Handle errors, log them, and return an error response
            $not_error = [
                'message' => ' ' . $e->getMessage(),
                'alert-type' => 'error',
            ];

            return redirect()->back()->with($not_error);
        }
    }
}
