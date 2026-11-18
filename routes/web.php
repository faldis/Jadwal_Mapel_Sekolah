<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\MapelController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\JadwalController;
use Illuminate\Support\Facades\Route;

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Data Master
    Route::resource('guru', GuruController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('mapel', MapelController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('kelas', KelasController::class)->only(['index', 'store', 'update', 'destroy']);

    // Jadwal
    Route::get('/jadwal', [JadwalController::class, 'index'])->name('jadwal.index');
    Route::post('/jadwal', [JadwalController::class, 'store'])->name('jadwal.store');
    Route::post('/jadwal/hapus', [JadwalController::class, 'hapus'])->name('jadwal.hapus');
    Route::post('/jadwal/cek-bentrok', [JadwalController::class, 'cekBentrok'])->name('jadwal.cekBentrok');

    // Export
    Route::get('/export', [JadwalController::class, 'export'])->name('export.index');
    Route::get('/export/kelas/{id}', [JadwalController::class, 'exportPerKelas'])->name('export.kelas');
    Route::get('/export/guru/{id}', [JadwalController::class, 'exportPerGuru'])->name('export.guru');
});
