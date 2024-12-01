<?php

use App\Http\Controllers\ProfileController;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\CategoryController;

Route::get('/', function () {
    return view('welcome');
});




// Rute untuk admin
Route::middleware(['auth', RoleMiddleware::class . ':admin'])->group(function () {
    Route::get('/admin', function () {
        return view('pages.admin.dashboard'); // Halaman Admin
    })->name('admin.dashboard');

    // Routes untuk Menu
    Route::get('/admin/menu', [MenuController::class, 'adminIndex'])->name('admin.menu.index');
    Route::get('/admin/menu/create', [MenuController::class, 'create'])->name('admin.menu.create');
    Route::post('/admin/menu', [MenuController::class, 'store'])->name('admin.menu.store');
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
});


Route::middleware('auth')->get('/dashboard', function () {
    return view('dashboard'); // Halaman dashboard
})->name('dashboard');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('/reservasi', function () {
    return view('pages.user.reservasi.index');
});
 
Route::get('/profil', function () {
    return view('pages.user.profile.index');
});

Route::get('/menu', function () {
    return view('pages.user.menu.index');
});

Route::get('/contact', function () {
    return view('pages.user.contact.index');
});
