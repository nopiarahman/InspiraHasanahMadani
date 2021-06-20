<?php

namespace App\Http\Controllers;

use App\kasPendaftaran;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Exports\KasPendaftaranExport;
use Maatwebsite\Excel\Facades\Excel;
class KasPendaftaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $start = Carbon::now()->firstOfMonth()->isoFormat('YYYY-MM-DD');
        $end = Carbon::now()->endOFMonth()->isoFormat('YYYY-MM-DD');
        // dd($end);
        // $end = moment();
        if($request->get('filter')){
            $start = Carbon::parse($request->start)->isoFormat('YYYY-MM-DD');
            $end = Carbon::parse($request->end)->isoFormat('YYYY-MM-DD');
            $kasPendaftaran=kasPendaftaran::whereBetween('tanggal',[$start,$end])->where('proyek_id',proyekId())->orderBy('no')->get();
        }else{
            $kasPendaftaran=kasPendaftaran::whereBetween('tanggal',[$start,$end])->where('proyek_id',proyekId())->orderBy('no')->get();
        }
        return view ('kas/pendaftaran',compact('kasPendaftaran','start','end'));
    }
    public function keluar(Request $request)
    {
        $start = Carbon::now()->firstOfMonth()->isoFormat('YYYY-MM-DD');
        $end = Carbon::now()->endOFMonth()->isoFormat('YYYY-MM-DD');
        // dd($end);
        // $end = moment();
        if($request->get('filter')){
            $start = Carbon::parse($request->start)->isoFormat('YYYY-MM-DD');
            $end = Carbon::parse($request->end)->isoFormat('YYYY-MM-DD');
            $kasPendaftaran=kasPendaftaran::whereBetween('tanggal',[$start,$end])->where('proyek_id',proyekId())->orderBy('no')->get();
        }else{
            $kasPendaftaran=kasPendaftaran::whereBetween('tanggal',[$start,$end])->where('proyek_id',proyekId())->orderBy('no')->get();
        }
        return view ('kas/pendaftaranKeluar',compact('kasPendaftaran','start','end'));
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
        // $requestData=$request->all();
        $requestData=$request->all();
        $requestData['kredit']=str_replace(',', '', $request->jumlah);
        $requestData['proyek_id']=proyekId();
        /* cek apakah ada transaksi sebelumnya */
        $cekTransaksiSebelum=kasPendaftaran::where('tanggal','<=',$request->tanggal)->orderBy('no')->where('proyek_id',proyekId())->get();
        /* jika transaksi sebelumnya ada value */
        if($cekTransaksiSebelum->first() != null){
            $sebelum = $cekTransaksiSebelum->last();
            $requestData['no']=$sebelum->no+1;
            $requestData['saldo']=$sebelum->saldo+$jumlah;
        }else{
            /* jika tidak ada value simpan ke awal transaksi */
            $requestData['no']=1;
            $requestData['saldo']=$jumlah;
        }
        /* cek transaksi sesudah input */
        $cekTransaksi=kasPendaftaran::where('tanggal','>',$request->tanggal)->orderBy('no')->where('proyek_id',proyekId())->get();
        if($cekTransaksi != null){
            /* jika ada, update transaksi sesudah sesuai perubahan input*/
            foreach($cekTransaksi as $updateTransaksi){
                $updateTransaksi['no'] = $updateTransaksi->no +1;
                $updateTransaksi['saldo'] = $updateTransaksi->saldo + $jumlah;
                $updateTransaksi->save();
            }
        }
        kasPendaftaran::create($requestData);
        return redirect()->route('kasPendaftaranMasuk')->with('status','Transaksi Berhasil Disimpan');
    }
    public function storeKeluar(Request $request)
    {
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
        // $requestData=$request->all();
        $requestData=$request->all();
        $requestData['debet']=str_replace(',', '', $request->jumlah);
        $requestData['proyek_id']=proyekId();
        /* cek apakah ada transaksi sebelumnya */
        $cekTransaksiSebelum=kasPendaftaran::where('tanggal','<=',$request->tanggal)->orderBy('no')->where('proyek_id',proyekId())->get();
        /* jika transaksi sebelumnya ada value */
        if($cekTransaksiSebelum != null){
            $sebelum = $cekTransaksiSebelum->last();
            // dd($cekTransaksiSebelum);
            $requestData['no']=$sebelum->no+1;
            $requestData['saldo']=$sebelum->saldo-$jumlah;
        }else{
            /* jika tidak ada value simpan ke akhir transaksi */
            $requestData['no']=noTransaksiTerakhir()+1;
            $requestData['saldo']=saldoTerakhirKasPendaftaran()-$jumlah;
        }
        /* cek transaksi sesudah input */
        $cekTransaksi=kasPendaftaran::where('tanggal','>',$request->tanggal)->orderBy('no')->where('proyek_id',proyekId())->get();
        // dd($cekTransaksi);
        if($cekTransaksi != null){
            /* jika ada, update transaksi sesudah sesuai perubahan input*/
            foreach($cekTransaksi as $updateTransaksi){
                $updateTransaksi['no'] = $updateTransaksi->no +1;
                $updateTransaksi['saldo'] = $updateTransaksi->saldo - $jumlah;
                $updateTransaksi->save();
            }
        }
        // $requestData['debet']=str_replace(',', '', $request->jumlah);
        // $requestData['proyek_id']=proyekId();
        // $requestData['saldo']=saldoTerakhirKasPendaftaran()-str_replace(',', '', $request->jumlah);
        kasPendaftaran::create($requestData);
        // dd($request);
        return redirect()->route('kasPendaftaranKeluar')->with('status','Transaksi Berhasil Disimpan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\kasPendaftaran  $kasPendaftaran
     * @return \Illuminate\Http\Response
     */
    public function hapusPendaftaran(kasPendaftaran $id)
    {
        // dd($id);
        $cekKas=kasPendaftaran::where('tanggal','>=',$id->tanggal)->where('no','>',$id->no)->orderBy('no')->get();
        if($id->kredit != null){
            if($cekKas != null){
                /* jika ada, update transaksi sesudah sesuai perubahan input*/
                foreach($cekKas as $updateKasBesar){
                    $updateKasBesar['no'] = $updateKasBesar->no -1;
                    $updateKasBesar['saldo'] = $updateKasBesar->saldo - $id->kredit;
                    $updateKasBesar->save();
                }
            }
        }elseif($id->debet !=null){
            if($cekKas != null){
                /* jika ada, update transaksi sesudah sesuai perubahan input*/
                foreach($cekKas as $updateKasBesar){
                    $updateKasBesar['no'] = $updateKasBesar->no -1;
                    $updateKasBesar['saldo'] = $updateKasBesar->saldo + $id->debet;
                    $updateKasBesar->save();
                }
            }
        }
        $id->delete();
        return redirect()->back()->with('status','Transaksi berhasil dihapus');
    }
    public function exportKasPendaftaran (Request $request){
        $start = Carbon::now()->firstOfMonth()->isoFormat('YYYY-MM-DD');
        $end = Carbon::now()->endOFMonth()->isoFormat('YYYY-MM-DD');
        if($request->get('filter')){
            $start = Carbon::parse($request->start)->isoFormat('YYYY-MM-DD');
            $end = Carbon::parse($request->end)->isoFormat('YYYY-MM-DD');
            $kasPendaftaran=kasPendaftaran::whereBetween('tanggal',[$start,$end])->where('proyek_id',proyekId())->orderBy('no')->get();
        }else{
            $kasPendaftaran=kasPendaftaran::whereBetween('tanggal',[$start,$end])->where('proyek_id',proyekId())->orderBy('no')->get();
        }
        return Excel::download(new KasPendaftaranExport($kasPendaftaran,$start,$end), 'Kas Pendaftaran.xlsx');
    }
}
