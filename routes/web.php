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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware'=>['auth','role:admin']],function(){
    Route::get('/proyek', 'ProyekController@index')->name('proyek');
    Route::get('/proyekTambah', 'ProyekController@create')->name('proyekTambah');
    Route::post('/proyekSimpan', 'ProyekController@store')->name('proyekSimpan');
    Route::get('/proyek/edit/{id}', 'ProyekController@edit')->name('proyekEdit');
    Route::patch('/proyek/update/{id}', 'ProyekController@update')->name('proyekUpdate');
    Route::get('/kavling', 'KavlingController@index')->name('kavling');
    Route::post('/kavlingSimpan', 'KavlingController@kavlingSimpan')->name('kavlingSimpan');
    Route::get('/RAB', 'ProyekController@RAB')->name('RAB');
    Route::get('/pengeluaran', 'ProyekController@pengeluaran')->name('pengeluaran');

    Route::get('/pelanggan', 'PelangganController@index')->name('pelangganIndex');
    Route::get('/pelangganTambah', 'PelangganController@create')->name('pelangganTambah');
    Route::post('/pelangganSimpan', 'PelangganController@store')->name('pelangganSimpan');
    Route::get('/cariKavling', 'PelangganController@cariKavling');
    
    Route::get('/DPRumah', 'DPController@DPRumah')->name('DPRumah');
    Route::get('/DPKavling', 'DPController@DPKavling')->name('DPKavling');
    Route::get('/DPKavlingTambah/{id}', 'DPController@DPKavlingTambah')->name('DPKavlingTambah');
    Route::post('/DPKavlingSimpan', 'DPController@DPKavlingSimpan')->name('DPKavlingSimpan');
    Route::get('/DPKios', 'DPController@DPKios')->name('DPKios');

    Route::get('/cicilanRumah', 'CicilanController@cicilanRumah')->name('cicilanRumah');
    Route::get('/cicilanKavling', 'CicilanController@cicilanKavling')->name('cicilanKavling');
    Route::get('/cicilanKios', 'CicilanController@cicilanKios')->name('cicilanKios');
    
    Route::get('/akun', 'AkunController@index')->name('akun');
    
    Route::get('/transaksiMasuk', 'TransaksiController@masuk')->name('transaksiMasuk');
    Route::get('/transaksiKeluar', 'TransaksiController@keluar')->name('transaksiKeluar');
    
    Route::get('/kasBesar', 'KasController@kasBesar')->name('kasBesar');
    Route::get('/kasKecil', 'KasController@kasKecil')->name('kasKecil');
    
    Route::get('/laporanBulanan', 'LaporanController@laporanBulanan')->name('laporanBulanan');
    Route::get('/laporanTahunan', 'LaporanController@laporanTahunan')->name('laporanTahunan');
});
