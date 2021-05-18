<?php
use App\kavling;
use App\dp;
use App\akun;
use App\pembelian;
use App\rumah;
use App\transaksi;
use Carbon\Carbon;

function cekNamaUser(){
    return auth()->user()->name;
}
function proyekId(){
    return auth()->user()->proyek_id;
}

function unitPelanggan($id){
    $unit = kavling::find($id);
    return $unit;
}

function pembelianPelanggan($id){
    $pembelian = pembelian::where('pelanggan_id',$id)->first();
    return($pembelian);
}

function jenisKepemilikan($id){  /* $id = pelanggan_id */
    $pembelian = pembelian::where('pelanggan_id',$id)->first();
    if($pembelian->rumah_id !=null){
        return 'Kavling dan Rumah';
    }elseif($pembelian->kios_id !=null){
        return 'Kavling dan Kios';
    }elseif($pembelian->kavling_id !=null){
        return 'Kavling';
    }
}
function saldoTerakhir(){
    $saldo = transaksi::orderBy('created_at','desc')->first();
    $saldoTerakhir=0;
    if($saldo != null){
        $saldoTerakhir=$saldo->saldo;
    }
    return $saldoTerakhir;
}
function kasBesarMasuk($dataArray){
    $data = collect($dataArray);
    $akunPendapatan=akun::where('namaAkun','Pendapatan')->first();
    $requestData = $data->all();
    $requestData['kredit']=$data->get('jumlah');
    $requestData['saldo']=saldoTerakhir()+$data->get('jumlah');
    $requestData['akun_id']=$akunPendapatan->id;
    $requestData['proyek_id']=proyekId();
    // dd($requestData);
    transaksi::create($requestData);
    // return $this; 
}

function formatTanggal($date){
    $date = date('Y-m-d H:i:s');
    $newDate = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date)
                    ->format('d-m-Y');
    return $newDate;
}
