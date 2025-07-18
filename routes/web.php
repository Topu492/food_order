<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\ManageController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\Client\CouponController;
use App\Http\Controllers\Client\GalleryController;
use App\Http\Controllers\Client\ProductController;
use App\Http\Controllers\Client\ResturantController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [UserController::class, 'Index'])->name('index');

Route::get('/dashboard', function () {
    return view('frontend.dashboard.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/store', [UserController::class, 'ProfileStore'])->name('profile.store');
    Route::get('/user/logout', [UserController::class, 'UserLogout'])->name('user.logout');
    Route::get('/change/password', [UserController::class, 'ChangePassword'])->name('change.password');
    Route::post('/user/password/update', [UserController::class, 'UserPasswordUpdate'])->name('user.password.update');

     // Get Wishlist data for user 
    Route::get('/all/wishlist', [HomeController::class, 'AllWishlist'])->name('all.wishlist');
});

require __DIR__ . '/auth.php';

Route::middleware('admin')->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'AdminDashboard'])->name('admin.dashboard');
    Route::get('/admin/profile', [AdminController::class, 'AdminProfile'])->name('admin.profile');
    Route::post('/admin/profile/store', [AdminController::class, 'AdminProfileStore'])->name('admin.profile.store');
    Route::get('/admin/change/password', [AdminController::class, 'AdminChangePassword'])->name('admin.change.password');
    Route::post('/admin/password/update', [AdminController::class, 'AdminPasswordUpdate'])->name('admin.password.update');

});

Route::get('/admin/login', [AdminController::class, 'AdminLogin'])->name('admin.login');
Route::post('/admin/login_submit', [AdminController::class, 'AdminLoginSubmit'])->name('admin.login_submit');
Route::get('/admin/logout', [AdminController::class, 'AdminLogout'])->name('admin.logout');
Route::get('/admin/forget_password', [AdminController::class, 'AdminForgetPassword'])->name('admin.forget_password');
Route::post('/admin/password_submit', [AdminController::class, 'AdminPasswordSubmit'])->name('admin.password_submit');
Route::get('/admin/reset_password/{token}/{email}', [AdminController::class, 'AdminResetPassword']);
Route::post('/admin/reset_password_submit', [AdminController::class, 'AdminResetPasswordSubmit'])->name('admin.reset_password_submit');

/// ALL ROUTE FOR CLIENT Add commentMore actions

Route::middleware('client')->group(function () {
    Route::get('/client/dashboard', [ClientController::class, 'ClientDashboard'])->name('client.dashboard');
    Route::get('/client/profile', [ClientController::class, 'ClientProfile'])->name('client.profile');
    Route::post('/client/profile/store', [ClientController::class, 'ClientProfileStore'])->name('client.profile.store');
    Route::get('/client/change/password', [ClientController::class, 'ClientChangePassword'])->name('client.change.password');
    Route::post('/client/password/update', [ClientController::class, 'ClientPasswordUpdate'])->name('client.password.update');
});

Route::get('/client/login', [ClientController::class, 'ClientLogin'])->name('client.login');
Route::get('/client/register', [ClientController::class, 'ClientRegister'])->name('client.register');
Route::post('/client/register/submit', [ClientController::class, 'ClientRegisterSubmit'])->name('client.register.submit');
Route::post('/client/login_submit', [ClientController::class, 'ClientLoginSubmit'])->name('client.login_submit');
Route::get('/client/logout', [ClientController::class, 'ClientLogout'])->name('client.logout');

// All Admin Category

Route::middleware('admin')->group(function () {
    Route::controller(CategoryController::class)->group(function () {
        Route::get('/all/category', 'AllCategory')->name('all.category');
        Route::get('/add/category', 'AddCategory')->name('add.category');
        Route::post('/store/category', 'StoreCategory')->name('store.category');
        Route::get('/edit/category/{id}', 'EditCategory')->name('edit.category');
        Route::post('/update/category', 'UpdateCategory')->name('update.category');
        Route::get('/delete/category/{id}', 'DeleteCategory')->name('delete.category');

    });

    Route::controller(ManageController::class)->group(function () {
        Route::get('admin/all/product', 'AdminAllProduct')->name('admin.all.product');
        Route::get('admin/add/product', 'AdminAddProduct')->name('admin.add.product');
        Route::post('admin/store/product', 'AdminStoreProduct')->name('admin.store.product');
        Route::get('admin/edit/product/{id}', 'AdminEditProduct')->name('admin.edit.product');
        Route::post('admin/update/product', 'AdminUpdateProduct')->name('admin.update.product');
        Route::get('admin/delete/product/{id}', 'AdminDeleteProduct')->name('admin.delete.product');

    });

    Route::controller(ManageController::class)->group(function () {
        Route::get('pending/restaurant', 'PendingRestaurant')->name('pending.restaurant');
        Route::get('/approve/restaurant', 'ApproveRestaurant')->name('approve.restaurant');
        Route::get('/clientchangeStatus', 'ClientChangeStatus');

    });

    Route::controller(ManageController::class)->group(function () {
        Route::get('all/banner', 'AllBanner')->name('all.banner');
        Route::post('store/banner', 'BannerStore')->name('banner.store');
        Route::get('/edit/banner/{id}', 'EditBanner');
        Route::post('/banner/update', 'BannerUpdate')->name('banner.update');
        Route::get('/delete/banner/{id}', 'DeleteBanner')->name('delete.banner');

    });

});

// End Admin Middleware

Route::controller(CityController::class)->group(function () {
    Route::get('/all/city', 'AllCity')->name('all.city');
    Route::get('/add/city', 'AddCity')->name('add.city');
    Route::post('/store/city', 'StoreCity')->name('city.store');
    Route::get('/edit/city/{id}', 'EditCity');
    Route::post('/update/city', 'UpdateCity')->name('update.city');
    Route::get('/delete/city/{id}', 'DeleteCity')->name('delete.city');

});

// Start Client Middleware
Route::middleware(['client', 'status'])->group(function () {

    Route::controller(ResturantController::class)->group(function () {
        Route::get('/all/menu', 'AllMenu')->name('all.menu');
        Route::get('/add/menu', 'AddMenu')->name('add.menu');
        Route::post('/store/menu', 'StoreMenu')->name('store.menu');
        Route::get('/edit/menu/{id}', 'EditMenu')->name('edit.menu');
        Route::post('/update/menu', 'UpdateMenu')->name('update.menu');
        Route::get('/delete/menu/{id}', 'DeleteMenu')->name('delete.menu');

    });

    Route::controller(ProductController::class)->group(function () {
        Route::get('/all/product', 'AllProduct')->name('all.product');
        Route::get('/add/product', 'AddProduct')->name('add.product');
        Route::post('/store/product', 'StoreProduct')->name('store.product');
        Route::get('/edit/product/{id}', 'EditProduct')->name('edit.product');
        Route::post('/update/product', 'UpdateProduct')->name('update.product');
        Route::get('/delete/product/{id}', 'DeleteProduct')->name('delete.product');

    });

    Route::controller(GalleryController::class)->group(function () {
        Route::get('/all/gallery', 'AllGallery')->name('all.gallery');
        Route::get('/add/gallery', 'AddGallery')->name('add.gallery');
        Route::post('/store/gallery', 'StoreGallery')->name('store.gallery');
        Route::get('/edit/gallery/{id}', 'EditGallery')->name('edit.gallery');
        Route::post('/update/gallery', 'UpdateGallery')->name('update.gallery');
        Route::get('/delete/gallery/{id}', 'DeleteGallery')->name('delete.gallery');

    });

    Route::controller(CouponController::class)->group(function () {
        Route::get('/all/coupon', 'AllCoupon')->name('all.coupon');
        Route::get('/add/coupon', 'AddCoupon')->name('add.coupon');
        Route::post('/store/coupon', 'StoreCoupon')->name('store.coupon');
        Route::get('/edit/coupon/{id}', 'EditCoupon')->name('edit.coupon');
        Route::post('/update/coupon', 'UpdateCoupon')->name('coupon.update');
        Route::get('/delete/coupon/{id}', 'DeleteCoupon')->name('delete.coupon');

    });

});
// End Client Middleware

// That will be for all user
Route::get('/changeStatus', [ProductController::class, 'ChangeStatus']);

Route::controller(HomeController::class)->group(function () {
    Route::get('/restaurant/details/{id}', 'RestaurantDetails')->name('res.details');
    
    // Get Wishlist data for user 
    Route::post('/add-wish-list/{id}', 'AddWishList');
    Route::get('/remove/wishlist/{id}', [HomeController::class, 'RemoveWishlist'])->name('remove.wishlist');
});

Route::controller(CartController::class)->group(function(){
    Route::get('/add_to_cart/{id}', 'AddToCart')->name('add_to_cart');  
    Route::post('/cart/update-quantity', 'updateCartQuanity')->name('cart.updateQuantity');
    Route::post('/cart/remove', 'CartRemove')->name('cart.remove');
    
    Route::post('/apply-coupon', 'ApplyCoupon');
    Route::get('/remove-coupon', 'CouponRemove');

    Route::get('/checkout', 'ShopCheckout')->name('checkout');
    
});
