<?php

namespace App\Http\Controllers;
use App\transaksi;
use App\akun;
use App\gudang;
use Illuminate\Http\Request;

class GudangController extends Controller
{
    public function index(){
        $daftarGudang = gudang::where('proyek_id',proyekId())->get();
        return view('gudang/gudangIndex',compact('daftarGudang'));
    }
    public function transferGudang(Transaksi $id, Request $request){
        // dd($request);
        $cekAkun= akun::find($request->akun_id);
        // dd($cekAkun);
        $requestData = $request->all();
        $requestData['proyek_id']=proyekId();
        $requestData['tanggalPembelian']=$request->tanggal;
        $requestData['jenisBarang']=$request->uraian;
        $requestData['harga']=str_replace(',', '', $request->harga);
        $requestData['total']=str_replace(',', '', $request->total);
        gudang::create($requestData);
        return redirect()->route('transaksiKeluar')->with('statusGudang','Data Transaksi '.$request->uraian.' berhasil ditransfer ke Gudang');
    }
    public function alokasiGudang(Gudang $id, Request $request){

        // dd($request);
        $requestData = $request->all();
        $requestData['sisa']=$request->sisaSebelumnya-$request->jumlahAlokasi;
        $requestData['alokasi']=$request->keterangan;

        $id->update($requestData);
        return redirect()->back()->with('status','Alokasi gudang berhasil disimpan');
    }
}
