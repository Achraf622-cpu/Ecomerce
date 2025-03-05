<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    CategoryController,
    ProductController,
    CartController,
    OrderController,
    PaymentController,
    ReviewController
};

// Routes publiques
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Routes pour le catalogue de produits (publiques)
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product:slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('/categories/{category:slug}', [CategoryController::class, 'show'])->name('categories.show');

// Routes nécessitant une authentification
Route::middleware(['auth'])->group(function () {
    // Routes du panier
    Route::prefix('cart')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('cart.index');
        Route::post('/add', [CartController::class, 'addItem'])->name('cart.add');
        Route::patch('/items/{item}', [CartController::class, 'updateQuantity'])->name('cart.update');
        Route::delete('/items/{item}', [CartController::class, 'removeItem'])->name('cart.remove');
        Route::delete('/clear', [CartController::class, 'clear'])->name('cart.clear');
    });

    // Routes des commandes
    Route::prefix('orders')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('orders.index');
        Route::post('/', [OrderController::class, 'store'])->name('orders.store');
        Route::get('/{order}', [OrderController::class, 'show'])->name('orders.show');
    });

    // Routes des paiements
    Route::prefix('payments')->group(function () {
        Route::get('/process/{order}', [PaymentController::class, 'process'])->name('payments.process');
        Route::post('/webhook', [PaymentController::class, 'webhook'])->name('payments.webhook');
    });

    // Routes des avis
    Route::post('/products/{product}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
});

// Routes admin (nécessitant le rôle administrateur)
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    // Gestion des catégories
    Route::prefix('categories')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('admin.categories.index');
        Route::get('/create', [CategoryController::class, 'create'])->name('admin.categories.create');
        Route::post('/', [CategoryController::class, 'store'])->name('admin.categories.store');
        Route::get('/{category}/edit', [CategoryController::class, 'edit'])->name('admin.categories.edit');
        Route::put('/{category}', [CategoryController::class, 'update'])->name('admin.categories.update');
        Route::delete('/{category}', [CategoryController::class, 'destroy'])->name('admin.categories.destroy');
    });

    // Gestion des produits
    Route::prefix('products')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('admin.products.index');
        Route::get('/create', [ProductController::class, 'create'])->name('admin.products.create');
        Route::post('/', [ProductController::class, 'store'])->name('admin.products.store');
        Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('admin.products.edit');
        Route::put('/{product}', [ProductController::class, 'update'])->name('admin.products.update');
        Route::delete('/{product}', [ProductController::class, 'destroy'])->name('admin.products.destroy');
    });

    // Gestion des commandes (admin)
    Route::prefix('orders')->group(function () {
        Route::get('/', [OrderController::class, 'adminIndex'])->name('admin.orders.index');
        Route::get('/{order}', [OrderController::class, 'adminShow'])->name('admin.orders.show');
        Route::patch('/{order}/status', [OrderController::class, 'updateStatus'])->name('admin.orders.update-status');
    });

    // Gestion des avis (admin)
    Route::prefix('reviews')->group(function () {
        Route::get('/', [ReviewController::class, 'index'])->name('admin.reviews.index');
        Route::patch('/{review}/status', [ReviewController::class, 'updateStatus'])->name('admin.reviews.update-status');
        Route::delete('/{review}', [ReviewController::class, 'destroy'])->name('admin.reviews.destroy');
    });
});

// Middleware pour l'authentification
require __DIR__.'/auth.php';
