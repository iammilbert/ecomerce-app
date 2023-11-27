<?php
use Illuminate\Foundation\Auth\EmailVerificationRequest;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController\Authentication;
use App\Http\Controllers\StateController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\LgController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\NextOfKinController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\SubscribersController;
use App\Http\Controllers\GeneralMessageController;
use App\Http\Controllers\CustomerMessageController;
use App\Http\Controllers\VendorController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::as('woocom.auths.')->prefix('auths')->group(function() {
    Route::post('/logout', [Authentication::class, 'logout']);
    Route::post('/login', [Authentication::class, 'login']);
    Route::PATCH('/update-email/{userId}', [Authentication::class, 'updateEmail'])->name('update-email');
    Route::PATCH('/change-password/{userId}', [Authentication::class, 'changePassword'])->name('change-password');
    Route::post('/forgot-password', [Authentication::class, 'forgotPassword'])->name('forgot-password');
});


Route::as('woocom.address.')->prefix('address')->group(function() {
    Route::get('/', [ AddressController::class, 'index'])->name('index');
    Route::post('/', [ AddressController::class, 'create'])->name('create');
    Route::get('/{AddressId}', [ AddressController::class, 'show'])->name('show');
    Route::match(['POST', 'PUT', 'PATCH'],'/{AddressId}', [ AddressController::class, 'update'])->name('update');
    Route::delete('/{AddressId}', [ AddressController::class, 'destroy'])->name('delete');
});


Route::as('woocom.cart.')->prefix('cart')->group(function() {
        Route::post('/add', [CartController::class, 'addToCart']);
        Route::put('/update/{id}', [CartController::class, 'updateCart']);
        Route::delete('/remove/{id}', [CartController::class, 'removeFromCart']);
        Route::delete('/clear', [CartController::class, 'clearCart']);

    });


Route::as('woocom.subscribers.')->prefix('subscribers')->group(function() {
        Route::get('/', [ SubscribersController::class, 'index'])->name('index');
        Route::post('/', [SubscribersController::class, 'create'])->name('create');
        Route::delete('/{subscriberId}', [SubscribersController::class, 'delete'])->name('delete');

    });


Route::as('woocom.states.')->prefix('states')->group(function() {
    Route::get('/', [ StateController::class, 'index'])->name('index');
    Route::post('/', [ StateController::class, 'register'])->name('register');
    Route::get('/{stateId}', [ StateController::class, 'show'])->name('show');
    Route::match(['POST', 'PUT', 'PATCH'],'/{stateId}', [ StateController::class, 'update'])->name('update');
    Route::delete('/{stateId}', [ StateController::class, 'destroy'])->name('delete');
});

Route::as('woocom.users.')->prefix('users')->group(function() {
    Route::get('/', [ UserController::class, 'index'])->name('index');
    Route::get('/admin', [ UserController::class, 'admin'])->name('admin');
    Route::post('/', [ UserController::class, 'register'])->name('register');
    Route::get('/{id}', [ UserController::class, 'show'])->name('show');
    Route::match(['POST', 'PUT', 'PATCH'],'/{id}', [ UserController::class, 'update'])->name('update');
    Route::delete('/{id}', [ UserController::class, 'delete'])->name('delete');
});

Route::as('woocom.countries.')->prefix('countries')->group(function() {
    Route::get('/', [ CountryController::class, 'index'])->name('index');
    Route::post('/', [ CountryController::class, 'create'])->name('create');
    Route::get('/{countryId}', [ CountryController::class, 'show'])->name('show');
    Route::match(['POST', 'PUT', 'PATCH'],'/{countryId}', [ CountryController::class, 'update'])->name('update');
    Route::delete('/{countryId}', [ CountryController::class, 'delete'])->name('delete');
});

Route::as('woocom.lgs.')->prefix('lgs')->group(function() {
    Route::get('/', [ LgController::class, 'index'])->name('index');
    Route::post('/', [ LgController::class, 'create'])->name('create');
    Route::get('/{id}', [ LgController::class, 'show'])->name('show');
    Route::match(['POST', 'PUT', 'PATCH'],'/{id}', [ LgController::class, 'update'])->name('update');
    Route::delete('/{id}', [ LgController::class, 'delete'])->name('delete');
});


Route::as('woocom.categories.')->prefix('categories')->group(function() {
    Route::get('/', [ CategoryController::class, 'index'])->name('index');
    Route::post('/', [ CategoryController::class, 'register'])->name('register');
    Route::get('/{categoryId}', [ CategoryController::class, 'show'])->name('show');
    Route::PATCH('/{categoryId}', [ CategoryController::class, 'update'])->name('update');
    Route::delete('/{id}', [ CategoryController::class, 'destroy'])->name('delete');
});


Route::as('woocom.customersmessages.')->prefix('customersmessages')->group(function() {
    Route::get('/', [ CustomerMessageController::class, 'index'])->name('index');
    Route::post('/', [ CustomerMessageController::class, 'create'])->name('create');
    Route::get('/{userId}', [ CustomerMessageController::class, 'show'])->name('show');
    Route::get('/message_details/{messageId}', [ CustomerMessageController::class, 'message_details'])->name('message_details');
    Route::PATCH('/{messageId}', [ CustomerMessageController::class, 'update'])->name('update');
    Route::delete('/{messageId}', [ CustomerMessageController::class, 'destroy'])->name('delete');
});


Route::as('woocom.generalmessages.')->prefix('generalmessages')->group(function() {
    Route::get('/', [ GeneralMessageController::class, 'index'])->name('index');
    Route::post('/', [ GeneralMessageController::class, 'create'])->name('create');
    Route::get('/{messageId}', [ GeneralMessageController::class, 'show'])->name('show');
    Route::PATCH('/{messageId}', [ GeneralMessageController::class, 'update'])->name('update');
    Route::delete('/{messageId}', [ GeneralMessageController::class, 'destroy'])->name('delete');
});


Route::as('woocom.vendors.')->prefix('vendors')->group(function() {
    Route::get('/', [ VendorController::class, 'index'])->name('index');
    Route::post('/', [ VendorController::class, 'create'])->name('create');
    Route::get('/{userId}', [ VendorController::class, 'show'])->name('show');
    Route::PATCH('/{vendorId}', [ VendorController::class, 'update'])->name('update');
    Route::delete('/{vendorId}', [ VendorController::class, 'delete'])->name('delete');
});


Route::as('woocom.orders.')->prefix('orders')->group(function() {
    Route::get('/', [ OrderController::class, 'index'])->name('index');
    Route::post('/', [ OrderController::class, 'register'])->name('register');
    Route::get('/{id}', [ OrderController::class, 'show'])->name('show');
    Route::match(['POST', 'PUT', 'PATCH'],'/{id}', [ OrderController::class, 'update'])->name('update');
    Route::delete('/{id}', [ OrderController::class, 'destroy'])->name('delete');
});



Route::as('woocom.products.')->prefix('products')->group(function() {
    Route::get('/', [ ProductController::class, 'index'])->name('index');
    Route::post('/', [ ProductController::class, 'register'])->name('register');
    Route::get('/{productId}', [ ProductController::class, 'show'])->name('show');
    Route::match(['POST', 'PUT', 'PATCH'],'/{productId}', [ ProductController::class, 'update'])->name('update');
    Route::delete('/{productId}', [ ProductController::class, 'destroy'])->name('delete');
});


Route::as('woocom.nextofkins.')->prefix('nextofkins')->group(function() {
    Route::get('/', [ NextOfKinController::class, 'index'])->name('index');
    Route::post('/', [ NextOfKinController::class, 'create'])->name('create');
    Route::get('/{nextOfKinId}', [ NextOfKinController::class, 'show'])->name('show');
    Route::match(['POST', 'PUT', 'PATCH'],'/{nextOfKinId}', [ NextOfKinController::class, 'update'])->name('update');
    Route::delete('/{nextOfKinId}', [ NextOfKinController::class, 'delete'])->name('delete');
});


Route::as('woocom.discounts.')->prefix('discounts')->group(function() {
    Route::get('/', [ DiscountController::class, 'index'])->name('index');
    Route::post('/', [ DiscountController::class, 'create'])->name('create');
    Route::post('/activate', [ DiscountController::class, 'activate_discount'])->name('activate');
    Route::post('/update_active_discount/{productId}', [ DiscountController::class, 'update_active_discount'])->name('update_active_discount');
    Route::get('/{discountId}', [ DiscountController::class, 'show'])->name('show');
    Route::match(['POST', 'PUT', 'PATCH'],'/{discountId}', [ DiscountController::class, 'update'])->name('update');
    Route::delete('/{discountId}', [ DiscountController::class, 'delete'])->name('delete');
});

