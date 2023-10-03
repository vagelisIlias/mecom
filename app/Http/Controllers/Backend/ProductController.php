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
        try {
            $image = $request->file('product_thambnail');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $image_path = 'upload/products/thambnail/' . $name_gen;
            Image::make($image)->resize(800, 800)->save(public_path($image_path));
            $save_url = $image_path;

            // Create Product
            $product = Product::create([
                'product_name' => ucwords($request->product_name),
                'product_short_description' => ucfirst($request->product_short_description),
                'product_long_description' => ucfirst($request->product_long_description),
                'product_thambnail' => $save_url,
                'product_price' => $request->product_price,
                'product_discount' => $request->product_discount,
                'product_code' => $request->product_code,
                'product_qty' => $request->product_qty,
                'product_brand_id' => $request->product_brand_id,
                'product_category_id' => $request->product_category_id,
                'product_subcategory_id' => $request->product_subcategory_id,
                'product_vendor_id' => $request->product_vendor_id,
                'product_color' => ucwords($request->product_color),
                'product_size' => ucwords($request->product_size),
                'product_tags' => $request->product_tags,
                'product_hot_deals' => $request->product_hot_deals,
                'product_featured' => $request->product_featured,
                'product_special_offer' => $request->product_special_offer,
                'product_special_deals' => $request->product_special_deals,
                'product_status' => 1,
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
}
