<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\transaksi;
use App\cicilan;
use App\akun;
use App\proyek;
use App\dp;
use App\rab;
use App\rabUnit;
use App\rekening;
use App\pembelian;
use PDF;
use SnappyImage;
use App\Exports\LaporanBulananExport;
use App\Exports\LaporanTahunanExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
class LaporanController extends Controller
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
    
    public function laporanBulananRAB(Request $request){
        // dd($request);
        // $akunId=akun::where('proyek_id',proyekId())->where('namaAkun','pendapatan')->first();
        $start = Carbon::now()->firstOfMonth()->isoFormat('YYYY-MM-DD');
        $end = Carbon::now()->endOfMonth()->isoFormat('YYYY-MM-DD');
        $tahunSebelumStart = Carbon::now()->subYears(1)->firstOfYear()->isoFormat('YYYY-MM-DD');
        $tahunSebelumEnd = Carbon::now()->subYears(1)->endOfYear()->isoFormat('YYYY-MM-DD');
        $tahuniniStart = Carbon::now()->firstOfYear()->isoFormat('YYYY-MM-DD');
        $tahuniniEnd = Carbon::now()->endOfYear()->isoFormat('YYYY-MM-DD');
        $aset = rab::where('isi','Aset')->where('proyek_id',proyekId())->first();
        if($request->get('filter')){
            $start = Carbon::parse($request->start)->isoFormat('YYYY-MM-DD');
            $end = Carbon::parse($request->end)->isoFormat('YYYY-MM-DD');
            $tahunSebelumStart = Carbon::parse($request->start)->subYears(1)->firstOfYear()->isoFormat('YYYY-MM-DD');
            $tahunSebelumEnd = Carbon::parse($request->end)->subYears(1)->endOfYear()->isoFormat('YYYY-MM-DD');
            $tahuniniStart = Carbon::parse($request->start)->firstOfYear()->isoFormat('YYYY-MM-DD');
            $tahuniniEnd = Carbon::parse($request->end)->endOfYear()->isoFormat('YYYY-MM-DD');
            $pendapatan = transaksi::where('kategori','Pendapatan')->whereBetween('tanggal',[$start,$end])->get();
            $modal = transaksi::where('kategori','Modal')->whereBetween('tanggal',[$start,$end])->get();
            $modalTahunSebelum = transaksi::where('kategori','Modal')->where('tanggal','<=',$tahunSebelumEnd)->get();

            if($modalTahunSebelum){
                $mts = $modalTahunSebelum->sum('kredit');
            }else{
                $mts = 0;
            }
            $bulan = transaksi::where('kategori','Modal')->whereBetween('tanggal',[$tahuniniStart,$tahuniniEnd])->get()->groupBy(function ($val) {
                return Carbon::parse($val->tanggal)->isoFormat('MMMM');
            });
            if($aset){
                $transaksiAset=transaksi::where('rab_id',$aset->id)->whereBetween('tanggal',[$tahuniniStart,$tahuniniEnd])->get()->groupBy(function ($val) {
                    return Carbon::parse($val->tanggal)->isoFormat('MMMM');
                });
                $AsetTahunSebelum = transaksi::where('rab_id',$aset->id)->where('tanggal','<=',$tahunSebelumEnd)->get();
                if($AsetTahunSebelum){
                    $ats = $AsetTahunSebelum->sum('debet');
                }else{
                    $ats = 0;
                }
            }
        }else{
            $pendapatan = transaksi::where('kategori','Pendapatan')->whereBetween('tanggal',[$start,$end])->get();
            $modal = transaksi::where('kategori','Modal')->whereBetween('tanggal',[$start,$end])->get();
            $modalTahunSebelum = transaksi::where('kategori','Modal')->where('tanggal','<=',$tahunSebelumEnd)->get();
            if($modalTahunSebelum){
                $mts = $modalTahunSebelum->sum('kredit');
            }else{
                $mts = 0;
            }
            $bulan = transaksi::where('kategori','Modal')->whereBetween('tanggal',[$tahuniniStart,$tahuniniEnd])->get()->groupBy(function ($val) {
                return Carbon::parse($val->tanggal)->isoFormat('MMMM');
            });
            if($aset){
                $transaksiAset=transaksi::where('rab_id',$aset->id)->whereBetween('tanggal',[$tahuniniStart,$tahuniniEnd])->get()->groupBy(function ($val) {
                    return Carbon::parse($val->tanggal)->isoFormat('MMMM');
                });
            }
            if($aset){
                $transaksiAset=transaksi::where('rab_id',$aset->id)->whereBetween('tanggal',[$tahuniniStart,$tahuniniEnd])->get()->groupBy(function ($val) {
                    return Carbon::parse($val->tanggal)->isoFormat('MMMM');
                });
                $AsetTahunSebelum = transaksi::where('rab_id',$aset->id)->where('tanggal','<=',$tahunSebelumEnd)->get();
                if($AsetTahunSebelum){
                    $ats = $AsetTahunSebelum->sum('debet');
                }else{
                    $ats = 0;
                }
            }
        }
        /* RAB */
        $semuaRAB = rab::all()->where('proyek_id',proyekId())->groupBy(['header',function($item){
            return $item['judul'];
        }],$preserveKeys=true);
        $semuaUnit = rabUnit::where('proyek_id',proyekId())->get()->groupBy(['header',function($item){
            return $item['judul'];
        }],$preserveKeys=true);

        return view ('laporan/bulananRAB',compact('transaksiAset','ats',
            'pendapatan','start','end','semuaRAB','semuaUnit','mts','bulan','tahuniniStart'));
    }

    public function laporanTahunan(Request $request){
        if($request->get('filter')){
            $start = Carbon::parse($request->start)->isoFormat('YYYY-MM-DD');
            $end = Carbon::parse($request->end)->isoFormat('YYYY-MM-DD');
        }else{
            $start = Carbon::now()->firstOfYear()->isoFormat('YYYY-MM-DD');
            $end = Carbon::now()->endOfYear()->isoFormat('YYYY-MM-DD');
        }
        $operasional = akun::where('proyek_id',proyekId())->where('jenis','Operasional')->get();
        $produksi = akun::where('proyek_id',proyekId())->where('jenis','Produksi')->get();
        $nonOperasional = akun::where('proyek_id',proyekId())->where('jenis','Non-Operasional')->get();
        // dd($Produksi);
        $pendapatanLain = akun::where('proyek_id',proyekId())->where('jenis','Pendapatan Lain-lain')->get();
        return view ('laporan/tahunanIndex',compact('produksi','operasional','nonOperasional','start','end','pendapatanLain'));
    }

    public function cetakKwitansi(Cicilan $id){
        // dd($id);
        $pembayaranPertama= cicilan::where('pembelian_id',$id->pembelian_id)->orderBy('tanggal')->first();
        $pembayaranSebelum = cicilan::where('pembelian_id',$id->pembelian_id)->where('tanggal','<',$id->tanggal)->orderBy('tanggal','desc')->first();
        if($pembayaranSebelum){
            $tempoSebelum = $pembayaranSebelum->tempo;
        }else{
            $tempoSebelum = $id->tanggal;
        }
        // dd($tempoSebelum);
        $semuaPembayaran = cicilan::where('pembelian_id',$id->pembelian_id)->where('tanggal','<=',$id->tanggal)->get();
        $nilai=$id->pembelian->sisaKewajiban/$id->pembelian->tenor;
        $bulanTerbayar= intVal($semuaPembayaran->sum('jumlah')/$nilai) ;
        $bulanBerjalan = Carbon::parse($id->tanggal)->firstOfMonth()->addMonth(1)->diffInMonths(Carbon::parse($pembayaranPertama->tanggal)->firstOfMonth(),true);
        $cek=Carbon::parse($id->tanggal)->firstOfMonth()->diffInMonths(Carbon::parse($tempoSebelum)->firstOfMonth(),false);
        // dd($nilai);
        if($cek>=0){
            /* lancar */
            /* pembayaran dibawah nilai bulanan */
            if($nilai > $id->jumlah){
                $tempo = Carbon::parse($id->tanggal)->firstOfMonth()->isoFormat('YYYY-MM-DD');
            }elseif($bulanTerbayar>=$bulanBerjalan){
                $tempo = Carbon::parse($pembayaranPertama->tanggal)->firstOfMonth()->addMonth($bulanTerbayar)->isoFormat('YYYY-MM-DD');
            }else{
                $tempo = Carbon::parse($id->tanggal)->firstOfMonth()->addMonth(1)->isoFormat('YYYY-MM-DD');
            }
        }else{
            /* nunggak */
            /* pembayaran dibawah nilai bulanan */
            if($nilai > $id->jumlah){
                $tempo = Carbon::parse($id->tanggal)->firstOfMonth()->isoFormat('YYYY-MM-DD');
            }elseif($bulanTerbayar>=$bulanBerjalan){
                $tempo = Carbon::parse($pembayaranPertama->tanggal)->firstOfMonth()->addMonth($bulanTerbayar)->isoFormat('YYYY-MM-DD');
            }else{
                $tempo = Carbon::parse($id->tanggal)->firstOfMonth()->addMonth(1)->isoFormat('YYYY-MM-DD');
            }
            // $tempo = Carbon::parse($id->tanggal)->firstOfMonth()->addMonth(1)->isoFormat('YYYY-MM-DD');
        }
        $proyek=proyek::find(proyekId());
        $rekening=rekening::where('proyek_id',proyekId())->get();
        $pembelian= pembelian::where('id',$id->pembelian_id)->first();
        $uraian = 'Pembayaran Cicilan Ke '.cicilanKe($id->pembelian_id,$id->tanggal).' '.jenisKepemilikan($pembelian->pelanggan_id).' '.$pembelian->kavling->blok;   
        $cicilanPertama = cicilan::where('pembelian_id',$pembelian->id)->first();
        $sampaiSekarang = cicilan::whereBetween('created_at',[$cicilanPertama->created_at,$id->created_at])->where('pembelian_id',$id->pembelian_id)->get();
        // dd($sampaiSekarang);
        return view('cetak/kwitansi',compact('tempo','id','pembelian','uraian','sampaiSekarang','rekening','proyek'));
    }
    public function cetakKwitansiDp(Dp $id){
        $pembayaranPertama= dp::where('pembelian_id',$id->pembelian_id)->orderBy('tanggal')->first();
        $pembayaranSebelum = dp::where('pembelian_id',$id->pembelian_id)->where('tanggal','<',$id->tanggal)->orderBy('tanggal','desc')->first();
        if($pembayaranSebelum){
            $tanggalSebelum = $pembayaranSebelum->tanggal;
        }else{
            $tanggalSebelum = $id->tanggal;
        }
        $semuaPembayaran = dp::where('pembelian_id',$id->pembelian_id)->where('tanggal','<=',$id->tanggal)->get();
        $nilai=$id->pembelian->dp/$id->pembelian->tenorDP;
        $bulanTerbayar= intVal($semuaPembayaran->sum('jumlah')/$nilai) ;
        $bulanBerjalan = Carbon::parse($id->tanggal)->firstOfMonth()->addMonth(1)->diffInMonths(Carbon::parse($pembayaranPertama->tanggal)->firstOfMonth(),true);

        $cek=Carbon::parse($id->tanggal)->firstOfMonth()->diffInMonths(Carbon::parse($tanggalSebelum)->firstOfMonth(),false);
        if($cek>=0){
            /* lancar */
            if($bulanTerbayar>=$bulanBerjalan){
                $tempo = Carbon::parse($pembayaranPertama->tanggal)->firstOfMonth()->addMonth($bulanTerbayar)->isoFormat('YYYY-MM-DD');
            }else{
                $tempo = Carbon::parse($id->tanggal)->firstOfMonth()->addMonth(1)->isoFormat('YYYY-MM-DD');
            }
        }else{
            /* nunggak */
            if($bulanTerbayar>=$bulanBerjalan){
                $tempo = Carbon::parse($pembayaranPertama->tanggal)->firstOfMonth()->addMonth($bulanTerbayar)->isoFormat('YYYY-MM-DD');
            }else{
                $tempo = Carbon::parse($id->tanggal)->firstOfMonth()->addMonth(1)->isoFormat('YYYY-MM-DD');
            }
            // $tempo = Carbon::parse($id->tanggal)->firstOfMonth()->addMonth(1)->isoFormat('YYYY-MM-DD');
        }
        $proyek=proyek::find(proyekId());       
        $pembelian= pembelian::where('id',$id->pembelian_id)->first();
        $rekening=rekening::where('proyek_id',proyekId())->get();
        $uraian = 'Pembayaran Dp Ke '.dpKe($id->pembelian_id,$id->tanggal).' '.jenisKepemilikan($pembelian->pelanggan_id).' '.$pembelian->kavling->blok;   
        $DpPertama = dp::where('pembelian_id',$pembelian->id)->first();
        $sampaiSekarang = dp::whereBetween('created_at',[$DpPertama->created_at,$id->created_at])->where('pembelian_id',$id->pembelian_id)->get();
        return view('cetak/kwitansiDp',compact('tempo','id','pembelian','uraian','sampaiSekarang','rekening','proyek'));
    }
    public function exportBulanan(Request $request){
        $start = Carbon::now()->firstOfMonth()->isoFormat('YYYY-MM-DD');
        $end = Carbon::now()->endOfMonth()->isoFormat('YYYY-MM-DD');
        $tahunSebelumStart = Carbon::now()->subYears(1)->firstOfYear()->isoFormat('YYYY-MM-DD');
        $tahunSebelumEnd = Carbon::now()->subYears(1)->endOfYear()->isoFormat('YYYY-MM-DD');
        $tahuniniStart = Carbon::now()->firstOfYear()->isoFormat('YYYY-MM-DD');
        $tahuniniEnd = Carbon::now()->endOfYear()->isoFormat('YYYY-MM-DD');
        $aset = rab::where('isi','Aset')->where('proyek_id',proyekId())->first();
        if($request->get('filter')){
            $start = Carbon::parse($request->start)->isoFormat('YYYY-MM-DD');
            $end = Carbon::parse($request->end)->isoFormat('YYYY-MM-DD');
            $tahunSebelumStart = Carbon::parse($request->start)->subYears(1)->firstOfYear()->isoFormat('YYYY-MM-DD');
            $tahunSebelumEnd = Carbon::parse($request->end)->subYears(1)->endOfYear()->isoFormat('YYYY-MM-DD');
            $tahuniniStart = Carbon::parse($request->start)->firstOfYear()->isoFormat('YYYY-MM-DD');
            $tahuniniEnd = Carbon::parse($request->end)->endOfYear()->isoFormat('YYYY-MM-DD');
            $pendapatan = transaksi::where('kategori','Pendapatan')->whereBetween('tanggal',[$start,$end])->get();
            $modal = transaksi::where('kategori','Modal')->whereBetween('tanggal',[$start,$end])->get();
            $modalTahunSebelum = transaksi::where('kategori','Modal')->where('tanggal','<=',$tahunSebelumEnd)->get();

            if($modalTahunSebelum){
                $mts = $modalTahunSebelum->sum('kredit');
            }else{
                $mts = 0;
            }
            $bulan = transaksi::where('kategori','Modal')->whereBetween('tanggal',[$tahuniniStart,$tahuniniEnd])->get()->groupBy(function ($val) {
                return Carbon::parse($val->tanggal)->isoFormat('MMMM');
            });
            if($aset){
                $transaksiAset=transaksi::where('rab_id',$aset->id)->whereBetween('tanggal',[$tahuniniStart,$tahuniniEnd])->get()->groupBy(function ($val) {
                    return Carbon::parse($val->tanggal)->isoFormat('MMMM');
                });
                $AsetTahunSebelum = transaksi::where('rab_id',$aset->id)->where('tanggal','<=',$tahunSebelumEnd)->get();
                if($AsetTahunSebelum){
                    $ats = $AsetTahunSebelum->sum('debet');
                }else{
                    $ats = 0;
                }
            }
        }else{
            $pendapatan = transaksi::where('kategori','Pendapatan')->whereBetween('tanggal',[$start,$end])->get();
            $modal = transaksi::where('kategori','Modal')->whereBetween('tanggal',[$start,$end])->get();
            $modalTahunSebelum = transaksi::where('kategori','Modal')->where('tanggal','<=',$tahunSebelumEnd)->get();
            if($modalTahunSebelum){
                $mts = $modalTahunSebelum->sum('kredit');
            }else{
                $mts = 0;
            }
            $bulan = transaksi::where('kategori','Modal')->whereBetween('tanggal',[$tahuniniStart,$tahuniniEnd])->get()->groupBy(function ($val) {
                return Carbon::parse($val->tanggal)->isoFormat('MMMM');
            });
            if($aset){
                $transaksiAset=transaksi::where('rab_id',$aset->id)->whereBetween('tanggal',[$tahuniniStart,$tahuniniEnd])->get()->groupBy(function ($val) {
                    return Carbon::parse($val->tanggal)->isoFormat('MMMM');
                });
            }
            if($aset){
                $transaksiAset=transaksi::where('rab_id',$aset->id)->whereBetween('tanggal',[$tahuniniStart,$tahuniniEnd])->get()->groupBy(function ($val) {
                    return Carbon::parse($val->tanggal)->isoFormat('MMMM');
                });
                $AsetTahunSebelum = transaksi::where('rab_id',$aset->id)->where('tanggal','<=',$tahunSebelumEnd)->get();
                if($AsetTahunSebelum){
                    $ats = $AsetTahunSebelum->sum('debet');
                }else{
                    $ats = 0;
                }
            }
        }
        // dd($pendapatan->first());
        /* RAB */
        $semuaRAB = rab::all()->where('proyek_id',proyekId())->groupBy(['header',function($item){
            return $item['judul'];
        }],$preserveKeys=true);
        $semuaUnit = rabUnit::where('proyek_id',proyekId())->get()->groupBy(['header',function($item){
            return $item['judul'];
        }],$preserveKeys=true);
        return Excel::download(new LaporanBulananExport(
            $transaksiAset,$ats,
            $pendapatan,$start,$end,$mts,$bulan,$tahuniniStart,$semuaRAB,$semuaUnit
        ), 'LaporanBulanan.xlsx');
    }
    public function exportTahunan(Request $request){
        if($request->get('filter')){
            $start = Carbon::parse($request->start)->isoFormat('YYYY-MM-DD');
            $end = Carbon::parse($request->end)->isoFormat('YYYY-MM-DD');
        }else{
            $start = Carbon::now()->firstOfYear()->isoFormat('YYYY-MM-DD');
            $end = Carbon::now()->endOfYear()->isoFormat('YYYY-MM-DD');
        }
        $operasional = akun::where('proyek_id',proyekId())->where('jenis','Operasional')->get();
        $produksi = akun::where('proyek_id',proyekId())->where('jenis','Produksi')->get();
        $nonOperasional = akun::where('proyek_id',proyekId())->where('jenis','Non-Operasional')->get();
        $pendapatanLain = akun::where('proyek_id',proyekId())->where('jenis','Pendapatan Lain-lain')->get();
        return Excel::download(new LaporanTahunanExport($produksi,$start,$end,$operasional,$nonOperasional,$pendapatanLain), 'Laporan Tahunan.xlsx');
        // return view ('laporan/tahunanIndex',compact('produksi','operasional','nonOperasional','start','end','pendapatanLain'));
    }
    public function cetakDPPDF(Dp $id){
        $proyek=proyek::find(proyekId()); 
        // $logoPT = Storage::url($proyek->logoPT);
        // dd($logoPT);
        $pembayaranPertama= dp::where('pembelian_id',$id->pembelian_id)->orderBy('tanggal')->first();
        $pembayaranSebelum = dp::where('pembelian_id',$id->pembelian_id)->where('tanggal','<',$id->tanggal)->orderBy('tanggal','desc')->first();
        if($pembayaranSebelum){
            $tanggalSebelum = $pembayaranSebelum->tanggal;
        }else{
            $tanggalSebelum = $id->tanggal;
        }
        $semuaPembayaran = dp::where('pembelian_id',$id->pembelian_id)->where('tanggal','<=',$id->tanggal)->get();
        $nilai=$id->pembelian->dp/$id->pembelian->tenorDP;
        $bulanTerbayar= intVal($semuaPembayaran->sum('jumlah')/$nilai) ;
        $bulanBerjalan = Carbon::parse($id->tanggal)->firstOfMonth()->addMonth(1)->diffInMonths(Carbon::parse($pembayaranPertama->tanggal)->firstOfMonth(),true);

        $cek=Carbon::parse($id->tanggal)->firstOfMonth()->diffInMonths(Carbon::parse($tanggalSebelum)->firstOfMonth(),false);
        if($cek>=0){
            /* lancar */
            if($bulanTerbayar>=$bulanBerjalan){
                $tempo = Carbon::parse($pembayaranPertama->tanggal)->firstOfMonth()->addMonth($bulanTerbayar)->isoFormat('YYYY-MM-DD');
            }else{
                $tempo = Carbon::parse($id->tanggal)->firstOfMonth()->addMonth(1)->isoFormat('YYYY-MM-DD');
            }
        }else{
            /* nunggak */
            if($bulanTerbayar>=$bulanBerjalan){
                $tempo = Carbon::parse($pembayaranPertama->tanggal)->firstOfMonth()->addMonth($bulanTerbayar)->isoFormat('YYYY-MM-DD');
            }else{
                $tempo = Carbon::parse($id->tanggal)->firstOfMonth()->addMonth(1)->isoFormat('YYYY-MM-DD');
            }
            // $tempo = Carbon::parse($id->tanggal)->firstOfMonth()->addMonth(1)->isoFormat('YYYY-MM-DD');
        }
        $rekening=rekening::where('proyek_id',proyekId())->get();
        $pembelian= pembelian::where('id',$id->pembelian_id)->first();
        $kavling = $pembelian->pelanggan->kavling;
        if($kavling){
            $blok = $kavling->blok;
        }else{
            $blok = "Batal Akad";
        }
        $uraian = 'Pembayaran Dp Ke '.dpKe($id->pembelian_id,$id->tanggal).' '.jenisKepemilikan($pembelian->pelanggan_id).' '.$pembelian->kavling->blok;   
        $DpPertama = Dp::where('pembelian_id',$pembelian->id)->first();
        $sampaiSekarang = dp::whereBetween('created_at',[$DpPertama->created_at,$id->created_at])->where('pembelian_id',$id->pembelian_id)->get();
        // return view('PDF/kwitansiDp2',compact('id','pembelian','uraian','sampaiSekarang','rekening','proyek'));
        $pdf=PDF::loadview('PDF/kwitansiDP2',compact('tempo','id','pembelian','uraian','sampaiSekarang','rekening','proyek'))->setPaper('A5','landscape');
        return $pdf->download('Kwitansi DP '.$pembelian->pelanggan->nama .' '. $blok .' Ke '.$id->urut.'.pdf');
    }
    public function cetakKwitansiPDF(Cicilan $id){
        $pembayaranPertama= cicilan::where('pembelian_id',$id->pembelian_id)->orderBy('tanggal')->first();
        $pembayaranSebelum = cicilan::where('pembelian_id',$id->pembelian_id)->where('tanggal','<',$id->tanggal)->orderBy('tanggal','desc')->first();
        if($pembayaranSebelum){
            $tanggalSebelum = $pembayaranSebelum->tanggal;
        }else{
            $tanggalSebelum = $id->tanggal;
        }
        $semuaPembayaran = cicilan::where('pembelian_id',$id->pembelian_id)->where('tanggal','<=',$id->tanggal)->get();
        $nilai=$id->pembelian->sisaKewajiban/$id->pembelian->tenor;
        $bulanTerbayar= intVal($semuaPembayaran->sum('jumlah')/$nilai) ;
        $bulanBerjalan = Carbon::parse($id->tanggal)->firstOfMonth()->addMonth(1)->diffInMonths(Carbon::parse($pembayaranPertama->tanggal)->firstOfMonth(),true);

        $cek=Carbon::parse($id->tanggal)->firstOfMonth()->diffInMonths(Carbon::parse($tanggalSebelum)->firstOfMonth(),false);
        if($cek>=0){
            /* lancar */
            if($bulanTerbayar>=$bulanBerjalan){
                $tempo = Carbon::parse($pembayaranPertama->tanggal)->firstOfMonth()->addMonth($bulanTerbayar)->isoFormat('YYYY-MM-DD');
            }else{
                $tempo = Carbon::parse($id->tanggal)->firstOfMonth()->addMonth(1)->isoFormat('YYYY-MM-DD');
            }
        }else{
            /* nunggak */
            if($bulanTerbayar>=$bulanBerjalan){
                $tempo = Carbon::parse($pembayaranPertama->tanggal)->firstOfMonth()->addMonth($bulanTerbayar)->isoFormat('YYYY-MM-DD');
            }else{
                $tempo = Carbon::parse($id->tanggal)->firstOfMonth()->addMonth(1)->isoFormat('YYYY-MM-DD');
            }
            // $tempo = Carbon::parse($id->tanggal)->firstOfMonth()->addMonth(1)->isoFormat('YYYY-MM-DD');
        }
        $proyek=proyek::find(proyekId());
        $logoPT = Storage::url($proyek->logoPT);
        // dd($logoPT); 
        $rekening=rekening::where('proyek_id',proyekId())->get();
        $pembelian= pembelian::where('id',$id->pembelian_id)->first();
        $kavling = $pembelian->pelanggan->kavling;
        if($kavling){
            $blok = $kavling->blok;
        }else{
            $blok = "Batal Akad";
        }
        $uraian = 'Pembayaran Cicilan Ke '.cicilanKe($id->pembelian_id,$id->tanggal).' '.jenisKepemilikan($pembelian->pelanggan_id).' '.$pembelian->kavling->blok;   
        $cicilanPertama = cicilan::where('pembelian_id',$pembelian->id)->first();
        $sampaiSekarang = cicilan::whereBetween('created_at',[$cicilanPertama->created_at,$id->created_at])->where('pembelian_id',$id->pembelian_id)->get();
        $pdf=PDF::loadview('PDF/kwitansi',compact('tempo','id','pembelian','uraian','sampaiSekarang','rekening','proyek','logoPT'))->setPaper('A5','landscape');
        return $pdf->download('Kwitansi Cicilan '.$pembelian->pelanggan->nama.' '.$blok.' Ke '.$id->urut.'.pdf');
    }
}
