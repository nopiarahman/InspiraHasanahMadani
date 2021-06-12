<?php

namespace App\Http\Controllers;

use App\transaksi;
use App\akun;
use App\rabUnit;
use App\pettycash;
use App\rab;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TransaksiController extends Controller
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

    public function masuk(Request $request){
        if($request->get('filter')){
            $start = Carbon::parse($request->start)->isoFormat('YYYY-MM-DD');
            $end = Carbon::parse($request->end)->isoFormat('YYYY-MM-DD');
            $transaksiMasuk=transaksi::whereBetween('tanggal',[$start,$end])
                            ->whereNotNull('kredit')->paginate(40);
        }else{
            $start = Carbon::now()->firstOfMonth()->isoFormat('YYYY-MM-DD');
            $end = Carbon::now()->endOfMonth()->isoFormat('YYYY-MM-DD');
            $transaksiMasuk=transaksi::whereBetween('tanggal',[$start,$end])
            ->whereNotNull('kredit')->paginate(40);
        }
        return view ('transaksi/masukIndex',compact('transaksiMasuk','start','end'));
    }

    public function keluar(Request $request){
        /* RAB */
        // dd($request);
        $semuaRAB = rab::all()->groupBy(['header',function($item){
            return $item['judul'];
        }],$preserveKeys=true);
        $perHeader=$semuaRAB;
        $perJudul=$semuaRAB;

        /* Biaya Unit */
        $semuaRABUnit = rabUnit::all()->groupBy(['header',function($item){
            return $item['judul'];
        }],$preserveKeys=true);
        $perHeaderUnit=$semuaRABUnit;
        $perJudulUnit=$semuaRABUnit;

        /* Akun */
        $semuaAkun=akun::where('proyek_id',proyekId())->get();
        $kategoriAkun=akun::all()->groupBy('kategori');
        $perKategori = $kategoriAkun;
        
        if($request->get('filter')){
            $start = Carbon::parse($request->start)->isoFormat('YYYY-MM-DD');
            $end = Carbon::parse($request->end)->isoFormat('YYYY-MM-DD');
            $transaksiKeluar=transaksi::whereBetween('tanggal',[$start,$end])
                            ->whereNotNull('debet')->orderBy('no')->get();
        }else{
            $start = Carbon::now()->firstOfMonth()->isoFormat('YYYY-MM-DD');
            $end = Carbon::now()->endOfMonth()->isoFormat('YYYY-MM-DD');
            $transaksiKeluar=transaksi::whereBetween('tanggal',[$start,$end])
                            ->whereNotNull('debet')->orderBy('no')->get();
        }
        return view ('transaksi/keluarIndex',compact('semuaAkun','perKategori','kategoriAkun','transaksiKeluar','perHeader','semuaRAB','perJudul','perHeaderUnit','semuaRABUnit','perJudulUnit','start','end'));
    }
    public function cariAkunTransaksi(Request $request){
        if($request->has('q')){
            $cari = $request->q;
            $data = akun::select('id','kodeAkun')->where('kodeAkun', 'LIKE', '%'.$cari.'%')
                                                ->where('proyek_id',proyekId())->distinct()->get();
            return response()->json($data);
        }
    }
    public function cariRAB(Request $request){
        if($request->has('q')){
            $cari = $request->q;
            $data = rab::select('id','isi')->where('isi', 'LIKE', '%'.$cari.'%')
                                                ->where('proyek_id',proyekId())->distinct()->get();
            return response()->json($data);
        }
    }
    public function cariRABUnit(Request $request){
        if($request->has('q')){
            $cari = $request->q;
            $data = rabUnit::select('id','isi')->where('isi', 'LIKE', '%'.$cari.'%')
                                                ->where('proyek_id',proyekId())->distinct()->get();
            return response()->json($data);
        }
    }
    public function keluarSimpan(Request $request){
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
        /* cek apakah ada transaksi sebelumnya */
        $cekTransaksiSebelum=transaksi::where('tanggal','<=',$request->tanggal)->orderBy('no')->get();
        /* jika transaksi sebelumnya ada value */
        if($cekTransaksiSebelum != null){
            $sebelum = $cekTransaksiSebelum->last();
            $requestData['no']=$sebelum->no+1;
            $requestData['saldo']=$sebelum->saldo-$jumlah;
        }else{
            /* jika tidak ada value simpan ke akhir transaksi */
            $requestData['no']=noTransaksiTerakhir()+1;
            $requestData['saldo']=saldoTerakhir()-$jumlah;
        }
        /* parameter kasBesarKeluar=['tanggal','rab_id(nullable)','rabUnit_id(nullable)','akun_id','uraian','sumber','jumlah','no','saldo'] */
        if($request->sumberKas=='kasBesar'){
            /* cek transaksi sesudah input */
            $cekTransaksi=transaksi::where('tanggal','>',$request->tanggal)->orderBy('no')->get();
            if($cekTransaksi != null){
                /* jika ada, update transaksi sesudah sesuai perubahan input*/
                foreach($cekTransaksi as $updateTransaksi){
                    $updateTransaksi['no'] = $updateTransaksi->no +1;
                    $updateTransaksi['saldo'] = $updateTransaksi->saldo - $jumlah;
                    $updateTransaksi->save();
                }
            }
            /*  simpan ke kas besar sesuai input requestData*/
            kasBesarKeluar($requestData);
        }else{
            /* cek transaksi sesudah input */
            $cekTransaksi=transaksi::where('tanggal','>',$request->tanggal)->orderBy('no')->get();
            if($cekTransaksi != null){
                /* jika ada, update transaksi sesudah sesuai perubahan input*/
                foreach($cekTransaksi as $updateTransaksi){
                    $updateTransaksi['no'] = $updateTransaksi->no +1;
                    $updateTransaksi['saldo'] = $updateTransaksi->saldo - $jumlah;
                    $updateTransaksi->save();
                }
            }
            /*  simpan ke kas besar sesuai input requestData*/
            kasBesarKeluar($requestData);
            /* cek apakah ada transaksi sebelumnya */
            $cekPettyCashSebelum=pettycash::where('tanggal','<=',$request->tanggal)->orderBy('no')->get();
            /* jika transaksi sebelumnya ada value */
            if($cekPettyCashSebelum != null){
                $sebelum = $cekPettyCashSebelum->last();
                $requestData['no']=$sebelum->no+1;
                $requestData['saldo']=$sebelum->saldo-$jumlah;
                $requestData['keterangan']='Kas Besar';
                /* cek transaksi sesudah input */
                $cekTransaksi=pettycash::where('tanggal','>',$request->tanggal)->orderBy('no')->get();
                if($cekTransaksi != null){
                    /* jika ada, update transaksi sesudah sesuai perubahan input*/
                    foreach($cekTransaksi as $updateTransaksi){
                        $updateTransaksi['no'] = $updateTransaksi->no +1;
                        $updateTransaksi['saldo'] = $updateTransaksi->saldo - $jumlah;
                        $updateTransaksi->save();
                    }
                }
                pettyCashKeluar($requestData);
            }else{
                /* jika tidak ada value simpan ke akhir transaksi */
                $requestData['no']=noPettyCashTerakhir()+1;
                $requestData['saldo']=saldoTerakhirPettyCash()-$jumlah;
                $requestData['keterangan']='Kas Besar';
                pettyCashKeluar($requestData);
                /* cek transaksi sesudah input */
                $cekTransaksi=pettycash::where('tanggal','>',$request->tanggal)->orderBy('no')->get();
                if($cekTransaksi != null){
                    /* jika ada, update transaksi sesudah sesuai perubahan input*/
                    foreach($cekTransaksi as $updateTransaksi){
                        $updateTransaksi['no'] = $updateTransaksi->no +1;
                        $updateTransaksi['saldo'] = $updateTransaksi->saldo - $jumlah;
                        $updateTransaksi->save();
                    }
                }
            }
        }
        return redirect()->route('transaksiKeluar')->with('status','Transaksi Berhasil disimpan');
    }
    public function cashFlow(Request $request){
        $semuaAkun = akun::where('proyek_id',proyekId())->where('kategori','Pendapatan')->orWhere('kategori','Modal')->get();
        // dd($request);
        if($request->get('filter')){
            $start = Carbon::parse($request->start)->isoFormat('YYYY-MM-DD');
            $end = Carbon::parse($request->end)->isoFormat('YYYY-MM-DD');
            $cashFlow=transaksi::whereBetween('tanggal',[$start,$end])->orderBy('no')->get();
            $awal=$cashFlow->first();
            // dd($awal);
        }else{
            $start = Carbon::now()->firstOfMonth()->isoFormat('YYYY-MM-DD');
            $end = Carbon::now()->endOfMonth()->isoFormat('YYYY-MM-DD');
            $cashFlow=transaksi::whereBetween('tanggal',[$start,$end])->orderBy('no')->get();
            $awal=$cashFlow->first();
        }
        return view ('transaksi/cashFlowIndex',compact('cashFlow','semuaAkun','awal','start','end'));
    }
    public function hapusKeluar(Transaksi $id){
        // dd($id);
        $dari = Carbon::parse($id->created_at)->subSeconds(5);
        $sampai = Carbon::parse($id->created_at)->addSeconds(5);
        $cekPettyCash = pettyCash::where('uraian',$id->uraian)->whereBetween('created_at',[$dari,$sampai])->where('debet',$id->debet)->first();
        // dd($cekPettyCash);
        if($cekPettyCash != null){
            /* cek transaksi sesudah input */
            $cekTransaksi=pettyCash::where('tanggal','>=',$id->tanggal)->where('no','>',$cekPettyCash->no)->orderBy('no')->get();
            if($cekTransaksi != null){
                /* jika ada, update transaksi sesudah sesuai perubahan input*/
                foreach($cekTransaksi as $updateTransaksi){
                    $updateTransaksi['no'] = $updateTransaksi->no -1;
                    $updateTransaksi['saldo'] = $updateTransaksi->saldo + $id->debet;
                    $updateTransaksi->save();
                }
            }
            $cekPettyCash->delete();
        }
        /* cek transaksi sesudah input */
        // $hapusKasBesar=transaksi::find($id->id);
        $cekKasBesar=transaksi::where('tanggal','>=',$id->tanggal)->where('no','>',$id->no)->orderBy('no')->get();
        // dd($cekKasBesar);
        if($cekKasBesar != null){
            /* jika ada, update transaksi sesudah sesuai perubahan input*/
            foreach($cekKasBesar as $updateKasBesar){
                $updateKasBesar['no'] = $updateKasBesar->no -1;
                $updateKasBesar['saldo'] = $updateKasBesar->saldo + $id->debet;
                $updateKasBesar->save();
            }
        }
        $id->delete();
        return redirect()->back()->with('status','Transaksi berhasil dihapus');
    }
}