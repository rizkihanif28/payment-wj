<?php

use App\Http\Controllers\Admin\KelasController;
use App\Http\Controllers\Admin\ManajemenPembayaranController;
use App\Http\Controllers\Admin\PembayaranController as AdminPembayaranController;
use App\Http\Controllers\Admin\PeriodeController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\PetugasController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\RolePermissionController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\UserPermissionController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SiswaController as ControllersSiswaController;
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

Route::prefix('pembayaran')->middleware(['auth', 'role:admin|petugas'])->group(function () {
    Route::get('index', [PembayaranController::class, 'index'])->name('pembayaran.index');
    Route::get('form/{nisn}', [PembayaranController::class, 'formBayar'])->name('pembayaran.form');
    Route::get('spp/{tahun}', [PembayaranController::class, 'periode'])->name('pembayaran.spp');
    Route::post('pembayaran-detail', [PembayaranController::class, 'bayarValidate'])->name('pembayaran.post');
    Route::post('midtrans-callback', [PembayaranController::class, 'callback'])->name('midtrans.callback');
    Route::get('status', [PembayaranController::class, 'statusPembayaran'])->name('pembayaran.status');
    Route::get('status/detail/{siswa:nisn}', [PembayaranController::class, 'statusPembayaranDetail'])->name('pembayaran.status-pembayaran.detail');
    Route::get('status/{nisn}/{tahun}', [PembayaranController::class, 'statusPembayaranList'])->name('pembayaran.status-pembayaran.list');
    Route::get('history-pembayaran', [PembayaranController::class, 'historyPembayaran'])->name('pembayaran.history-pembayaran');
    Route::get('history-print/preview/{id}', [PembayaranController::class, 'printHistoryPembayaran'])->name('pembayaran.history.print');
    Route::get('laporan', [PembayaranController::class, 'laporan'])->name('pembayaran.laporan');
    Route::post('print-laporan', [PembayaranController::class, 'printLaporan'])->name('pembayaran.print-laporan');
    Route::delete('delete/{id}', [PembayaranController::class, 'destroy'])->name('pembayaran.delete');
    Route::get('pembayaran/activity/log', [PembayaranController::class, 'log'])->name('pembayaran.log');
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
            // Permission List
            Route::get('permission', [PermissionController::class, 'index'])->name('permission.index');
            Route::post('permission/store', [PermissionController::class, 'store'])->name('permission.store');
            Route::get('permission/{id}/edit', [PermissionController::class, 'edit'])->name('permission.edit');
            Route::post('permission/{id}/update', [PermissionController::class, 'update'])->name('permission.update');
            Route::delete('permission/{id}/delete', [PermissionController::class, 'destroy'])->name('permission.delete');
            // Role Permission
            Route::get('role-permission', [RolePermissionController::class, 'index'])->name('role-permission.index');
            Route::get('role-permission/create/{id}', [RolePermissionController::class, 'create'])->name('role-permission.create');
            Route::post('role-permission/store/{id}', [RolePermissionController::class, 'store'])->name('role-permission.store');
            // User Permission
            Route::get('user-permission', [UserPermissionController::class, 'index'])->name('user-permission.index');
            Route::get('user-permission/create/{id}', [UserPermissionController::class, 'create'])->name('user-permission.create');
            Route::post('user-permission/store/{id}', [UserPermissionController::class, 'store'])->name('user-permission.store');
            // List Role
            Route::get('roles', [RoleController::class, 'index'])->name('roles.index');
            Route::post('roles/store', [RoleController::class, 'store'])->name('roles.store');
            Route::get('roles/{id}/edit', [RoleController::class, 'edit'])->name('roles.edit');
            Route::post('roles/{id}/update', [RoleController::class, 'update'])->name('roles.update');
            Route::delete('roles/{id}/delete', [RoleController::class, 'destroy'])->name('roles.delete');
        });
        Route::middleware(['role:admin|petugas'])->group(function () {
            // Siswa
            Route::get('siswa', [SiswaController::class, 'index'])->name('siswa.index');
            Route::post('siswa/store', [SiswaController::class, 'store'])->name('siswa.store');
            Route::get('siswa/{id}/edit', [SiswaController::class, 'edit'])->name('siswa.edit');
            Route::post('siswa/{id}/update', [SiswaController::class, 'update'])->name('siswa.update');
            Route::delete('siswa/{id}/delete', [SiswaController::class, 'destroy'])->name('siswa.delete');
            // log activity siswa
            Route::get('siswa/activity/log', [SiswaController::class, 'log'])->name('siswa.log');
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
            // Manajemen Pembayaran
            Route::get('manajemen/pembayaran', [ManajemenPembayaranController::class, 'index'])->name('pembayaran.manajemen');
            Route::delete('pembayaran/{id}/delete', [ManajemenPembayaranController::class, 'destroy'])->name('pembayaran.manajemen.delete');
        });
    });
Route::prefix('profile')->name('profile.')->middleware(['auth'])->group(function () {
    Route::get('/', [ProfileController::class, 'index'])->name('index');
    Route::patch('/', [ProfileController::class, 'update'])->name('update');
});

Route::prefix('siswa')->middleware(['auth', 'role:siswa'])->group(function () {
    Route::get('/history-pembayaran', [ControllersSiswaController::class, 'indexHistory'])->name('siswa.history-pembayaran');
    Route::get('/status-pembayaran', [ControllersSiswaController::class, 'statusPembayaranDetail'])->name('siswa.status-pembayaran.detail');
    Route::get('/status/pembayaran/{tahun}', [ControllersSiswaController::class, 'statusPembayaranBulan'])->name('siswa.status-bulan');
    Route::get('/formBayar/{nisn}', [ControllersSiswaController::class, 'formBayarSiswa'])->name('siswa.formBayar');
    Route::get('/pembayaran/{tahun}', [ControllersSiswaController::class, 'siswaBayarPeriode'])->name('siswa.bayar-periode');
    Route::post('/pembayaran/{nisn}', [ControllersSiswaController::class, 'siswaBayarValidate'])->name('siswa.bayarValidate');
});

require __DIR__ . '/auth.php';
