<?php

namespace App\Http\Controllers;

use App\dp;
use App\pembelian;

use Illuminate\Http\Request;

class DPController extends Controller
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

    public function DPRumah(){
        return view ('cicilanDP/rumah');
    }
    public function DPKavling(){
        $semuaCicilanDp = pembelian::where('statusDp','Credit')->paginate(20);
        
        // dd(unitPelanggan($semuaCicilanDp->id));
        return view ('cicilanDP/kavling',compact('semuaCicilanDp'));
    }
    public function DPKavlingTambah(Pembelian $id){
        // dd($id);
        $daftarCicilanDp = dp::where('pembelian_id',$id->id)->get();
        // dd($daftarCicilanDp);
        return view ('cicilanDp/kavlingTambah',compact('id','daftarCicilanDp'));
    }
    public function DPKavlingSimpan(Request $request){
        $rules=[
            'jumlah'=>'required',
        ];
        $costumMessages = [
            'required'=>':attribute tidak boleh kosong'
        ];
        $id=$request->pembelian_id;
        /* Cek Akad DP */
        $cekDp=pembelian::find($id);
        $akadDp=$cekDp->dp;
        /* menghitung dp yang telah terbayar */
        $terbayar=dp::where('pembelian_id',$id)->get();
        $totalTerbayar=0;
        $terbayarSekarang=str_replace(',', '', $request->jumlah);
        // dd($terbayarSekarang);
        foreach($terbayar as $tb){
            $totalTerbayar = $totalTerbayar+$tb->jumlah;
        }
        // dd($totalTerbayar);
        $requestDp=[
            'pembelian_id'=>$request->pembelian_id,
            'tanggal'=>$request->tanggal,
            'jumlah'=>str_replace(',', '', $request->jumlah),
            'sisaDp'=>$akadDp-$totalTerbayar-$terbayarSekarang,
        ];
        $this->validate($request,$rules,$costumMessages);
        dp::create($requestDp);
        $update=pembelian::find($id)->update(['sisaDp'=>$akadDp-$totalTerbayar-$terbayarSekarang]);
        // dd($id);

        return redirect()->route('DPKavlingTambah',['id'=>$id])->with('status','Cicilan DP Berhasil ditambahkan');


        
    }
    public function DPKios(){
        return view ('cicilanDP/kios');
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
     * @param  \App\dp  $dp
     * @return \Illuminate\Http\Response
     */
    public function show(dp $dp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\dp  $dp
     * @return \Illuminate\Http\Response
     */
    public function edit(dp $dp)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\dp  $dp
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, dp $dp)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\dp  $dp
     * @return \Illuminate\Http\Response
     */
    public function destroy(dp $dp)
    {
        //
    }

}
