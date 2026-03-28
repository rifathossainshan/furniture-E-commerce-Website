<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/shop', [\App\Http\Controllers\ShopController::class, 'index'])->name('shop');
Route::get('/product/{slug}', [\App\Http\Controllers\ShopController::class, 'show'])->name('product.show');

Route::get('/cart', [\App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{product}', [\App\Http\Controllers\CartController::class, 'add'])->name('cart.add');
Route::patch('/cart/update', [\App\Http\Controllers\CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove', [\App\Http\Controllers\CartController::class, 'remove'])->name('cart.remove');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\UserController::class, 'dashboard'])->name('dashboard');

    Route::get('/checkout', [\App\Http\Controllers\CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/voucher', [\App\Http\Controllers\CheckoutController::class, 'applyVoucher'])->name('checkout.voucher');
    Route::post('/checkout/place-order', [\App\Http\Controllers\CheckoutController::class, 'store'])->name('checkout.store');
    
    Route::get('/order/{order}/invoice', [\App\Http\Controllers\UserController::class, 'invoice'])->name('order.invoice');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', function () {
        return redirect()->route('admin.dashboard');
    });
    Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/password', [\App\Http\Controllers\Admin\DashboardController::class, 'password'])->name('password');
    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);
    Route::delete('products/{product}/image/{index}', [\App\Http\Controllers\Admin\ProductController::class, 'deleteImage'])->name('products.image.delete');
    Route::resource('products', \App\Http\Controllers\Admin\ProductController::class);
    Route::resource('sliders', \App\Http\Controllers\Admin\SliderController::class);
    Route::resource('vouchers', \App\Http\Controllers\Admin\VoucherController::class);
    Route::resource('orders', \App\Http\Controllers\Admin\OrderController::class)->except(['create', 'store', 'destroy']);
    Route::get('settings', [\App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings.index');
    Route::post('settings', [\App\Http\Controllers\Admin\SettingController::class, 'store'])->name('settings.store');
});

require __DIR__ . '/auth.php';
