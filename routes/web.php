<?php

use App\Http\Controllers\HalamanController;

use App\Http\Controllers\AuthController;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/halo', function () {
    return 'Halo, ini halaman pertamaku!';
});

Route::get('/halaman', [HalamanController::class, 'index']);



// Halaman login
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Halaman register
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard (halaman setelah login)
Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

Route::post('/dashboard/avatar', [AuthController::class, 'updateAvatar'])->name('avatar.update');


