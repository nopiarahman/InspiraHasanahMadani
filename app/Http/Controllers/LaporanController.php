<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\transaksi;
use App\akun;

class LaporanController extends Controller
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
    
    public function laporanBulanan(Request $request){
        $akunId=akun::where('proyek_id',proyekId())->where('namaAkun','pendapatan')->first();
        $start = Carbon::now()->subDays(29)->isoFormat('YYYY-MM-DD');
        $end = Carbon::now()->isoFormat('YYYY-MM-DD');
        if($request->get('filter')){
            $start = Carbon::parse($request->start)->isoFormat('YYYY-MM-DD');
            $end = Carbon::parse($request->end)->isoFormat('YYYY-MM-DD');
            $pendapatan = transaksi::where('akun_id',$akunId->id)->whereBetween('tanggal',[$start,$end])->get();
        }else{
        $pendapatan = transaksi::where('akun_id',$akunId->id)->whereBetween('tanggal',[$start,$end])->get();
        }
        $kategoriAkun=akun::where('proyek_id',proyekId())->get()->groupBy('kategori')->forget('Pendapatan');
        // dd($kategoriAkun);
        $perKategori = $kategoriAkun;
        return view ('laporan/bulananIndex',compact('pendapatan','start','end','kategoriAkun','perKategori'));
    }

    public function laporanTahunan(){
        return view ('laporan/tahunanIndex');
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}