<?php

use App\Http\Controllers\Admin\KelasController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Models\Siswa;
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

Route::middleware(['auth'])->group(function () {
    Route::get('home', [HomeController::class, 'index'])->name('home');
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Route Admin
    Route::get('admin/siswa', [SiswaController::class, 'index'])->name('siswa');
    Route::post('admin/siswa', [SiswaController::class, 'store'])->name('siswa.store');
    Route::get('admin/siswa/{id}/edit', [SiswaController::class, 'edit'])->name('siswa.edit');
    Route::post('admin/siswa/{id}', [SiswaController::class, 'update'])->name('siswa.update');
    // Route Admin Kelas
    Route::get('kelas', [KelasController::class, 'index'])->name('kelas');
    // Route Admin User
    Route::get('user', [UserController::class, 'index'])->name('user');
    // Route Petugas
    // Route Siswa

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
