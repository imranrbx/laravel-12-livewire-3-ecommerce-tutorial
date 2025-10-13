<?php

use App\Livewire\Admin\CategoryManager;
use App\Livewire\Admin\ProductManager;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\TwoFactor;
use App\Livewire\Store\Cart;
use App\Livewire\Store\CheckOut;
use App\Livewire\Store\OrderConfirmation;
use App\Livewire\Store\ProductDetails;
use App\Livewire\Store\ProductList;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return view('welcome');
})->name('home');
Route::middleware(['web'])->group(function () {

    Route::get('/products', ProductList::class)->name('store.products');
    Route::get('/product/{slug}', ProductDetails::class)->name('store.product.details');
    Route::get('/cart', Cart::class)->name('store.cart');
    Route::get('/checkout', CheckOut::class)->name('store.checkout');
    Route::get('/order-confirmation', OrderConfirmation::class)->name('store.order.confirmation');
});
Route::middleware(['auth','verified','admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::get('categories', CategoryManager::class)->name('categories');
    Route::get('products', ProductManager::class)->name('products');
});


Route::middleware(['auth',])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');

    Route::get('settings/two-factor', TwoFactor::class)
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');
});

require __DIR__.'/auth.php';
