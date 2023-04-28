<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\frontend\CartController;
use App\Http\Controllers\Frontend\IndexController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\CompareController;
use App\Http\Controllers\User\WishlistController;
use App\Http\Controllers\UserController;
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
Route::get('/', [IndexController::class, 'Index']);

/// Frontend Product Details All Route
Route::get('/product/details/{id}/{slug}', [IndexController::class, 'ProductDetails']);
Route::get('/product/category/{id}/{slug}', [IndexController::class, 'CatWiseProduct']);
Route::get('/product/subcategory/{id}/{slug}', [IndexController::class, 'SubCatWiseProduct']);
// Product View Modal With Ajax
Route::get('/product/view/modal/{id}', [IndexController::class, 'ProductViewAjax']);
/// Frontend Product Details All Route End



// CART ROUTE
/// Add to cart store data
Route::post('/cart/data/store/{id}', [CartController::class, 'AddToCart']);
// Get Data from mini Cart
Route::get('/product/mini/cart', [CartController::class, 'AddMiniCart']);
Route::get('/minicart/product/remove/{rowId}', [CartController::class, 'RemoveMiniCart']);
/// Add to cart store data For Product Details Page
Route::post('/dcart/data/store/{id}', [CartController::class, 'AddToCartDetails']);


/// Add to Wishlist
Route::post('/add-to-wishlist/{product_id}', [WishlistController::class, 'AddToWishList']);

/// Add to Compare
Route::post('/add-to-compare/{product_id}', [CompareController::class, 'AddToCompare']);

/// Frontend Coupon Option
Route::post('/coupon-apply', [CartController::class, 'CouponApply']);

Route::get('/coupon-calculation', [CartController::class, 'CouponCalculation']);
Route::get('/coupon-remove', [CartController::class, 'CouponRemove']);


// Checkout Page Route
Route::get('/checkout', [CartController::class, 'CheckoutCreate'])->name('checkout');

// Cart All Route
Route::controller(CartController::class)->group(function(){
    Route::get('/mycart' ,[CartController::class, 'MyCart'])->name('mycart');
    Route::get('/get-cart-product' ,[CartController::class, 'GetCartProduct']);
    Route::get('/cart-remove/{rowId}' ,[CartController::class, 'CartRemove']);

    Route::get('/cart-decrement/{rowId}' ,[CartController::class, 'CartDecrement']);
    Route::get('/cart-increment/{rowId}' ,[CartController::class, 'CartIncrement']);


});

Route::middleware(['auth'])->group(function() {

    // Wishlist All Route
    Route::controller(WishlistController::class)->group(function () {
        Route::get('/wishlist', [WishlistController::class, 'AllWishlist'])->name('wishlist');
        Route::get('/get-wishlist-product',[WishlistController::class,  'GetWishlistProduct']);
        Route::get('/wishlist-remove/{id}', [WishlistController::class, 'WishlistRemove']);

    });


    // Compare All Route
    Route::controller(CompareController::class)->group(function () {
        Route::get('/compare', [CompareController::class,  'AllCompare'])->name('compare');
        Route::get('/get-compare-product', [CompareController::class,'GetCompareProduct']);
        Route::get('/compare-remove/{id}',[CompareController::class, 'CompareRemove']);

    });

}); // Gorup Milldeware End


Route::middleware(['auth'])->group(function() {
    Route::get('/dashboard', [UserController::class, 'UserDashboard'])->name('dashboard');
    Route::post('/user/profile/store', [UserController::class, 'UserProfileStore'])->name('user.profile.store');
    Route::get('/user/logout', [UserController::class, 'UserLogout'])->name('user.logout');
    Route::post('/user/update/password', [UserController::class, 'UserUpdatePassword'])->name('user.update.password');
}); // Gorup Milldeware End


//Route::get('/', function () {
//    return view('welcome');
//});

//Route::get('/dashboard', function () {
//    return view('dashboard');
//})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
