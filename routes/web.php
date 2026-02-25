<?php
use App\Http\Controllers\Merchant\DashboardController as MDashboard;
use App\Http\Controllers\Merchant\ProfileController as MProfile;
use App\Http\Controllers\Merchant\MenuController as MMenu;
use App\Http\Controllers\Merchant\OrderController as MOrder;
use App\Http\Controllers\Merchant\InvoiceController as MInvoice;

use App\Http\Controllers\Customer\DashboardController as CDashboard;
use App\Http\Controllers\Customer\CateringController as CCatering;
use App\Http\Controllers\Customer\CheckoutController as CCheckout;
use App\Http\Controllers\Customer\OrderController as COrder;
use App\Http\Controllers\Customer\InvoiceController as CInvoice;

Route::get('/', fn() => redirect('/login'));
use App\Http\Controllers\Auth\AuthController;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');
Route::middleware(['auth', 'role:merchant'])->prefix('merchant')->name('merchant.')->group(function () {
    Route::get('/dashboard', [MDashboard::class, 'index'])->name('dashboard');

    Route::get('/profile', [MProfile::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [MProfile::class, 'update'])->name('profile.update');

    Route::get('/menus', [MMenu::class, 'index'])->name('menus.index');
    Route::get('/menus/create', [MMenu::class, 'create'])->name('menus.create');
    Route::post('/menus', [MMenu::class, 'store'])->name('menus.store');
    Route::get('/menus/{menu}/edit', [MMenu::class, 'edit'])->name('menus.edit');
    Route::put('/menus/{menu}', [MMenu::class, 'update'])->name('menus.update');
    Route::delete('/menus/{menu}', [MMenu::class, 'destroy'])->name('menus.destroy');
    // atau PATCH:
    // Route::patch('/menus/{menu}', [MMenu::class, 'update'])->name('menus.update');    Route::post('/menus/{menu}/delete', [MMenu::class, 'destroy'])->name('menus.destroy');

    Route::get('/orders', [MOrder::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [MOrder::class, 'show'])->name('orders.show');
    Route::post('/orders/{order}/status', [MOrder::class, 'updateStatus'])->name('orders.status');

    Route::get('/invoices/{order}', [MInvoice::class, 'show'])->name('invoices.show');
});

Route::middleware(['auth', 'role:customer'])->prefix('customer')->name('customer.')->group(function () {
    Route::get('/dashboard', [CDashboard::class, 'index'])->name('dashboard');

    Route::get('/caterings', [CCatering::class, 'index'])->name('caterings.index');
    Route::get('/caterings/{merchant}', [CCatering::class, 'show'])->name('caterings.show');

    Route::post('/checkout', [CCheckout::class, 'checkout'])->name('checkout');

    Route::get('/orders', [COrder::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [COrder::class, 'show'])->name('orders.show');

    Route::get('/invoices/{order}', [CInvoice::class, 'show'])->name('invoices.show');
});

Route::get('customer/caterings', [\App\Http\Controllers\Customer\CateringController::class, 'index'])
    ->name('customer.caterings.index');

Route::get('customer/caterings/{merchant}', [\App\Http\Controllers\Customer\CateringController::class, 'show'])
    ->name('customer.caterings.show');

Route::post(
    'merchant/orders/{order}/status',
    [\App\Http\Controllers\Merchant\OrderController::class, 'updateStatus']
)
    ->name('merchant.orders.status');