<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Backend\BrandController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\SubCategoryController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\VendorStatus;
use App\Http\Controllers\Backend\UserStatus;
use App\Http\Controllers\Backend\SliderController;
use App\Http\Controllers\VendorBackend\VendorProductController;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Middleware\VendorStatusChecker;
use App\Http\Middleware\RedirectIfAuthenticatedController;

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

// Replace the Custom Welcome with Frontend Index
Route::get('/', function () {
    return view('frontend.index');
});

// User Dashboard
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [UserController::class, 'userDashboard'])->name('dashboard');
    Route::post('/user/profile/store', [UserController::class, 'userProfileStore'])->name('user.profile.store');
    Route::get('/user/logout', [UserController::class, 'userLogout'])->name('user.logout');
    Route::post('/user/update/password', [UserController::class, 'userUpdatePassword'])->name('user.update.password');
});

// Admin Dashboard
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'adminDashboard'])->name('admin.dashboard'); 
    Route::get('/admin/logout', [AdminController::class, 'adminLogout'])->name('admin.logout');   
    Route::get('/admin/profile', [AdminController::class, 'adminProfile'])->name('admin.profile');
    Route::post('/admin/profile/store', [AdminController::class, 'adminProfileStore'])->name('admin.profile.store');
    Route::get('/admin/change/password', [AdminController::class, 'adminChangePassword'])->name('admin.change.password');
    Route::post('/admin/update/password', [AdminController::class, 'adminUpdatePassword'])->name('admin.update.password');
});

// Vendor Dashboard In Admin Dashboard
Route::middleware(['auth', 'role:vendor'])->group(function () {
    Route::get('/vendor/dashboard', [VendorController::class, 'vendorDashboard'])->name('vendor.dashboard')->middleware('status:active');;
    Route::get('/vendor/logout', [VendorController::class, 'vendorLogout'])->name('vendor.logout');
    Route::get('/vendor/profile', [VendorController::class, 'vendorProfile'])->name('vendor.profile');
    Route::post('/vendor/profile/store', [VendorController::class, 'vendorProfileStore'])->name('vendor.profile.store');
    Route::get('/vendor/change/password', [VendorController::class, 'vendorChangePassword'])->name('vendor.change.password');
    Route::post('/vendor/update/password', [VendorController::class, 'vendorUpdatePassword'])->name('vendor.update.password');
    
    // Vendor Product Controller In Vendor Dashboard All && Add product
    Route::controller(VendorProductController::class)->group(function () {
        Route::get('/all/vendor/product', 'allVendorProduct')->name('all.vendor.product');
        Route::get('/add/vendor/product', 'addVendorProduct')->name('add.vendor.product');
        Route::get('/vendor/subcategory/ajax/{category_id}', 'vendorGetSubCategoryAjax');
        Route::post('/vendor/store/product', 'vendorStoreProduct')->name('vendor.store.product');
        Route::post('/check/vendor/product/existence', 'checkVendorProductExistence')->name('check.vendor.product.existence');
        Route::get('/edit/vendor/product/{id}', 'editVendorProduct')->name('edit.vendor.product');
        Route::get('/change/vendor/product/status/{id}', 'changeVendorProductStatus')->name('change.vendor.product.status');
        Route::post('/update/vendor/product', 'updateVendorProduct')->name('update.vendor.product');
        Route::get('/delete/vendor/multi/image/{id}', 'deleteVendorMultiImage')->name('delete.vendor.multi.image');
        Route::get('/vendor/delete/product/{id}', 'vendorDeleteProduct')->name('vendor.delete.product');
    });
});

// Become a Vendor
Route::get('/become/vendor', [VendorController::class, 'becomeVendor'])->name('become.vendor');

// Admin Login Route
Route::get('/admin/login', [AdminController::class, 'adminLogin'])->middleware(RedirectIfAuthenticated::class);

// Vendor Register | Login routes
Route::get('/vendor/login', [VendorController::class, 'vendorLogin'])->name('vendor.login')->middleware(RedirectIfAuthenticated::class);
Route::post('/vendor/register', [VendorController::class, 'vendorRegister'])->name('vendor.register');

// Brand Admin Route with Middleware
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::controller(BrandController::class)->group(function () {
        Route::get('/all/brand', 'allBrand')->name('all.brand');
        Route::get('/add/brand', 'addBrand')->name('add.brand');
        Route::post('/store/brand', 'storeBrand')->name('store.brand');
        Route::get('/edit/brand/{id}', 'editBrand')->name('edit.brand');
        Route::post('/update/brand', 'updateBrand')->name('update.brand');
        Route::get('/delete/brand/{id}', 'deleteBrand')->name('delete.brand');
    });
});

// Category Admin Route with Middleware
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::controller(CategoryController::class)->group(function () {
        Route::get('/all/category', 'allCategory')->name('all.category');
        Route::get('/add/category', 'addCategory')->name('add.category');
        Route::post('/store/category', 'storeCategory')->name('store.category');
        Route::get('/edit/category/{id}', 'editCategory')->name('edit.category');
        Route::post('/update/category', 'updateCategory')->name('update.category');
        Route::get('/delete/category/{id}', 'deleteCategory')->name('delete.category');
    });
});

// SubCategory Admin Route with Middleware
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::controller(SubCategoryController::class)->group(function () {
        Route::get('/all/subcategory', 'allSubCategory')->name('all.subcategory');
        Route::get('/add/subcategory', 'addSubCategory')->name('add.subcategory');
        Route::post('/store/subcategory', 'storeSubCategory')->name('store.subcategory');
        Route::get('/edit/subcategory/{id}', 'editSubcategory')->name('edit.subcategory');
        Route::post('/update/subcategory', 'updateSubcategory')->name('update.subcategory');
        Route::get('/delete/subcategory/{id}', 'deleteSubCategory')->name('delete.subcategory');
        Route::get('/subcategory/ajax/{category_id}', 'getSubCategoryAjax');
    });
});

// Vendor Status Active/Inactive Admin Route with Middleware
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::controller(VendorStatus::class)->group(function () {
        Route::get('/all/vendor/status', 'allVendorStatus')->name('all.vendor.status');
        Route::get('/check/vendor/details/{id}', 'checkVendorDetails')->name('check.vendor.details');
        Route::post('/change/vendor/status/', 'changeVendorStatus')->name('change.vendor.status');
        Route::get('/delete/vendor/details/{id}', 'deleteVendorDetails')->name('delete.vendor.details');
    });
});

// Users Admin Route with Middleware
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::controller(UserStatus::class)->group(function () {
        Route::get('/all/user/status', 'allUserStatus')->name('all.user.status');
    });
});

// Slider Admin Route with Middleware
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::controller(SliderController::class)->group(function () {
        Route::get('/all/slider', 'allSlider')->name('all.slider');
        Route::get('/add/slider', 'addSlider')->name('add.slider');
        Route::post('/store/slider', 'storeSlider')->name('store.slider');
    });
});

// Product Admin Route with Middleware
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::controller(ProductController::class)->group(function () {
        Route::get('/all/product', 'allProduct')->name('all.product');
        Route::get('/add/product', 'addProduct')->name('add.product');
        Route::post('/store/product', 'storeProduct')->name('store.product');
        Route::post('/check/product/existence', 'checkProductExistence')->name('check.product.existence');
        Route::get('/edit/product/{id}', 'editProduct')->name('edit.product');
        Route::post('/update/product', 'updateProduct')->name('update.product');
        Route::get('/delete/multi/image/{id}', 'deleteMultiImage')->name('delete.multi.image');
        Route::get('/delete/product/{id}', 'deleteProduct')->name('delete.product');
        Route::get('/change/product/status/{id}', 'changeProductStatus')->name('change.product.status');        
    });
});

// Middleware authedication route
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';



