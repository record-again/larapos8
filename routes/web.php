<?php

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

use App\Http\Controllers\BarangController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\TransaksiController;

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/dash', function() {
//     return view('admin/frontdash');
// });

Route::get('/', function () {
    if(Auth::check()) {
        return view('admin.kasir');    
    }
    return view('auth.login');
});

Route::post('/validlogin', 'App\Http\Controllers\AdminController@vallogin');

Route::group(['middleware' => 'admin'], function() {
    Route::get('/barang', [BarangController::class, 'index']);    
    Route::get('/formbarang', [BarangController::class, 'form']);
    Route::post('/addbarang', [BarangController::class, 'insert']);
    Route::get('/barang/{id}/edit', [BarangController::class, 'edit']);
    Route::put('/updatebarang/{id}', [BarangController::class, 'update']);
    Route::delete('/delbarang/{id}', [BarangController::class, 'delete']);
    Route::get('/kategori', [KategoriController::class, 'list']);
    Route::get('/formcat', [KategoriController::class, 'form']);
    Route::post('/addcat', [KategoriController::class, 'insert']);
    Route::get('/kategori/{id}/edit', [KategoriController::class, 'edit']);
    Route::put('/updatecat/{id}', [KategoriController::class, 'update']);
    Route::delete('/delcat/{id}', [KategoriController::class, 'delete']);
    Route::get('/kasir', [TransaksiController::class, 'buy']);
    Route::get('/alltransaksi', [TransaksiController::class, 'datalist']);
    Route::get('/transaksi/{id}/edit', [TransaksiController::class, 'view']);
    Route::put('/updatetrans/{id}', [TransaksiController::class, 'update']);
    Route::delete('/deltrans/{id}', [TransaksiController::class, 'delete']);
    //Ajax
    Route::post('/codeval', [BarangController::class, 'validkode']);
    Route::post('/kdsearch', [BarangController::class, 'kodeSrc']);
    Route::post('/search', [BarangController::class, 'search']);
    Route::post('/transaksi', [TransaksiController::class, 'store']);

    //Chart
    Route::get('/datachart', 'App\Http\Controllers\BarangController@month');
    Route::get('/datasell', 'App\Http\Controllers\BarangController@sellprod');
    Route::get('/grafik', 'App\Http\Controllers\BarangController@grafik');
    Route::get('/laporan', 'App\Http\Controllers\LaporanController@index');
});

Route::get('/temp', 'App\Http\Controllers\LaporanController@temp');
Route::get('/transpdf', 'App\Http\Controllers\LaporanController@cashpdf');
Route::get('/barpdf', 'App\Http\Controllers\LaporanController@barangpdf');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();
