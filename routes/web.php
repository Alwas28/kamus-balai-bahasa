<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\WordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'permission:dashboard.read'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::middleware('permission:kategori.read')->group(function () {
        Route::get('/kategori', [CategoryController::class, 'index'])->name('categories.index');
    });
    Route::middleware('permission:kategori.tambah')->group(function () {
        Route::get('/kategori/tambah', [CategoryController::class, 'create'])->name('categories.create');
        Route::post('/kategori', [CategoryController::class, 'store'])->name('categories.store');
    });
    Route::middleware('permission:kategori.edit')->group(function () {
        Route::get('/kategori/{category}/ubah', [CategoryController::class, 'edit'])->name('categories.edit');
        Route::put('/kategori/{category}', [CategoryController::class, 'update'])->name('categories.update');
    });
    Route::middleware('permission:kategori.delete')->group(function () {
        Route::delete('/kategori/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    });

    Route::middleware('permission:kata.read')->group(function () {
        Route::get('/kata', [WordController::class, 'index'])->name('words.index');
    });
    Route::middleware('permission:kata.tambah')->group(function () {
        Route::get('/kata/tambah', [WordController::class, 'create'])->name('words.create');
        Route::post('/kata', [WordController::class, 'store'])->name('words.store');
    });
    Route::middleware('permission:kata.edit')->group(function () {
        Route::get('/kata/{word}/ubah', [WordController::class, 'edit'])->name('words.edit');
        Route::put('/kata/{word}', [WordController::class, 'update'])->name('words.update');
    });
    Route::middleware('permission:kata.delete')->group(function () {
        Route::delete('/kata/{word}', [WordController::class, 'destroy'])->name('words.destroy');
    });

    Route::middleware('permission:pengguna.read')->group(function () {
        Route::get('/pengguna', [UserController::class, 'index'])->name('users.index');
    });
    Route::middleware('permission:pengguna.tambah')->group(function () {
        Route::get('/pengguna/tambah', [UserController::class, 'create'])->name('users.create');
        Route::post('/pengguna', [UserController::class, 'store'])->name('users.store');
    });
    Route::middleware('permission:pengguna.edit')->group(function () {
        Route::get('/pengguna/{user}/ubah', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/pengguna/{user}', [UserController::class, 'update'])->name('users.update');
    });
    Route::middleware('permission:pengguna.delete')->group(function () {
        Route::delete('/pengguna/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    });

    Route::middleware('permission:role.read')->group(function () {
        Route::get('/role', [RoleController::class, 'index'])->name('roles.index');
    });
    Route::middleware('permission:role.tambah')->group(function () {
        Route::get('/role/tambah', [RoleController::class, 'create'])->name('roles.create');
        Route::post('/role', [RoleController::class, 'store'])->name('roles.store');
    });
    Route::middleware('permission:role.edit')->group(function () {
        Route::get('/role/{role}/ubah', [RoleController::class, 'edit'])->name('roles.edit');
        Route::put('/role/{role}', [RoleController::class, 'update'])->name('roles.update');
    });
    Route::middleware('permission:role.delete')->group(function () {
        Route::delete('/role/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');
    });
});

require __DIR__.'/auth.php';
