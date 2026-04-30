<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\MarketplaceController;
use App\Http\Controllers\ChatbotController;
use Illuminate\Support\Facades\Route;

// Аутентификация маршруттары
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Logout - тек кірген пайдаланушылар
Route::middleware(['auth'])->post('/logout', [AuthController::class, 'logout'])->name('logout');

// Басты бет
Route::get('/', [HomeController::class, 'index'])->name('home');




// Продуктілер
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

// Категориялар
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{id}', [CategoryController::class, 'show'])->name('categories.show');

// Себет маршруттары
Route::middleware(['auth'])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::get('/cart/remove/{product}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
    Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
    Route::post('/cart/stripe-checkout', [CartController::class, 'stripeCheckout'])->name('cart.stripe-checkout');
});

// Stripe маршруттары
Route::middleware(['auth'])->group(function () {
    Route::post('/stripe/checkout', [StripeController::class, 'checkout'])->name('stripe.checkout');
    Route::get('/stripe/success', [StripeController::class, 'success'])->name('stripe.success');
    Route::get('/stripe/cancel', [StripeController::class, 'cancel'])->name('stripe.cancel');
});

// Профиль маршруттары
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar');
    Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
});

// Байланыс маршруттары
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact/message', [ContactController::class, 'storeContact'])->name('contact.message');
Route::post('/contact/laptop-request', [ContactController::class, 'storeLaptopRequest'])->name('contact.laptop-request');

// Біз туралы бет
Route::get('/about', [AboutController::class, 'index'])->name('about.index');

// Админ маршруттары
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/', [AdminController::class, 'dashboard'])->name('index');
    
    // Категориялар
    Route::get('/categories', [CategoryController::class, 'adminIndex'])->name('categories.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    Route::post('/categories/merge', [CategoryController::class, 'mergeCategories'])->name('categories.merge');
    
    // Өнімдер
    Route::get('/products', [AdminProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [AdminProductController::class, 'create'])->name('products.create');
    Route::post('/products', [AdminProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [AdminProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [AdminProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [AdminProductController::class, 'destroy'])->name('products.destroy');
    
    // Пайдаланушылар
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}/edit', [AdminUserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [AdminUserController::class, 'update'])->name('users.update');
    Route::put('/users/{user}/role', [AdminUserController::class, 'updateRole'])->name('users.update-role');
    Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');
    
    // Тапсырыстар
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::put('/orders/{order}', [AdminOrderController::class, 'update'])->name('orders.update');
    Route::delete('/orders/{order}', [AdminOrderController::class, 'destroy'])->name('orders.destroy');
    
    // Ноутбук сұраныстары
    Route::put('/laptop-requests/{request}/status', [AdminOrderController::class, 'updateRequestStatus'])->name('requests.update-status');
    Route::delete('/laptop-requests/{request}', [AdminOrderController::class, 'destroyRequest'])->name('requests.destroy');
});

// Webhook (CSRF қорғаныссыз) - бұл жеке жолға қою керек
Route::post('/stripe/webhook', [StripeController::class, 'webhook'])->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);

// Marketplace маршруттары
Route::prefix('marketplace')->name('marketplace.')->group(function () {
    // Басты бет
    Route::get('/', [MarketplaceController::class, 'index'])->name('index');

        // Тауарды хабарлама арқылы байланысу
    Route::middleware(['auth'])->post('/product/{id}/message', [MarketplaceController::class, 'sendProductMessage'])->name('send-product-message');

        // Тауарды көрсету
    Route::get('/product/{id}', [MarketplaceController::class, 'show'])->name('show');
    
    // Аутентификация қажет маршруттар
    Route::middleware(['auth'])->group(function () {
        // Тауар операциялары
        Route::get('/add', [MarketplaceController::class, 'create'])->name('create');
        Route::post('/add', [MarketplaceController::class, 'store'])->name('store');
        Route::get('/my-products', [MarketplaceController::class, 'myProducts'])->name('myProducts');
        Route::post('/product/{id}/status', [MarketplaceController::class, 'updateStatus'])->name('update-status');
        Route::get('/edit/{product}', [MarketplaceController::class, 'edit'])->name('edit');

        Route::put('/update/{product}', [MarketplaceController::class, 'update'])->name('update');
        Route::delete('/delete/{product}', [MarketplaceController::class, 'destroy'])->name('destroy');
        
        // Хабарлама операциялары
        Route::post('/message/send', [MarketplaceController::class, 'sendMessage'])->name('sendMessage');
        Route::post('/interest/{product}', [MarketplaceController::class, 'addInterest'])->name('addInterest');
        
        // Чат операциялары
        Route::get('/chats', [MarketplaceController::class, 'chats'])->name('chats');
        Route::get('/chat/{user}', [MarketplaceController::class, 'chat'])->name('chat');
        Route::get('/messages/{user}', [MarketplaceController::class, 'getMessages'])->name('getMessages');
        Route::post('/send-chat-message', [MarketplaceController::class, 'sendChatMessage'])->name('sendChatMessage');
    });
});

// Бот-консультант маршруттары
Route::prefix('chatbot')->group(function () {
    Route::post('/chat', [ChatbotController::class, 'chat'])->name('chatbot.chat');
    Route::post('/email', [ChatbotController::class, 'sendEmail'])->name('chatbot.email');
});


