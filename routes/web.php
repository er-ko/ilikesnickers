<?php

use App\Http\Controllers\LocaleController;
use App\Http\Controllers\SystemController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\WelcomeController; // homepage
use App\Http\Controllers\ContactController; // contact
use App\Http\Controllers\FaqController; // faq
use App\Http\Controllers\TaskController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\BookingSlotController;
use App\Http\Controllers\BookingActivityController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductGroupController;
use App\Http\Controllers\ManufacturerController;
use App\Http\Controllers\AddressBookController;
use App\Http\Controllers\CustomerGroupController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('locale/{lang}', [LocaleController::class, 'setLocale']);
Route::resource('language', LanguageController::class)
    ->only(['index', 'edit', 'update'])
    ->middleware(['auth', 'verified']);
Route::resource('currency', CurrencyController::class)
    ->only(['index', 'edit', 'update'])
    ->middleware(['auth', 'verified']);
Route::resource('country', CountryController::class)
    ->only(['index', 'edit', 'update'])
    ->middleware(['auth', 'verified']);
Route::resource('user', UserController::class)
    ->only(['index', 'edit', 'update', 'destroy'])
    ->middleware(['auth', 'verified']);

Route::get(uri: '/',action: [WelcomeController::class, 'index'])->name('welcome');

Route::get('/contact',[ContactController::class, 'index'])->name('contact.index');
Route::get('/cart',[CartController::class, 'index'])->name('cart.index');

Route::resource('faq', FaqController::class)
    ->only(['index', 'create', 'store', 'edit', 'update', 'destroy'])
    ->middleware(['auth', 'verified']);
Route::resource('faq', FaqController::class)->only(['index']);

Route::resource('page', PageController::class)
    ->only(['index', 'create', 'store', 'edit', 'update', 'destroy'])
    ->middleware(['auth', 'verified']);
Route::get('/page/{page:slug}', [PageController::class, 'show'])->name('page.show'); // url slug redirect

Route::resource('task', TaskController::class)
    ->only(['index'])
    ->middleware(['auth', 'verified']);

// post admin
Route::resource('post', PostController::class)
    ->only(['index', 'create', 'store', 'edit', 'update', 'destroy'])
    ->middleware(['auth', 'verified']);
// post public
Route::resource('post', controller: PostController::class)->only(['index']);
Route::get('/post/{post:slug}', action: [PostController::class, 'show'])->name('post.show'); // url slug redirect

// booking
Route::resource('booking', BookingController::class)
    ->only(methods: ['index', 'store', 'edit', 'update', 'destroy'])
    ->middleware(['auth', 'verified']);
Route::get('booking', [BookingController::class, 'index'])->name('booking.index');
Route::post('booking', [BookingController::class, 'store'])->name('booking.store');

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

    Route::get('/welcome', [WelcomeController::class, 'edit'])->name('welcome.edit');
    Route::patch('/welcome', [WelcomeController::class, 'update'])->name('welcome.update');

    Route::get('/contact/edit', [ContactController::class, 'edit'])->name('contact.edit');
    Route::patch('/contact', [ContactController::class, 'update'])->name('contact.update');

    Route::get('/booking/slot', [BookingSlotController::class, 'index'])->name('booking.slot.index');
    Route::get('/booking/slot/create', [BookingSlotController::class, 'create'])->name('booking.slot.create');
    Route::post('/booking/slot/create', [BookingSlotController::class, 'store'])->name('booking.slot.store');
    Route::get('/booking/slot/edit/{id}', [BookingSlotController::class, 'edit'])->name('booking.slot.edit');
    Route::patch('/booking/slot/edit/{id}', [BookingSlotController::class, 'update'])->name('booking.slot.update');
    Route::delete('/booking/slot/{id}', [BookingSlotController::class, 'destroy'])->name('booking.slot.destroy');

    Route::get('/booking/activity', [BookingActivityController::class, 'index'])->name('booking.activity.index');
    Route::get('/booking/activity/create', action: [BookingActivityController::class, 'create'])->name('booking.activity.create');
    Route::post('/booking/activity/create', [BookingActivityController::class, 'store'])->name('booking.activity.store');
    Route::get('/booking/activity/edit/{id}', [BookingActivityController::class, 'edit'])->name('booking.activity.edit');
    Route::patch('/booking/activity/edit/{id}', [BookingActivityController::class, 'update'])->name('booking.activity.update');
    Route::delete('/booking/activity/{id}', [BookingActivityController::class, 'destroy'])->name('booking.activity.destroy');
});

require __DIR__.'/auth.php';
