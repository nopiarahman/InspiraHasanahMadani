<?php

namespace App\Http\Controllers;

use App\akun;
use Illuminate\Http\Request;

class AkunController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $semuaAkun=akun::where('proyek_id',proyekId())->get();
        $kategoriAkun=akun::where('proyek_id',proyekId())->get()->groupBy('kategori');
        $perKategori = $kategoriAkun;
        /* menampilkan hasil groupBy ke view cek https://stackoverflow.com/questions/38029591/laravel-how-can-i-use-group-by-within-my-view */
        return view ('akun/index',compact('semuaAkun','perKategori','kategoriAkun'));
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
        if($request->kategoriLama != null){
            $kategori = $request->kategoriLama;
        }else{
            $kategori = $request->kategori;
        }
        // dd($request);
        $rules=[
            'kodeAkun'=>'required',
            'namaAkun'=>'required',
        ];
        $costumMessages = [
            'required'=>':attribute tidak boleh kosong'
        ];
        $requestData = $request->all();
        $requestData['proyek_id']= proyekId();
        $requestData['kategori']= $kategori;
        // dd($requestData);
        $this->validate($request,$rules,$costumMessages);
        akun::create($requestData);
        $semuaAkun=akun::where('proyek_id',proyekId())->get();
        return redirect()->route('akun',['semuaAkun'=>$semuaAkun])->with('status','Akun berhasil ditambahkan');
    }
    public function cariAkun(Request $request){
        if($request->has('q')){
            $cari = $request->q;
            $data = akun::select('kategori')->where('kategori','LIKE','%'.$cari.'%')
                                            ->where('proyek_id',proyekId())->distinct()->get();

            return response()->json($data);
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\akun  $akun
     * @return \Illuminate\Http\Response
     */
    public function show(akun $akun)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\akun  $akun
     * @return \Illuminate\Http\Response
     */
    public function edit(akun $akun)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\akun  $akun
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, akun $akun)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\akun  $akun
     * @return \Illuminate\Http\Response
     */
    public function destroy(akun $akun)
    {
        //
    }
}
