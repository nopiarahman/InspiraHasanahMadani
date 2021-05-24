<?php

namespace App\Http\Controllers;

use App\kasPendaftaran;
use Illuminate\Http\Request;

class KasPendaftaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kasPendaftaran = kasPendaftaran::where('proyek_id',proyekId())->paginate(20);
        return view ('kas/pendaftaran',compact('kasPendaftaran'));
    }
    public function keluar()
    {
        $kasPendaftaran = kasPendaftaran::where('proyek_id',proyekId())->paginate(20);
        return view ('kas/pendaftaranKeluar',compact('kasPendaftaran'));
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
        $rules=[
            'jumlah'=>'required',
            'tanggal'=>'required',
            'uraian'=>'required',
        ];
        $costumMessages = [
            'required'=>':attribute tidak boleh kosong'
        ];
        $this->validate($request,$rules,$costumMessages);
        $requestData=$request->all();
        $requestData['kredit']=str_replace(',', '', $request->jumlah);
        $requestData['proyek_id']=proyekId();
        $requestData['saldo']=saldoTerakhirKasPendaftaran()+str_replace(',', '', $request->jumlah);
        kasPendaftaran::create($requestData);
        // dd($request);
        return redirect()->route('kasPendaftaranMasuk')->with('status','Transaksi Berhasil Disimpan');
    }
    public function storeKeluar(Request $request)
    {
        $rules=[
            'jumlah'=>'required',
            'tanggal'=>'required',
            'uraian'=>'required',
        ];
        $costumMessages = [
            'required'=>':attribute tidak boleh kosong'
        ];
        $this->validate($request,$rules,$costumMessages);
        $requestData=$request->all();
        $requestData['debet']=str_replace(',', '', $request->jumlah);
        $requestData['proyek_id']=proyekId();
        $requestData['saldo']=saldoTerakhirKasPendaftaran()-str_replace(',', '', $request->jumlah);
        kasPendaftaran::create($requestData);
        // dd($request);
        return redirect()->route('kasPendaftaranKeluar')->with('status','Transaksi Berhasil Disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\kasPendaftaran  $kasPendaftaran
     * @return \Illuminate\Http\Response
     */
    public function show(kasPendaftaran $kasPendaftaran)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\kasPendaftaran  $kasPendaftaran
     * @return \Illuminate\Http\Response
     */
    public function edit(kasPendaftaran $kasPendaftaran)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\kasPendaftaran  $kasPendaftaran
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, kasPendaftaran $kasPendaftaran)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\kasPendaftaran  $kasPendaftaran
     * @return \Illuminate\Http\Response
     */
    public function destroy(kasPendaftaran $kasPendaftaran)
    {
        //
    }
}
