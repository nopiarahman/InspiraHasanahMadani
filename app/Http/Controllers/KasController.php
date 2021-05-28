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
        $start = Carbon::now()->subDays(29)->isoFormat('YYYY-MM-DD');
        $end = Carbon::now()->isoFormat('YYYY-MM-DD');
        // dd($end);
        // $end = moment();
        if($request->get('filter')){
            $mulai = Carbon::parse($request->start)->isoFormat('YYYY-MM-DD');
            $akhir = Carbon::parse($request->end)->isoFormat('YYYY-MM-DD');
            $pettyCash=pettyCash::whereBetween('tanggal',[$mulai,$akhir])->paginate(20);
        }else{
            $pettyCash=pettyCash::whereBetween('tanggal',[$start,$end])->paginate(20);
        }
        return view ('kas/pettyCash',compact('pettyCash'));
    }
    public function pettyCashSimpan(Request $request){
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
        $requestData['saldo']=saldoTerakhirPettyCash()+str_replace(',', '', $request->jumlah);
        pettyCash::create($requestData);
        return redirect()->route('pettyCash')->with('status','Transaksi Berhasil Disimpan');
    }
    public function kasBesarSimpan(Request $request){
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
        $requestData['kredit']=str_replace(',', '', $request->jumlah);
        $requestData['proyek_id']=proyekId();
        $requestData['saldo']=saldoTerakhir()+str_replace(',', '', $request->jumlah);
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
