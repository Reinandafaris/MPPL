<?php

use App\Http\Controllers\AkunController;
use App\Http\Controllers\BukubesarController;
use App\Http\Controllers\KasKeluarController;
use App\Http\Controllers\KasMasukController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
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
  return view('welcome2');
});

Auth::routes();

Route::resource('user', UserController::class);

Route::get('/user/hapus/{kode}', [UserController::class, 'destroy'])->name('user.destroy');

Route::resource('/akun', AkunController::class);

Route::get('/akun/hapus/{kode}', [AkunController::class, 'destroy'])->name('akun.destroy');

Route::resource('/kaskeluar', KasKeluarController::class);

Route::get('/kaskeluar/hapus/{id}', [KasKeluarController::class, 'destroy'])->name('kaskeluar.destroy');

Route::resource('/bukubesar', BukubesarController::class);

Route::resource('/kasmasuk', KasMasukController::class);

Route::get('/kasmasuk/hapus/{id}', [KasMasukController::class, 'destroy'])->name('kasmasuk.destroy');

Route::resource('/laporan', LaporanController::class);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
