<?php

namespace App\Http\Controllers;

use App\history;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function index(Request $request)
    {
        $start = Carbon::now()->firstOfMonth()->isoFormat('YYYY-MM-DD');
        $end = Carbon::now()->endOfMonth()->isoFormat('YYYY-MM-DD');
        if($request->get('filter')){
            $start = Carbon::parse($request->start)->isoFormat('YYYY-MM-DD');
            $end = Carbon::parse($request->end)->isoFormat('YYYY-MM-DD');
        }
        $history=history::whereBetween('tanggal',[$start,$end])->where('tambahan',0)->where('proyek_id',proyekId())->orderBy('created_at','desc')->get();
        return view('history/index',compact('history','start','end'));
    }
    public function tambahan(Request $request)
    {
        $start = Carbon::now()->firstOfMonth()->isoFormat('YYYY-MM-DD');
        $end = Carbon::now()->endOfMonth()->isoFormat('YYYY-MM-DD');
        if($request->get('filter')){
            $start = Carbon::parse($request->start)->isoFormat('YYYY-MM-DD');
            $end = Carbon::parse($request->end)->isoFormat('YYYY-MM-DD');
        }
        $history=history::whereBetween('tanggal',[$start,$end])->where('tambahan',1)->where('proyek_id',proyekId())->orderBy('created_at','desc')->get();
        return view('history/index',compact('history','start','end'));
    }
}
