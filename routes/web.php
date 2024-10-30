<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CalegController;
use App\Http\Controllers\DaerahPemilihanController;
use App\Http\Controllers\DaftarCalegController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DataPartaiController;
use App\Http\Controllers\LembagaLegislatifController;
use App\Http\Controllers\TahunPemilihanController;
use App\Http\Controllers\UserController;

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

// GRUP MIDDLEWARE AUTH MULAI
Route::middleware('auth')->group(function () {

    /** HALAMAN UTAMA */
    Route::get('/', [DashboardController::class, 'index'])->name('home');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    /** USER MULAI  */
    Route::get('/user', [UserController::class, 'index'])->name('user.index');
    Route::delete('/user/{id}', [UserController::class, 'destroy'])->name('user.destroy');
    Route::post('/user', [UserController::class, 'store'])->name('user.store');
    Route::put('/user/{id}', [UserController::class, 'update'])->name('user.update');
    /** USER SELESAI  */

    /** LEMBAGA LEGISLATIF MULAI  */
    Route::get('/lembaga-legislatif', [LembagaLegislatifController::class, 'index'])->name('lembaga-legislatif.index');
    Route::delete('/lembaga-legislatif/{id}', [LembagaLegislatifController::class, 'destroy'])->name('lembaga-legislatif.destroy');
    Route::post('/lembaga-legislatif', [LembagaLegislatifController::class, 'store'])->name('lembaga-legislatif.store');
    Route::put('/lembaga-legislatif/{id}', [LembagaLegislatifController::class, 'update'])->name('lembaga-legislatif.update');
    /** LEMBAGA LEGISLATIF SELESAI  */

    /** TAHUN PEMILIHAN MULAI  */
    Route::get('/tahun-pemilihan', [TahunPemilihanController::class, 'index'])->name('tahun-pemilihan.index');
    Route::delete('/tahun-pemilihan/{id}', [TahunPemilihanController::class, 'destroy'])->name('tahun-pemilihan.destroy');
    Route::post('/tahun-pemilihan', [TahunPemilihanController::class, 'store'])->name('tahun-pemilihan.store');
    Route::put('/tahun-pemilihan/{id}', [TahunPemilihanController::class, 'update'])->name('tahun-pemilihan.update');
    /** TAHUN PEMILIHAN SELESAI  */

    /** DAERAH PEMILIHAN MULAI  */
    Route::get('/daerah-pemilihan/{tahun_pemilihan_id}', [DaerahPemilihanController::class, 'index'])->name('daerah-pemilihan.index');
    Route::delete('/daerah-pemilihan/{id}', [DaerahPemilihanController::class, 'destroy'])->name('daerah-pemilihan.destroy');
    Route::post('/daerah-pemilihan', [DaerahPemilihanController::class, 'store'])->name('daerah-pemilihan.store');
    Route::put('/daerah-pemilihan/{id}', [DaerahPemilihanController::class, 'update'])->name('daerah-pemilihan.update');
    /** DAERAH PEMILIHAN SELESAI  */

    /** DATA PARTAI MULAI  */
    Route::get('/data-partai', [DataPartaiController::class, 'index'])->name('data-partai.index');
    Route::put('/data-partai/{id}', [DataPartaiController::class, 'update'])->name('data-partai.update');
    /** DATA PARTAI SELESAI  */

    /** DAFTAR CALEG MULAI  */
    Route::get('/daftar-caleg/pilih-lembaga', [DaftarCalegController::class, 'pilih_lembaga'])->name('daftar-caleg.pilih_lembaga');
    Route::get('/daftar-caleg/pilih-tahun/{lembaga_id}', [DaftarCalegController::class, 'pilih_tahun'])->name('daftar-caleg.pilih_tahun');
    Route::get('/daftar-caleg/pilih-dapil/{tahun_id}', [DaftarCalegController::class, 'pilih_dapil'])->name('daftar-caleg.pilih_dapil');
    Route::get('/daftar-caleg/{dapil_id}', [DaftarCalegController::class, 'index'])->name('daftar-caleg.index');
    Route::get('/daftar-caleg/cetak/{dapil_id}', [DaftarCalegController::class, 'cetak'])->name('daftar-caleg.cetak');
    /** DAFTAR CALEG SELESAI  */

    /** CALEG MULAI  */
    Route::get('/caleg/pilih-lembaga', [CalegController::class, 'pilih_lembaga'])->name('caleg.pilih_lembaga');
    Route::get('/caleg/pilih-tahun/{lembaga_id}', [CalegController::class, 'pilih_tahun'])->name('caleg.pilih_tahun');
    Route::get('/caleg/pilih-dapil/{tahun_id}', [CalegController::class, 'pilih_dapil'])->name('caleg.pilih_dapil');
    Route::get('/caleg/{dapil_id}', [CalegController::class, 'index'])->name('caleg.index');
    Route::delete('/caleg/{id}', [CalegController::class, 'destroy'])->name('caleg.destroy');
    Route::post('/caleg', [CalegController::class, 'store'])->name('caleg.store');
    Route::put('/caleg/{id}', [CalegController::class, 'update'])->name('caleg.update');
    /** CALEG SELESAI  */

    // Logout
    Route::get('logout', [AuthController::class, 'actionLogout'])->name('logout');
});
// GRUP MIDDLEWARE AUTH SELESAI

/** Login mulai  */
Route::get('login', [AuthController::class, 'index'])->name('login')->middleware('guest');
Route::post('login', [AuthController::class, 'authenticate'])->name('login.authenticate')->middleware('guest');
/** Login selesai */