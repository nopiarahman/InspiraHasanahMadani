<?php

namespace App\Http\Controllers;

use App\transaksi;
use App\akun;
use App\rabUnit;
use App\rab;
use App\pelanggan;
use App\pengembalian;
use App\gudang;
use App\isiPengadaan;
use App\pettycash;
use App\kasKecilLapangan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Exports\KasBEsarExport;
use Maatwebsite\Excel\Facades\Excel;

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
                            ->whereNotNull('kredit')->where('proyek_id',proyekId())->get();
        }else{
            $start = Carbon::now()->firstOfMonth()->isoFormat('YYYY-MM-DD');
            $end = Carbon::now()->endOfMonth()->isoFormat('YYYY-MM-DD');
            $transaksiMasuk=transaksi::whereBetween('tanggal',[$start,$end])
            ->whereNotNull('kredit')->where('proyek_id',proyekId())->get();
        }
        return view ('transaksi/masukIndex',compact('transaksiMasuk','start','end'));
    }

    public function keluar(Request $request){
        // dd($request);
        /* RAB */
        $semuaRAB = rab::where('proyek_id',proyekId())->get()->groupBy(['header',function($item){
            return $item['judul'];
        }],$preserveKeys=true);
        $perHeader=$semuaRAB;
        $perJudul=$semuaRAB;

        /* Biaya Unit */
        $semuaRABUnit = rabUnit::where('proyek_id',proyekId())->get()->groupBy(['header',function($item){
            return $item['judul'];
        }],$preserveKeys=true);
        $perHeaderUnit=$semuaRABUnit;
        $perJudulUnit=$semuaRABUnit;

        /* Akun */
        // $semuaAkun=akun::where('proyek_id',proyekId())->get();
        // $kategoriAkun=akun::where('proyek_id',proyekId())->get()->groupBy('kategori');
        // $perKategori = $kategoriAkun;
        
        if($request->get('filter')){
            $start = Carbon::parse($request->start)->isoFormat('YYYY-MM-DD');
            $end = Carbon::parse($request->end)->isoFormat('YYYY-MM-DD');
            $transaksiKeluar=transaksi::whereBetween('tanggal',[$start,$end])
                            ->whereNotNull('debet')->where('proyek_id',proyekId())->orderBy('tanggal')->get();
        }else{
            $start = Carbon::now()->firstOfMonth()->isoFormat('YYYY-MM-DD');
            $end = Carbon::now()->endOfMonth()->isoFormat('YYYY-MM-DD');
            $transaksiKeluar=transaksi::whereBetween('tanggal',[$start,$end])
                            ->whereNotNull('debet')->where('proyek_id',proyekId())->orderBy('tanggal')->get();
        }
        return view ('transaksi/keluarIndex',compact('transaksiKeluar','perHeader','semuaRAB','perJudul','perHeaderUnit','semuaRABUnit','perJudulUnit','start','end'));
    }
    // public function cariAkunTransaksi(Request $request){
    //     if($request->has('q')){
    //         $cari = $request->q;
    //         $data = akun::select('id','kodeAkun')->where('kodeAkun', 'LIKE', '%'.$cari.'%')
    //                                             ->where('proyek_id',proyekId())->distinct()->get();
    //         return response()->json($data);
    //     }
    // }
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
        // dd($request);
        $jumlah = str_replace(',', '', $request->total);
        $rules=[
            'total'=>'required',
            'tanggal'=>'required',
            'uraian'=>'required',
        ];
        $costumMessages = [
            'required'=>':attribute tidak boleh kosong'
        ];
        $this->validate($request,$rules,$costumMessages);
        $requestData=$request->all();
        // dd($requestData);
        if($request->pengembalian != null){
            $requestData['jumlah']=$jumlah;
            $requestData['hargaSatuan']=1;
        }
        /* cek apakah ada transaksi sebelumnya */
        $cekTransaksiSebelum=transaksi::where('tanggal','<=',$request->tanggal)->orderBy('no')->where('proyek_id',proyekId())->get();
        /* jika transaksi sebelumnya ada value */
        if($cekTransaksiSebelum->first() != null){
            $sebelum = $cekTransaksiSebelum->last();
            $requestData['no']=$sebelum->no+1;
            $requestData['saldo']=$sebelum->saldo-$jumlah;
        }else{
            /* jika tidak ada value simpan ke akhir transaksi */
            $requestData['no']=1;
            $requestData['saldo']=$jumlah;
        }
        // dd($requestData);
        /* parameter kasBesarKeluar=['tanggal','rab_id(nullable)','rabUnit_id(nullable)','akun_id','uraian','sumber','jumlah','no','saldo'] */
        if($request->sumberKas=='kasBesar'){
            /* cek transaksi sesudah input */
            $cekTransaksi=transaksi::where('tanggal','>',$request->tanggal)->orderBy('no')->where('proyek_id',proyekId())->get();
            if($cekTransaksi->first() != null){
                /* jika ada, update transaksi sesudah sesuai perubahan input*/
                foreach($cekTransaksi as $updateTransaksi){
                    $updateTransaksi['no'] = $updateTransaksi->no +1;
                    $updateTransaksi['saldo'] = $updateTransaksi->saldo - $jumlah;
                    $updateTransaksi->save();
                }
            }
            // dd($requestData);
            /*  simpan ke kas besar sesuai input requestData*/
            kasBesarKeluar($requestData);
        }elseif($request->sumberKas=='kasKecilLapangan'){
            /* cek transaksi sesudah input */
            $cekTransaksi=transaksi::where('tanggal','>',$request->tanggal)->orderBy('no')->where('proyek_id',proyekId())->get();
            if($cekTransaksi->first() != null){
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
            $cekKasLapangan=kasKecilLapangan::where('tanggal','<=',$request->tanggal)->orderBy('no')->where('proyek_id',proyekId())->get();
            /* jika transaksi sebelumnya ada value */
            if($cekKasLapangan->first() != null){
                $sebelum = $cekKasLapangan->last();
                $requestData['no']=$sebelum->no+1;
                $requestData['saldo']=$sebelum->saldo-$jumlah;
                $requestData['keterangan']='Kas Besar';
                /* cek transaksi sesudah input */
                $cekTransaksi=kasKecilLapangan::where('tanggal','>',$request->tanggal)->orderBy('no')->where('proyek_id',proyekId())->get();
                if($cekTransaksi->first() != null){
                    /* jika ada, update transaksi sesudah sesuai perubahan input*/
                    foreach($cekTransaksi as $updateTransaksi){
                        $updateTransaksi['no'] = $updateTransaksi->no +1;
                        $updateTransaksi['saldo'] = $updateTransaksi->saldo - $jumlah;
                        $updateTransaksi->save();
                    }
                }
                kasLapanganKeluar($requestData);
            }
        }else{
            /* cek transaksi sesudah input */
            $cekTransaksi=transaksi::where('tanggal','>',$request->tanggal)->orderBy('no')->where('proyek_id',proyekId())->get();
            if($cekTransaksi->first() != null){
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
            $cekPettyCashSebelum=pettycash::where('tanggal','<=',$request->tanggal)->orderBy('no')->where('proyek_id',proyekId())->get();
            /* jika transaksi sebelumnya ada value */
            if($cekPettyCashSebelum->first() != null){
                $sebelum = $cekPettyCashSebelum->last();
                $requestData['no']=$sebelum->no+1;
                $requestData['saldo']=$sebelum->saldo-$jumlah;
                $requestData['keterangan']='Kas Besar';
                /* cek transaksi sesudah input */
                $cekTransaksi=pettycash::where('tanggal','>',$request->tanggal)->orderBy('no')->where('proyek_id',proyekId())->get();
                if($cekTransaksi->first() != null){
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
                $cekTransaksi=pettycash::where('tanggal','>',$request->tanggal)->orderBy('no')->where('proyek_id',proyekId())->get();
                if($cekTransaksi->first() != null){
                    /* jika ada, update transaksi sesudah sesuai perubahan input*/
                    foreach($cekTransaksi as $updateTransaksi){
                        $updateTransaksi['no'] = $updateTransaksi->no +1;
                        $updateTransaksi['saldo'] = $updateTransaksi->saldo - $jumlah;
                        $updateTransaksi->save();
                    }
                }
            }
        }
        if($request->isiPengadaan_id != null){
            isiPengadaan::find($request->isiPengadaan_id)->update(['statusTransfer'=>1]);
        }
        if($request->pengembalian !=null){
            
            $pelanggan=pelanggan::find($request->pengembalian);
            $pengembalian=pengembalian::where('pelanggan_id',$pelanggan->id)->first();

            $requestPengembalian = $request->all();
            $requestPengembalian['proyek_id']=proyekId();
            $requestPengembalian['pelanggan_id']=$pelanggan->id;
            $requestPengembalian['jumlah']=$jumlah;
            if($pengembalian == null){
                $requestPengembalian['sisaPengembalian']=$pelanggan->pembelian->sisaKewajiban-$pelanggan->pembelian->sisaCicilan- $jumlah;
            }else{
                $terakhir = $pengembalian->last();
                $requestPengembalian['sisaPengembalian']=$terakhir->sisaPengembalian - $jumlah;
            }
            pengembalian::create($requestPengembalian);
        }
        return redirect()->back()->with('status','Transaksi Berhasil disimpan');
    }
    public function cashFlow(Request $request){
        $semuaAkun = akun::where('proyek_id',proyekId())->where('kategori','Pendapatan')->orWhere('kategori','Modal')->get();
        // dd($request);
        if($request->get('filter')){
            $start = Carbon::parse($request->start)->isoFormat('YYYY-MM-DD');
            $end = Carbon::parse($request->end)->isoFormat('YYYY-MM-DD');
            $cashFlow=transaksi::whereBetween('tanggal',[$start,$end])->where('proyek_id',proyekId())->orderBy('no')->get();
            $awal=$cashFlow->first();
            // dd($awal);
        }else{
            $start = Carbon::now()->firstOfMonth()->isoFormat('YYYY-MM-DD');
            $end = Carbon::now()->endOfMonth()->isoFormat('YYYY-MM-DD');
            $cashFlow=transaksi::whereBetween('tanggal',[$start,$end])->where('proyek_id',proyekId())->orderBy('no')->get();
            $awal=$cashFlow->first();
        }
        return view ('transaksi/cashFlowIndex',compact('cashFlow','semuaAkun','awal','start','end'));
    }
    public function hapusKeluar(Transaksi $id){
        // dd($id);
        $dari = Carbon::parse($id->created_at)->subSeconds(20);
        $sampai = Carbon::parse($id->created_at)->addSeconds(20);
        $cekPettyCash = pettyCash::where('uraian',$id->uraian)->whereBetween('created_at',[$dari,$sampai])->where('debet',$id->debet)->first();
        // dd($cekPettyCash);
        if($cekPettyCash != null){
            /* cek transaksi sesudah input */
            $cekTransaksi=pettyCash::where('tanggal','>=',$cekPettyCash->tanggal)->where('no','>',$cekPettyCash->no)->orderBy('no')->get();
            if($cekTransaksi->first() != null){
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
        if($cekKasBesar->first() != null){
            /* jika ada, update transaksi sesudah sesuai perubahan input*/
            foreach($cekKasBesar as $updateKasBesar){
                $updateKasBesar['no'] = $updateKasBesar->no -1;
                $updateKasBesar['saldo'] = $updateKasBesar->saldo + $id->debet;
                $updateKasBesar->save();
            }
        }
        $id->delete();
        $cekGudang = gudang::where('transaksi_id',$id->id)->delete();
        return redirect()->back()->with('status','Transaksi berhasil dihapus');
    }
    public function hapusKasBesar(Transaksi $id){
        // dd($id);
        $cekKasBesar=transaksi::where('tanggal','>=',$id->tanggal)->where('no','>',$id->no)->orderBy('no')->get();
        // dd($cekKasBesar);
        if($cekKasBesar->first() != null){
            /* jika ada, update transaksi sesudah sesuai perubahan input*/
            foreach($cekKasBesar as $updateKasBesar){
                $updateKasBesar['no'] = $updateKasBesar->no -1;
                $updateKasBesar['saldo'] = $updateKasBesar->saldo - $id->kredit;
                $updateKasBesar->save();
            }
        }
        $id->delete();
        return redirect()->back()->with('status','Transaksi Berhasil dihapus');
    }
    public function exportKasBesar(Request $request){   
        if($request->get('filter')){
            $start = Carbon::parse($request->start)->isoFormat('YYYY-MM-DD');
            $end = Carbon::parse($request->end)->isoFormat('YYYY-MM-DD');
            $cashFlow=transaksi::whereBetween('tanggal',[$start,$end])->orderBy('no')->where('proyek_id',proyekId())->get();
            $awal=$cashFlow->first();
            // dd($awal);
        }else{
            $start = Carbon::now()->firstOfMonth()->isoFormat('YYYY-MM-DD');
            $end = Carbon::now()->endOfMonth()->isoFormat('YYYY-MM-DD');
            $cashFlow=transaksi::whereBetween('tanggal',[$start,$end])->orderBy('no')->where('proyek_id',proyekId())->get();
            $awal=$cashFlow->first();
        }
        return Excel::download(new KasBEsarExport($cashFlow,$start,$end), 'Kas Besar.xlsx');
    }
}