<?php

use App\Http\Controllers\LocaleController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('locale/{lang}', [LocaleController::class, 'setLocale']);
Route::resource('language', LanguageController::class)
    ->only(['index', 'edit', 'update'])
    ->middleware(['auth', 'verified']);

Route::get('/',[WelcomeController::class, 'index'])->name('welcome');

Route::resource('task', TaskController::class)
    ->only(['index'])
    ->middleware(['auth', 'verified']);

Route::resource('post', PostController::class)->only(['index']);
Route::get('/post/{post:slug}', [PostController::class, 'show'])->name('post.show');
Route::resource('post', PostController::class)
    ->only(['create', 'store', 'edit', 'update', 'destroy'])
    ->middleware(['auth', 'verified']);

Route::resource('product', ProductController::class)
    ->only(['index', 'show']);
Route::get('/product/{product:slug}', [ProductController::class, 'show'])->name('product.show');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
