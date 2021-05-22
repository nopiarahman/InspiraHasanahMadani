<?php

namespace App\Http\Controllers;

use App\transaksi;
use App\akun;
use App\rabUnit;
use App\rab;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function masuk(){
        $transaksiMasuk=transaksi::whereNotNull('kredit')
                                    ->where('proyek_id',proyekId())->paginate(20);
        return view ('transaksi/masukIndex',compact('transaksiMasuk'));
    }

    public function keluar(){
        /* RAB */
        $semuaRAB = rab::all()->groupBy(['header',function($item){
            return $item['judul'];
        }],$preserveKeys=true);
        $perHeader=$semuaRAB;
        $perJudul=$semuaRAB;

        /* Biaya Unit */
        $semuaRABUnit = rabUnit::all()->groupBy(['header',function($item){
            return $item['judul'];
        }],$preserveKeys=true);
        $perHeaderUnit=$semuaRABUnit;
        $perJudulUnit=$semuaRABUnit;

        /* Akun */
        $semuaAkun=akun::where('proyek_id',proyekId())->get();
        $kategoriAkun=akun::all()->groupBy('kategori');
        $perKategori = $kategoriAkun;
        

        $transaksiKeluar=transaksi::whereNotNull('debet')
                                    ->where('proyek_id',proyekId())->paginate(20);
        return view ('transaksi/keluarIndex',compact('semuaAkun','perKategori','kategoriAkun','transaksiKeluar','perHeader','semuaRAB','perJudul','perHeaderUnit','semuaRABUnit','perJudulUnit'));
    }
    public function cariAkunTransaksi(Request $request){
        if($request->has('q')){
            $cari = $request->q;
            $data = akun::select('id','kodeAkun')->where('kodeAkun', 'LIKE', '%'.$cari.'%')
                                                ->where('proyek_id',proyekId())->distinct()->get();
            return response()->json($data);
        }
    }
    public function cariRAB(Request $request){
        if($request->has('q')){
            $cari = $request->q;
            $data = rab::select('id','isi')->where('isi', 'LIKE', '%'.$cari.'%')
                                                ->where('proyek_id',proyekId())->distinct()->get();
            return response()->json($data);
        }
    }
    public function cariRABUnit(Request $request){
        if($request->has('q')){
            $cari = $request->q;
            $data = rabUnit::select('id','isi')->where('isi', 'LIKE', '%'.$cari.'%')
                                                ->where('proyek_id',proyekId())->distinct()->get();
            return response()->json($data);
        }
    }
    public function keluarSimpan(Request $request){
        $rules=[
            'jumlah'=>'required',
            'tanggal'=>'required',
            'uraian'=>'required',
        ];
        $costumMessages = [
            'required'=>':attribute tidak boleh kosong'
        ];
        $this->validate($request,$rules,$costumMessages);
        // dd($request);
        $requestData=$request->all();
        /* parameter kasBesarKeluar=['tanggal','rab_id(nullable)','rabUnit_id(nullable)','akun_id','uraian','sumber','jumlah'] */
        kasBesarKeluar($requestData);
        return redirect()->route('transaksiKeluar')->with('status','Transaksi Berhasil disimpan');
    }
    public function cashFlow(){
        $cashFlow=transaksi::orderBy('created_at','asc')->where('proyek_id',proyekId())->get();
        return view ('transaksi/cashFlowIndex',compact('cashFlow'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\transaksi  $transaksi
     * @return \Illuminate\Http\Response
     */
    public function show(transaksi $transaksi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\transaksi  $transaksi
     * @return \Illuminate\Http\Response
     */
    public function edit(transaksi $transaksi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\transaksi  $transaksi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, transaksi $transaksi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\transaksi  $transaksi
     * @return \Illuminate\Http\Response
     */
    public function destroy(transaksi $transaksi)
    {
        //
    }
}
