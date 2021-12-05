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
use App\alokasiGudang;
use App\pettyCash;
use App\kasKecilLapangan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\KasBesarExport;
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
        // $cek = transaksi::whereNull('kategori')->whereNull('rab_id')->whereNull('rabunit_id')->get()->toArray();
        // foreach($cek as $c){
        //     $c->update(['kategori'=>'Pendapatan Lain']);
        // }
        // dd($cek);
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
        DB::beginTransaction();
        try {
            $jumlah = str_replace(',', '', $request->total);
            // dd($jumlah);
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
            // if($request->pengembalian != null){
            //     $requestData['jumlah']=null;
            //     $requestData['hargaSatuan']=null;
            // }
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
            if($request->pengembalian != null){
                kasBesarKeluarTanpaJumlah($requestData);
            }else{
                kasBesarKeluar($requestData);
            }
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
                else{
                    /* jika tidak ada value simpan ke akhir transaksi */
                    $requestData['no']=noKasKecilLapanganTerakhir()+1;
                    $requestData['saldo']=saldoTerakhirKasKecilLapangan()-$jumlah;
                    $requestData['keterangan']='Kas Besar';
                    kasLapanganKeluar($requestData);
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
                }
                // DB::rollback();
                // dd($requestData);
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
                $pengembalian=pengembalian::where('pelanggan_id',$pelanggan->id)->get();
                $totalCicilan = cicilanTerbayarTotal($pelanggan->pembelian->id);
                $totalDP = cekTotalDp($pelanggan->pembelian->id);
                // dd($totalDP);
                $sisa=    $totalCicilan+$totalDP-$pelanggan->pembelian->pengembalian - $jumlah;
                // dd($sisa);
                $requestPengembalian = $request->all();
                $requestPengembalian['proyek_id']=proyekId();
                $requestPengembalian['pelanggan_id']=$pelanggan->id;
                $requestPengembalian['jumlah']=$jumlah;
                if($pengembalian->first() == null){
                    $requestPengembalian['sisaPengembalian']=$sisa;
                }else{
                    $terakhir = $pengembalian->last();
                    $requestPengembalian['sisaPengembalian']=$terakhir->sisaPengembalian - $jumlah;
                }
                $cekTransaksi = transaksi::where('tanggal',$request->tanggal)->where('uraian',$request->uraian)->where('debet',$jumlah)->first();
                $requestPengembalian['transaksi_id']=$cekTransaksi->id;
                
                pengembalian::create($requestPengembalian);

            }
            DB::commit();
            return redirect()->back()->with('status','Transaksi Berhasil disimpan');
        } catch (\Exception $ex) {
            DB::rollback();
            // dd($ex);
            return redirect()->back()->with('error','Gagal. Pesan Error: '.$ex->getMessage());
        }
        
    }
    public function cashFlow(Request $request){
        // $semuaAkun = akun::where('proyek_id',proyekId())->where('kategori','Pendapatan')->orWhere('kategori','Modal')->get();
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
        return view ('transaksi/cashFlowIndex',compact('cashFlow','awal','start','end'));
    }
    public function hapusKeluar(Transaksi $id){
        // dd($id);
        DB::beginTransaction();
        try {
            $dari = Carbon::parse($id->created_at);
            $sampai = Carbon::parse($id->created_at)->addSeconds(240);
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
            }elseif($cekPettyCash == null){
                /* cek transaksi sesudah input */
                $cekKasLapangan = kasKecilLapangan::where('uraian',$id->uraian)->whereBetween('created_at',[$dari,$sampai])->where('debet',$id->debet)->first();
                // dd($cekKasLapangan);
                if($cekKasLapangan != null){
                    $cekTransaksi=kasKecilLapangan::where('tanggal','>=',$cekKasLapangan->tanggal)->where('no','>',$cekKasLapangan->no)->orderBy('no')->get();
                    if($cekTransaksi->first() != null){
                        /* jika ada, update transaksi sesudah sesuai perubahan input*/
                        foreach($cekTransaksi as $updateTransaksi){
                            $updateTransaksi['no'] = $updateTransaksi->no -1;
                            $updateTransaksi['saldo'] = $updateTransaksi->saldo + $id->debet;
                            $updateTransaksi->save();
                        }
                    }
                    $cekKasLapangan->delete();
                }
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
            $cekAlokasi = alokasiGudang::whereBetween('created_at',[$dari,$sampai])->where('uraian',$id->uraian)->first();
            if($cekAlokasi){
                $cekGudang = gudang::where('id',$cekAlokasi->gudang_id)->first();
                $cekAlokasi->delete();
                $updateStok = $cekGudang->sisa + $id->jumlah;
                $cekGudang->update(['sisa'=>$updateStok]);
            }
            $cekGudang = gudang::where('transaksi_id',$id->id)->first();
            // dd($cekGudang);
            if($cekGudang){
                if($cekGudang->alokasigudang->first()){
                    return redirect()->back()->with('error','Gagal Dihapus, transaksi mempunyai stok gudang yang telah dialokasi');
                }
                $cekGudang->delete();
            }    
            $cekPengembalian = pengembalian::where('transaksi_id',$id->id)->delete();
            $id->delete();
            DB::commit();
            return redirect()->back()->with('status','Transaksi berhasil dihapus');
        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->back()->with('error','Gagal. Pesan Error: '.$ex->getMessage());
        }
        
    }
    public function hapusKasBesar(Transaksi $id){
        // dd($id);
        DB::beginTransaction();
        try {
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
            DB::commit();
            return redirect()->back()->with('status','Transaksi Berhasil dihapus');
        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->back()->with('error','Gagal. Pesan Error: '.$ex->getMessage());
        }
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
        return Excel::download(new KasBesarExport($cashFlow,$start,$end), 'Kas Besar.xlsx');
    }
}