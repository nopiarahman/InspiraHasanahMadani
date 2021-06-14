<?php

namespace App\Http\Controllers;
use App\pelanggan;
use App\cicilan;
use App\dp;
use App\pembelian;
use App\kavling;
use App\transaksi;
use App\Charts\chartAdmin;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        /* package laravel chart check di https://v6.charts.erik.cat/installation.html#composer */
        $kasBesar = transaksi::where('proyek_id',proyekId())->orderBy('no','desc')->take(15)->get();
        $saldo=$kasBesar->map(function ($item){
                            return $item->saldo;
                            });
        // dd($kasBesar);
        $chartKasBesar = new chartAdmin;
        $chartKasBesar->labels($saldo->reverse()->keys());
        $chartKasBesar->dataset('Kas Besar','line',$saldo->reverse()->values())
        ->options(['borderColor' => '#4CAF50',
                                        'fill'=>false,       
                                        'backgroundColor'=>'transparent',
                                        // 'tension'=>0.3, 
                            ]);
        $chartKasBesar->height(200);
        return view('home',compact('chartKasBesar'));
    }

    public function cariPelangganHome(Request $request){
        $id=pelanggan::find($request->id);
        $dataKavling=kavling::where('pelanggan_id',$request->id)->first();
        $dataPembelian=pembelian::where('pelanggan_id',$request->id)->first();
        $persenDiskon = ($dataPembelian->diskon/$dataPembelian->harga)*100;
        $dataDp = dp::where('pembelian_id',$dataPembelian->id)->get();
        $dataCicilan = cicilan::where('pembelian_id',$dataPembelian->id)->get();
        return view ('pelanggan/pelangganDetail',compact('id','dataKavling','dataPembelian','persenDiskon','dataDp','dataCicilan'));
    }
    public function cariPelangganDaftar(Request $request){
        if ($request->has('q')) {
    	    $cari = $request->q;
    		$data = pelanggan::select('id', 'nama')->where('nama', 'LIKE', '%'.$cari.'%')
                                                ->where('proyek_id',proyekId())->get();
            // dd($data);
    		return response()->json($data);
    	}
    }
}
