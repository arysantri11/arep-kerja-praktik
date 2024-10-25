<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
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