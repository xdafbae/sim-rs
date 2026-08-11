<?php

use App\Http\Controllers\PolaTarifController;
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
    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */
    // Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])
    //     ->name('admin.dashboard');
    /*
    |--------------------------------------------------------------------------
    | Master Tarif
    |--------------------------------------------------------------------------
    */

    Route::get('/pola-tarif', [PolaTarifController::class, 'show'])
        ->name('pola_tarif.show');
    Route::get('/pola-tarif/create', [PolaTarifController::class, 'create'])
        ->name('pola_tarif.create');
    Route::post('/pola-tarif', [PolaTarifController::class, 'store'])
        ->name('pola_tarif.store');
    Route::get('/pola-tarif/{polaTarif}/edit', [PolaTarifController::class, 'edit'])
        ->name('pola_tarif.edit');
    Route::put('/pola-tarif/{polaTarif}', [PolaTarifController::class, 'update'])
        ->name('pola_tarif.update');
    Route::delete('/pola-tarif/bulk-delete', [PolaTarifController::class, 'bulkDestroy'])
        ->name('pola_tarif.bulk_destroy');
    Route::delete('/pola-tarif/{polaTarif}', [PolaTarifController::class, 'destroy'])
        ->name('pola_tarif.destroy');

    // Route::get('/cara-bayar', [CaraBayarController::class, 'show'])
    //     ->name('cara_bayar.show');

    // Route::get('/kelas-perawatan', [KelasPerawatanController::class, 'show'])
    //     ->name('kelas_perawatan.show');


    /*
    |--------------------------------------------------------------------------
    | Master Ruangan
    |--------------------------------------------------------------------------
    */

    // Route::get('/kelas-rajal', [KelasRajalController::class, 'show'])
    //     ->name('kelas_rajal.show');

    // Route::get('/bangsal', [BangsalController::class, 'show'])
    //     ->name('bangsal.show');

    // Route::get('/distribusi-tt', [DistribusiController::class, 'show'])
    //     ->name('distribusi.show');


    /*
    |--------------------------------------------------------------------------
    | Administrasi Sistem
    |--------------------------------------------------------------------------
    */

    // Route::get('/user-account', [UserController::class, 'user_akun'])
    //     ->name('user.user_akun');

    // Route::get('/user-log', [UserLogController::class, 'show'])
    //     ->name('userlog.show');

    // Route::get('/tte-log', [TteLogController::class, 'show'])
    //     ->name('ttelog.show');
});

require __DIR__ . '/auth.php';
