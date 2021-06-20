<?php

namespace App\Http\Controllers;
use App\pelanggan;
use App\cicilan;
use App\dp;
use App\pembelian;
use App\kavling;
use App\User;
use App\transferDp;
use App\transferUnit;
use App\transaksi;
use App\Charts\chartAdmin;
use App\detailUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
        $kasBesar = transaksi::where(    'proyek_id',proyekId())->orderBy('no','desc')->take(15)->get();
        $saldo=$kasBesar->map(function ($item){
                            return $item->saldo;
                            });
        // dd($kasBesar);
        $chartKasBesar = new chartAdmin;
        $chartKasBesar->labels($saldo->reverse()->keys());
        $chartKasBesar->dataset('Kas Besar','line',$saldo->reverse()->values())
        ->options(['borderColor' => '#4CAF50',
                                        'fill'=>false,       
                                        'backgroundColor'=>'#4CAF50',
                                        // 'tension'=>0.3, 
                            ]);
        $chartKasBesar->height(200);

        $kavling = kavling::where('proyek_id',proyekId())->get();
        $pelanggan = pelanggan::where('proyek_id',proyekId())->get();
        $transferDp = transferDp::where('proyek_id',proyekId())->get();
        $transferUnit = transferUnit::where('proyek_id',proyekId())->get();
    
        /* pelanggan */
        if(auth()->user()->role=='pelanggan'){
            $idUser=auth()->user()->pelanggan->id;
            $id=pelanggan::find($idUser);
            $dataKavling=kavling::where('pelanggan_id',$idUser)->first();
            $dataPembelian=pembelian::where('pelanggan_id',$idUser)->first();
            // dd($dataPembelian);
            $persenDiskon = ($dataPembelian->diskon/$dataPembelian->harga)*100;
            $dpPelanggan=dp::where('pembelian_id',$dataPembelian->id)->get()->sortByDesc('urut');
            $cicilanPelanggan=cicilan::where('pembelian_id',$dataPembelian->id)->get()->sortByDesc('urut');
        }else{
            $dataKavling=[];
            $dataPembelian=[];
            $id=[];
            $idUser=[];
            $dpPelanggan=[];
            $persenDiskon=0;
            $cicilanPelanggan=[];
        }

        return view('home',compact('dpPelanggan','cicilanPelanggan','chartKasBesar','kavling','pelanggan','transferDp','transferUnit','dataKavling','dataPembelian','persenDiskon','id'));
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
    public function pengaturan(){
        $user = auth()->user();
        $detail = detailUser::where('user_id',$user->id)->first();
        return view('user/pengaturan',compact('user','detail'));
    }
    public function gantiFoto(detailUser $id, Request $request){
        // dd($id);
        $requestData=$request->all();
        if ($request->hasFile('foto')) {
            $file_nama            = $request->file('foto')->store('public/user/foto');
            $requestData['poto'] = $file_nama;
        } else {
            unset($requestData['poto']);
        }
        // dd($requestData);
        $id->update($requestData);
        return redirect()->back()->with('status','Foto berhasil diganti');
    }
    public function rubahPassword(User $id, Request $request){
        $rules=[
            'username'=>'required|min:3|max:50',
            'password'=>'required|confirmed|min:6',
        ];
        $costumMessages = [
            'required'=>':attribute tidak boleh kosong',
            'confirmed'=>'Password tidak cocok'
        ];
        $requestData = $request->all();
        $this->validate($request,$rules,$costumMessages);
        $requestData['password']= Hash::make($request->password);
        $id->update($requestData);
        return redirect()->back()->with('status','Informasi login berhasil dirubah');
    }
}
