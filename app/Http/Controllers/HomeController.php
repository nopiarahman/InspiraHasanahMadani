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
        // $transferDp = transferDp::where('proyek_id',proyekId())->get();
        // $transferUnit = transferUnit::where('proyek_id',proyekId())->get();
    
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

        /* Detail Proyek */
        $semuaPembelian = pembelian::where('proyek_id',proyekId())->where('statusCicilan','Credit')->get();
        $totalDp = 0;
        $totalDpTerbayar = 0;
        $totalDpRumah = 0;
        $totalDpKios = 0;
        $totalDpRumahTerbayar = 0;
        $totalDpKiosTerbayar = 0;
        $totalCicilan = 0;
        $totalCicilanRumah = 0;
        $totalCicilanKios = 0;
        $totalCicilanTerbayar = 0;
        $totalCicilanRumahTerbayar = 0;
        $totalCicilanKiosTerbayar = 0;
        /* kavling */
        foreach($semuaPembelian->where('rumah_id',null)->where('kios_id',null) as $a){
            if($a->pelanggan !=null && $a->pelanggan->kavling !=null){
            $totalDp += $a->dp;
            $totalDpTerbayar += $a->dp()->sum('jumlah');
            $totalCicilan += $a->sisaKewajiban;
            $totalCicilanTerbayar += $a->cicilan()->sum('jumlah');
            }
        }
        $sisaDp = $totalDp-$totalDpTerbayar;
        $sisaCicilan = $totalCicilan-$totalCicilanTerbayar;
        /* rumah */
        foreach($semuaPembelian->whereNotNull('rumah_id') as $a){
            if($a->pelanggan !=null && $a->pelanggan->kavling !=null){
                $totalDpRumah += $a->dp;
                $totalDpRumahTerbayar += $a->dp()->sum('jumlah');
                $totalCicilanRumah += $a->sisaKewajiban;
                $totalCicilanRumahTerbayar += $a->cicilan()->sum('jumlah');
            }
        }
        $sisaDpRumah = $totalDpRumah-$totalDpRumahTerbayar;
        $sisaCicilanRumah = $totalCicilanRumah-$totalCicilanRumahTerbayar;
        /* kios */
        foreach($semuaPembelian->whereNotNull('kios_id') as $a){
            if($a->pelanggan !=null && $a->pelanggan->kavling !=null){
                $totalDpKios += $a->dp;
                $totalDpKiosTerbayar += $a->dp()->sum('jumlah');
                $totalCicilanKios += $a->sisaKewajiban;
                $totalCicilanKiosTerbayar += $a->cicilan()->sum('jumlah');
            }
        }
        $kelebihanTanah=transaksi::where('kategori','Kelebihan Tanah')->where('proyek_id',proyekId())->get()->sum('kredit');
        // dd($kelebihanTanah);
        $sisaDpKios = $totalDpKios-$totalDpKiosTerbayar;
        $sisaCicilanKios = $totalCicilanKios-$totalCicilanKiosTerbayar;
        /* Pendapatan */
        $pendapatanRumah = $totalDpRumah+$totalCicilanRumah;
        $pendapatanKavling = $totalDp+$totalDpKios+$totalCicilan+$totalCicilanKios+$kelebihanTanah;
        $totalPendapatan = $pendapatanRumah+$pendapatanKavling+$kelebihanTanah;
        /* chart */
        $chartPendapatan = new chartAdmin;
        $chartPendapatan->labels(['Kalving','Rumah','Kelebihan Tanah']);
        $chartPendapatan->dataset('Total Pendapatan','pie',[$pendapatanKavling,$pendapatanRumah,$kelebihanTanah])->options([
            'backgroundColor'=>['#169948','#ffa426','#fc544b']
        ]);
        $chartPendapatan->title("Total Pendapatan");

        $chartDPKavling = new chartAdmin;
        $chartDPKavling->labels(['Total Terbayar','Sisa DP']);
        $chartDPKavling->dataset('Total Terbayar Kavling','doughnut',[$totalDpTerbayar,$sisaDp])->options([
            'backgroundColor'=>['#169948','#ffa426']
        ]);
        $chartDPKavling->title("DP Kavling");
        $chartDPRumah = new chartAdmin;
        $chartDPRumah->labels(['Total Terbayar','Sisa DP']);
        $chartDPRumah->dataset('Total Terbayar Rumah','doughnut',[$totalDpRumahTerbayar,$sisaDpRumah])->options([
            'backgroundColor'=>['#169948','#ffa426']
        ]);
        $chartDPRumah->title("DP Rumah");
        $chartDPKios = new chartAdmin;
        $chartDPKios->labels(['Total Terbayar','Sisa DP']);
        $chartDPKios->dataset('Total Terbayar Kios','doughnut',[$totalDpKiosTerbayar,$sisaDpKios])->options([
            'backgroundColor'=>['#169948','#ffa426']
        ]);
        $chartDPKios->title("DP Kios");

        $chartCicilanKavling = new chartAdmin;
        $chartCicilanKavling->labels(['Total Terbayar','Sisa Cicilan']);
        $chartCicilanKavling->dataset('Total Terbayar Kavling','doughnut',[$totalCicilanTerbayar,$sisaCicilan])->options([
            'backgroundColor'=>['#169948','#ffa426']
        ]);
        $chartCicilanKavling->title("Cicilan Kavling");
        $chartCicilanRumah = new chartAdmin;
        $chartCicilanRumah->labels(['Total Terbayar','Sisa Cicilan']);
        $chartCicilanRumah->dataset('Total Terbayar Rumah','doughnut',[$totalCicilanRumahTerbayar,$sisaCicilanRumah])->options([
            'backgroundColor'=>['#169948','#ffa426']
        ]);
        $chartCicilanRumah->title("Cicilan Rumah");
        $chartCicilanKios = new chartAdmin;
        $chartCicilanKios->labels(['Total Terbayar','Sisa Cicilan']);
        $chartCicilanKios->dataset('Total Terbayar Kios','doughnut',[$totalCicilanKiosTerbayar,$sisaCicilanKios])->options([
            'backgroundColor'=>['#169948','#ffa426']
        ]);
        $chartCicilanKios->title("Cicilan Kios");
        return view('home',compact(
            'totalDpTerbayar','sisaDp','dpPelanggan','cicilanPelanggan','chartKasBesar','kavling','pelanggan','dataKavling','dataPembelian','persenDiskon','id',
            'totalCicilanTerbayar','sisaCicilan','sisaDpRumah','sisaCicilanRumah','totalDpRumahTerbayar','totalCicilanRumahTerbayar',
            'totalDpKiosTerbayar','sisaDpKios','totalCicilanKiosTerbayar','sisaCicilanKios',
            'pendapatanRumah','pendapatanKavling','totalPendapatan','kelebihanTanah',
            'chartPendapatan','chartDPKavling','chartDPRumah','chartDPKios','chartCicilanKavling','chartCicilanRumah','chartCicilanKios'
        ));
    }

    public function cariPelangganHome(Request $request){
        $id=pelanggan::find($request->id);        
        return redirect()->route('pelangganDetail', ['id' => $id->id]);
    }
    // public function cariPelangganHome(Request $request){
    //     $id=pelanggan::find($request->id);
    //     $dataKavling=kavling::where('pelanggan_id',$request->id)->first();
    //     $dataPembelian=pembelian::where('pelanggan_id',$request->id)->first();
    //     $persenDiskon = ($dataPembelian->diskon/$dataPembelian->harga)*100;
    //     $dataDp = dp::where('pembelian_id',$dataPembelian->id)->get();
    //     $dataCicilan = cicilan::where('pembelian_id',$dataPembelian->id)->get();
    //     return view ('pelanggan/pelangganDetail',compact('id','dataKavling','dataPembelian','persenDiskon','dataDp','dataCicilan'));
    // }
    public function cariPelangganDaftar(Request $request){
        if ($request->has('q')) {
    	    $cari = $request->q;
    		$data = pelanggan::select('id', 'nama')->where('nama', 'LIKE', '%'.$cari.'%')
                                                ->where('proyek_id',proyekId())->get();
            // // dd($data);
            
            // $pelanggan = pelanggan::find($data['id']);
            // $data['blok']= $pelanggan->kavling->blok;
            // $pelanggan = pelanggan::find($data['id']);
            // dd($pelanggan);
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
