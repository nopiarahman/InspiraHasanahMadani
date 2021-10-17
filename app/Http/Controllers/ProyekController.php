<?php

namespace App\Http\Controllers;

use App\proyek;
use App\kavling;
use App\rab;
use App\rekening;
use App\transaksi;
use App\rumah;
use App\rabUnit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

use App\Exports\RABExport;
use App\Exports\UnitExport;
use Maatwebsite\Excel\Facades\Excel;
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
        // dd($request);
        $rules=[
            'nama'=>'required',
            'lokasi'=>'required',
            'proyekStart'=>'required',
            'namaPT'=>'required',
            'alamatPT'=>'required',
            'proyekStart'=>'required'
        ];
        $costumMessages = [
            'required'=>':attribute tidak boleh kosong'
        ];
        $requestData = $request->all();
        if ($request->hasFile('logoPT')) {
            $file_nama            = $request->file('logoPT')->store('public/file/proyek/logoPT');
            $requestData['logoPT'] = $file_nama;
        } else {
            unset($requestData['logoPT']);
        }
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
            'namaPT'=>'required',
            'alamatPT'=>'required',
            'lokasi'=>'required',
            'proyekStart'=>'required'
        ];
        $costumMessages = [
            'required'=>':attribute tidak boleh kosong'
        ];
        $requestData = $request->all();
        if ($request->hasFile('logoPT')) {
            $file_nama            = $request->file('logoPT')->store('public/file/proyek/logoPT');
            $requestData['logoPT'] = $file_nama;
        } else {
            unset($requestData['logoPT']);
        }
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
        $semuaRAB = rab::all()->where('proyek_id',proyekId())->groupBy(['header',function($item){
            return $item['judul'];
        }],$preserveKeys=true);
        $semuaUnit = rabUnit::where('proyek_id',proyekId())->get()->groupBy(['header',function($item){
            return $item['judul'];
        }],$preserveKeys=true);
        $perHeader=$semuaRAB->sortBy('kodeRAB');
        $perJudul=$semuaRAB->sortBy('kodeRAB');
        $perHeaderUnit=$semuaUnit->sortBy('kodeRAB');
        $perJudulUnit=$semuaUnit->sortBy('kodeRAB');
        
        return view ('proyek/DataProyek/RAB',compact('perHeader','semuaRAB','semuaUnit','perJudul','perHeaderUnit','perJudulUnit'));
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
        $total=str_replace(',','',$request->total);
        $rules=[
            'isi'=>'required',
            'kodeRAB'=>'required'
        ];
        $costumMessages = [
            'required'=>':attribute tidak boleh kosong'
        ];
        $this->validate($request,$rules,$costumMessages);
        $rab = rab::create([
            'proyek_id'=>proyekId(),
            'header'=>$header,
            'judul'=>$judul,
            'kodeRAB'=>$request->kodeRAB,
            'isi'=>$request->isi,
            'volume'=>$request->volume,
            'satuan'=>$request->satuan,
            'hargaSatuan'=>$request->hargaSatuan,
            'total'=>str_replace(',', '', $request->total)
        ]);$rab->save();

        return redirect()->route('RAB')->with('status','Jenis Biaya Berhasil Disimpan');
    }
    public function biayaUnit(Request $request){
        $semuaRAB = rabUnit::where('proyek_id',proyekId())->get()->groupBy(['header',function($item){
            return $item['judul'];
        }],$preserveKeys=true);
        // dd($semuaRAB);
        $perHeader=$semuaRAB;
        $perJudul=$semuaRAB;
        $semuaRumah=rumah::where('proyek_id',proyekId())->get();
        return view ('proyek/DataProyek/rabUnit',compact('perHeader','semuaRAB','perJudul','semuaRumah'));
    }
    public function rabUnitSimpan(Request $request){
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
        $total=str_replace(',',' ',$request->hargaSatuan);
        $rules=[
            'isi'=>'required'
        ];
        $costumMessages = [
            'required'=>':attribute tidak boleh kosong'
        ];
        $this->validate($request,$rules,$costumMessages);
        $rabUnit = rabUnit::create([
            'proyek_id'=>proyekId(),
            'header'=>$header,
            'judul'=>$judul,
            'isi'=>$request->isi,
            'jenisUnit'=>$request->jenisUnit,
            'hargaSatuan'=>str_replace(',', '', $request->hargaSatuan)
        ]);$rabUnit->save();
        return redirect()->route('biayaUnit')->with('status','Biaya Unit Berhasil Disimpan');
    }
    public function transaksiRABUnit(RabUnit $id, Request $request){
        // dd($id->getTable());
        $totalRAB=hitungUnit($id->isi,$id->judul,$id->jenisUnit)*(int)$id->hargaSatuan;
        if($request->get('filter')){
            // dd($request);
            $mulai = Carbon::parse($request->start)->isoFormat('YYYY-MM-DD');
            // dd($mulai);
            $akhir = Carbon::parse($request->end)->isoFormat('YYYY-MM-DD');
            // dd($mulai);
            $transaksiKeluar=transaksi::whereBetween('tanggal',[$mulai,$akhir])
                            ->where('rabUnit_id',$id->id)->get();
            // dd($transaksiKeluar);
            $total=transaksi::where('rabUnit_id',$id->id)->get();
        }else{
            $total=transaksi::where('rabUnit_id',$id->id)->get();
            $transaksiKeluar=transaksi::where('rabUnit_id',$id->id)->get();
        }
        return view('proyek/DataProyek/pengeluaranUnit',compact('transaksiKeluar','id','totalRAB','total'));        
    }
    public function transaksiRAB(rab $id, Request $request){
        // dd($id->getTable());
        $totalRAB=$id->total;
        // dd($id);
        if($request->get('filter')){
            // dd($request);
            $mulai = Carbon::parse($request->start)->isoFormat('YYYY-MM-DD');
            // dd($mulai);
            $akhir = Carbon::parse($request->end)->isoFormat('YYYY-MM-DD');
            // dd($mulai);
            $transaksiKeluar=transaksi::whereBetween('tanggal',[$mulai,$akhir])
                            ->where('rab_id',$id->id)->get();
            // dd($transaksiKeluar);
            $total=transaksi::where('rab_id',$id->id)->get();
        }else{
            $total=transaksi::where('rab_id',$id->id)->get();
            $transaksiKeluar=transaksi::where('rab_id',$id->id)->get();
        }
        return view('proyek/DataProyek/pengeluaranUnit',compact('transaksiKeluar','id','totalRAB','total'));  
    }
    public function cetakRAB(){

        $semuaRAB = rab::all()->where('proyek_id',proyekId())->groupBy(['header',function($item){
            return $item['judul'];
        }],$preserveKeys=true);
        $semuaUnit = rabUnit::where('proyek_id',proyekId())->get()->groupBy(['header',function($item){
            return $item['judul'];
        }],$preserveKeys=true);
        // return view ('excel.rab',compact('semuaRAB'));
        return Excel::download(new RABExport($semuaRAB,$semuaUnit), 'RAB.xlsx');
    }
    public function cetakRABUnit(){

        $semuaRAB = rabUnit::where('proyek_id',proyekId())->get()->groupBy(['header',function($item){
            return $item['judul'];
        }],$preserveKeys=true);
        // return view ('excel.rab',compact('semuaRAB'));
        return Excel::download(new UnitExport($semuaRAB), 'Biaya Unit.xlsx');
    }
    public function rekening(){
        $rekening = rekening::where('proyek_id',proyekId())->get();
        return view('rekening/index',compact('rekening'));
    }
    public function rekeningSimpan(Request $request){
        // dd($request);
        $rules=[
            'namaBank'=>'required',
            'noRekening'=>'required',
            'atasNama'=>'required'
        ];
        $costumMessages = [
            'required'=>':attribute tidak boleh kosong'
        ];
        $requestData = $request->all();
        $this->validate($request,$rules,$costumMessages);
        $requestData['proyek_id']=proyekId();
        rekening::create($requestData);
        return redirect()->route('rekening')->with('status','Data Rekening berhasil ditambahkan');
    }
    public function rekeningUbah(Request $request, Rekening $id){
        // dd($request);
        $requestData = $request->all();
        $requestData['proyek_id']=proyekId();
        $id->update($requestData);
        return redirect()->route('rekening')->with('status','Data Rekening berhasil dirubah');
    }
    public function hapusRekening(Rekening $id){
        rekening::destroy($id->id);
        return redirect()->route('rekening')->with('status','Data Rekening berhasil dihapus');
    }
    public function editRAB(RAB $id, Request $request){
        // dd($request);
        $hargaSatuan=(int)str_replace(',','',$request->hargaSatuan);
        $total=(int)str_replace(',','',$request->total);
        $requestData=$request->all();
        $requestData['hargaSatuan']=$hargaSatuan;
        $requestData['total']=$total;
        $id->update($requestData);
        return redirect()->back()->with('status','RAB Berhasil diedit');
    }
    public function editRABUnit(RABUnit $id, Request $request){
        // dd($request);
        $hargaSatuan=(int)str_replace(',','',$request->hargaSatuan);
        $requestData=$request->all();
        $requestData['hargaSatuan']=$hargaSatuan;
        $id->update($requestData);
        return redirect()->back()->with('status','RAB Unit Berhasil diedit');
    }
    public function hapusRAB(RAB $id){
        if(hitungTransaksiRAB($id->id) != null){
            return redirect()->back()->with('error','Data RAB gagal dihapus, RAB memiliki transaksi pengeluaran');
        }
        RAB::destroy($id->id);
        return redirect()->back()->with('status','Data RAB berhasil dihapus');
    }
    public function hapusRABUnit(RABUnit $id){
        if(hitungTransaksiRABUnit($id->id) != null){
            return redirect()->back()->with('error','Data RAB gagal dihapus, RAB memiliki transaksi pengeluaran');
        }
        RABUnit::destroy($id->id);
        return redirect()->back()->with('status','Data RAB berhasil dihapus');
    }
}
