<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// Dashboard view
Route::middleware('auth')->prefix('/dashboard')->group(function () {
    Route::get('/', DashboardController::class)->name('dashboard');
});

// Products routes
Route::middleware('auth')->prefix('/products')->group(function () {
    // Products view
    Route::get('/', [ProductController::class, 'index'])->name('products.index');
    Route::get('/create', [ProductController::class, 'create'])->name('products.create');
    Route::get('/{id}', [ProductController::class, 'show'])->name('products.show');

    Route::patch('/{id}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::post('/', [ProductController::class, 'store'])->name('products.store');
});

// Users routes
Route::middleware(['auth', 'admin'])->prefix('/users')->group(function () {
    // Users view
    Route::get('/', [UserController::class, 'index'])->name('users.index');
    Route::get('/create', [UserController::class, 'create'])->name('users.create');
    Route::get('/{id}', [UserController::class, 'show'])->name('users.show');

    Route::patch('/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::post('/', [UserController::class, 'store'])->name('users.store');
});

// Categories routes
Route::middleware(['auth', 'admin'])->prefix('/categories')->group(function () {
    // Users view
    Route::get('/', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::get('/{id}', [CategoryController::class, 'show'])->name('categories.show');

    Route::patch('/{id}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    Route::post('/', [CategoryController::class, 'store'])->name('categories.store');
});

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
