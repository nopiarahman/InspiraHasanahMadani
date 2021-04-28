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
    Route::get('/unit', 'ProyekController@unit')->name('unit');
    Route::get('/RAB', 'ProyekController@RAB')->name('RAB');
    Route::get('/pengeluaran', 'ProyekController@pengeluaran')->name('pengeluaran');
    Route::get('/costumer', 'CostumerController@index')->name('costumerIndex');
    Route::get('/DPRumah', 'DPController@DPRumah')->name('DPRumah');
    Route::get('/DPKavling', 'DPController@DPKavling')->name('DPKavling');
    Route::get('/DPKios', 'DPController@DPKios')->name('DPKios');
    Route::get('/cicilanRumah', 'CicilanController@cicilanRumah')->name('cicilanRumah');
    Route::get('/cicilanKavling', 'CicilanController@cicilanKavling')->name('cicilanKavling');
    Route::get('/cicilanKios', 'CicilanController@cicilanKios')->name('cicilanKios');
    
});
