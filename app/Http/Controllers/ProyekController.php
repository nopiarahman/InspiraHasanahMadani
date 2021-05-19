<?php

namespace App\Http\Controllers;

use App\proyek;
use App\kavling;
use App\rab;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
class ProyekController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $proyek=proyek::all()->sortDesc();
        // dd($proyek);
        return view ('proyek/index',compact('proyek'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ('proyek/tambah');
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
            'nama'=>'required',
            'lokasi'=>'required',
            'proyekStart'=>'required'
        ];
        $costumMessages = [
            'required'=>':attribute tidak boleh kosong'
        ];

        $requestData = $request->all();
        $this->validate($request,$rules,$costumMessages);
        proyek::create($requestData);

        return redirect()->route('proyek')->with('status','Data Proyek Berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\proyek  $proyek
     * @return \Illuminate\Http\Response
     */
    public function show(proyek $proyek)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\proyek  $proyek
     * @return \Illuminate\Http\Response
     */
    public function edit(Proyek $id)
    {
        $proyek=$id;
        return view ('proyek/edit',compact('proyek'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\proyek  $proyek
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, proyek $id)
    {
        $rules=[
            'nama'=>'required',
            'lokasi'=>'required',
            'proyekStart'=>'required'
        ];
        $costumMessages = [
            'required'=>':attribute tidak boleh kosong'
        ];
        $requestData = $request->all();
        $this->validate($request,$rules,$costumMessages);
        $id->update($requestData);
        return redirect()->route('proyek')->with('status','Data Proyek Berhasil dirubah');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\proyek  $proyek
     * @return \Illuminate\Http\Response
     */
    public function destroy(proyek $proyek)
    {
        //
    }
    public function RAB (){
        $semuaRAB = rab::all()->groupBy(['header',function($item){
            return $item['judul'];
        }],$preserveKeys=true);
        $perHeader=$semuaRAB;
        $perJudul=$semuaRAB;
        return view ('proyek/DataProyek/RAB',compact('perHeader','semuaRAB','perJudul'));
    }
    public function cariHeader(Request $request){
        if($request->has('q')){
            $cari = $request->q;
            $data = rab::select('header')->where('header','LIKE','%'.$cari.'%')
                                            ->where('proyek_id',proyekId())->distinct()->get();
            return response()->json($data);
        }
    }
    public function cariJudul(Request $request){
        if($request->has('q')){
            $cari = $request->q;
            $data = rab::select('judul')->where('judul','LIKE','%'.$cari.'%')
                                            ->where('proyek_id',proyekId())->distinct()->get();
            return response()->json($data);
        }
    }
    public function biayaRABSimpan(Request $request){
        // dd($request);
        if($request->headerLama != null){
            $header = $request->headerLama;
        }else{
            $header = $request->header;
        }
        if($request->judulLama != null){
            $judul = $request->judulLama;
        }else{
            $judul = $request->judul;
        }
        $total=str_replace(',',' ',$request->total);
        $rules=[
            'header'=>'required',
            'judul'=>'required',
            'isi'=>'required'
        ];
        $costumMessages = [
            'required'=>':attribute tidak boleh kosong'
        ];
        $rab = rab::create([
            'proyek_id'=>proyekId(),
            'header'=>$header,
            'judul'=>$judul,
            'isi'=>$request->isi,
            'volume'=>$request->volume,
            'satuan'=>$request->satuan,
            'hargaSatuan'=>$request->hargaSatuan,
            'total'=>str_replace(',', '', $request->total)
        ]);$rab->save();

        return redirect()->route('RAB')->with('status','Jenis Biaya Berhasil Disimpan');
    }
    public function pengeluaran (){
        return view ('proyek/DataProyek/pengeluaran');
    }
}
