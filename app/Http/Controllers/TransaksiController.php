<?php

namespace App\Http\Controllers;

use App\transaksi;
use App\akun;
use App\rabUnit;
use App\rab;
use Carbon\Carbon;
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

    public function masuk(Request $request){
        if($request->get('filter')){
            $mulai = Carbon::parse($request->start)->isoFormat('YYYY-MM-DD');
            $akhir = Carbon::parse($request->end)->isoFormat('YYYY-MM-DD');
            $transaksiMasuk=transaksi::whereBetween('tanggal',[$mulai,$akhir])
                            ->whereNotNull('kredit')->paginate(20);
        }else{
            $start = Carbon::now()->subDays(29)->isoFormat('YYYY-MM-DD');
            $end = Carbon::now()->isoFormat('YYYY-MM-DD');
            $transaksiMasuk=transaksi::whereBetween('tanggal',[$start,$end])
            ->whereNotNull('kredit')->paginate(20);
        }
        return view ('transaksi/masukIndex',compact('transaksiMasuk'));
    }

    public function keluar(Request $request){
        /* RAB */
        // dd($request);
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
        
        if($request->get('filter')){
            $mulai = Carbon::parse($request->start)->isoFormat('YYYY-MM-DD');
            $akhir = Carbon::parse($request->end)->isoFormat('YYYY-MM-DD');
            $transaksiKeluar=transaksi::whereBetween('tanggal',[$mulai,$akhir])
                            ->whereNotNull('debet')->paginate(20);
        }else{
            $start = Carbon::now()->subDays(29)->isoFormat('YYYY-MM-DD');
            $end = Carbon::now()->isoFormat('YYYY-MM-DD');
            $transaksiKeluar=transaksi::whereBetween('tanggal',[$start,$end])
                            ->whereNotNull('debet')->paginate(20);
        }
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
        if($request->sumberKas=='kasBesar'){
            kasBesarKeluar($requestData);
        }else{
            kasBesarKeluar($requestData);
            $requestData['keterangan']='Kas Besar';
            pettyCashKeluar($requestData);
        }
        return redirect()->route('transaksiKeluar')->with('status','Transaksi Berhasil disimpan');
    }
    public function cashFlow(Request $request){
        if($request->get('filter')){
            $mulai = Carbon::parse($request->start)->isoFormat('YYYY-MM-DD');
            $akhir = Carbon::parse($request->end)->isoFormat('YYYY-MM-DD');
            $cashFlow=transaksi::whereBetween('tanggal',[$mulai,$akhir])->paginate(20);
        }else{
            $start = Carbon::now()->subDays(29)->isoFormat('YYYY-MM-DD');
            $end = Carbon::now()->isoFormat('YYYY-MM-DD');
            $cashFlow=transaksi::whereBetween('tanggal',[$start,$end])->paginate(20);
        }
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
