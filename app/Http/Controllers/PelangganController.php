<?php

namespace App\Http\Controllers;

use App\pelanggan;
use App\kavling;
use App\transferUnit;
use App\transferDp;
use App\rekening;
use App\rumah;
use App\kios;
use App\akun;
use App\user;
use App\detailUser;
use App\rab;
use App\cicilan;
use App\dp;
use App\rabUnit;
use App\pembelian;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // $users = User::all();
        // $usersUnique = $users->unique('username');
        // $usersDupes = $users->diff($usersUnique);
        // dd($users, $usersUnique, $usersDupes);

        $semuaPelanggan = pelanggan::where('proyek_id',proyekId())->orderBy('nama')->get();
        // $pelanggan=collect($semuaPelanggan);
        $pelangganAktif = $semuaPelanggan->filter(function ($value, $key) {
            return $value->kavling != null;
        });
        // dd($aktif->paginate());
        return view ('pelanggan/index',compact('pelangganAktif'));
    }
    public function nonAktif()
    {
        $semuaPelanggan = pelanggan::where('proyek_id',proyekId())->orderBy('nama')->get();
        // $pelanggan=collect($semuaPelanggan);
        $pelangganNonAktif = $semuaPelanggan->filter(function ($value, $key) {
            return $value->kavling == null;
        });
        // dd($aktif->paginate());
        // dd($pelangganNonAktif);
        return view ('pelanggan/nonAktif',compact('pelangganNonAktif'));
    }
    public function terhapus()
    {
        $terhapus = pelanggan::onlyTrashed()->where('proyek_id',proyekId())->orderBy('nama')->get();
        
        return view ('pelanggan/terhapus',compact('terhapus'));
    }
    public function restoreTerhapus($id, Request $request){
        $terhapus = Pelanggan::onlyTrashed()->where('id',$id)->first();
        // dd($terhapus);
        try {
            DB::beginTransaction();
            $terhapus->restore();
            DB::commit();
            return redirect()->back()->with('pesan','Pelanggan berhasil di restore.');
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->back()->with('error','Gagal. Pesan Error: '.$ex->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ('pelanggan/pelangganTambah');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        // dd($request);
        $rules=[
            'nama'=>'required',
            'kavling_id'=>'required',
            'tenor'=>'required',
            'potonganDp'=>'required',
            'harga'=>'required',
            'dp'=>'required',
        ];
        $costumMessages = [
            'required'=>':attribute tidak boleh kosong'
        ];
        $this->validate($request,$rules,$costumMessages);
        DB::beginTransaction();
        try {
            /* Membuat Akun User */
            $kavlingPelanggan=kavling::where('id',$request->kavling_id)->first();
            // dd($kavlingPelanggan->blok);
            // $parts = explode("@",$request->email);
            $username =strtolower("kta".$kavlingPelanggan->blok);
            // dd($username);
            $sandi = Carbon::parse($request->tanggalLahir)->isoFormat('DDMMYY');
            $requestUser ['proyek_id'] = proyekId();
            $requestUser ['name'] = $request->nama;
            $requestUser ['email'] = $request->email;
            $requestUser ['username'] = $username;
            $requestUser ['password'] = Hash::make($sandi);
            $requestUser ['role'] = 'pelanggan';
            User::create($requestUser);
            $cekUser = User::where('username',$username)->first();
            $detail = detailUser::create([
                'user_id'=>$cekUser->id
            ]);
            $detail->save();

            /* membuat data pelanggan */
            if($request->statusDp=='Credit'){
                $sisaDp=str_replace(',', '', $request->dp);
            }else{
                $sisaDp=0;
            }
            if($request->statusCicilan=='Credit'){
                $sisaCicilan=str_replace(',', '', $request->sisaKewajiban);
            }else{
                $sisaCicilan=0;
            }
            $requestpelanggan = pelanggan::create([
                'nik'=>$request->nik,
                'nama'=>$request->nama,
                'email'=>$request->email,
                'tempatLahir'=>$request->tempatLahir,
                'tanggalLahir'=>$request->tanggalLahir,
                'alamat'=>$request->alamat,
                'jenisKelamin'=>$request->jenisKelamin,
                'statusPernikahan'=>$request->statusPernikahan,
                'pekerjaan'=>$request->pekerjaan,
                'nomorTelepon'=>$request->nomorTelepon,
                'noDarurat'=>$request->noDarurat,
                'proyek_id'=>proyekId(),
                'user_id'=>$cekUser->id,
            ]);
            $requestpelanggan->save();
            $cariPelanggan=pelanggan::where('user_id',$cekUser->id)->first(); 
            if($request->tenorDP != null){
                $tenorDP = $request->tenorDP;
            }else{
                $tenorDP = 1;
            }
            $potonganDp=str_replace(',', '', $request->potonganDp);
            $requestPembelian = pembelian::create([
                'kavling_id'=>$request->kavling_id,
                'nomorAkad'=>$request->nomorAkad,
                'tanggalAkad'=>$request->tanggalAkad,
                'harga'=>str_replace(',', '', $request->harga),
                'diskon'=>str_replace(',', '', $request->totalDiskon),
                'dp'=>str_replace(',', '', $request->dp)-$potonganDp,
                'sisaKewajiban'=>str_replace(',', '', $request->sisaKewajiban),
                'sisaDp'=>$sisaDp,
                'sisaCicilan'=>$sisaCicilan,
                'tenor'=>$request->tenor,
                'tenorDP'=>$tenorDP,
                'statusDp'=>$request->statusDp,
                'statusCicilan'=>$request->statusCicilan,
                'proyek_id'=>proyekId(),
                'pelanggan_id'=>$cariPelanggan->id,
                'luasBangunan'=>$request->luasBangunan,
                'statusPembelian'=>$request->statusPembelian,
                'tanggalBooking'=>$request->tanggalBooking,
                'potonganDp'=>$potonganDp,
            ]);$requestPembelian->save();
            /* simpan data Rumah dan Kios*/
            if($request->includePembelian =='Rumah'){
                $data ['kavling_id']=$request->kavling_id;
                $data ['proyek_id']=proyekId();
                $data ['pelanggan_id']=$cariPelanggan->id;
                $data ['luasBangunan']=$request->luasBangunan;
                rumah::updateOrCreate(['kavling_id'=>$request->kavling_id],$data);
                $cariRumah=rumah::where('kavling_id',$request->kavling_id)->first();
                $updatePembelian=pembelian::where('kavling_id',$request->kavling_id)->update(['rumah_id'=>$cariRumah->id]);
                /* update RAB unit */
                $cariKavling=kavling::find($request->kavling_id);
                $blok= $cariKavling->blok;
                $rabUnit=rabUnit::updateOrCreate(['isi'=>$cariKavling->blok],[
                    'proyek_id'=>proyekId(),
                    'header'=>'BIAYA PRODUKSI RUMAH',
                    'judul'=>'Biaya Produksi Rumah',
                    'kodeRAB'=>'IH-5-'.$cariKavling->b.'-'.$cariKavling->nr,
                    'isi'=>$cariKavling->blok,
                    'jenisUnit'=>'rumah',
                    'hargaSatuan'=>hargaSatuanRumah(),
                ]);
            }elseif($request->includePembelian =='Kios'){
                $data ['kavling_id']=$request->kavling_id;
                $data ['proyek_id']=proyekId();
                $data ['pelanggan_id']=$cariPelanggan->id;
                $data ['luasBangunan']=$request->luasBangunan;
                kios::updateOrCreate(['kavling_id'=>$request->kavling_id],($data));
                $cariKios=kios::where('kavling_id',$request->kavling_id)->first();
                $updatePembelian=pembelian::where('kavling_id',$request->kavling_id)->update(['kios_id'=>$cariKios->id]);
                /* update RAB unit */
                $cariKavling=kavling::find($request->kavling_id);
                $blok= $cariKavling->blok;
                $rabUnit=rabUnit::updateOrCreate(['isi'=>$cariKavling->blok],[
                    'proyek_id'=>proyekId(),
                    'header'=>'BIAYA PRODUKSI RUMAH',
                    'judul'=>'Biaya Produksi Rumah',
                    'kodeRAB'=>'IH-5-'.$cariKavling->b.'-'.$cariKavling->nr,
                    'isi'=>$cariKavling->blok,
                    'jenisUnit'=>'kios',
                    'hargaSatuan'=>hargaSatuanRumah(),
                ]);
            }
            /* update data kavling*/
            $updateKavling=kavling::find($request->kavling_id)->update(['pelanggan_id'=>$cariPelanggan->id]);
            DB::commit();
            return redirect()->route('pelangganIndex')->with('status','Data Pelanggan Berhasil ditambahkan');
        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->back()->with('error','Gagal. Pesan Error: '.$ex->getMessage());
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\pelanggan  $pelanggan
     * @return \Illuminate\Http\Response
     */
    public function show(pelanggan $pelanggan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\pelanggan  $pelanggan
     * @return \Illuminate\Http\Response
     */
    public function edit(pelanggan $pelanggan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\pelanggan  $pelanggan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, pelanggan $id){
        $rules=[
            'nama'=>'required',
        ];
        $costumMessages = [
            'required'=>':attribute tidak boleh kosong'
        ];
        $requestpelanggan = ([
            'nik'=>$request->nik,
            'nama'=>$request->nama,
            'email'=>$request->email,
            'tempatLahir'=>$request->tempatLahir,
            'tanggalLahir'=>$request->tanggalLahir,
            'alamat'=>$request->alamat,
            'jenisKelamin'=>$request->jenisKelamin,
            'statusPernikahan'=>$request->statusPernikahan,
            'pekerjaan'=>$request->pekerjaan,
            'nomorTelepon'=>$request->nomorTelepon,
            'noDarurat'=>$request->noDarurat,
            'proyek_id'=>proyekId(),
        ]);
        $this->validate($request,$rules,$costumMessages);
        $id->update($requestpelanggan);
        // $requestpelanggan->save();
        return redirect()->back()->with('status','Pelanggan berhasil dirubah');
    }
    public function updateUnit(Pelanggan $id, Request $request){
        // dd($request);
        DB::beginTransaction();
        try {
            $cekPembelian=pembelian::where('pelanggan_id',$id->id)->first();
        $cekRumah=$cekPembelian->rumah;
        $cekKios=$cekPembelian->kios;
        $cekKavling=$id->kavling;

        /* Potongan DP */
        $potonganDp=str_replace(',', '', $request->potonganDp);
        $terbayar=dp::where('pembelian_id',$cekPembelian->id)->get()->sum('jumlah');
        $cicilanTerbayar=cicilan::where('pembelian_id',$cekPembelian->id)->get()->sum('jumlah');
        if($request->statusDp=='Credit'){
            $sisaDp=str_replace(',', '', $request->dp)-$terbayar;
        }else{
            $sisaDp=0;
        }
        if($request->statusCicilan=='Credit'){
            $sisaCicilan=str_replace(',', '', $request->sisaKewajiban)-$cicilanTerbayar;
        }else{
            $sisaCicilan=0;
        }
        $rules=[
            'harga'=>'required',
            'dp'=>'required',
            'potonganDp'=>'required',
            'tenor'=>'required',
        ];
        $costumMessages = [
            'required'=>':attribute tidak boleh kosong'
        ];
        $this->validate($request,$rules,$costumMessages);
        if($request->kavling_id){
            $kavlingBaru = $request->kavling_id;
        }else{
            $kavlingBaru = $cekPembelian->kavling_id;
            $kavlingsebelum=kavling::find($cekPembelian->kavling_id);
        }
        $requestPembelian = ([
            'kavling_id'=>$kavlingBaru,
            'nomorAkad'=>$request->nomorAkad,
            'tanggalAkad'=>$request->tanggalAkad,
            'harga'=>str_replace(',', '', $request->harga),
            'diskon'=>str_replace(',', '', $request->totalDiskon),
            'dp'=>str_replace(',', '', $request->dp)-$potonganDp,
            'sisaKewajiban'=>str_replace(',', '', $request->sisaKewajiban),
            'sisaDp'=>$sisaDp,
            'sisaCicilan'=>$sisaCicilan,
            'tenor'=>$request->tenor,
            'statusDp'=>$request->statusDp,
            'statusCicilan'=>$request->statusCicilan,
            'proyek_id'=>proyekId(),
            'pelanggan_id'=>$id->id,
            'luasBangunan'=>$request->luasBangunan,
            'potonganDp'=>$potonganDp,
        ]);
        /* update pembelian dibawah */
        $cekPembelian->update($requestPembelian);
        /* simpan data Rumah dan Kios*/
        if($request->includePembelian == null){
            $cariKavling=kavling::find($kavlingBaru);
            if( $cariKavling->b === "KIOS"){
                DB::rollback();
                return redirect()->back()->with('error','Gagal, silahkan ganti blok selain blok kios!');
            }
            
            $id->pembelian->update(['rumah_id'=>null,'kios_id'=>null]);
            if($cekRumah!=null){
                $id->rumah->update(['pelanggan_id'=>0]);
            }elseif($cekKios!=null){
                $id->kios->update(['pelanggan_id'=>0]);
            }
        }
        if($request->includePembelian =='Rumah'){
            $cariKavling=kavling::find($kavlingBaru);
            $blok= $cariKavling->blok;
            if( $cariKavling->b === "KIOS"){
                DB::rollback();
                return redirect()->back()->with('error','Gagal, Blok kavling bukan kavling rumah!');
            }
            if($cekRumah !=null){
                rumah::where('pelanggan_id',$id->id)->update(['pelanggan_id'=>0]);               
                /* Buat Rumah jika sebelum nya belum punya rumah */
            }
            /* buat rumah baru di kavling terpilih */
            $data ['kavling_id']=$kavlingBaru;
            $data ['proyek_id']=proyekId();
            $data ['pelanggan_id']=$id->id;
            $data ['luasBangunan']=$request->luasBangunan;
            rumah::create($data);
            /* update RAB unit */
            $rabUnit=rabUnit::updateOrCreate(['isi'=>$cariKavling->blok],[
                'proyek_id'=>proyekId(),
                'header'=>'BIAYA PRODUKSI RUMAH',
                'judul'=>'Biaya Produksi Rumah',
                'kodeRAB'=>'IH-5-'.$cariKavling->b.'-'.$cariKavling->nr,
                'isi'=>$cariKavling->blok,
                'jenisUnit'=>'rumah',
                'hargaSatuan'=>hargaSatuanRumah(),
            ]);
            /* cek dan rubah jika pembelian sebelumnya adalah kios */
            if($cekKios != null){
                /* dihapus dulu kepemilikan kios */
                $updatePembelian = pembelian::find($cekPembelian->id)->update(['kios_id'=>null]);
                /* hapus kios */
                kios::where('pelanggan_id',$id->id)->update(['pelanggan_id'=>0]);            
            }
            /* update data rumah dari rumah sebelumnya */
            
            $updateRumah = rumah::where('kavling_id',$kavlingBaru)->update(['luasBangunan'=>$request->luasBangunan]);
            $rumah=rumah::where('kavling_id',$kavlingBaru)->first();
            $id->pembelian->update(['rumah_id'=>$rumah->id]);
        }elseif($request->includePembelian =='Kios'){
            $cariKavling=kavling::find($kavlingBaru);
            $blok= $cariKavling->blok;
            if( $cariKavling->b != "KIOS"){
                DB::rollback();
                // dd($cariKavling->b);
                return redirect()->back()->with('error','Gagal, Blok kavling bukan kavling kios!');
            }
            if($cekKios !=null){
                kios::where('pelanggan_id',$id->id)->update(['pelanggan_id'=>0]);               
            }
            $data ['kavling_id']=$kavlingBaru;
            $data ['proyek_id']=proyekId();
            $data ['pelanggan_id']=$id->id;
            $data ['luasBangunan']=$request->luasBangunan;
            kios::create($data);
            /* update RAB unit */
            $rabUnit=rabUnit::updateOrCreate(['isi'=>$cariKavling->blok],[
                'proyek_id'=>proyekId(),
                'header'=>'BIAYA PRODUKSI RUMAH',
                'judul'=>'Biaya Produksi Rumah',
                'kodeRAB'=>'IH-5-'.$cariKavling->b.'-'.$cariKavling->nr,
                'isi'=>$cariKavling->blok,
                'jenisUnit'=>'kios',
                'hargaSatuan'=>hargaSatuanRumah(),
            ]);
            if($cekRumah != null){
                /* dihapus dulu kepemilikan kios */
                $updatePembelian = pembelian::find($cekPembelian->id)->update(['rumah_id'=>null]);
                /* hapus rumah */
                rumah::where('pelanggan_id',$id->id)->update(['pelanggan_id'=>0]);
            }
            
            /* cek dan rubah jika pembelian sebelumnya adalah rumah */
            if($cekKios != null){
                /* dihapus dulu kepemilikan rumah */
                $updatePembelian = pembelian::find($cekPembelian->id)->update(['kios_id'=>null]);
            }
            $updateKios = kios::where('kavling_id',$kavlingBaru)->update(['luasBangunan'=>$request->luasBangunan,'kavling_id'=>$request->kavling_id]);
            $kios=kios::where('kavling_id',$kavlingBaru)->first();
            $id->pembelian->update(['kios_id'=>$kios->id]);
        }
        $updateKepemilikanKavling=kavling::find($cekKavling->id)->update(['pelanggan_id'=>0]);
        $updateKavling = kavling::find($kavlingBaru)->update(['pelanggan_id'=>$id->id]);
        DB::commit();
        return redirect()->back()->with('status','Data Unit Pelanggan berhasil diedit');
        } catch (\Exception $ex) {
            DB::rollback();
            dd($ex);
            return redirect()->back()->with('error','Gagal. Pesan Error: '.$ex->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\pelanggan  $pelanggan
     * @return \Illuminate\Http\Response
     */
    public function destroy(pelanggan $id)
    {
        DB::beginTransaction();
        try {
            if($id->dp->first() || $id->cicilan->first() != null){
                return redirect()->back()->with('error','Gagal Hapus Pelanggan, Pelanggan Mempunyai transaksi');
            }
            $pelanggan = pelanggan::find($id->id);
            $cekKavling = kavling::where('pelanggan_id',$id->id)->first();
            $cekKavling->pembelian->update(['statusPembelian'=>'Ready']);
            if($cekKavling!=null){
                $updateKavling = kavling::find($id->kavling->id)->update(['pelanggan_id'=>0]);
                if($id->rumah != null){
                    $updateRumah = rumah::find($id->rumah->id)->update(['pelanggan_id'=>0]);
                }
                if($id->kios != null){
                    $updateKios = kios::find($id->kios->id)->update(['pelanggan_id'=>0]);
                }
            }
            $user=user::find($id->user_id);
            $user->delete();
            $pelanggan->delete();
            DB::commit();
            return redirect()->back()->with('status','Pelanggan Dihapus!');
        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->back()->with('error','Gagal. Pesan Error: '.$ex->getMessage());
        }
        
    }
    public function destroyNonAktif(Pelanggan $id){
        // dd($id->kavling);
        DB::beginTransaction();
        try {
            if($id->dp->first() || $id->cicilan->first() != null){
                return redirect()->back()->with('error','Gagal Hapus Pelanggan, Pelanggan Mempunyai transaksi');
            }
            $id->delete();
            $user=user::find($id->user_id);
            $user->delete();
            DB::commit();
            return redirect()->back()->with('status','Pelanggan Dihapus!');
        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->back()->with('error','Gagal. Pesan Error: '.$ex->getMessage());
        }
        
    }
    public function batalAkad(Pelanggan $id){
        DB::beginTransaction();
        try {
            $user = $id->user;
            $user->update(['username'=>'batalakad'.strtolower($id->kavling->blok)]);
            $cekKavling = kavling::where('pelanggan_id',$id->id)->first();
            $cekKavling->pembelian->update(['statusPembelian'=>'Ready']);
            $updateKavling = kavling::find($id->kavling->id)->update(['pelanggan_id'=>0]);
            if($id->rumah != null){
                $updateRumah = rumah::find($id->rumah->id)->update(['pelanggan_id'=>0]);
            }
            if($id->kios != null){
                $updateKios = kios::find($id->kios->id)->update(['pelanggan_id'=>0]);
            }
            DB::commit();
            return redirect()->back()->with('status','Akad Dibatalkan!');
        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->back()->with('error','Gagal. Pesan Error: '.$ex->getMessage());
        }
    }
    public function cariKavling(Request $request){
        // dd($request);
        if ($request->has('q')) {
    	    $cari = $request->q;
    		$data = kavling::select('id', 'blok')->where('blok', 'LIKE', '%'.$cari.'%')
                                                ->where('pelanggan_id',0)
                                                ->where('proyek_id',proyekId())->get();

    		return response()->json($data);
    	}
    }
    public function detail(Pelanggan $id){
        // dd($id->user);
        $dataKavling=kavling::where('pelanggan_id',$id->id)->first();
        // dd($dataKavling);
        $dataPembelian=pembelian::where('pelanggan_id',$id->id)->first();
        $persenDiskon = ($dataPembelian->diskon/$dataPembelian->harga)*100;
        /* tambahan model untuk cetak pelanggan */
        $dataDp = dp::where('pembelian_id',$dataPembelian->id)->get();
        $dataCicilan = cicilan::where('pembelian_id',$dataPembelian->id)->get();
        return view ('pelanggan/pelangganDetail',compact('id','dataKavling','dataPembelian','persenDiskon','dataDp','dataCicilan'));
    }
    public function simpanNomorAkad(Pembelian $id ,Request $request){
        
        $id->nomorAkad=$request->nomorAkad;
        $id->save();
        $pelangganId=$id->pelanggan_id;
    
        return redirect()->route('pelangganDetail',['id'=>$pelangganId])->with('status','Nomor Akad Tersimpan');
    }
    public function simpanTanggalAkad(Pembelian $id ,Request $request){
        
        $id->tanggalAkad=$request->tanggalAkad;
        $id->save();
        $pelangganId=$id->pelanggan_id;
    
        return redirect()->route('pelangganDetail',['id'=>$pelangganId])->with('status','Tanggal Akad Tersimpan');
    }
    public function dataDiri(){
        $idUser=auth()->user()->pelanggan->id;
        $id=pelanggan::find($idUser);
        $dataKavling=kavling::where('pelanggan_id',$idUser)->first();
        $dataPembelian=pembelian::where('pelanggan_id',$idUser)->first();
        // dd($dataPembelian);
        $persenDiskon = ($dataPembelian->diskon/$dataPembelian->harga)*100;
        return view('user/dataDiri',compact('dataKavling','dataPembelian','persenDiskon','id'));
    }
    public function pembelianPelanggan(){
        $idUser=auth()->user()->pelanggan->id;
        $id=pelanggan::find($idUser);
        $dataKavling=kavling::where('pelanggan_id',$idUser)->first();
        $dataPembelian=pembelian::where('pelanggan_id',$idUser)->first();
        // dd($dataPembelian);
        $persenDiskon = ($dataPembelian->diskon/$dataPembelian->harga)*100;
        return view('user/pembelianPelanggan',compact('dataKavling','dataPembelian','persenDiskon','id'));
    }
    public function DPPelanggan(){
        $idPelanggan=auth()->user()->pelanggan->id;
        $id=pembelian::where('pelanggan_id',$idPelanggan)->first();
        // dd($id->pembelian[0]->id);
        $daftarCicilanDp = dp::where('pembelian_id',$id->id)->paginate(20);
        // dd($daftarCicilanDp);
        $terbayar=dp::where('pembelian_id',$id->id)->get();
        if($terbayar != null){
            $info = $terbayar->last();
        }else{
            $info = null;
        }
        $cekTransferDp = transferDp::where('pembelian_id',$id->id)->first();
        return view ('user/DPPelanggan',compact('id','daftarCicilanDp','info','cekTransferDp'));
    }
    public function unitPelanggan(){
        $idPelanggan=auth()->user()->pelanggan->id;
        $id=pembelian::where('pelanggan_id',$idPelanggan)->first();
        $daftarCicilanUnit = cicilan::where('pembelian_id',$id->id)->paginate(20);
        $cicilanPerBulan = $id->sisaKewajiban/$id->tenor;
        $terbayar=cicilan::where('pembelian_id',$id->id)->get();
        if($terbayar != null){
            $info = $terbayar->last();
        }else{
            $info = null;
        }
        
        $cekTransferUnit = transferUnit::where('pembelian_id',$id->id)->first();
        // dd($cekTranferUnit);
        $totalTerbayar=$terbayar->sum('jumlah');
        return view('user/unitPelanggan',compact('id','daftarCicilanUnit','cicilanPerBulan','totalTerbayar','info','cekTransferUnit'));
    }
    public function transferUnit(){
        $idPelanggan=auth()->user()->pelanggan->id;
        $id=pembelian::where('pelanggan_id',$idPelanggan)->first();
        $cicilanPerBulan = $id->sisaKewajiban/$id->tenor;
        $rekening = rekening::where('proyek_id',proyekId())->get();
        $cekTransferUnit = transferUnit::where('pembelian_id',$id->id)->first();
        return view('user/unitTambah',compact('id','cicilanPerBulan','rekening','cekTransferUnit'));
    }
    public function transferDP(){
        $idPelanggan=auth()->user()->pelanggan->id;
        $id=pembelian::where('pelanggan_id',$idPelanggan)->first();
        $cicilanPerBulan = $id->sisaKewajiban/$id->tenor;
        $rekening = rekening::where('proyek_id',proyekId())->get();
        $cekTransferDp = transferDp::where('pembelian_id',$id->id)->first();
        return view('user/DPTambah',compact('id','cicilanPerBulan','rekening','cekTransferDp'));
    }
    public function transferCicilanSimpan(Request $request){
        // dd($request);
        $jumlah = str_replace(',', '', $request->jumlah);
        $idPelanggan=auth()->user()->pelanggan->id;
        $rules=[
            'tanggal'=>'required',
            'jumlah'=>'required',
            'rekening_id'=>'required',
            'namaPemilik'=>'required',
            'bukti'=>'file|mimes:pdf,jpg,jpeg,png'
        ];
        $costumMessages = [
            'required'=>':attribute tidak boleh kosong'
        ];
        $requestData = $request->all();
        if ($request->hasFile('bukti')) {
            $file_nama            = $request->file('bukti')->store('public/file/unit/bukti');
            $requestData['bukti'] = $file_nama;
        } else {
            unset($requestData['bukti']);
        }
        $requestData['jumlah']=$jumlah;
        $requestData['proyek_id']=proyekId();
        $requestData['pelanggan_id']=$idPelanggan;
        $this->validate($request,$rules,$costumMessages);
        transferUnit::create($requestData);
        return redirect()->route('unitPelanggan')->with('status','Terima kasih, pembayaran akan dicek oleh admin kami');
    }
    public function lihatTransferUnit(TransferUnit $id){
        // dd($id);
        $idPelanggan=auth()->user()->pelanggan->id;
        $pembelian=pembelian::where('pelanggan_id',$idPelanggan)->first();
        $rekening = rekening::where('proyek_id',proyekId())->get();
        return view('user/lihatTransferUnit',compact('id','rekening','pembelian'));
    }
    public function lihatTransferDp(TransferDp $id){
        // dd($id);
        $idPelanggan=auth()->user()->pelanggan->id;
        $pembelian=pembelian::where('pelanggan_id',$idPelanggan)->first();
        $rekening = rekening::where('proyek_id',proyekId())->get();
        return view('user/lihatTransferDp',compact('id','rekening','pembelian'));
    }
    public function transferCicilanUpdate(transferUnit $id,Request $request){
        // dd($request);
        $jumlah = str_replace(',', '', $request->jumlah);
        $idPelanggan=auth()->user()->pelanggan->id;
        $rules=[
            'tanggal'=>'required',
            'jumlah'=>'required',
            'rekening_id'=>'required',
            'namaPemilik'=>'required',
            'bukti'=>'file|mimes:pdf,jpg,jpeg,png'
        ];
        $costumMessages = [
            'required'=>':attribute tidak boleh kosong'
        ];
        $requestData = $request->all();
        if ($request->hasFile('bukti')) {
            $file_nama            = $request->file('bukti')->store('public/file/unit/bukti');
            $requestData['bukti'] = $file_nama;
        } else {
            unset($requestData['bukti']);
        }
        $requestData['jumlah']=$jumlah;
        $requestData['status']='diupdate';
        $requestData['proyek_id']=proyekId();
        $requestData['pelanggan_id']=$idPelanggan;
        $this->validate($request,$rules,$costumMessages);
        $id->update($requestData);
        return redirect()->route('unitPelanggan')->with('status','Terima kasih, pembayaran akan dicek kembali oleh admin kami');
    }
    public function transferDPUpdate(transferDp $id,Request $request){
        // dd($request);
        $jumlah = str_replace(',', '', $request->jumlah);
        $idPelanggan=auth()->user()->pelanggan->id;
        $rules=[
            'tanggal'=>'required',
            'jumlah'=>'required',
            'rekening_id'=>'required',
            'namaPemilik'=>'required',
            'bukti'=>'file|mimes:pdf,jpg,jpeg,png'
        ];
        $costumMessages = [
            'required'=>':attribute tidak boleh kosong'
        ];
        $requestData = $request->all();
        if ($request->hasFile('bukti')) {
            $file_nama            = $request->file('bukti')->store('public/file/unit/bukti');
            $requestData['bukti'] = $file_nama;
        } else {
            unset($requestData['bukti']);
        }
        $requestData['jumlah']=$jumlah;
        $requestData['status']='diupdate';
        $requestData['proyek_id']=proyekId();
        $requestData['pelanggan_id']=$idPelanggan;
        $this->validate($request,$rules,$costumMessages);
        $id->update($requestData);
        return redirect()->route('unitPelanggan')->with('status','Terima kasih, pembayaran akan dicek kembali oleh admin kami');
    }
    public function transferDPSimpan(Request $request){
        // dd($request);
        $jumlah = str_replace(',', '', $request->jumlah);
        $idPelanggan=auth()->user()->pelanggan->id;
        $rules=[
            'tanggal'=>'required',
            'jumlah'=>'required',
            'rekening_id'=>'required',
            'namaPemilik'=>'required',
            'bukti'=>'file|mimes:pdf,jpg,jpeg,png'
        ];
        $costumMessages = [
            'required'=>':attribute tidak boleh kosong'
        ];
        $requestData = $request->all();
        if ($request->hasFile('bukti')) {
            $file_nama            = $request->file('bukti')->store('public/file/dp/bukti');
            $requestData['bukti'] = $file_nama;
        } else {
            unset($requestData['bukti']);
        }
        $requestData['jumlah']=$jumlah;
        $requestData['proyek_id']=proyekId();
        $requestData['pelanggan_id']=$idPelanggan;
        $this->validate($request,$rules,$costumMessages);
        transferDp::create($requestData);
        return redirect()->route('DPPelanggan')->with('status','Terima kasih, pembayaran akan dicek oleh admin kami');
    }
}
