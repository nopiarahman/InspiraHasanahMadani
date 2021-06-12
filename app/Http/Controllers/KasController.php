<?php

namespace App\Http\Controllers;
use App\pettyCash;
use App\transaksi;
use Carbon\Carbon;
use Illuminate\Http\Request;

class KasController extends Controller
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

    public function kasBesar(){
        return view ('kas/kasBesar');
    }
    public function pettyCash(Request $request){
        $start = Carbon::now()->firstOfMonth()->isoFormat('YYYY-MM-DD');
        $end = Carbon::now()->endOfMonth()->isoFormat('YYYY-MM-DD');
        // dd($end);
        // $end = moment();
        if($request->get('filter')){
            $start = Carbon::parse($request->start)->isoFormat('YYYY-MM-DD');
            $end = Carbon::parse($request->end)->isoFormat('YYYY-MM-DD');
            $pettyCash=pettyCash::whereBetween('tanggal',[$start,$end])->orderBy('no')->get();
        }else{
            $pettyCash=pettyCash::whereBetween('tanggal',[$start,$end])->orderBy('no')->get();
        }
        return view ('kas/pettyCash',compact('pettyCash','start','end'));
    }
    public function pettyCashSimpan(Request $request){
        $jumlah = str_replace(',', '', $request->jumlah);
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
        $cekTransaksiSebelum=pettyCash::where('tanggal','<=',$request->tanggal)->orderBy('no')->get();
        /* jika transaksi sebelumnya ada value */
        if($cekTransaksiSebelum != null){
            $sebelum = $cekTransaksiSebelum->last();
            $requestData['no']=$sebelum->no+1;
            $requestData['saldo']=$sebelum->saldo+$jumlah;
            $requestData['kredit']=str_replace(',', '', $request->jumlah);
            $requestData['proyek_id']=proyekId();
        }else{
            /* jika tidak ada value simpan ke akhir transaksi */
            $requestData['no']=noTransaksiTerakhir()+1;
            $requestData['saldo']=saldoTerakhirPettyCash()+$jumlah;
            $requestData['kredit']=str_replace(',', '', $request->jumlah);
            $requestData['proyek_id']=proyekId();
        }
        /* cek transaksi sesudah input */
        $cekTransaksi=pettyCash::where('tanggal','>',$request->tanggal)->orderBy('no')->get();
        if($cekTransaksi != null){
            /* jika ada, update transaksi sesudah sesuai perubahan input*/
            foreach($cekTransaksi as $updateTransaksi){
                $updateTransaksi['no'] = $updateTransaksi->no +1;
                $updateTransaksi['saldo'] = $updateTransaksi->saldo + $jumlah;
                $updateTransaksi->save();
            }
        }
        // dd($requestData);
        // transaksi::create($requestData);
        // $requestData['kredit']=str_replace(',', '', $request->jumlah);
        // $requestData['proyek_id']=proyekId();
        // $requestData['saldo']=saldoTerakhirPettyCash()+str_replace(',', '', $request->jumlah);
        pettyCash::create($requestData);
        return redirect()->route('pettyCash')->with('status','Transaksi Berhasil Disimpan');
    }
    public function kasBesarSimpan(Request $request){
        $jumlah = str_replace(',', '', $request->jumlah);
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
        // dd($requestData);
        $cekTransaksiSebelum=transaksi::where('tanggal','<=',$request->tanggal)->orderBy('no')->get();
        /* jika transaksi sebelumnya ada value */
        if($cekTransaksiSebelum != null){
            $sebelum = $cekTransaksiSebelum->last();
            $requestData['no']=$sebelum->no+1;
            $requestData['saldo']=$sebelum->saldo+$jumlah;
            $requestData['kredit']=str_replace(',', '', $request->jumlah);
            $requestData['proyek_id']=proyekId();
        }else{
            /* jika tidak ada value simpan ke akhir transaksi */
            $requestData['no']=noTransaksiTerakhir()+1;
            $requestData['saldo']=saldoTerakhir()+$jumlah;
            $requestData['kredit']=str_replace(',', '', $request->jumlah);
            $requestData['proyek_id']=proyekId();
        }
        /* cek transaksi sesudah input */
        $cekTransaksi=transaksi::where('tanggal','>',$request->tanggal)->orderBy('no')->get();
        if($cekTransaksi != null){
            /* jika ada, update transaksi sesudah sesuai perubahan input*/
            foreach($cekTransaksi as $updateTransaksi){
                $updateTransaksi['no'] = $updateTransaksi->no +1;
                $updateTransaksi['saldo'] = $updateTransaksi->saldo + $jumlah;
                $updateTransaksi->save();
            }
        }
        // dd($requestData);
        transaksi::create($requestData);
        return redirect()->route('cashFlow')->with('status','Transaksi Berhasil Disimpan');
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
}