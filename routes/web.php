<?php

use App\Http\Controllers\Admin\KelasController;
use App\Http\Controllers\Admin\PeriodeController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\PetugasController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\RoleListController;
use App\Http\Controllers\Admin\RolePermissionController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Models\Petugas;
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
            Route::post('petugas/store', [PetugasController::class, 'store'])->name('petugas.store');
            Route::get('petugas/{id}/edit', [PetugasController::class, 'edit'])->name('petugas.edit');
            Route::post('petugas/{id}/update', [PetugasController::class, 'update'])->name('petugas.update');
            Route::delete('petugas/{id}/delete', [PetugasController::class, 'destroy'])->name('petugas.delete');
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
            // Periode
            Route::get('periode', [PeriodeController::class, 'index'])->name('periode.index');
            Route::post('periode/store', [PeriodeController::class, 'store'])->name('periode.store');
            Route::get('periode/{id}/edit', [PeriodeController::class, 'edit'])->name('periode.edit');
            Route::post('periode/{id}/update', [PeriodeController::class, 'update'])->name('periode.update');
            Route::delete('periode/{id}/delete', [PeriodeController::class, 'destroy'])->name('periode.delete');
            // Permission List
            Route::get('permission', [PermissionController::class, 'index'])->name('permission.index');
            Route::post('permission/store', [PermissionController::class, 'store'])->name('permission.store');
            // Role Permission
            Route::get('role-permission', [RolePermissionController::class, 'index'])->name('role-permission.index');
            Route::get('role-permission/create/{id}', [RolePermissionController::class, 'create'])->name('role-permission.create');
            Route::post('role-permission/store/{id}', [RolePermissionController::class, 'store'])->name('role-permission.store');
            // List Role
            Route::get('roles', [RoleController::class, 'index'])->name('roles.index');
        });
    });

require __DIR__ . '/auth.php';
