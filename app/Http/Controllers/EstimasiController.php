<?php

namespace App\Http\Controllers;
use App\dp;
use App\pembelian;
use App\cicilan;
use App\pelanggan;
use Carbon\Carbon;
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
        foreach($pelangganAktif as $p){
            $dp[]= $p->dp->whereBetween('tempo',[$start,$end])->last();
            
        }
        $dpAktif = collect($dp);
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
        foreach($pelangganAktif as $p){
            $cicilan[]= $p->cicilan->whereBetween('tempo',[$start,$end])->last();            
        }
        $cicilanAktif = collect($cicilan);
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
        foreach($pelangganAktif as $p){
            $dpNunggak[]=$p->dp->where('tempo','<',$start)->filter(function ($value, $key) {
                return cekPembayaranDP($value->id) == null;
            })->last();
            $cicilanNunggak[]=$p->cicilan->where('tempo','<',$start)->filter(function ($value, $key) {
                return cekPembayaranCicilan($value->id) == null;
            })->last();
        }
        $DPtertunggak=collect($dpNunggak)->where('sisaDp','>',0);
        $cicilanTertunggak=collect($cicilanNunggak)->where('sisaKewajiban','>',0);
        // dd($cicilanTertunggak);
        return view('estimasi/estimasiTunggakan',compact('start','end','DPtertunggak','cicilanTertunggak'));
    }
}
