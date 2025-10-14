<?php

use App\Livewire\Admin\CategoryManager;
use App\Livewire\Admin\ProductManager;
use App\Livewire\FetchProducts;
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
use App\Livewire\Customers\Dashboard;
use App\Livewire\Customers\Wishlists;
use App\Livewire\Customers\Addresses;
use App\Livewire\Customers\Forms\Addresses as Form;
use App\Livewire\Customers\Orders;
use App\Livewire\Customers\OrderDetails;
use App\Livewire\Customers\Reviews;

Route::get('/', function () {
    return view('welcome');
})->name('home');
Route::get('/fetch-products', FetchProducts::class)->name('products.fetch');

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


Route::middleware(['auth','admin'])->group(function () {
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
Route::middleware(['web', 'auth', 'verified'])->prefix('customers')->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('customer.dashboard');
    Route::get('/account/wishlist', Wishlists::class)->name('customer.wishlist');
    Route::get('/account/addresses', Addresses::class)->name('customer.addresses');
    Route::get('/account/addresses/form/{id?}', Form::class)->name('customer.addresses.form');
    Route::get('/account/orders', Orders::class)->name('customer.orders');
    Route::get('/account/orders/{id}', OrderDetails::class)->name('customer.orders.detail');
    Route::get('/account/reviews/edit/{id?}', Reviews::class)->name('customer.reviews');
});
require __DIR__.'/auth.php';
