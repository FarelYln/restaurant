<?php

use App\Http\Controllers\ProfileController;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\UlasanController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MejaController;
use App\Http\Controllers\ReservasiController;

Route::get('/', function () {
    return view('welcome');
});




// Rute untuk admin
Route::middleware(['auth', RoleMiddleware::class . ':admin'])->group(function () {
    Route::get('/admin', function () {
        return view('pages.admin.dashboard'); // Halaman Admin
    })->name('admin');

    // Routes untuk Menu
    Route::get('/admin/menu', [MenuController::class, 'adminIndex'])->name('admin.menu.index');
    Route::get('/admin/menu/create', [MenuController::class, 'create'])->name('admin.menu.create');
    Route::post('/admin/menu', [MenuController::class, 'store'])->name('admin.menu.store');
    Route::get('/admin/menu/{id}', [MenuController::class, 'show'])->name('admin.menu.show');
    Route::get('/admin/menu/{id}/edit', [MenuController::class, 'edit'])->name('admin.menu.edit');
    Route::put('/admin/menu/{id}', [MenuController::class, 'update'])->name('admin.menu.update');
    Route::delete('/admin/menu/{id}', [MenuController::class, 'destroy'])->name('admin.menu.destroy');

    // Routes untuk Category
    Route::get('/admin/category', [CategoryController::class, 'adminIndex'])->name('admin.category.index');
    Route::get('/admin/category/create', [CategoryController::class, 'create'])->name('admin.category.create');
    Route::post('/admin/category', [CategoryController::class, 'store'])->name('admin.category.store');
    Route::get('/admin/category/{id}/edit', [CategoryController::class, 'edit'])->name('admin.category.edit');
    Route::put('/admin/category/{id}', [CategoryController::class, 'update'])->name('admin.category.update');
    Route::delete('/admin/category/{id}/destroy', [CategoryController::class, 'destroy'])->name('admin.category.destroy');

    Route::get('/admin/meja', [MejaController::class, 'adminIndex'])->name('admin.meja.index');
    Route::get('/admin/meja/create', [MejaController::class, 'create'])->name('admin.meja.create');
    Route::post('/admin/meja', [MejaController::class, 'store'])->name('admin.meja.store');
    Route::get('/admin/meja/{id}/edit', [MejaController::class, 'edit'])->name('admin.meja.edit');
    Route::put('/admin/meja/{id}', [MejaController::class, 'update'])->name('admin.meja.update');
    Route::delete('/admin/meja/{id}/destroy', [MejaController::class, 'destroy'])->name('admin.meja.destroy');
});





Route::middleware('auth')->group(function () {


Route::post('/ulasans', [UlasanController::class, 'store'])->name('ulasans.store');

Route::get('/menu/{id}', [MenuController::class, 'usershow'])->name('user.menu.show');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/reservasi', [ReservasiController::class, 'index'])->name('user.reservasi.index');

    // Rute untuk menampilkan form pembuatan reservasi
    Route::get('/reservasi/create', [ReservasiController::class, 'create'])->name('user.reservasi.create');

    // Rute untuk menyimpan data reservasi
    Route::post('/reservasi', [ReservasiController::class, 'store'])->name('user.reservasi.store');
    Route::get('/reservasi/{id}', [ReservasiController::class, 'show'])->name('user.reservasi.show');
    Route::get('/reservasi/{id}/edit', [ReservasiController::class, 'edit'])->name('user.reservasi.edit');
    Route::put('/reservasi/{id}', [ReservasiController::class, 'update'])->name('user.reservasi.update');
    Route::delete('/reservasi/{id}', [ReservasiController::class, 'destroy'])->name('user.reservasi.destroy');
    Route::get('/cancel/{reservasi}', [ReservasiController::class, 'cancel'])->name('user.reservasi.cancel');
    Route::get('/reservasi/{reservasi}/remaining-time', [ReservasiController::class, 'getRemainingTime'])
        ->name('user.reservasi.remaining-time ');
        Route::get('/reservasi/{reservasi}/payment', 
        [PaymentController::class, 'showPaymentPage'])
        ->name('user.reservasi.payment');
    
    Route::post('/reservasi/{reservasi}/payment', 
        [PaymentController::class, 'processPayment'])
        ->name('user.reservasi.payment.process');
        Route::get('/reservasi/{reservasi}/prevent-auto-cancel', 
    [ReservasiController::class, 'preventAutoCancel'])
    ->name('user.reservasi.prevent-auto-cancel');
});

require __DIR__ . '/auth.php';

Route::get('/profil', function () {
    return view('pages.user.profile.index');
});

Route::get('/menu', [MenuController::class, 'index'])->name('menus.index');

Route::get('/contact', function () {
    return view('pages.user.contact.index');
});
