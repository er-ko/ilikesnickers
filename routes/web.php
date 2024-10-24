<?php

use App\Http\Controllers\LocaleController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductGroupController;
use App\Http\Controllers\ManufacturerController;
use App\Http\Controllers\AddressBookController;
use App\Http\Controllers\CustomerGroupController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SystemController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('locale/{lang}', [LocaleController::class, 'setLocale']);
Route::resource('language', LanguageController::class)
    ->only(['index', 'edit', 'update'])
    ->middleware(['auth', 'verified']);

Route::resource('country', CountryController::class)
    ->only(['index', 'edit', 'update'])
    ->middleware(['auth', 'verified']);

Route::get('/',[WelcomeController::class, 'index'])->name('welcome');

Route::resource('task', TaskController::class)
    ->only(['index'])
    ->middleware(['auth', 'verified']);

// post admin
Route::resource('post', PostController::class)
    ->only(['index', 'create', 'store', 'edit', 'update', 'destroy'])
    ->middleware(['auth', 'verified']);
// post public
Route::resource('post', PostController::class)->only(['index']);
Route::get('/post/{post:slug}', [PostController::class, 'show'])->name('post.show'); // url slug redirect

Route::resource('product', ProductController::class)
    ->only(['index', 'create', 'store', 'edit', 'update', 'destroy'])
    ->middleware(['auth', 'verified']);
Route::resource('product', ProductController::class)->only(['index']);
Route::get('/product/{product:slug}', [ProductController::class, 'show'])->name('product.show');

Route::resource('category', CategoryController::class)
    ->only(['index', 'create', 'store', 'edit', 'update', 'destroy'])
    ->middleware(['auth', 'verified']);
Route::resource('category', CategoryController::class)->only(['index']);
Route::resource('category', CategoryController::class)->only(['index']);
Route::get('/category/{category:slug}', action: [CategoryController::class, 'show'])->name(name: 'category.show'); // url slug redirect

Route::resource('product-group', ProductGroupController::class)
    ->only(['index', 'create', 'store', 'edit', 'update', 'destroy'])
    ->middleware(['auth', 'verified']);

Route::resource('manufacturer', ManufacturerController::class)
    ->only(['index', 'create', 'store', 'edit', 'update', 'destroy'])
    ->middleware(['auth', 'verified']);
Route::get('/manufacturer/{manufacturer:slug}', [ManufacturerController::class, 'show'])->name('manufacturer.show'); // url slug redirect

Route::resource('address-book', AddressBookController::class)
    ->only(['index', 'create', 'store', 'edit', 'update', 'destroy'])
    ->middleware(['auth', 'verified']);

Route::resource('customer-group', CustomerGroupController::class)
    ->only(['index', 'create', 'store', 'edit', 'update', 'destroy'])
    ->middleware(['auth', 'verified']);

Route::resource('customer', CustomerController::class)
    ->only(['index', 'create', 'store', 'edit', 'update', 'destroy'])
    ->middleware(['auth', 'verified']);
    
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');
    
    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        Route::get('/system', [SystemController::class, 'edit'])->name('system.edit');
        Route::patch('/system', [SystemController::class, 'update'])->name('system.update');
});

require __DIR__.'/auth.php';
