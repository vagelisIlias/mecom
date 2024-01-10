<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\MultiImage;
use App\Models\Product;
use App\Models\SubCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{
    // All Products
    public function allProduct()
    {
        $allProduct = Product::latest()->get();

        return view('admin.backend.product.product_all', compact('allProduct'));
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

        return view('admin.backend.product.product_add', compact('brands', 'categories', 'subcategories', 'activeVendor'));
    }

    // Store Product
    public function storeProduct(Request $request)
    {
        try {
            // Initialize $save_url variable
            $save_url = null;
            $save_multi_url = null;

            // Validate thumbnail image
            $request->validate([
                'product_thambnail' => 'required|image|mimes:png,jpeg,jpg|max:2048',
            ], [
                'product_thambnail.required' => 'You must upload a thumbnail image',
                'product_thambnail.image' => 'The thumbnail must be an image',
                'product_thambnail.mimes' => 'The thumbnail must be a file of type: jpeg, jpg, png',
                'product_thambnail.max' => 'The thumbnail size must be less than 2MB',
            ]);

            // Validate multi-images
            $request->validate([
                'multi_image' => 'required|array|max:7',
                'multi_image.*' => 'image|mimes:png,jpeg,jpg|max:2048',
            ], [
                'multi_image.required' => 'You must upload one or more multi images',
                'multi_image.array' => 'The multi_image must be an array',
                'multi_image.max' => 'You can upload up to 7 multi images',
                'multi_image.*.image' => 'One or more images you are trying to upload are not valid or the format is not supported',
                'multi_image.*.mimes' => 'One or more images must be of type: jpeg, jpg, png',
                'multi_image.*.max' => 'One or more images size must be less than 2MB, please resize the image and try again',
            ]);

            // Request the product to check if is valid
            if ($request->hasFile('product_thambnail')) {
                $image = $request->file('product_thambnail');
                $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
                $tham_image_path = 'upload/products/thambnail/'.$name_gen;
                Image::make($image)->resize(800, 800)->save(public_path($tham_image_path));
                $save_url = $tham_image_path;
                // Create Product
                $product = Product::create([
                    'product_name' => ucwords($request->product_name),
                    'product_short_description' => ucfirst($request->product_short_description),
                    'product_long_description' => strip_tags($request->product_long_description),
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

                // Request if the image is valid
                if ($request->hasFile('multi_image')) {
                    $product_id = $product->id;
                    // Looping though images
                    foreach ($request->file('multi_image') as $multi_img) {
                        $name_gen = hexdec(uniqid()).'.'.$multi_img->getClientOriginalExtension();
                        $multi_image_path = 'upload/products/multi_image/'.$name_gen;
                        Image::make($multi_img)->resize(800, 800)->save(public_path($multi_image_path));
                        $save_multi_url = $multi_image_path;

                        MultiImage::create([
                            'product_id' => $product_id,
                            'multi_image' => $save_multi_url,
                        ]);
                    }
                }
                // Success message notification
                $not_succ = [
                    'message' => 'Product Created Successfully',
                    'alert-type' => 'success',
                ];

                return redirect()->route('all.product')->with($not_succ);
            }
        } catch (\Exception $e) {
            // Handle errors, log them, and return an error response
            $not_error = [
                'message' => ''.$e->getMessage(),
                'alert-type' => 'error',
            ];

            return redirect()->back()->with($not_error);
        }
    }

    // Create Method to Check Product Name Existence in Database
    public function checkProductExistence(Request $request)
    {
        try {
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

        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while checking product existence']);
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

        return view('admin.backend.product.product_edit', compact('brands', 'categories', 'subcategories', 'activeVendor', 'product', 'mutliImages'));
    }

    // Update Product
    public function updateProduct(Request $request)
    {
        try {
            // Update the product using id and old thumbnail declared as a hidden parameter
            $product_id = $request->id;
            $old_thambnail = $request->old_thambnail;

            // validate the image
            $request->validate([
                'product_thambnail' => 'nullable|image|mimes:png,jpeg,jpg|max:2048',
            ],
                [
                    'product_thambnail.image' => 'The image you trying to upload is not valid or the format is not supported',
                    'product_thambnail.max' => 'The image size must be less than 2MB, please resize the image and try again',
                ]);

            // Checking the image existence and creating path
            if ($request->hasFile('product_thambnail')) {
                $image = $request->file('product_thambnail');
                $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
                $image_path = 'upload/products/thambnail/'. $name_gen;
                if (file_exists($old_thambnail)) {
                    unlink($old_thambnail);
                }
                // Resize and save the image
                Image::make($image)->resize(800, 800)
                    ->save(public_path($image_path));
                // Save the image
                $save_url = $image_path;
            } else {
                $save_url = $old_thambnail;
            }

            // Find or fail the id of the product
            $product = Product::findOrFail($product_id);

            // Update the Product
            $product->update([
                'product_name' => ucwords($request->product_name),
                'product_short_description' => ucfirst($request->product_short_description),
                'product_long_description' => strip_tags($request->product_long_description),
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

            // Validate the multi image
            $request->validate([
                'multi_image.*' => 'nullable|image|mimes:png,jpeg,jpg|max:2048',
            ], [
                'multi_image.*.image' => 'One or more images you are trying to upload are not valid or the format is not supported',
                'multi_image.*.max' => 'One or more images size must be less than 2MB, please resize the image and try again',
            ]);

            // Checking if the multi image is valid
            if ($request->hasFile('multi_image')) {
                // Checking the id of the product to much the id fro the product_id from multi images
                $product_id = $product->id;
                // Loop through the product images and passing
                foreach ($request->file('multi_image') as $multi_img) {
                    $name_gen = hexdec(uniqid()).'.'.$multi_img->getClientOriginalExtension();
                    $multi_image_path = 'upload/products/multi_image/'.$name_gen;
                    Image::make($multi_img)->resize(800, 800)->save(public_path($multi_image_path));
                    $save_multi_url = $multi_image_path;
                    // Create new image store
                    MultiImage::create([
                        'product_id' => $product_id,
                        'multi_image' => $save_multi_url,
                    ]);
                }
            }

            // Set the success message
            if ($request->hasFile('product_thambnail') || $request->hasFile('multi_image')) {
                $alertType = 'success';
                $message = 'Product with Image Updated Successfully';
            } else {
                $alertType = 'info';
                $message = 'Product without Image Updated Successfully';
            }
            $notification = [
                'message' => $message,
                'alert-type' => $alertType,
            ];

            return redirect()->route('all.product')->with($notification);
        } catch (\Exception $e) {
            // Handle errors, log them, and return an error response
            $not_error = [
                'message' => ' '.$e->getMessage(),
                'alert-type' => 'error',
            ];

            return redirect()->back()->with($not_error);
        }
    }

    // Delete Multi Images
    public function deleteMultiImage($id)
    {
        try {
            // Find or fail the id
            $deleteMultiImage = MultiImage::findOrFail($id);
            $img = $deleteMultiImage->multi_image;
            unlink($img);

            // Delete the Thambnail
            $deleteMultiImage->delete();

            // Success message notification
            $not_succ = [
                'message' => 'Image Deleted Successfully',
                'alert-type' => 'success',
            ];

            return redirect()->back()->with($not_succ);
        } catch (\Exception $e) {
            // Error message notification
            $not_error = [
                'message' => 'Error deleting image'.$e->getMessage(),
                'alert-type' => 'error',
            ];

            return redirect()->back()->with($not_error);
        }
    }

    // Delete Product
    public function deleteProduct($id)
    {
        try {
            // Find the product and associated multi-images
            $product = Product::findOrFail($id);

            // Checking the Method in the Product Model
            $all_images = MultiImage::where('product_id', $id)->get();

            // Delete the multi-images
            foreach ($all_images as $image) {
                $multiImagePath = $image->multi_image;
                if (file_exists($multiImagePath)) {
                    unlink($multiImagePath);
                }
                $image->delete();
            }

            // Unlink the Product Thambnail Image
            $productThambnailPath = $product->product_thambnail;
            if (file_exists($productThambnailPath)) {
                unlink($productThambnailPath);
            }

            // Delete the product
            $product->delete();

            // Success message notification
            $notification = [
                'message' => 'Product and Related Images Deleted Successfully',
                'alert-type' => 'success',
            ];

            return redirect()->back()->with($notification);
        } catch (\Exception $e) {
            // Error message notification
            $errorNotification = [
                'message' => 'Error deleting product: '.$e->getMessage(),
                'alert-type' => 'error',
            ];

            return redirect()->back()->with($errorNotification);
        }
    }

    // Change Product Status
    public function changeProductStatus($id)
    {
        $changeProductStatus = Product::findOrFail($id);

        if ($changeProductStatus->product_status == 'inactive') {
            $changeProductStatus->update([
                'product_status' => 'active',
            ]);

            // Pass the success message
            $not_succ = [
                'message' => 'Product has been Activated Successfully',
                'alert-type' => 'success',
            ];
        } else {
            $changeProductStatus->update([
                'product_status' => 'inactive',
            ]);

            // Pass the success message
            $not_succ = [
                'message' => 'Product has been Deactivated Successfully',
                'alert-type' => 'success',
            ];
        }

        return redirect()->route('all.product')->with($not_succ);
    }
}
