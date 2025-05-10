<?php

// routes/web.php
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Admin Controllers
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\CarController as AdminCarController;
use App\Http\Controllers\Admin\RentalController as AdminRentalController;
use App\Http\Controllers\Admin\CustomerController as AdminCustomerController;

// Frontend Controllers
use App\Http\Controllers\Frontend\PageController as FrontendPageController;
use App\Http\Controllers\Frontend\CarController as FrontendCarController;
use App\Http\Controllers\Frontend\RentalController as FrontendRentalController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Frontend Routes
Route::get('/', [FrontendPageController::class, 'home'])->name('home');
Route::get('/about', [FrontendPageController::class, 'about'])->name('about');
Route::get('/contact', [FrontendPageController::class, 'contact'])->name('contact');
Route::get('/cars', [FrontendCarController::class, 'index'])->name('cars.index');
Route::get('/cars/{car}', [FrontendCarController::class, 'show'])->name('cars.show');

Route::middleware(['auth'])->group(function () { // Routes requiring login
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/bookings', [FrontendRentalController::class, 'store'])->name('bookings.store');
    Route::get('/my-bookings', [FrontendRentalController::class, 'myBookings'])->name('my-bookings');
    Route::patch('/my-bookings/{rental}/cancel', [FrontendRentalController::class, 'cancelBooking'])->name('bookings.cancel');
});


// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::resource('cars', AdminCarController::class);
    Route::resource('rentals', AdminRentalController::class)->except(['create', 'store']); // Rentals created via frontend
    Route::resource('customers', AdminCustomerController::class);
});


require __DIR__.'/auth.php'; // Breeze auth routes