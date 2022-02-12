<?php

namespace App\Http\Controllers;
use App\dp;
use App\pembelian;
use App\cicilan;
use App\pelanggan;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\EsDpExport;
use App\Exports\EsCicilanExport;
use App\Exports\EsTunggakanExport;
use Illuminate\Http\Request;

class EstimasiController extends Controller
{
    public function estimasi(Request $request){
        if($request->get('filter')){
            $start = Carbon::parse($request->start)->isoFormat('YYYY-MM-DD');
            $end = Carbon::parse($request->end)->isoFormat('YYYY-MM-DD');
        }else{
            $start = Carbon::now()->firstOfMonth()->isoFormat('YYYY-MM-DD');
            $end = Carbon::now()->endOfMonth()->isoFormat('YYYY-MM-DD');
        }
        $semuaPelanggan = pelanggan::where('proyek_id',proyekId())->orderBy('nama')->get();
        $pelangganAktif = $semuaPelanggan->filter(function ($value, $key) {
            return $value->kavling != null;
        });
        foreach($pelangganAktif as $p){
            $dp[]= $p->dp->whereBetween('tempo',[$start,$end])->last();
            $cicilan[]= $p->cicilan->whereBetween('tempo',[$start,$end])->last();
            $dpNunggak[]=$p->dp->where('tempo','<',$start)->filter(function ($value, $key) {
                return cekPembayaranDP($value->id) == null;
            })->last();
            $cicilanNunggak[]=$p->cicilan->where('tempo','<',$start)->filter(function ($value, $key) {
                return cekPembayaranCicilan($value->id) == null;
            })->last();
        }
        $dpAktif = collect($dp);
        $cicilanAktif = collect($cicilan);
        $DPtertunggak=collect($dpNunggak)->where('sisaDp','>',0);

        $cicilanTertunggak=collect($cicilanNunggak)->where('sisaKewajiban','>',0);
        return view('estimasi/estimasiIndex',compact('start','end','cicilanAktif','dpAktif','DPtertunggak','cicilanTertunggak'));
    }
    public function estimasiDp(Request $request){
        if($request->get('filter')){
            $start = Carbon::parse($request->start)->isoFormat('YYYY-MM-DD');
            $end = Carbon::parse($request->end)->isoFormat('YYYY-MM-DD');
        }else{
            $start = Carbon::now()->firstOfMonth()->isoFormat('YYYY-MM-DD');
            $end = Carbon::now()->endOfMonth()->isoFormat('YYYY-MM-DD');
        }
        $semuaPelanggan = pelanggan::where('proyek_id',proyekId())->orderBy('nama')->get();
        $pelangganAktif = $semuaPelanggan->filter(function ($value, $key) {
            return $value->kavling != null;
        });
        $dp=[];
        foreach($pelangganAktif as $p){
            $dp[]= $p->pembelian;
        }
        if($dp){
            $dpAktif = collect($dp);
        }else{
            $dpAktif=[];
        }

        return view('estimasi/estimasiDP',compact('start','end','dpAktif'));
    }
    public function estimasiCicilan(Request $request){
        if($request->get('filter')){
            $start = Carbon::parse($request->start)->isoFormat('YYYY-MM-DD');
            $end = Carbon::parse($request->end)->isoFormat('YYYY-MM-DD');
        }else{
            $start = Carbon::now()->firstOfMonth()->isoFormat('YYYY-MM-DD');
            $end = Carbon::now()->endOfMonth()->isoFormat('YYYY-MM-DD');
        }
        $semuaPelanggan = pelanggan::where('proyek_id',proyekId())->orderBy('nama')->get();
        $pelangganAktif = $semuaPelanggan->filter(function ($value, $key) {
            return $value->kavling != null;
        });
        $cicilan=[];
        foreach($pelangganAktif as $p){
            $cicilan[]= $p->pembelian;
        }
        if($cicilan){
            $cicilanAktif = collect($cicilan)->where('sisaCicilan','>',0);
        }else{
            $cicilanAktif=[];
        }
        // dd($cicilanAktif->take(10));
        return view('estimasi/estimasiCicilan',compact('start','end','cicilanAktif'));
    }
    public function estimasiTunggakan(Request $request){
        if($request->get('filter')){
            $start = Carbon::parse($request->start)->isoFormat('YYYY-MM-DD');
            $end = Carbon::parse($request->end)->isoFormat('YYYY-MM-DD');
        }else{
            $start = Carbon::now()->firstOfMonth()->isoFormat('YYYY-MM-DD');
            $end = Carbon::now()->endOfMonth()->isoFormat('YYYY-MM-DD');
        }
        $semuaPelanggan = pelanggan::where('proyek_id',proyekId())->orderBy('nama')->get();
        $pelangganAktif = $semuaPelanggan->filter(function ($value, $key) {
            return $value->kavling != null;
        });
        $x=[];
        foreach($pelangganAktif as $p){
            $x[]= $p->pembelian;
        }
        if($x){
            foreach($x as $p){
                if(cekDPNunggakBulanIni($p,$start)!=null){
                    $dpNunggak[]=$p;
                };
                if(cekCicilanNunggakBulanIni($p,$start)!=null){
                    $cicilanNunggak[]=$p;
                };
            }

            $DPtertunggak=collect($dpNunggak)->where('sisaDp','>',0);
            $cicilanTertunggak=collect($cicilanNunggak)->where('sisaCicilan','>',0);
        }else{
            $DPtertunggak=[];
            $cicilanTertunggak=[];
        }
        return view('estimasi/estimasiTunggakan',compact('start','end','DPtertunggak','cicilanTertunggak'));
    }
    public function exportEstimasiDp(Request $request){
        // dd($request);
        if($request->get('filter')){
            $start = Carbon::parse($request->start)->isoFormat('YYYY-MM-DD');
            $end = Carbon::parse($request->end)->isoFormat('YYYY-MM-DD');
        }else{
            $start = Carbon::now()->firstOfMonth()->isoFormat('YYYY-MM-DD');
            $end = Carbon::now()->endOfMonth()->isoFormat('YYYY-MM-DD');
        }
        $semuaPelanggan = pelanggan::where('proyek_id',proyekId())->orderBy('nama')->get();
        $pelangganAktif = $semuaPelanggan->filter(function ($value, $key) {
            return $value->kavling != null;
        });
        foreach($pelangganAktif as $p){
            $dp[]= $p->pembelian;
        }
        $dpAktif = collect($dp);
        $bulan=$start;
        return Excel::download(new EsDpExport(
            $start,$end,$dpAktif
        ), 'Estimasi DP '.$bulan.'.xlsx');
    }
    public function exportEstimasiCicilan(Request $request){
        if($request->get('filter')){
            $start = Carbon::parse($request->start)->isoFormat('YYYY-MM-DD');
            $end = Carbon::parse($request->end)->isoFormat('YYYY-MM-DD');
        }else{
            $start = Carbon::now()->firstOfMonth()->isoFormat('YYYY-MM-DD');
            $end = Carbon::now()->endOfMonth()->isoFormat('YYYY-MM-DD');
        }
        $semuaPelanggan = pelanggan::where('proyek_id',proyekId())->orderBy('nama')->get();
        $pelangganAktif = $semuaPelanggan->filter(function ($value, $key) {
            return $value->kavling != null;
        });
        foreach($pelangganAktif as $p){
            $cicilan[]= $p->pembelian;
            // $cicilan=collect($cicilanPelanggan)->whereBetween('tempo',[$start,$end]);       
        }

        $cicilanAktif = collect($cicilan)->where('sisaCicilan','>',0);
        $bulan=$start;
        return Excel::download(new EsCicilanExport(
            $start,$end,$cicilanAktif
        ), 'Estimasi Cicilan '.$bulan.'.xlsx');
    }
    public function exportEstimasiTunggakan(Request $request){
        if($request->get('filter')){
            $start = Carbon::parse($request->start)->isoFormat('YYYY-MM-DD');
            $end = Carbon::parse($request->end)->isoFormat('YYYY-MM-DD');
        }else{
            $start = Carbon::now()->firstOfMonth()->isoFormat('YYYY-MM-DD');
            $end = Carbon::now()->endOfMonth()->isoFormat('YYYY-MM-DD');
        }
        $semuaPelanggan = pelanggan::where('proyek_id',proyekId())->orderBy('nama')->get();
        $pelangganAktif = $semuaPelanggan->filter(function ($value, $key) {
            return $value->kavling != null;
        });
        $x=[];
        foreach($pelangganAktif as $p){
            $x[]= $p->pembelian;
        }
        if($x){
            foreach($x as $p){
                if(cekDPNunggakBulanIni($p,$start)!=null){
                    $dpNunggak[]=$p;
                };
                if(cekCicilanNunggakBulanIni($p,$start)!=null){
                    $cicilanNunggak[]=$p;
                };
            }
                $DPtertunggak=collect($dpNunggak)->where('sisaDp','>',0);
                $cicilanTertunggak=collect($cicilanNunggak)->where('sisaCicilan','>',0);

        }
        return Excel::download(new EsTunggakanExport(
            $start,$end,$DPtertunggak,$cicilanTertunggak
        ), 'Tunggakan .xlsx');
    }
}
