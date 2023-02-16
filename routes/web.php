<?php

use App\Http\Controllers\Admin\KelasController;
use App\Http\Controllers\Admin\PetugasController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
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
});

Route::prefix('admin')
    ->namespace('Admin')
    ->middleware(['auth'])
    ->group(function () {
        Route::middleware(['role:admin'])->group(function () {
            Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
            // User
            Route::get('user', [UserController::class, 'index'])->name('user.index');
            Route::post('user/store', [UserController::class, 'store'])->name('user.store');
            Route::get('user/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
            Route::post('user/{id}/update', [UserController::class, 'update'])->name('user.update');
            Route::delete('user/{id}/delete', [UserController::class, 'destroy'])->name('user.delete');
            // Petugas
            Route::get('petugas', [PetugasController::class, 'index'])->name('petugas.index');
        });
        Route::middleware(['role:admin|petugas'])->group(function () {
            // Siswa
            Route::get('siswa', [SiswaController::class, 'index'])->name('siswa.index');
            Route::post('siswa/store', [SiswaController::class, 'store'])->name('siswa.store');
            Route::get('siswa/{id}/edit', [SiswaController::class, 'edit'])->name('siswa.edit');
            Route::post('siswa/{id}/update', [SiswaController::class, 'update'])->name('siswa.update');
            Route::delete('siswa/{id}/delete', [SiswaController::class, 'destroy'])->name('siswa.delete');
            // Kelas
            Route::get('kelas', [KelasController::class, 'index'])->name('kelas.index');
            Route::post('kelas/store', [KelasController::class, 'store'])->name('kelas.store');
            Route::get('kelas/{id}/edit', [KelasController::class, 'edit'])->name('kelas.edit');
            Route::post('kelas/{id}/update', [KelasController::class, 'update'])->name('kelas.update');
            Route::delete('kelas/{id}/delete', [KelasController::class, 'destroy'])->name('kelas.delete');
        });
    });

require __DIR__ . '/auth.php';
