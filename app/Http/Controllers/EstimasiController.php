<?php

namespace App\Http\Controllers;
use App\dp;
use App\pembelian;
use App\cicilan;
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
        $cicilanTempo = cicilan::whereBetween('tempo',[$start,$end])->where('proyek_id',proyekId())->get();
        $cicilanAktif = $cicilanTempo->filter(function ($value, $key) {
            return $value->pelanggan->kavling != null;
        });
        $dpTempo = dp::whereBetween('tempo',[$start,$end])->where('proyek_id',proyekId())->get();
        $dpAktif = $dpTempo->filter(function ($value, $key) {
            return $value->pelanggan->kavling != null;
        });
        return view('estimasi/estimasiIndex',compact('start','end','cicilanAktif','dpAktif'));
    }
}
