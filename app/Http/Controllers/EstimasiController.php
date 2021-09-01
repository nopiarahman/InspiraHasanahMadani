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
        $cicilanTempo = cicilan::whereBetween('tempo',[$start,$end])->where('proyek_id',proyekId())->where('sisaKewajiban','>',0)->get();
        $cicilanAktif = $cicilanTempo->filter(function ($value, $key) {
            if($value->pelanggan != null){
                return $value->pelanggan->kavling != null;
            }
        });
        $dpTempo = dp::whereBetween('tempo',[$start,$end])->where('proyek_id',proyekId())->where('sisaDp','>',0)->get();
        $dpAktif = $dpTempo->filter(function ($value, $key) {
            if($value->pelanggan != null){
                return $value->pelanggan->kavling != null;
            }
        });
        // dd($dpAktif);
        /* Tunggakan */
        $semuadp=dp::where('tempo','<',$start)->where('proyek_id',proyekId())->where('sisaDp','>',0)->get();
        $semuaTunggakanDP = $semuadp->filter(function ($value, $key) {
            if($value->pelanggan != null){
                return $value->pelanggan->kavling != null;
            }
        });
        $DPtertunggak=[];
        foreach($semuaTunggakanDP as $dp){
            if(cekPembayaranDP($dp->id) == null){
                $DPtertunggak[]=$dp;
            }
        }
        $semuaCicilan=cicilan::where('tempo','<',$start)->where('proyek_id',proyekId())->where('sisaKewajiban','>',0)->get();
        $semuaTunggakanCicilan = $semuaCicilan->filter(function ($value, $key) {
            if($value->pelanggan != null){
                return $value->pelanggan->kavling != null;
            }
        });
        $cicilanTertunggak=[];
        foreach($semuaTunggakanCicilan as $cicilan){
            if(cekPembayaranCicilan($cicilan->id) == null){
                $cicilanTertunggak[]=$cicilan;
            }
        }
        // dd($cicilanTertunggak);
        return view('estimasi/estimasiIndex',compact('start','end','cicilanAktif','dpAktif','DPtertunggak','cicilanTertunggak'));
    }
}
