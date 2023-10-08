<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Backend\BrandController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\SubCategoryController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Middleware\VendorStatusChecker;

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

// Replace the custom welcome with frontend index
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

// Vendor Dashboard
Route::middleware(['auth', 'role:vendor'])->group(function () {
    Route::get('/vendor/dashboard', [VendorController::class, 'vendorDashboard'])->name('vendor.dashboard')->middleware('status:active');;
    Route::get('/vendor/logout', [VendorController::class, 'vendorLogout'])->name('vendor.logout');
    Route::get('/vendor/profile', [VendorController::class, 'vendorProfile'])->name('vendor.profile');
    Route::post('/vendor/profile/store', [VendorController::class, 'vendorProfileStore'])->name('vendor.profile.store');
    Route::get('/vendor/change/password', [VendorController::class, 'vendorChangePassword'])->name('vendor.change.password');
    Route::post('/vendor/update/password', [VendorController::class, 'vendorUpdatePassword'])->name('vendor.update.password');
});

// Become a Vendor
Route::get('/become/vendor', [VendorController::class, 'becomeVendor'])->name('become.vendor');

// Admin login route
Route::get('/admin/login', [AdminController::class, 'adminLogin']);

// Vendor Register | Login routes
Route::get('/vendor/login', [VendorController::class, 'vendorLogin'])
    ->name('vendor.login');
Route::post('/vendor/register', [VendorController::class, 'vendorRegister'])
    ->name('vendor.register');

// Brand admin route with middleware
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

// Category admin route with middleware
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

// SubCategory admin route with middleware
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

// Vendor Active/Inactive admin route with middleware
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::controller(AdminController::class)->group(function () {
        Route::get('/all/vendor/status', 'allVendorStatus')->name('all.vendor.status');
        Route::get('/check/vendor/details/{id}', 'checkVendorDetails')->name('check.vendor.details');
        Route::post('/change/vendor/status/', 'changeVendorStatus')->name('change.vendor.status');
        Route::get('/delete/vendor/details/{id}', 'deleteVendorDetails')->name('delete.vendor.details');
    });
});

// Users admin route with middleware
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::controller(AdminController::class)->group(function () {
        Route::get('/all/user/status', 'allUserStatus')->name('all.user.status');
    });
});

// Product admin route with middleware
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::controller(ProductController::class)->group(function () {
        Route::get('/all/product', 'allProduct')->name('all.product');
        Route::get('/add/product', 'addProduct')->name('add.product');
        Route::post('/store/product', 'storeProduct')->name('store.product');
        // Checking if product exists in database
        Route::post('/check/product/existence', 'checkProductExistence')->name('check.product.existence');
        Route::get('/edit/product/{id}', 'editProduct')->name('edit.product');
        Route::post('/update/product', 'updateProduct')->name('update.product');
    });
});



// Middleware authedication route
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';



