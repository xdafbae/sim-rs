<?php

use App\Http\Controllers\PolaTarifController;
use App\Http\Controllers\PenjualanObatController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\JadwalOperasiController;
use App\Http\Controllers\PemakaianObatController;
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
    Route::prefix('farmasi')->name('farmasi.')->group(function () {
        Route::get('/penjualan-obat', [PenjualanObatController::class, 'index'])->name('penjualan-obat.index');
        Route::get('/penjualan-obat/create', [PenjualanObatController::class, 'create'])->name('penjualan-obat.create');
        Route::post('/penjualan-obat', [PenjualanObatController::class, 'store'])->name('penjualan-obat.store');
        Route::get('/penjualan-obat/{penjualanObat}/edit', [PenjualanObatController::class, 'edit'])->name('penjualan-obat.edit');
        Route::put('/penjualan-obat/{penjualanObat}', [PenjualanObatController::class, 'update'])->name('penjualan-obat.update');
        Route::delete('/penjualan-obat/{penjualanObat}', [PenjualanObatController::class, 'destroy'])->name('penjualan-obat.destroy');
        Route::view('/pemesanan-obat', 'farmasi.index', ['title' => 'Pemesanan Obat'])->name('pemesanan-obat.index');
        Route::view('/pemasukan-obat', 'farmasi.index', ['title' => 'Pemasukan Obat'])->name('pemasukan-obat.index');
        Route::view('/mutasi-obat', 'farmasi.index', ['title' => 'Mutasi Obat'])->name('mutasi-obat.index');
        Route::view('/jurnal-obat', 'farmasi.index', ['title' => 'Jurnal Obat'])->name('jurnal-obat.index');
        Route::resource('obat', ObatController::class)->except('show');
        Route::view('/persediaan-obat', 'farmasi.index', ['title' => 'Persediaan Obat'])->name('persediaan-obat.index');
        Route::view('/pbf', 'farmasi.index', ['title' => 'PBF'])->name('pbf.index');
        Route::view('/apotek-online', 'farmasi.index', ['title' => 'Apotek Online'])->name('apotek-online.index');
    });

    Route::get('/jadwal-operasi', [JadwalOperasiController::class, 'index'])->name('jadwal-operasi.index');
    Route::get('/jadwal-operasi/data', [JadwalOperasiController::class, 'data'])->name('jadwal-operasi.data');
    Route::get('/jadwal-operasi/tambah', [JadwalOperasiController::class, 'create'])->name('jadwal-operasi.create');
    Route::post('/jadwal-operasi', [JadwalOperasiController::class, 'store'])->name('jadwal-operasi.store');
    Route::get('/jadwal-operasi/{jadwalOperasi}/edit', [JadwalOperasiController::class, 'edit'])->name('jadwal-operasi.edit');
    Route::patch('/jadwal-operasi/{jadwalOperasi}', [JadwalOperasiController::class, 'update'])->name('jadwal-operasi.update');
    Route::delete('/jadwal-operasi/{jadwalOperasi}', [JadwalOperasiController::class, 'destroy'])->name('jadwal-operasi.destroy');

    Route::get('/pemakaian-obat', [PemakaianObatController::class, 'index'])->name('pemakaian-obat.index');
    Route::get('/pemakaian-obat/tambah', [PemakaianObatController::class, 'create'])->name('pemakaian-obat.create');
    Route::post('/pemakaian-obat', [PemakaianObatController::class, 'store'])->name('pemakaian-obat.store');
    Route::delete('/pemakaian-obat/{pemakaianObat}', [PemakaianObatController::class, 'destroy'])->name('pemakaian-obat.destroy');

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
