<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\CheckEmailController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DressController;
use App\Http\Controllers\WishlistController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\UserMiddleware;
use App\Http\Controllers\Cartcontroller;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\UserController;



Route::get('/', function () {
    return view('index');
});
Route::get('/map', function () {
    return view('map');
})->name('map');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');




Route::get('/location', function () {
    return view('location');
})->name('location');


Route::get('/inspiration', function () {
    return view('inspiration');
})->name('inspiration');



Route::get('login2', function(){
    return view('auth.login2');
});
Route::get('register1', function(){
    return view('auth.register1');
});

Route::get('user layout', function(){
    return view('layouts.user layout');
});
Route::get('admin layout', function(){
    return view('layouts.admin layout');
});
Route::get('index layout', function(){
    return view('layouts.index layout');
});
Route::get('legister layout', function(){
    return view('layouts.legister layout');
});
Auth::routes();

Route::get('/check-email', [CheckEmailController::class, 'showForm'])->name('check.email.form');
Route::post('/check-email', [CheckEmailController::class, 'checkEmail'])->name('check.email');
Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');



Route::middleware([AdminMiddleware::class])->group(function(){
Route::get('/users', [AdminController::class, 'users'])->name('users');
Route::get('deleteuser/{id}', [AdminController::class, 'deleteuser'])->name('deleteuser');
Route::get('banned_status/{id}', [AdminController::class, 'banned_status'])->name('banned_status');
Route::get('unbanned_status/{id}', [AdminController::class, 'unbanned_status'])->name('unbanned_status');
Route::get('add_dress', [DressController::class, 'add_dress'])->name('add_dress');
Route::post('create_dress', [DressController::class, 'create_dress'])->name('create_dress');
Route::get('manage_dress', [DressController::class, 'manage_dress'])->name('manage_dress');
Route::get('view_dress/{id}', [DressController::class, 'view_dress'])->name('view_dress');
Route::get('delete_dress/{id}', [DressController::class, 'delete_dress'])->name('delete_dress');
Route::get('edit_dress/{id}', [DressController::class, 'edit_dress'])->name('edit_dress');
Route::post('update_dress/{id}', [DressController::class, 'update_dress'])->name('update_dress');
Route::prefix('admin')->group(function() {
    Route::get('deliveries', [DeliveryController::class, 'index'])->name('admin.deliveries');
    Route::post('deliveries', [DeliveryController::class, 'store'])->name('admin.deliveries.store');
    Route::put('deliveries/{id}', [DeliveryController::class, 'update'])->name('admin.deliveries.update');
    Route::delete('deliveries/{id}', [DeliveryController::class, 'destroy'])->name('admin.deliveries.delete');
});


    
// Orders Management
 Route::get('/admin/orders', [App\Http\Controllers\OrderController::class, 'index'])->name('admin.orders');
    Route::get('/admin/orders/pending', [App\Http\Controllers\OrderController::class, 'pending'])->name('admin.orders.pending');
    Route::get('/admin/orders/paid', [App\Http\Controllers\OrderController::class, 'paid'])->name('admin.orders.paid');

    Route::get('/admin/orders/view/{id}', [App\Http\Controllers\OrderController::class, 'show'])->name('admin.orders.view');
    Route::post('/admin/orders/{id}/update-status', [App\Http\Controllers\OrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');
    Route::delete('/admin/orders/{id}', [App\Http\Controllers\OrderController::class, 'delete'])->name('admin.orders.delete');

    Route::get('/categories', [CategoryController::class, 'index'])->name('admin.categories');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('admin.create');
    Route::post('/categories/store', [CategoryController::class, 'store'])->name('admin.store');
    Route::get('/categories/edit/{id}', [CategoryController::class, 'edit'])->name('admin.edit');
    Route::put('/categories/update/{id}', [CategoryController::class, 'update'])->name('admin.update');
    Route::delete('/categories/delete/{id}', [CategoryController::class, 'destroy'])->name('admin.delete');
Route::get('admin/category/image/delete/{id}', [CategoryController::class, 'deleteImage'])->name('admin.deleteImage');


       
});







   
   Route::get('/dress/{id}', [DressController::class,'api_show']);
   Route::post('/add-to-cart', [CartController::class, 'addToCart'])->name('add.to.cart');
   Route::get('/bag', [CartController::class, 'index'])->name('bag');

Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/update-quantity', [CartController::class, 'updateQuantity'])->name('cart.updateQuantity');


Route::get('/cart/count', [CartController::class, 'cartCount'])->name('cart.count');
Route::post('/cart/check-stock', [CartController::class, 'checkStock'])->name('cart.checkStock');

Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');
Route::post('/checkout/place-order', [CartController::class, 'placeOrder'])->name('checkout.placeOrder');



Route::middleware(['auth'])->group(function () {
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist');
    Route::get('/user-wishlist', [WishlistController::class, 'index'])->name('user-wishlist');
    Route::post('/wishlist/add/{dress}', [WishlistController::class, 'add'])->name('wishlist.add');
    Route::post('/wishlist/remove/{dress}', [WishlistController::class, 'remove'])->name('wishlist.remove');
    Route::get('orders', [App\Http\Controllers\OrderController::class, 'userOrders'])->name('orders');
    Route::get('orders/{id}', [App\Http\Controllers\OrderController::class, 'userOrderDetails'])->name('orders.show');
    Route::get('/dashboard/profile', [UserController::class, 'profile'])->name('profile');
Route::get('/dashboard/profile/edit', [UserController::class, 'editProfile'])->name('profile.edit');
Route::post('/dashboard/profile/update', [UserController::class, 'updateProfile'])->name('profile.update');

// Change password
Route::post('/dashboard/profile/change-password', [UserController::class, 'changePassword'])->name('profile.password');

// Delete account
Route::post('/dashboard/profile/delete', [UserController::class, 'deleteAccount'])->name('profile.delete');

});


Route::post('/pay/initialize', [PaymentController::class, 'initialize'])->name('pay.initialize');
Route::post('/pay/verify', [PaymentController::class, 'verify'])->name('pay.verify');

Route::get('/order/receipt/{order_id}', [CartController::class, 'sendReceipt'])->name('order.receipt');

// Save order after successful payment
Route::post('/order/save', [CartController::class, 'saveOrder'])->name('order.save');

// Payment Success Page
Route::get('/payment/success/{reference}', [CartController::class, 'paymentSuccess'])->name('payment.success');

Route::get('/order/success/{order_id}', [App\Http\Controllers\PaymentController::class, 'paymentSuccess'])
    ->name('order.success');

Route::post('/paystack/webhook', [PaymentController::class, 'handleWebhook'])->name('paystack.webhook');

Route::get('/wishlist/count', function () {
    if(!Auth::check()) return 0;
    return Auth::user()->wishlists()->count();
});


Route::get('/search', [DressController::class, 'search'])->name('search');
Route::get('/view-product/{id}', [DressController::class, 'viewProduct'])->name('view.product');


Route::get('/category/{slug}', [CategoryController::class, 'show'])->name('category.show');
Route::get('/subcategory/{id}', [DressController::class, 'subcategory'])->name('subcategory.view');






