<?php

namespace App\Http\Controllers;
use App\pettyCash;
use App\kasKecilLapangan;
use App\transaksi;
use Carbon\Carbon;
use App\Exports\PettyCashExport;
use App\Exports\KasPendaftaranExport;
use App\Exports\kasKecilLapanganExport;
use Maatwebsite\Excel\Facades\Excel;
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
            $pettyCash=pettyCash::whereBetween('tanggal',[$start,$end])->where('proyek_id',proyekId())->orderBy('no')->get();
        }else{
            $pettyCash=pettyCash::whereBetween('tanggal',[$start,$end])->where('proyek_id',proyekId())->orderBy('no')->get();
        }
        return view ('kas/pettyCash',compact('pettyCash','start','end'));
    }
    public function kasKecilLapangan(Request $request){
        $start = Carbon::now()->firstOfMonth()->isoFormat('YYYY-MM-DD');
        $end = Carbon::now()->endOfMonth()->isoFormat('YYYY-MM-DD');
        // dd($end);
        // $end = moment();
        if($request->get('filter')){
            $start = Carbon::parse($request->start)->isoFormat('YYYY-MM-DD');
            $end = Carbon::parse($request->end)->isoFormat('YYYY-MM-DD');
            $kasKecilLapangan=kasKecilLapangan::whereBetween('tanggal',[$start,$end])->where('proyek_id',proyekId())->orderBy('no')->get();
        }else{
            $kasKecilLapangan=kasKecilLapangan::whereBetween('tanggal',[$start,$end])->where('proyek_id',proyekId())->orderBy('no')->get();
        }
        return view ('kas/kasKecilLapangan',compact('kasKecilLapangan','start','end'));
    }
    public function exportKasLapangan (Request $request){
        $start = Carbon::now()->firstOfMonth()->isoFormat('YYYY-MM-DD');
        $end = Carbon::now()->endOFMonth()->isoFormat('YYYY-MM-DD');
        if($request->get('filter')){
            $start = Carbon::parse($request->start)->isoFormat('YYYY-MM-DD');
            $end = Carbon::parse($request->end)->isoFormat('YYYY-MM-DD');
            $kasKecilLapangan=kasKecilLapangan::whereBetween('tanggal',[$start,$end])->where('proyek_id',proyekId())->orderBy('no')->get();
        }else{
            $kasKecilLapangan=kasKecilLapangan::whereBetween('tanggal',[$start,$end])->where('proyek_id',proyekId())->orderBy('no')->get();
        }
        return Excel::download(new kasKecilLapanganExport($kasKecilLapangan,$start,$end), 'Kas Kecil Lapangan.xlsx');
    }
    public function kasKecilLapanganKeluar(Request $request){
        $start = Carbon::now()->firstOfMonth()->isoFormat('YYYY-MM-DD');
        $end = Carbon::now()->endOfMonth()->isoFormat('YYYY-MM-DD');
        // dd($end);
        // $end = moment();
        if($request->get('filter')){
            $start = Carbon::parse($request->start)->isoFormat('YYYY-MM-DD');
            $end = Carbon::parse($request->end)->isoFormat('YYYY-MM-DD');
            $kasKecilLapangan=kasKecilLapangan::whereBetween('tanggal',[$start,$end])->where('proyek_id',proyekId())->orderBy('no')->get();
        }else{
            $kasKecilLapangan=kasKecilLapangan::whereBetween('tanggal',[$start,$end])->where('proyek_id',proyekId())->orderBy('no')->get();
        }
        return view ('kas/kasKecilLapanganKeluar',compact('kasKecilLapangan','start','end'));
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
        $cekTransaksiSebelum=pettyCash::where('tanggal','<=',$request->tanggal)->orderBy('no')->where('proyek_id',proyekId())->get();
        /* jika transaksi sebelumnya ada value */
        if($cekTransaksiSebelum->first() != null){
            $sebelum = $cekTransaksiSebelum->last();
            $requestData['no']=$sebelum->no+1;
            $requestData['saldo']=$sebelum->saldo+$jumlah;
            $requestData['kredit']=str_replace(',', '', $request->jumlah);
            $requestData['proyek_id']=proyekId();
            $requestData['jumlah']=null;
        }else{
            /* jika tidak ada value simpan ke akhir transaksi */
            $requestData['no']=1;
            $requestData['saldo']=$jumlah;
            $requestData['kredit']=str_replace(',', '', $request->jumlah);
            $requestData['proyek_id']=proyekId();
            $requestData['jumlah']=null;

        }
        /* cek transaksi sesudah input */
        $cekTransaksi=pettyCash::where('tanggal','>',$request->tanggal)->orderBy('no')->where('proyek_id',proyekId())->get();
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
        // dd($request);
        $jumlah = str_replace(',', '', $request->jumlah);
        $rules=[
            'jumlah'=>'required',
            'kategori'=>'required',
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
        // dd($cekTransaksiSebelum);
        if($cekTransaksiSebelum->first() != null){
            $sebelum = $cekTransaksiSebelum->last();
            $requestData['no']=$sebelum->no+1;
            $requestData['kategori']=$request->kategori;
            $requestData['saldo']=$sebelum->saldo+$jumlah;
            $requestData['kredit']=str_replace(',', '', $request->jumlah);
            $requestData['proyek_id']=proyekId();
            $requestData['jumlah']=null;
        }else{
            /* jika tidak ada value simpan ke akhir transaksi */
            $requestData['no']=noTransaksiTerakhir()+1;
            $requestData['kategori']=$request->kategori;
            $requestData['saldo']=saldoTerakhir()+$jumlah;
            $requestData['kredit']=str_replace(',', '', $request->jumlah);
            $requestData['proyek_id']=proyekId();
            $requestData['jumlah']=null;

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
    public function pettyCashHapus(pettyCash $id){
        // dd($id);
        if($id->debet !=null){
            $dari = Carbon::parse($id->created_at)->subSeconds(5);
            $sampai = Carbon::parse($id->created_at)->addSeconds(5);
            $KasBesar = transaksi::where('uraian',$id->uraian)->whereBetween('created_at',[$dari,$sampai])->first();
            // dd($KasBesar);
            /* cek transaksi sesudah input */
            // $hapusKasBesar=transaksi::find($id->id);
            $cekKasBesar=transaksi::where('tanggal','>=',$KasBesar->tanggal)->where('no','>',$KasBesar->no)->orderBy('no')->get();
            // dd($cekKasBesar);
            if($cekKasBesar != null){
                /* jika ada, update transaksi sesudah sesuai perubahan input*/
                foreach($cekKasBesar as $updateKasBesar){
                    $updateKasBesar['no'] = $updateKasBesar->no -1;
                    $updateKasBesar['saldo'] = $updateKasBesar->saldo + $id->debet;
                    $updateKasBesar->save();
                }
            }
            $KasBesar->delete();
        }
        /* cek transaksi sesudah input */
        $cekTransaksi=pettyCash::where('tanggal','>=',$id->tanggal)->where('no','>',$id->no)->orderBy('no')->get();
        if($cekTransaksi != null){
            /* jika ada, update transaksi sesudah sesuai perubahan input*/
            foreach($cekTransaksi as $updateTransaksi){
                $updateTransaksi['no'] = $updateTransaksi->no -1;
                $updateTransaksi['saldo'] = $updateTransaksi->saldo + $id->debet;
                $updateTransaksi->save();
            }
        }
        $id->delete();
        return redirect()->back()->with('status','Transaksi berhasil dihapus');
    }
    public function exportPettyCash(Request $request){
        $start = Carbon::now()->firstOfMonth()->isoFormat('YYYY-MM-DD');
        $end = Carbon::now()->endOfMonth()->isoFormat('YYYY-MM-DD');
        // dd($end);
        // $end = moment();
        if($request->get('filter')){
            $start = Carbon::parse($request->start)->isoFormat('YYYY-MM-DD');
            $end = Carbon::parse($request->end)->isoFormat('YYYY-MM-DD');
            $pettyCash=pettyCash::whereBetween('tanggal',[$start,$end])->where('proyek_id',proyekId())->orderBy('no')->get();
        }else{
            $pettyCash=pettyCash::whereBetween('tanggal',[$start,$end])->where('proyek_id',proyekId())->orderBy('no')->get();
        }
        return Excel::download(new PettyCashExport($pettyCash,$start,$end), 'Petty Cash.xlsx');
    }
    public function kasKecilLapanganMasukSimpan(Request $request)
    {
        // dd($request);
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
        $cekTransaksiSebelum=kasKecilLapangan::where('tanggal','<=',$request->tanggal)->orderBy('no')->where('proyek_id',proyekId())->get();
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
        // dd($requestData);
        /* cek transaksi sesudah input */
        $cekTransaksi=kasKecilLapangan::where('tanggal','>',$request->tanggal)->orderBy('no')->where('proyek_id',proyekId())->get();
        if($cekTransaksi != null){
            /* jika ada, update transaksi sesudah sesuai perubahan input*/
            foreach($cekTransaksi as $updateTransaksi){
                $updateTransaksi['no'] = $updateTransaksi->no +1;
                $updateTransaksi['saldo'] = $updateTransaksi->saldo + $jumlah;
                $updateTransaksi->save();
            }
        }
        kasKecilLapangan::create($requestData);
        return redirect()->route('kasKecilLapangan')->with('status','Transaksi Berhasil Disimpan');
    }
    public function kasKecilLapanganKeluarSimpan(Request $request)
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
        $cekTransaksiSebelum=kasKecilLapangan::where('tanggal','<=',$request->tanggal)->orderBy('no')->where('proyek_id',proyekId())->get();
        /* jika transaksi sebelumnya ada value */
        if($cekTransaksiSebelum->last() != null){
            $sebelum = $cekTransaksiSebelum->last();
            // dd($sebelum);
            $requestData['no']=$sebelum->no+1;
            $requestData['saldo']=$sebelum->saldo-$jumlah;
        }else{
            /* jika tidak ada value simpan ke akhir transaksi */
            $requestData['no']=1;
            $requestData['saldo']=0-$jumlah;
        }
        /* cek transaksi sesudah input */
        $cekTransaksi=kasKecilLapangan::where('tanggal','>',$request->tanggal)->orderBy('no')->where('proyek_id',proyekId())->get();
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
        // $requestData['saldo']=saldoTerakhirkasKecilLapangan()-str_replace(',', '', $request->jumlah);
        kasKecilLapangan::create($requestData);
        // dd($request);
        return redirect()->route('kasKecilLapanganKeluar')->with('status','Transaksi Berhasil Disimpan');
    }
    public function hapusKasLapangan(kasKecilLapangan $id){
        if($id->debet !=null){
            $dari = Carbon::parse($id->created_at)->subSeconds(5);
            $sampai = Carbon::parse($id->created_at)->addSeconds(5);
            $KasBesar = transaksi::where('uraian',$id->uraian)->whereBetween('created_at',[$dari,$sampai])->first();
            // dd($KasBesar);
            /* cek transaksi sesudah input */
            // $hapusKasBesar=transaksi::find($id->id);
            $cekKasBesar=transaksi::where('tanggal','>=',$KasBesar->tanggal)->where('no','>',$KasBesar->no)->orderBy('no')->get();
            // dd($cekKasBesar);
            if($cekKasBesar != null){
                /* jika ada, update transaksi sesudah sesuai perubahan input*/
                foreach($cekKasBesar as $updateKasBesar){
                    $updateKasBesar['no'] = $updateKasBesar->no -1;
                    $updateKasBesar['saldo'] = $updateKasBesar->saldo + $id->debet;
                    $updateKasBesar->save();
                }
            }
            $KasBesar->delete();
        }
        /* cek transaksi sesudah input */
        $cekTransaksi=kasKecilLapangan::where('tanggal','>=',$id->tanggal)->where('no','>',$id->no)->orderBy('no')->get();
        if($cekTransaksi != null){
            /* jika ada, update transaksi sesudah sesuai perubahan input*/
            foreach($cekTransaksi as $updateTransaksi){
                $updateTransaksi['no'] = $updateTransaksi->no -1;
                $updateTransaksi['saldo'] = $updateTransaksi->saldo + $id->debet;
                $updateTransaksi->save();
            }
        }
        $id->delete();
        return redirect()->back()->with('status','Transaksi berhasil dihapus');
    }
}