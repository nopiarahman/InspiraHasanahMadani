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
    Route::get('/cariHeader', 'ProyekController@cariHeader')->name('cariHeader');
    Route::get('/cariJudul', 'ProyekController@cariJudul')->name('cariJudul');
    Route::post('/biayaRABSimpan', 'ProyekController@biayaRABSimpan')->name('biayaRABSimpan');
    Route::get('/pengeluaran', 'ProyekController@pengeluaran')->name('pengeluaran');

    Route::post('/cariPelangganHome', 'HomeController@cariPelangganHome')->name('cariPelangganHome');
    Route::get('/cariPelangganDaftar', 'HomeController@cariPelangganDaftar');

    Route::get('/pelanggan', 'PelangganController@index')->name('pelangganIndex');
    Route::get('/pelangganTambah', 'PelangganController@create')->name('pelangganTambah');
    Route::get('/pelangganDetail/{id}', 'PelangganController@detail')->name('pelangganDetail');
    Route::post('/pelangganSimpan', 'PelangganController@store')->name('pelangganSimpan');
    Route::post('/simpanNomorAkad/{id}', 'PelangganController@simpanNomorAkad')->name('simpanNomorAkad');
    Route::post('/simpanTanggalAkad/{id}', 'PelangganController@simpanTanggalAkad')->name('simpanTanggalAkad');
    Route::get('/cariKavling', 'PelangganController@cariKavling');
    
    Route::get('/DPRumah', 'DPController@DPRumah')->name('DPRumah');
    Route::get('/DPKavling', 'DPController@DPKavling')->name('DPKavling');
    Route::get('/DPKavlingTambah/{id}', 'DPController@DPKavlingTambah')->name('DPKavlingTambah');
    Route::post('/DPKavlingSimpan', 'DPController@DPKavlingSimpan')->name('DPKavlingSimpan');
    Route::get('/DPKios', 'DPController@DPKios')->name('DPKios');
    
    Route::get('/cicilanRumah', 'CicilanController@cicilanRumah')->name('cicilanRumah');
    Route::get('/cicilanKavling', 'CicilanController@cicilanKavling')->name('cicilanKavling');
    Route::get('/unitKavlingDetail/{id}', 'CicilanController@unitKavlingDetail')->name('unitKavlingDetail');
    Route::post('/cicilanKavlingSimpan', 'CicilanController@cicilanKavlingSimpan')->name('cicilanKavlingSimpan');
    Route::get('/cicilanKios', 'CicilanController@cicilanKios')->name('cicilanKios');
    
    Route::get('/akun', 'AkunController@index')->name('akun');
    Route::post('/akunSimpan', 'AkunController@store')->name('akunSimpan');
    Route::get('/cariAkun', 'AkunController@cariAkun')->name('cariAKun');
    
    Route::get('/transaksiMasuk', 'TransaksiController@masuk')->name('transaksiMasuk');
    Route::get('/transaksiKeluar', 'TransaksiController@keluar')->name('transaksiKeluar');
    Route::get('/cashFlow', 'TransaksiController@cashFlow')->name('cashFlow');
    
    Route::get('/kasBesar', 'KasController@kasBesar')->name('kasBesar');
    Route::get('/kasKecil', 'KasController@kasKecil')->name('kasKecil');
    
    Route::get('/laporanBulanan', 'LaporanController@laporanBulanan')->name('laporanBulanan');
    Route::get('/laporanTahunan', 'LaporanController@laporanTahunan')->name('laporanTahunan');
});
