<?php
use App\kavling;
use App\dp;
use App\akun;
use App\pembelian;
use App\rumah;
use App\transaksi;
use App\kasPendaftaran;
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
function saldoTerakhirKasPendaftaran(){
    $saldo = kasPendaftaran::orderBy('created_at','desc')->first();
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
function kasBesarKeluar($dataArray)
{
    $data = collect($dataArray);
    $jumlah= str_replace(',', '', $data->get('jumlah'));
    $dataTransaksi['tanggal'] = $data->get('tanggal');
    $dataTransaksi['rab_id'] = $data->get('rab_id');
    $dataTransaksi['rabUnit_id'] = $data->get('rabUnit_id');
    $dataTransaksi['akun_id'] = $data->get('akun_id');
    $dataTransaksi['uraian'] = $data->get('uraian');
    $dataTransaksi['sumber'] = $data->get('sumber');
    $dataTransaksi['debet'] = $jumlah;
    $dataTransaksi['saldo'] = saldoTerakhir()-$jumlah;
    $dataTransaksi['proyek_id'] = proyekId();
    transaksi::create($dataTransaksi);
    // dd($dataTransaksi);
}

function formatTanggal($date){
    $newDate = \Carbon\Carbon::parse($date);
    return $newDate->isoFormat('DD/MM/YYYY');
}
function satuanUnit($judul){
    // dd($judul);
    if($judul=='Biaya Produksi Rumah'){
        return 'm2';
    }else{
        return 'unit';
    }
}

function hitungUnit($unit,$judul,$jenis){
    $cekBlok=kavling::where('blok',$unit)->first();
    if($cekBlok != null){
        if($judul=='Biaya Produksi Rumah'){
            $cariRumah=rumah::where('kavling_id',$cekBlok->id)->first();
            return $cariRumah->luasBangunan;
        }
    }else{
        if($jenis=='kavling'){
            $kavling = kavling::all();
            $hitung=$kavling->count();
            return $hitung;
        }if($jenis=='rumah'){
            $rumah = rumah::count();
            return $rumah;
        }
    }
}

function hargaSatuanRumah(){
    $satuan=1400000;
    return $satuan;
}

function hitungTransaksiRAB($idRAB){
    $total = transaksi::where('rab_id',$idRAB)->get();
    if($total != null){
    $totalRAB = $total->sum('debet');
        // dd($total);
        return $totalRAB;
    }else{
        return 0;
    }
}
function hitungTransaksiRABUnit($idRAB){
    $total = transaksi::where('rabUnit_id',$idRAB)->get();
    if($total != null){
        $totalRAB = $total->sum('debet');
        // dd($total);
        return $totalRAB;
    }else{
        return 0;
    }
}
