<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// Route principale
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Routes d'authentification basiques
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
