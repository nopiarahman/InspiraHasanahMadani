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
Route::group(['middleware'=>['auth','role:admin,projectmanager']],function(){
    Route::get('/proyek', 'ProyekController@index')->name('proyek');
    Route::get('/proyekTambah', 'ProyekController@create')->name('proyekTambah');
    Route::post('/proyekSimpan', 'ProyekController@store')->name('proyekSimpan');
    Route::get('/proyek/edit/{id}', 'ProyekController@edit')->name('proyekEdit');
    Route::patch('/proyek/update/{id}', 'ProyekController@update')->name('proyekUpdate');
    Route::get('/proyek/pengeluaran/{id}', 'ProyekController@transaksiRABUnit')->name('transaksiRABUnit');
    Route::get('/proyek/pengeluaran/RAB/{id}', 'ProyekController@transaksiRAB')->name('transaksiRAB');

    Route::get('/kavling', 'KavlingController@index')->name('kavling');
    Route::patch('/editKavling/{id}', 'KavlingController@update')->name('editKavling');
    Route::post('/kavlingSimpan', 'KavlingController@kavlingSimpan')->name('kavlingSimpan');
    Route::delete('/hapusKavling/{id}', 'KavlingController@destroy')->name('hapusKavling');

    Route::patch('/gantiStatus/{id}', 'KavlingController@gantiStatus')->name('gantiStatus');
    
    Route::get('/RAB', 'ProyekController@RAB')->name('RAB');
    Route::patch('/editRAB/{id}', 'ProyekController@editRAB');
    Route::patch('/editRABUnit/{id}', 'ProyekController@editRABUnit');
    Route::delete('/hapusRAB/{id}', 'ProyekController@hapusRAB');
    Route::delete('/hapusRABUnit/{id}', 'ProyekController@hapusRABUnit');
    Route::get('/biayaUnit', 'ProyekController@biayaUnit')->name('biayaUnit');
    Route::post('/rabUnitSimpan', 'ProyekController@rabUnitSimpan')->name('rabUnitSimpan');
    Route::get('/cariHeader', 'ProyekController@cariHeader')->name('cariHeader');
    Route::get('/cariJudul', 'ProyekController@cariJudul')->name('cariJudul');
    Route::post('/biayaRABSimpan', 'ProyekController@biayaRABSimpan')->name('biayaRABSimpan');

    Route::post('/cariPelangganHome', 'HomeController@cariPelangganHome')->name('cariPelangganHome');
    Route::get('/cariPelangganDaftar', 'HomeController@cariPelangganDaftar');

    Route::get('/pelanggan', 'PelangganController@index')->name('pelangganIndex');
    Route::get('/pelangganNonAktif', 'PelangganController@nonAktif')->name('pelangganNonAktif');
    Route::get('/pelangganTambah', 'PelangganController@create')->name('pelangganTambah');
    Route::get('/pelangganDetail/{id}', 'PelangganController@detail')->name('pelangganDetail');
    Route::post('/pelangganSimpan', 'PelangganController@store')->name('pelangganSimpan');
    Route::patch('/pelangganUpdate/{id}', 'PelangganController@update')->name('pelangganUpdate');
    Route::patch('/unitPelangganUpdate/{id}', 'PelangganController@updateUnit')->name('unitPelangganUpdate');
    Route::post('/simpanNomorAkad/{id}', 'PelangganController@simpanNomorAkad')->name('simpanNomorAkad');
    Route::post('/simpanTanggalAkad/{id}', 'PelangganController@simpanTanggalAkad')->name('simpanTanggalAkad');
    Route::get('/cariKavling', 'PelangganController@cariKavling');
    Route::patch('/batalAkad/{id}', 'PelangganController@batalAkad')->name('batalAkad');
    Route::delete('/hapusPelanggan/{id}', 'PelangganController@destroy')->name('hapusPelanggan');
    
    Route::get('/DPRumah', 'DPController@DPRumah')->name('DPRumah');
    Route::get('/DPKavling', 'DPController@DPKavling')->name('DPKavling');
    Route::get('/DPKavlingTambah/{id}', 'DPController@DPKavlingTambah')->name('DPKavlingTambah');
    Route::post('/DPKavlingSimpan', 'DPController@DPKavlingSimpan')->name('DPKavlingSimpan');
    Route::get('/DPKios', 'DPController@DPKios')->name('DPKios');
    Route::delete('/hapusTransaksi/{id}', 'DPController@destroy')->name('hapusTransaksi');
    
    Route::get('/cicilanRumah', 'CicilanController@cicilanRumah')->name('cicilanRumah');
    Route::get('/cicilanKavling', 'CicilanController@cicilanKavling')->name('cicilanKavling');
    Route::get('/unitKavlingDetail/{id}', 'CicilanController@unitKavlingDetail')->name('unitKavlingDetail');
    Route::post('/cicilanKavlingSimpan', 'CicilanController@cicilanKavlingSimpan')->name('cicilanKavlingSimpan');
    Route::get('/cicilanKios', 'CicilanController@cicilanKios')->name('cicilanKios');
    Route::delete('/hapusCicilan/{id}', 'CicilanController@destroy')->name('hapusCicilan');
    Route::get('/cekTransferUnitPelanggan', 'CicilanController@cekTransferUnitPelanggan')->name('cekTransferUnitPelanggan');
    Route::get('/cekTransferDPPelanggan', 'DPController@cekTransferDPPelanggan')->name('cekTransferDPPelanggan');
    Route::get('/lihatTransferPelanggan/{id}', 'CicilanController@lihatTransferPelanggan')->name('lihatTransferPelanggan');
    Route::get('/lihatTransferDPPelanggan/{id}', 'DPController@lihatTransferDPPelanggan')->name('lihatTransferDPPelanggan');
    Route::patch('/tolakTransfer/{id}', 'CicilanController@tolakTransfer')->name('tolakTransfer');
    Route::patch('/tolakTransferDP/{id}', 'DPController@tolakTransferDP')->name('tolakTransferDP');
    
    Route::get('/akun', 'AkunController@index')->name('akun');
    Route::delete('/hapusAkun/{id}', 'AkunController@destroy')->name('hapusAkun');
    Route::patch('/editAkun/{id}', 'AkunController@update')->name('editAkun');
    Route::post('/akunSimpan', 'AkunController@store')->name('akunSimpan');
    Route::get('/cariAkun', 'AkunController@cariAkun')->name('cariAKun');
    Route::get('/cariAkunTransaksi', 'TransaksiController@cariAkunTransaksi')->name('cariAkunTransaksi');
    Route::get('/cariRAB', 'TransaksiController@cariRAB')->name('cariRAB');
    Route::get('/cariRABUnit', 'TransaksiController@cariRABUnit')->name('cariRABUnit');
    
    Route::get('/transaksiMasuk', 'TransaksiController@masuk')->name('transaksiMasuk');
    Route::get('/transaksiKeluar', 'TransaksiController@keluar')->name('transaksiKeluar');
    Route::post('/transaksiKeluarSimpan', 'TransaksiController@keluarSimpan')->name('transaksiKeluarSimpan');
    Route::delete('/hapusTransaksiKeluar/{id}', 'TransaksiController@hapusKeluar')->name('hapusTransaksiKeluar');
    Route::get('/cashFlow', 'TransaksiController@cashFlow')->name('cashFlow');
    Route::delete('/hapusKasBesar/{id}', 'TransaksiController@hapusKasBesar')->name('hapusTransaksiKeluar');
    
    Route::get('/kasKecilLapangan', 'KasController@kasKecilLapangan')->name('kasKecilLapangan');
    Route::get('/kasKecilLapanganKeluar', 'KasController@kasKecilLapanganKeluar')->name('kasKecilLapanganKeluar');
    Route::post('/kasKecilLapanganKeluarSimpan', 'KasController@kasKecilLapanganKeluarSimpan')->name('kasKecilLapanganKeluarSimpan');
    Route::post('/kasKecilLapanganMasukSimpan', 'KasController@kasKecilLapanganMasukSimpan')->name('kasKecilLapanganMasukSimpan');
    Route::get('/kasBesar', 'KasController@kasBesar')->name('kasBesar');
    Route::get('/kasPendaftaranMasuk', 'kasPendaftaranController@index')->name('kasPendaftaranMasuk');
    Route::get('/kasPendaftaranKeluar', 'kasPendaftaranController@keluar')->name('kasPendaftaranKeluar');
    Route::post('/kasPendaftaranMasukSimpan', 'kasPendaftaranController@store')->name('kasPendaftaranMasukSimpan');
    Route::post('/kasPendaftaranKeluarSimpan', 'kasPendaftaranController@storeKeluar')->name('kasPendaftaranKeluarSimpan');
    Route::post('/kasBesarSimpan', 'KasController@kasBesarSimpan')->name('kasBesarSimpan');
    Route::get('/pettyCash', 'KasController@pettyCash')->name('pettyCash');
    Route::post('/pettyCashSimpan', 'KasController@pettyCashSimpan')->name('pettyCashSimpan');
    Route::delete('/hapusPettyCash/{id}', 'KasController@pettyCashHapus')->name('hapusPettyCash');
    Route::delete('/hapusKasPendaftaran/{id}', 'kasPendaftaranController@hapusPendaftaran')->name('hapusKasPendaftaran');
    
    Route::get('/laporanBulanan', 'LaporanController@laporanBulanan')->name('laporanBulanan');
    Route::get('/laporanTahunan', 'LaporanController@laporanTahunan')->name('laporanTahunan');
    
    Route::get('/cetakKwitansi/{id}', 'LaporanController@cetakKwitansi')->name('cetakKwitansi');
    Route::get('/cetakKwitansiDp/{id}', 'LaporanController@cetakKwitansiDp')->name('cetakKwitansiDp');
    Route::get('/cetakDPPDF/{id}', 'LaporanController@cetakDPPDF')->name('cetakDPPDF');
    Route::get('/cetakKwitansiPDF/{id}', 'LaporanController@cetakKwitansiPDF')->name('cetakKwitansiPDF');
    
    Route::get('/gudang', 'GudangController@index')->name('gudang');
    Route::post('/transferGudang/{id}', 'GudangController@transferGudang')->name('transferGudang');
    Route::post('/alokasiGudang/{id}', 'GudangController@alokasiGudang')->name('alokasiGudang');
    
    Route::get('/rekening', 'ProyekController@rekening')->name('rekening');
    Route::post('/rekeningSimpan', 'ProyekController@rekeningSimpan')->name('rekeningSimpan');
    Route::patch('/rekeningUbah/{id}', 'ProyekController@rekeningUbah')->name('rekeningUbah');
    Route::delete('/hapusRekening/{id}', 'ProyekController@hapusRekening')->name('hapusRekening');
    /* cetak */
    Route::get('/cetakRAB', 'ProyekController@cetakRAB')->name('cetakRAB');
    Route::get('/cetakRABUnit', 'ProyekController@cetakRABUnit')->name('cetakRABUnit');
    Route::get('/exportKasBesar', 'TransaksiController@exportKasBesar')->name('exportKasBesar');
    Route::get('/exportKasPendaftaran', 'kasPendaftaranController@exportKasPendaftaran')->name('exportKasPendaftaran');
    Route::get('/exportPettyCash', 'KasController@exportPettyCash')->name('exportPettyCash');
    Route::get('/exportBulanan', 'LaporanController@exportBulanan')->name('exportBulanan');
    Route::get('/exportTahunan', 'LaporanController@exportTahunan')->name('exportTahunan');
});

Route::group(['middleware'=>['auth','role:projectmanager']],function(){
    
    Route::get('/kelolaUser', 'ProjectManagerController@kelolaUser')->name('kelolaUser');
    Route::get('/userTambah', 'ProjectManagerController@userTambah')->name('userTambah');
    Route::post('/userSimpan', 'ProjectManagerController@userSimpan')->name('userSimpan');
    Route::patch('/userEdit/{id}', 'ProjectManagerController@userEdit')->name('userEdit');
    Route::delete('/hapusUser/{id}', 'ProjectManagerController@hapusUser')->name('hapusUser');
});

Route::group(['middleware'=>['auth','role:pelanggan']],function(){
    Route::get('/dataDiri', 'PelangganController@dataDiri')->name('dataDiri');
    Route::get('/pembelianPelanggan', 'PelangganController@pembelianPelanggan')->name('pembelianPelanggan');
    Route::get('/DPPelanggan', 'PelangganController@DPPelanggan')->name('DPPelanggan');
    Route::get('/unitPelanggan', 'PelangganController@unitPelanggan')->name('unitPelanggan');
    Route::get('/transferUnit', 'PelangganController@transferUnit')->name('transferUnit');
    Route::get('/transferDP', 'PelangganController@transferDP')->name('transferDP');
    Route::post('/transferDPSimpan', 'PelangganController@transferDPSimpan')->name('transferDPSimpan');
    Route::post('/transferCicilanSimpan', 'PelangganController@transferCicilanSimpan')->name('transferCicilanSimpan');
    Route::get('/lihatTransferUnit/{id}', 'PelangganController@lihatTransferUnit')->name('lihatTransferUnit');
    Route::get('/lihatTransferDp/{id}', 'PelangganController@lihatTransferDp')->name('lihatTransferDp');
    Route::patch('/transferCicilanUpdate/{id}', 'PelangganController@transferCicilanUpdate')->name('transferCicilanUpdate');
    Route::patch('/transferDPUpdate/{id}', 'PelangganController@transferDPUpdate')->name('transferDPUpdate');
    Route::get('/cetakKwitansiPelanggan/{id}', 'LaporanController@cetakKwitansi')->name('cetakKwitansiPelanggan');
    Route::get('/cetakKwitansiDpPelanggan/{id}', 'LaporanController@cetakKwitansiDp')->name('cetakKwitansiDpPelanggan');
});
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/pengaturan', 'HomeController@pengaturan')->name('pengaturan');
Route::patch('/gantiFoto/{id}', 'HomeController@gantiFoto')->name('gantiFoto');
Route::patch('/gantiFoto/{id}', 'HomeController@gantiFoto')->name('gantiFoto');
Route::patch('/rubahPassword/{id}', 'HomeController@rubahPassword')->name('rubahPassword');