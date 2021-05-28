<?php

namespace App\Http\Controllers;

use App\cicilan;
use Carbon\Carbon;
use App\pembelian;
use Illuminate\Http\Request;

class CicilanController extends Controller
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

    public function cicilanRumah()
    {
        return view ('cicilanUnit/rumah');
    }
    
    public function cicilanKavling()
    {
        $semuaCicilanUnit = pembelian::where('statusCicilan','Credit')->where('proyek_id',proyekId())->orderBy('kavling_id')->paginate(20);
        return view ('cicilanUnit/kavling',compact('semuaCicilanUnit'));
    }
    public function unitKavlingDetail(Pembelian $id){
        $daftarCicilanUnit = cicilan::where('pembelian_id',$id->id)->get();
        
        $cicilanPerBulan = $id->sisaKewajiban/$id->tenor;
        $terbayar=cicilan::where('pembelian_id',$id->id)->get();
        $totalTerbayar=0;
        foreach($terbayar as $tb){
            $totalTerbayar = $totalTerbayar+$tb->jumlah;
        }

        // dd($id);

        return view('cicilanUnit/kavlingTambah',compact('id','daftarCicilanUnit','cicilanPerBulan','totalTerbayar'));
    }
    public function cicilanKavlingSimpan(Request $request){
        // dd($request);
        $rules=[
            'jumlah'=>'required',
            'tanggal'=>'required',
        ];
        $costumMessages = [
            'required'=>':attribute tidak boleh kosong'
        ];
        $id=$request->pembelian_id;
        $cekCicilan=pembelian::find($id);
        $cicilan=$cekCicilan->sisaKewajiban;
        /* Jatuh Tempo */
        $totalBulan = ($cekCicilan->sisaKewajiban-$cekCicilan->sisaCicilan)/($cekCicilan->sisaKewajiban/$cekCicilan->tenor);
        $tambahBulan = str_replace(',', '', $request->jumlah)/($cekCicilan->sisaKewajiban/$cekCicilan->tenor);
        // dd($tambahBulan);
        $tenorBulan = (int)$totalBulan+$tambahBulan;
        $cicilanPertama = cicilan::where('pembelian_id',$cekCicilan->id)->first();
        if($cicilanPertama != null){
            $tempo=Carbon::parse($cicilanPertama->tanggal)->addMonth($tenorBulan)->isoFormat('YYYY-MM-DD');
        }else{
            $tempo=Carbon::now()->addMonth($tenorBulan)->isoFormat('YYYY-MM-DD');
        }
        // dd($tempo);
        /* menghitung cicilan yang telah terbayar */
        $awal = Carbon::parse($request->tanggal)->firstOfMonth()->isoFormat('YYYY-MM-DD');
        $akhir = Carbon::parse($request->tanggal)->endOfMonth()->isoFormat('YYYY-MM-DD');
        $cekBulan = cicilan::whereBetween('tanggal',[$awal,$akhir])->count();
        // dd($cekBulan);
        
        $urut = cicilan::where('pembelian_id',$id)->orderBy('urut','desc')->first();
        if($urut != null){
            $urutan = $urut->urut;
        }else{
            $urutan=0;
        }
        $terbayar=cicilan::where('pembelian_id',$id)->get();
        $totalTerbayar=0;
        $terbayarSekarang=str_replace(',', '', $request->jumlah);
        foreach($terbayar as $tb){
            $totalTerbayar = $totalTerbayar+$tb->jumlah;
        }
        $requestCicilan=[
            'pembelian_id'=>$request->pembelian_id,
            'urut'=>$urutan+1,
            'ke'=>$cekBulan+1,
            'tanggal'=>$request->tanggal,
            'jumlah'=>str_replace(',', '', $request->jumlah),
            'sisaKewajiban'=>$cicilan-$totalTerbayar-$terbayarSekarang,
            'tempo'=>$tempo,
            'sumber'=>'Cash',
            'uraian'=>'Penerimaan Cicilan Unit '.jenisKepemilikan($cekCicilan->pelanggan_id).' '.$cekCicilan->kavling->blok.' a/n '.$cekCicilan->pelanggan->nama,
        ];
        // dd($id); 
        $this->validate($request,$rules,$costumMessages);

        /* parameter kasBesarMasuk ['tanggal','jumlah','sumber','uraian',]*/
        kasBesarMasuk($requestCicilan);

        cicilan::create($requestCicilan);
        $update=pembelian::find($id)->update(['sisaCicilan'=>$cicilan-$totalTerbayar-$terbayarSekarang]);

        $daftarCicilanUnit = cicilan::where('pembelian_id',$id)->get();
        $cicilanPerBulan = $cekCicilan->sisaKewajiban/$cekCicilan->tenor;

        return redirect()->route('unitKavlingDetail',['id'=>$id,'daftarCicilanUnit'=>$daftarCicilanUnit,'cicilanPerBulan'=>$cicilanPerBulan])
                ->with('status','Cicilan Unit Berhasil Ditambahkan');
    }
    public function cicilanKios()
    {
        return view ('cicilanUnit/kios');
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
     * @param  \App\cicilan  $cicilan
     * @return \Illuminate\Http\Response
     */
    public function show(cicilan $cicilan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\cicilan  $cicilan
     * @return \Illuminate\Http\Response
     */
    public function edit(cicilan $cicilan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\cicilan  $cicilan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, cicilan $cicilan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\cicilan  $cicilan
     * @return \Illuminate\Http\Response
     */
    public function destroy(cicilan $cicilan)
    {
        //
    }
}
