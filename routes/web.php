<?php

use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

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
Route::group([
    'prefix' => LaravelLocalization::setLocale(), // Set the language prefix correctly
    'middleware' => [
        'auth:sanctum',
        config('jetstream.auth_session'),
        'verified',
        'admin', // Apply the admin middleware
    ]
], function () {
    Route::get('/admin', [\App\Http\Controllers\Admin\Dashboard::class, 'index'])->name('dashboard');
    Route::resource('/admin/products', \App\Http\Controllers\Admin\ProductController::class)->names('admin.products');
    Route::resource('/categories', \App\Http\Controllers\Admin\CategoryController::class)->names('admin.categories');
    Route::resource('adsliders', \App\Http\Controllers\Admin\AdSliderController::class)->names('admin.adsliders');
    Route::post('/products/upload', [\App\Http\Controllers\Admin\ProductController::class, 'upload'])->name('admin.products.upload');
    Route::delete('/admin/products/temp-image', [\App\Http\Controllers\Admin\ProductController::class, 'deleteTempImage'])->name('admin.products.delete_temp_image');
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class)->names('admin.users');
    Route::resource('messages', \App\Http\Controllers\Admin\MessageAdminController::class)->names('admin.messages');
});

Route::group([
    'prefix' => LaravelLocalization::setLocale() // Set the language prefix correctly
], function () {


    Route::get('/', [\App\Http\Controllers\Front\HomeController::class, 'index'])->name('home');
    Route::get('/product/details/{id}', [\App\Http\Controllers\Front\ProductsController::class, 'details'])->name('product.details');
    Route::get('/products', [\App\Http\Controllers\Front\ProductsController::class, 'index'])->name('products.index');
    Route::get('/products/{category}', [\App\Http\Controllers\Front\ProductsController::class, 'filterByCategory'])->name('products.filterByCategory');
    Route::get('/about', [\App\Http\Controllers\Front\HomeController::class, 'about'])->name('about');
    Route::get('/contact', [\App\Http\Controllers\Front\HomeController::class, 'contact'])->name('contact');
    Route::post('/contact', [\App\Http\Controllers\MessageController::class, 'store'])->name('messages.store');
    Route::get('/search', [\App\Http\Controllers\Front\HomeController::class, 'search'])->name('search');

});
