<?php

namespace App\Http\Controllers;

use App\dp;
use Carbon\Carbon;
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
        $semuaCicilanDp = pembelian::where('statusDp','Credit')->orderBy('kavling_id')->paginate(20);
        

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
            'tanggal'=>'required',
        ];
        $costumMessages = [
            'required'=>':attribute tidak boleh kosong'
        ];
        $id=$request->pembelian_id;
        /* Cek Akad DP */
        $cekDp=pembelian::find($id);
        $akadDp=$cekDp->dp;
        /* Jatuh Tempo */
        $tempo=Carbon::parse($request->tanggal)->addMonth(1)->isoFormat('YYYY-MM-DD');
        /* menghitung dp yang telah terbayar */
        $urut = dp::where('pembelian_id',$id)->orderBy('urut','desc')->first();
        if($urut != null){
            $urutan = $urut->urut;
        }else{
            $urutan=0;
        }
        /* Cek DP per bulan */
        $awal = Carbon::parse($request->tanggal)->firstOfMonth()->isoFormat('YYYY-MM-DD');
        $akhir = Carbon::parse($request->tanggal)->endOfMonth()->isoFormat('YYYY-MM-DD');
        $cekBulan = dp::whereBetween('tanggal',[$awal,$akhir])->count();

        $terbayar=dp::where('pembelian_id',$id)->get();
        $totalTerbayar=0;
        $terbayarSekarang=str_replace(',', '', $request->jumlah);
        // dd($terbayarSekarang);
        foreach($terbayar as $tb){
            $totalTerbayar = $totalTerbayar+$tb->jumlah;
        }
        // dd($cekDp->kavling->blok);
        $requestDp=[
            'pembelian_id'=>$request->pembelian_id,
            'urut'=>$urutan+1,
            'ke'=>$cekBulan+1,
            'tanggal'=>$request->tanggal,
            'jumlah'=>str_replace(',', '', $request->jumlah),
            'sisaDp'=>$akadDp-$totalTerbayar-$terbayarSekarang,
            'tempo'=>$tempo,
            'sumber'=>'Cash',
            'uraian'=>'Penerimaan Cicilan DP '.jenisKepemilikan($cekDp->pelanggan_id).' '.$cekDp->kavling->blok.' a/n '.$cekDp->pelanggan->nama,
        ];
        $this->validate($request,$rules,$costumMessages);

        /* parameter kasBesarMasuk ['tanggal','jumlah','sumber','uraian',]*/
        dp::create($requestDp);
        kasBesarMasuk($requestDp);
        $update=pembelian::find($id)->update(['sisaDp'=>$akadDp-$totalTerbayar-$terbayarSekarang]);

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
