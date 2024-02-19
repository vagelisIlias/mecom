<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Backend\BannerController;
use App\Http\Controllers\Backend\BrandController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\SliderController;
use App\Http\Controllers\Backend\SubCategoryController;
use App\Http\Controllers\Backend\UserStatus;
use App\Http\Controllers\Backend\VendorStatus;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VendorBackend\VendorProductController;
use App\Http\Controllers\VendorController;
use App\Http\Middleware\RedirectIfAuthenticated;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Index
Route::get('/', function () {
    $categories = App\Models\Category::orderBy('category_name', 'asc')->get();
    $subcategories = App\Models\SubCategory::orderBy('sub_category_name', 'asc')->get();
    $slider = App\Models\Slider::orderBy('slider_title', 'asc')->get();
    $products = App\Models\Product::orderBy('product_name', 'asc')->get();
    $banners = App\Models\Banner::orderBy('banner_title', 'asc')->get();

    return view('frontend.index', compact('categories', 'subcategories', 'slider', 'products', 'banners'));
});

// User Dashboard
Route::middleware(['auth'])->group(function () {
    /**
     * User Dashboard
     * Middleware: auth
     */
    Route::get('/dashboard', [UserController::class, 'index'])->name('dashboard'); // REFACTORED!!!
    Route::patch('/update/profile/{user}', [UserController::class, 'updateProfile'])->name('user.profile.update'); // REFACTORED
    Route::get('/logout', [UserController::class, 'logout'])->name('user.logout'); // REFACTORED
    Route::patch('/update/password', [UserController::class, 'updatePassword'])->name('user.password.update'); // REFACTORED
});
/**
 * Vendor Dashboard
 * Middleware: auth role:vendor
 */
Route::middleware(['auth', 'role:vendor'])->group(function () {
    Route::get('/vendor/dashboard', [VendorController::class, 'index'])->name('vendor.dashboard')->middleware('status'); // REFACTORED
    Route::get('/vendor/logout', [VendorController::class, 'logout'])->name('vendor.logout'); // REFACTORED
    Route::get('/vendor/profile/{user:slug}', [VendorController::class, 'vendorProfile'])->name('vendor.profile'); // REFACTORED
    Route::patch('/vendor/update/profile/{user}', [VendorController::class, 'update'])->name('vendor.profile.update'); // REFACTORED
    Route::get('/vendor/change/password', [VendorController::class, 'vendorChangePassword'])->name('vendor.change.password'); // REFACTORED
    Route::patch('/vendor/update/password', [VendorController::class, 'vendorUpdatePassword'])->name('vendor.update.password'); // REFACTORED

    // Vendor Product Controller In Vendor Dashboard All && Add product
    Route::get('/all/vendor/product', [VendorProductController::class, 'allVendorProduct'])->name('all.vendor.product');
    Route::get('/add/vendor/product', [VendorProductController::class, 'addVendorProduct'])->name('add.vendor.product');
    Route::get('/vendor/subcategory/ajax/{category_id}', [VendorProductController::class, 'vendorGetSubCategoryAjax']);
    Route::post('/vendor/store/product', [VendorProductController::class, 'vendorStoreProduct'])->name('vendor.store.product');
    Route::post('/check/vendor/product/existence', [VendorProductController::class, 'checkVendorProductExistence'])->name('check.vendor.product.existence');
    Route::get('/edit/vendor/product/{id}', [VendorProductController::class, 'editVendorProduct'])->name('edit.vendor.product');
    Route::get('/change/vendor/product/status/{id}', [VendorProductController::class, 'changeVendorProductStatus'])->name('change.vendor.product.status');
    Route::post('/update/vendor/product', [VendorProductController::class, 'updateVendorProduct'])->name('update.vendor.product');
    Route::get('/delete/vendor/multi/image/{id}', [VendorProductController::class, 'deleteVendorMultiImage'])->name('delete.vendor.multi.image');
    Route::get('/vendor/delete/product/{id}', [VendorProductController::class, 'vendorDeleteProduct'])->name('vendor.delete.product');
});

//Admin Route with Middleware
Route::middleware(['auth', 'role:admin'])->group(function () {
    /**
     * Admin Dashboard
     * Middleware: auth, role:admin
     */
    Route::get('/admin/dashboard', [AdminController::class, 'adminDashboard'])->name('admin.dashboard');
    Route::get('/admin/logout', [AdminController::class, 'adminLogout'])->name('admin.logout');
    Route::get('/admin/profile', [AdminController::class, 'adminProfile'])->name('admin.profile');
    Route::post('/admin/profile/store', [AdminController::class, 'adminProfileStore'])->name('admin.profile.store');
    Route::get('/admin/change/password', [AdminController::class, 'adminChangePassword'])->name('admin.change.password');
    Route::post('/admin/update/password', [AdminController::class, 'adminUpdatePassword'])->name('admin.update.password');

    // Admin Brand Route
    Route::get('/all/brand', [BrandController::class, 'allBrand'])->name('all.brand');
    Route::get('/add/brand', [BrandController::class, 'addBrand'])->name('add.brand');
    Route::post('/store/brand', [BrandController::class, 'storeBrand'])->name('store.brand');
    Route::get('/edit/brand/{id}', [BrandController::class, 'editBrand'])->name('edit.brand');
    Route::post('/update/brand', [BrandController::class, 'updateBrand'])->name('update.brand');
    Route::get('/delete/brand/{id}', [BrandController::class, 'deleteBrand'])->name('delete.brand');

    // Category Admin Route with Middleware
    Route::get('/all/category', [CategoryController::class, 'allCategory'])->name('all.category');
    Route::get('/add/category', [CategoryController::class, 'addCategory'])->name('add.category');
    Route::post('/store/category', [CategoryController::class, 'storeCategory'])->name('store.category');
    Route::get('/edit/category/{id}', [CategoryController::class, 'editCategory'])->name('edit.category');
    Route::post('/update/category', [CategoryController::class, 'updateCategory'])->name('update.category');
    Route::get('/delete/category/{id}', [CategoryController::class, 'deleteCategory'])->name('delete.category');

    // SubCategory Admin Route with Middleware
    Route::get('/all/subcategory', [SubCategoryController::class, 'allSubCategory'])->name('all.subcategory');
    Route::get('/add/subcategory', [SubCategoryController::class, 'addSubCategory'])->name('add.subcategory');
    Route::post('/store/subcategory', [SubCategoryController::class, 'storeSubCategory'])->name('store.subcategory');
    Route::get('/edit/subcategory/{id}', [SubCategoryController::class, 'editSubcategory'])->name('edit.subcategory');
    Route::post('/update/subcategory', [SubCategoryController::class, 'updateSubcategory'])->name('update.subcategory');
    Route::get('/delete/subcategory/{id}', [SubCategoryController::class, 'deleteSubCategory'])->name('delete.subcategory');
    Route::get('/subcategory/ajax/{category_id}', [SubCategoryController::class, 'getSubCategoryAjax']);

    // Vendor Status Active/Inactive Admin Route with Middleware
    Route::get('/all/vendor/status', [VendorStatus::class, 'allVendorStatus'])->name('all.vendor.status');
    Route::get('/change/vendor/status/{id}', [VendorStatus::class, 'changeVendorStatus'])->name('change.vendor.status');
    Route::get('/edit/vendor/details/{id}', [VendorStatus::class, 'editVendorDetails'])->name('edit.vendor.details');
    Route::post('/update/vendor/profile', [VendorStatus::class, 'updateVendorProfile'])->name('update.vendor.profile');
    Route::get('/delete/vendor/details/{id}', [VendorStatus::class, 'deleteVendorDetails'])->name('delete.vendor.details');
    Route::get('/add/vendor', [VendorStatus::class, 'addVendor'])->name('add.vendor');
    Route::post('/store/vendor/profile', [VendorStatus::class, 'storeVendorProfile'])->name('store.vendor.profile');

    // Users Admin Route with Middleware
    Route::get('/all/user/status', [UserStatus::class, 'allUserStatus'])->name('all.user.status');

    // Slider Admin Route with Middleware
    Route::get('/all/slider', [SliderController::class, 'allSlider'])->name('all.slider');
    Route::get('/add/slider', [SliderController::class, 'addSlider'])->name('add.slider');
    Route::post('/store/slider', [SliderController::class, 'storeSlider'])->name('store.slider');
    Route::get('/edit/slider/{id}', [SliderController::class, 'editSlider'])->name('edit.slider');
    Route::post('/update/slider', [SliderController::class, 'updateSlider'])->name('update.slider');
    Route::get('/delete/slider/{id}', [SliderController::class, 'deleteSlider'])->name('delete.slider');

    // Banner Admin Route with Middleware
    Route::get('/all/banner', [BannerController::class, 'allBanner'])->name('all.banner');
    Route::get('/add/banner', [BannerController::class, 'addBanner'])->name('add.banner');
    Route::post('/store/banner', [BannerController::class, 'storeBanner'])->name('store.banner');
    Route::get('/edit/banner/{id}', [BannerController::class, 'editBanner'])->name('edit.banner');
    Route::post('/update/banner', [BannerController::class, 'updateBanner'])->name('update.banner');
    Route::get('/delete/banner/{id}', [BannerController::class, 'deleteBanner'])->name('delete.banner');

    // Product Admin Route with Middleware
    Route::get('/all/product', [ProductController::class, 'allProduct'])->name('all.product');
    Route::get('/add/product', [ProductController::class, 'addProduct'])->name('add.product');
    Route::post('/store/product', [ProductController::class, 'storeProduct'])->name('store.product');
    Route::post('/check/product/existence', [ProductController::class, 'checkProductExistence'])->name('check.product.existence');
    Route::get('/edit/product/{id}', [ProductController::class, 'editProduct'])->name('edit.product');
    Route::post('/update/product', [ProductController::class, 'updateProduct'])->name('update.product');
    Route::get('/delete/multi/image/{id}', [ProductController::class, 'deleteMultiImage'])->name('delete.multi.image');
    Route::get('/delete/product/{id}', [ProductController::class, 'deleteProduct'])->name('delete.product');
    Route::get('/change/product/status/{id}', [ProductController::class, 'changeProductStatus'])->name('change.product.status');
});

// Vendor create new account
Route::get('/vendor/create', [VendorController::class, 'create'])->name('vendor.create'); // REFACTORED

// Admin Login Route
Route::get('/admin/login', [AdminController::class, 'adminLogin'])->middleware(RedirectIfAuthenticated::class);

// Vendor Register | Login routes
Route::get('/vendor/login', [VendorController::class, 'vendorLogin'])->name('vendor.login')->middleware(RedirectIfAuthenticated::class); // REFACTORED
Route::post('/vendor/register', [VendorController::class, 'vendorRegister'])->name('vendor.register'); // REFACTORED

// Middleware authedication route
// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__.'/auth.php';
