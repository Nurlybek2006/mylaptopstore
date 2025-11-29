<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// Басты бет
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');

// Продуктілер
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

// Категориялар
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{id}', [CategoryController::class, 'show'])->name('categories.show');

// Аутентификация (уақытша)
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/logout', function () {
    return redirect('/');
})->name('logout');

// Себет (уақытша)
Route::get('/cart', function () {
    return view('cart');
})->name('cart');

// Профиль (уақытша)
Route::get('/profile', function () {
    return view('profile');
})->name('profile');

// Админ (уақытша)
Route::get('/admin', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');

// Marketplace (уақытша)
Route::get('/marketplace', function () {
    return view('marketplace');
})->name('marketplace');