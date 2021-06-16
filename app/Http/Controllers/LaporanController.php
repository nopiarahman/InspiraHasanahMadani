<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\transaksi;
use App\cicilan;
use App\akun;
use App\dp;
use App\pembelian;
use PDF;
use SnappyImage;
use App\Exports\LaporanBulananExport;
use App\Exports\LaporanTahunanExport;
use Maatwebsite\Excel\Facades\Excel;

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
    
    public function laporanBulanan(Request $request){
        $akunId=akun::where('proyek_id',proyekId())->where('namaAkun','pendapatan')->first();
        $start = Carbon::now()->firstOfMonth()->isoFormat('YYYY-MM-DD');
        $end = Carbon::now()->endOfMonth()->isoFormat('YYYY-MM-DD');
        if($akunId != null){
            if($request->get('filter')){
                $start = Carbon::parse($request->start)->isoFormat('YYYY-MM-DD');
                $end = Carbon::parse($request->end)->isoFormat('YYYY-MM-DD');
                $pendapatan = transaksi::where('akun_id',$akunId->id)->whereBetween('tanggal',[$start,$end])->get();
                // dd($request);
            }else{
                $pendapatan = transaksi::where('akun_id',$akunId->id)->whereBetween('tanggal',[$start,$end])->get();
            }
        }else{
            $pendapatan=[];
        }
        $kategoriAkun=akun::where('proyek_id',proyekId())->get()->groupBy('kategori')->forget('Pendapatan');
        // dd($kategoriAkun);
        $perKategori = $kategoriAkun;
        return view ('laporan/bulananIndex',compact('pendapatan','start','end','kategoriAkun','perKategori'));
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
        $pembelian= pembelian::where('id',$id->pembelian_id)->first();
        $uraian = 'Pembayaran Cicilan Ke '.$id->urut.' '.jenisKepemilikan($pembelian->pelanggan_id).' '.$pembelian->kavling->blok;   
        $cicilanPertama = cicilan::where('pembelian_id',$pembelian->id)->first();
        $sampaiSekarang = cicilan::whereBetween('created_at',[$cicilanPertama->created_at,$id->created_at])->where('pembelian_id',$id->pembelian_id)->get();
        // dd($sampaiSekarang);
        return view('cetak/kwitansi',compact('id','pembelian','uraian','sampaiSekarang'));
    }
    public function cetakKwitansiDp(Dp $id){
        $pembelian= pembelian::where('id',$id->pembelian_id)->first();
        $uraian = 'Pembayaran Dp Ke '.$id->urut.' '.jenisKepemilikan($pembelian->pelanggan_id).' '.$pembelian->kavling->blok;   
        $DpPertama = Dp::where('pembelian_id',$pembelian->id)->first();
        $sampaiSekarang = dp::whereBetween('created_at',[$DpPertama->created_at,$id->created_at])->where('pembelian_id',$id->pembelian_id)->get();
        return view('cetak/kwitansiDp',compact('id','pembelian','uraian','sampaiSekarang'));
    }
    public function exportBulanan(Request $request){
        $akunId=akun::where('proyek_id',proyekId())->where('namaAkun','pendapatan')->first();
        $start = Carbon::now()->firstOfMonth()->isoFormat('YYYY-MM-DD');
        $end = Carbon::now()->endOfMonth()->isoFormat('YYYY-MM-DD');
        if($request->get('filter')){
            $start = Carbon::parse($request->start)->isoFormat('YYYY-MM-DD');
            $end = Carbon::parse($request->end)->isoFormat('YYYY-MM-DD');
            $pendapatan = transaksi::where('akun_id',$akunId->id)->whereBetween('tanggal',[$start,$end])->get();
            // dd($request);
        }else{
            $pendapatan = transaksi::where('akun_id',$akunId->id)->whereBetween('tanggal',[$start,$end])->get();
        }
        $kategoriAkun=akun::where('proyek_id',proyekId())->get()->groupBy('kategori')->forget('Pendapatan');
        // dd($kategoriAkun);
        $perKategori = $kategoriAkun;
        return Excel::download(new LaporanBulananExport($pendapatan,$start,$end,$kategoriAkun), 'LaporanBulanan.xlsx');
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

}
