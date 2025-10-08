<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DepositController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\FlashSaleController;
use App\Http\Controllers\SettingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ===============================
// FRONTEND ROUTES (Public)
// ===============================

// Home & Game Pages
Route::get('/', [PageController::class, 'index'])->name('home');
Route::get('/game/{slug}', [PageController::class, 'showGame'])->name('game.show');
Route::get('/games', [PageController::class, 'games'])->name('games');
Route::get('/flash-sale', [PageController::class, 'flashSale'])->name('flash-sale');
Route::get('/news', [PageController::class, 'news'])->name('news');
Route::get('/news/{slug}', [PageController::class, 'newsDetail'])->name('news.detail');

// Order Routes (Public)
Route::post('/order', [OrderController::class, 'store'])->name('order.store');
Route::get('/order/success/{orderId}', [OrderController::class, 'success'])->name('order.success');
Route::post('/order/check', [OrderController::class, 'check'])->name('order.check');
Route::get('/order/track', [OrderController::class, 'trackPage'])->name('order.track');

// Additional Pages
// Route::get('/about', [PageController::class, 'about'])->name('about');
// Route::get('/contact', [PageController::class, 'contact'])->name('contact');
// Route::get('/faq', [PageController::class, 'faq'])->name('faq');
// Route::get('/terms', [PageController::class, 'terms'])->name('terms');
// Route::get('/privacy', [PageController::class, 'privacy'])->name('privacy');

// AJAX Routes
Route::post('/check-server-id', [PageController::class, 'checkServerId'])->name('check.server');
Route::get('/payment-methods', [PageController::class, 'getPaymentMethods'])->name('payment.methods');
Route::get('/search', [PageController::class, 'search'])->name('search');

// ===============================
// AUTHENTICATION ROUTES
// ===============================

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/logout', [AuthController::class, 'logout']); // Support GET for simple link

// ===============================
// PROTECTED USER ROUTES
// ===============================

Route::middleware('auth')->group(function () {

    // Profile & Dashboard
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::put('/profile', [UserController::class, 'updateProfile'])->name('profile.update');
    Route::put('/profile/password', [UserController::class, 'updatePassword'])->name('profile.password');

    // User Orders
    Route::get('/orders', [OrderController::class, 'userOrders'])->name('orders');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');

    // User Deposits
    Route::get('/deposit', [DepositController::class, 'index'])->name('deposit');
    Route::post('/deposit', [DepositController::class, 'store'])->name('deposit.store');
    Route::get('/deposit/history', [DepositController::class, 'history'])->name('deposit.history');
});

// ===============================
// ADMIN ROUTES (with auth + admin middleware)
// ===============================

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // ===============================
    // USERS MANAGEMENT
    // ===============================
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'users'])->name('index');
        Route::get('/create', [UserController::class, 'createUser'])->name('create');
        Route::post('/', [UserController::class, 'storeUser'])->name('store');
        Route::get('/{id}/edit', [UserController::class, 'editUser'])->name('edit');
        Route::put('/{id}', [UserController::class, 'updateUser'])->name('update');
        Route::delete('/{id}', [UserController::class, 'deleteUser'])->name('delete');
        Route::post('/{id}/balance', [UserController::class, 'updateBalance'])->name('balance');
    });

    // ===============================
    // GAMES MANAGEMENT (DIPERBAIKI)
    // ===============================
    Route::prefix('games')->name('games.')->group(function () {
        Route::get('/', [GameController::class, 'games'])->name('index');
        Route::get('/create', [GameController::class, 'createGame'])->name('create');
        Route::post('/', [GameController::class, 'storeGame'])->name('store');
        Route::get('/{id}/edit', [GameController::class, 'editGame'])->name('edit');
        Route::put('/{id}', [GameController::class, 'updateGame'])->name('update');
        Route::delete('/{id}', [GameController::class, 'deleteGame'])->name('delete');
        Route::post('/{id}/toggle-status', [GameController::class, 'toggleStatus'])->name('toggle-status');
    });

    // ===============================
    // PRODUCTS MANAGEMENT
    // ===============================
    Route::prefix('products')->name('products.')->group(function () {
        Route::get('/', [ProductController::class, 'products'])->name('index');
        Route::get('/create', [ProductController::class, 'createProduct'])->name('create');
        Route::post('/', [ProductController::class, 'storeProduct'])->name('store');
        Route::get('/{id}/edit', [ProductController::class, 'editProduct'])->name('edit');
        Route::put('/{id}', [ProductController::class, 'updateProduct'])->name('update');
        Route::delete('/{id}', [ProductController::class, 'deleteProduct'])->name('delete');
    });

    // ===============================
    // ORDERS MANAGEMENT
    // ===============================
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [OrderController::class, 'orders'])->name('index');
        Route::get('/{id}', [OrderController::class, 'orderDetail'])->name('show');
        Route::post('/{id}/status', [OrderController::class, 'updateStatus'])->name('status');
        Route::post('/{id}/process', [OrderController::class, 'processOrder'])->name('process');
    });

    // ===============================
    // DEPOSITS MANAGEMENT
    // ===============================
    Route::prefix('deposits')->name('deposits.')->group(function () {
        Route::get('/', [DepositController::class, 'deposits'])->name('index');
        Route::get('/{id}', [DepositController::class, 'depositDetail'])->name('show');
        Route::post('/{id}/approve', [DepositController::class, 'approveDeposit'])->name('approve');
        Route::post('/{id}/reject', [DepositController::class, 'rejectDeposit'])->name('reject');
    });

    // ===============================
    // PAYMENTS MANAGEMENT
    // ===============================
    Route::prefix('payments')->name('payments.')->group(function () {
        Route::get('/', [PaymentController::class, 'payments'])->name('index');
        Route::get('/create', [PaymentController::class, 'createPayment'])->name('create');
        Route::post('/', [PaymentController::class, 'storePayment'])->name('store');
        Route::get('/{id}/edit', [PaymentController::class, 'editPayment'])->name('edit');
        Route::put('/{id}', [PaymentController::class, 'updatePayment'])->name('update');
        Route::delete('/{id}', [PaymentController::class, 'deletePayment'])->name('delete');
    });

    // ===============================
    // NEWS MANAGEMENT
    // ===============================
    Route::prefix('news')->name('news.')->group(function () {
        Route::get('/', [NewsController::class, 'newsList'])->name('index');
        Route::get('/create', [NewsController::class, 'createNews'])->name('create');
        Route::post('/', [NewsController::class, 'storeNews'])->name('store');
        Route::get('/{id}/edit', [NewsController::class, 'editNews'])->name('edit');
        Route::put('/{id}', [NewsController::class, 'updateNews'])->name('update');
        Route::delete('/{id}', [NewsController::class, 'deleteNews'])->name('delete');
    });

    // ===============================
    // BANNERS MANAGEMENT
    // ===============================
    Route::prefix('banners')->name('banners.')->group(function () {
        Route::get('/', [BannerController::class, 'banners'])->name('index');
        Route::get('/create', [BannerController::class, 'createBanner'])->name('create');
        Route::post('/', [BannerController::class, 'storeBanner'])->name('store');
        Route::get('/{id}/edit', [BannerController::class, 'editBanner'])->name('edit');
        Route::put('/{id}', [BannerController::class, 'updateBanner'])->name('update');
        Route::delete('/{id}', [BannerController::class, 'deleteBanner'])->name('delete');
    });

    // ===============================
    // FLASH SALES MANAGEMENT
    // ===============================
    Route::get('/flash-sales', [FlashSaleController::class, 'index'])->name('flash-sales.index');
    Route::get('/flash-sales/create', [FlashSaleController::class, 'create'])->name('flash-sales.create');
    Route::post('/flash-sales', [FlashSaleController::class, 'store'])->name('flash-sales.store');
    Route::get('/flash-sales/{id}/edit', [FlashSaleController::class, 'edit'])->name('flash-sales.edit');
    Route::put('/flash-sales/{id}', [FlashSaleController::class, 'update'])->name('flash-sales.update');
    Route::delete('/flash-sales/{id}', [FlashSaleController::class, 'destroy'])->name('flash-sales.destroy');

    // ===============================
    // SETTINGS MANAGEMENT
    // ===============================
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/', [SettingController::class, 'settings'])->name('index');
        Route::put('/', [SettingController::class, 'updateSettings'])->name('update');
    });

    // ===============================
    // REPORTS & ANALYTICS
    // ===============================
    // Route::prefix('reports')->name('reports.')->group(function () {
    //     Route::get('/sales', [AdminController::class, 'salesReport'])->name('sales');
    //     Route::get('/revenue', [AdminController::class, 'revenueReport'])->name('revenue');
    //     Route::get('/users', [AdminController::class, 'usersReport'])->name('users');
    //     Route::get('/export', [AdminController::class, 'exportReport'])->name('export');
    // });
});