<?php

namespace App\Http\Controllers;
use App\pelanggan;
use App\pembelian;
use App\kavling;
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
        return view('home');
    }

    public function cariPelangganHome(Request $request){
        $id=pelanggan::find($request->id);
        $dataKavling=kavling::where('pelanggan_id',$request->id)->first();
        $dataPembelian=pembelian::where('pelanggan_id',$request->id)->first();
        $persenDiskon = ($dataPembelian->diskon/$dataPembelian->harga)*100;
        return view ('pelanggan/pelangganDetail',compact('id','dataKavling','dataPembelian','persenDiskon'));
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
