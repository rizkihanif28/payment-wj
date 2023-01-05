<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth/login');
});

// Route::middleware(['auth', 'role:admin|petugas'])->get('dashboard', [DashboardController::class, 'index'])
//     ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('siswa', [SiswaController::class, 'index'])->name('siswa');
    Route::get('user', [UserController::class, 'index'])->name('user');
});

// Route::prefix('admin')
//     ->middleware(['auth'])
//     ->group(function () {
//         Route::middleware(['role:admin'])->group(function () {
//             Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
//             Route::resource('user', 'UserController');
//         });
//         Route::middleware(['role:admin|petugas'])->group(function () {
//             Route::resource('siswa', 'SiswaController');
//         });
//     });

require __DIR__ . '/auth.php';
