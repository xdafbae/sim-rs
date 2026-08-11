<?php

use App\Http\Controllers\JadwalOperasiController;
use App\Http\Controllers\ProfileController;
use App\Models\User;
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
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard', [
        'totalUsers' => User::count(),
        'superAdminCount' => User::where('role', 'superadmin')->count(),
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/jadwal-operasi', [JadwalOperasiController::class, 'index'])->name('jadwal-operasi.index');
    Route::get('/jadwal-operasi/data', [JadwalOperasiController::class, 'data'])->name('jadwal-operasi.data');
    Route::get('/jadwal-operasi/tambah', [JadwalOperasiController::class, 'create'])->name('jadwal-operasi.create');
    Route::post('/jadwal-operasi', [JadwalOperasiController::class, 'store'])->name('jadwal-operasi.store');
    Route::get('/jadwal-operasi/{jadwalOperasi}/edit', [JadwalOperasiController::class, 'edit'])->name('jadwal-operasi.edit');
    Route::patch('/jadwal-operasi/{jadwalOperasi}', [JadwalOperasiController::class, 'update'])->name('jadwal-operasi.update');
    Route::delete('/jadwal-operasi/{jadwalOperasi}', [JadwalOperasiController::class, 'destroy'])->name('jadwal-operasi.destroy');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
