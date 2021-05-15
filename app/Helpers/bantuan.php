<?php
use App\kavling;
use App\dp;
use App\pembelian;

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

function jenisKepemilikan($id){
    $pembelian = pembelian::where('pelanggan_id',$id)->first();
    if($pembelian->rumah_id !=null){
        return 'Kavling dan Rumah';
    }elseif($pembelian->kios_id !=null){
        return 'Kavling dan Kios';
    }elseif($pembelian->kavling_id !=null){
        return 'Kavling';
    }
}