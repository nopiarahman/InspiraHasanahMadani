<?php

namespace App\Http\Controllers;

use App\pelanggan;
use App\kavling;
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
        $semuaPelanggan = pelanggan::where('proyek_id',proyekId())->orderBy('nama')->paginate(50);
        return view ('pelanggan/index',compact('semuaPelanggan'));
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
        /* Membuat Akun User */
        $parts = explode("@",$request->email);
        $username = $parts[0];
        $sandi = Carbon::parse($request->tanggalLahir)->isoFormat('DDMMYY');
        $requestUser ['proyek_id'] = proyekId();
        $requestUser ['name'] = $request->nama;
        $requestUser ['email'] = $request->email;
        $requestUser ['username'] = $username;
        $requestUser ['password'] = Hash::make($sandi);
        $requestUser ['role'] = 'pelanggan';
        User::create($requestUser);
        $cekUser = User::where('email',$request->email)->first();
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
            'nama'=>$request->nama,
            'email'=>$request->email,
            'tempatLahir'=>$request->tempatLahir,
            'tanggalLahir'=>$request->tanggalLahir,
            'alamat'=>$request->alamat,
            'jenisKelamin'=>$request->jenisKelamin,
            'statusPernikahan'=>$request->statusPernikahan,
            'pekerjaan'=>$request->pekerjaan,
            'nomorTelepon'=>$request->nomorTelepon,
            'proyek_id'=>proyekId(),
        ]);
        $requestpelanggan->save();
        $cariPelanggan=pelanggan::where('email',$request->email)->first(); 
        $requestPembelian = pembelian::create([
            'kavling_id'=>$request->kavling_id,
            'nomorAkad'=>$request->nomorAkad,
            'tanggalAkad'=>$request->tanggalAkad,
            'harga'=>str_replace(',', '', $request->harga),
            'diskon'=>str_replace(',', '', $request->totalDiskon),
            'dp'=>str_replace(',', '', $request->dp),
            'sisaKewajiban'=>str_replace(',', '', $request->sisaKewajiban),
            'sisaDp'=>$sisaDp,
            'sisaCicilan'=>$sisaCicilan,
            'tenor'=>$request->tenor,
            'statusDp'=>$request->statusDp,
            'statusCicilan'=>$request->statusCicilan,
            'proyek_id'=>proyekId(),
            'pelanggan_id'=>$cariPelanggan->id,
            'luasBangunan'=>$request->luasBangunan,
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
            $rabUnit=rabUnit::updateOrCreate(['isi'=>$cariKavling->blok],[
                'proyek_id'=>proyekId(),
                'header'=>'BIAYA PRODUKSI RUMAH',
                'judul'=>'Biaya Produksi Rumah',
                'isi'=>$cariKavling->blok,
                'jenisUnit'=>'rumah',
                'hargaSatuan'=>hargaSatuanRumah(),
            ]);
            /* update Akun */
            $akun=akun::updateOrCreate(['kodeAkun'=> 'IH-30-'.$cariKavling->blok],[
                'proyek_id'=>proyekId(),
                'jenis'=> 'Pembangunan',
                'kategori'=> 'Pembangunan Rumah',
                'kodeAkun'=> 'IH-30-'.$cariKavling->blok,
                'namaAkun'=> 'Biaya Pembangunan Rumah '.$cariKavling->blok,
            ]);
            $akunPembebanan=akun::updateOrCreate(['kodeAkun'=> 'IH-31-'.$cariKavling->blok],[
                'proyek_id'=>proyekId(),
                'jenis'=> 'Pembebanan',
                'kategori'=> 'Biaya Pembebanan Per-Unit',
                'kodeAkun'=> 'IH-31-'.$cariKavling->blok,
                'namaAkun'=> 'Biaya Pembebanan Per-Unit '.$cariKavling->blok,
            ]);
        }elseif($request->includePembelian =='Kios'){
            $data ['kavling_id']=$request->kavling_id;
            $data ['pelanggan_id']=$cariPelanggan->id;
            $data ['luasBangunan']=$request->luasBangunan;
            kios::updateOrCreate(['kavling_id'=>$request->kavling_id],($data));
            $cariKios=kios::where('kavling_id',$request->kavling_id)->first();
            $updatePembelian=pembelian::where('kavling_id',$request->kavling_id)->update(['kios_id'=>$cariKios->id]);
            /* update RAB unit */
            $cariKavling=kavling::find($request->kavling_id);
            $rabUnit=rabUnit::updateOrCreate(['isi'=>$cariKavling->blok],[
                'proyek_id'=>proyekId(),
                'header'=>'BIAYA PRODUKSI RUMAH',
                'judul'=>'Biaya Produksi Rumah',
                'isi'=>$cariKavling->blok,
                'jenisUnit'=>'kios',
                'hargaSatuan'=>hargaSatuanRumah(),
            ]);
            /* update Akun */
            $akun=akun::updateOrCreate(['kodeAkun'=> 'IH-30-'.$cariKavling->blok,],[
                'proyek_id'=>proyekId(),
                'jenis'=> 'Pembangunan',
                'kategori'=> 'Pembangunan Rumah',
                'kodeAkun'=> 'IH-30-'.$cariKavling->blok,
                'namaAkun'=> 'Biaya Pembangunan Kios '.$cariKavling->blok,
            ]);
            $akunPembebanan=akun::updateOrCreate(['kodeAkun'=> 'IH-31-'.$cariKavling->blok,],[
                'proyek_id'=>proyekId(),
                'jenis'=> 'Pembebanan',
                'kategori'=> 'Biaya Pembebanan Per-Unit',
                'kodeAkun'=> 'IH-31-'.$cariKavling->blok,
                'namaAkun'=> 'Biaya Pembebanan Per-Unit '.$cariKavling->blok,
            ]);
        }
        
        /* update data kavling*/
        $updateKavling=kavling::find($request->kavling_id)->update(['pelanggan_id'=>$cariPelanggan->id]);
        return redirect()->route('pelangganIndex')->with('status','Data Pelanggan Berhasil ditambahkan');
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
            'tempatLahir'=>'required',
            'tanggalLahir'=>'required',
            'nomorTelepon'=>'required',
        ];
        $costumMessages = [
            'required'=>':attribute tidak boleh kosong'
        ];
        $requestpelanggan = ([
            'nama'=>$request->nama,
            'email'=>$request->email,
            'tempatLahir'=>$request->tempatLahir,
            'tanggalLahir'=>$request->tanggalLahir,
            'alamat'=>$request->alamat,
            'jenisKelamin'=>$request->jenisKelamin,
            'statusPernikahan'=>$request->statusPernikahan,
            'pekerjaan'=>$request->pekerjaan,
            'nomorTelepon'=>$request->nomorTelepon,
            'proyek_id'=>proyekId(),
        ]);
        $this->validate($request,$rules,$costumMessages);
        $id->update($requestpelanggan);
        // $requestpelanggan->save();
        return redirect()->back()->with('status','Pelanggan berhasil dirubah');
    }
    public function updateUnit(Pelanggan $id, Request $request){
        $cekPembelian=$id->pembelian->first();
        $cekRumah=$cekPembelian->rumah;
        $cekKios=$cekPembelian->kios;
        $cekKavling=$id->kavling;
        // dd($id);
        // dd($cekRumah);
        // dd($cekRumah->kavling->blok);
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
            'kavling_id'=>'required',
            'harga'=>'required',
            'dp'=>'required',
            'tenor'=>'required',
        ];
        $costumMessages = [
            'required'=>':attribute tidak boleh kosong'
        ];
        $this->validate($request,$rules,$costumMessages);
        // dd($request);
        $requestPembelian = ([
            'kavling_id'=>$request->kavling_id,
            'nomorAkad'=>$request->nomorAkad,
            'tanggalAkad'=>$request->tanggalAkad,
            'harga'=>str_replace(',', '', $request->harga),
            'diskon'=>str_replace(',', '', $request->totalDiskon),
            'dp'=>str_replace(',', '', $request->dp),
            'sisaKewajiban'=>str_replace(',', '', $request->sisaKewajiban),
            'sisaDp'=>$sisaDp,
            'sisaCicilan'=>$sisaCicilan,
            'tenor'=>$request->tenor,
            'statusDp'=>$request->statusDp,
            'statusCicilan'=>$request->statusCicilan,
            'proyek_id'=>proyekId(),
            'pelanggan_id'=>$id->id,
            'luasBangunan'=>$request->luasBangunan,
        ]);
        /* update pembelian dibawah */
        $cekPembelian->update($requestPembelian);
        /* simpan data Rumah dan Kios*/
        if($request->includePembelian =='Rumah'){
            /* cek dan rubah jika pembelian sebelumnya adalah kios */
            if($cekKios != null){
                /* dihapus dulu kepemilikan kios */
                $updatePembelian = pembelian::find($cekPembelian->id)->update(['kios_id'=>null]);
                /* buat rumah baru di kavling terpilih */
                $data ['kavling_id']=$request->kavling_id;
                $data ['proyek_id']=proyekId();
                $data ['pelanggan_id']=$id->id;
                $data ['luasBangunan']=$request->luasBangunan;
                rumah::create($data);
                /* hapus kios */
                kios::where('pelanggan_id',$id->id)->delete();
            }
            /* update data rumah dari rumah sebelumnya */
            $updateRumah = rumah::where('kavling_id',$request->kavling_id)->update(['luasBangunan'=>$request->luasBangunan,'kavling_id'=>$request->kavling_id]);
            /* update pembelian */
            $cekRumahKavlingSebelum = rumah::where('kavling_id',$request->kavling_id)->first();
            // dd($cariRumah);
            if($cekRumahKavlingSebelum == null){
                $data ['kavling_id']=$request->kavling_id;
                $data ['proyek_id']=proyekId();
                $data ['pelanggan_id']=$id->id;
                $data ['luasBangunan']=$request->luasBangunan;
                rumah::create($data);
            }
            if($cekRumah !=null){
                $updateRumahPelangganSebelum = rumah::where('kavling_id',$cekKavling->id)->delete();
            }
            $cariRumah = rumah::where('kavling_id',$request->kavling_id)->first();
            $updatePembelian=pembelian::where('kavling_id',$request->kavling_id)->update(['rumah_id'=>$cariRumah->id]);
            /* update RAB unit */
            $cariKavling=kavling::find($request->kavling_id);
            if($cekKios != null){
                $cariruRabUnit = rabUnit::where('isi',$cekKavling->blok)->update(['isi'=>$cariKavling->blok,'jenisUnit'=>'rumah']);
            }else{
                $cariruRabUnit = rabUnit::where('isi',$cekKavling->blok)->update(['isi'=>$cariKavling->blok]);
            }
            /* update Akun */
            $updateAkun= akun::where('kodeAkun','IH-30-'.$cekKavling->blok)->update(['kodeAkun'=>'IH-30-'.$cariKavling->blok,'namaAkun'=>'Biaya Pembangunan Rumah '.$cariKavling->blok]);
            $updateAkun= akun::where('kodeAkun','IH-31-'.$cekKavling->blok)->update(['kodeAkun'=>'IH-31-'.$cariKavling->blok,'namaAkun'=>'Biaya Pembebanan Per-Unit '.$cariKavling->blok]);
            /* update kavling */
            $updateKepemilikanKavling=kavling::find($cekKavling->id)->update(['pelanggan_id'=>0]);
            $updateKavling = kavling::find($cariKavling->id)->update(['pelanggan_id'=>$id->id]);
        }elseif($request->includePembelian =='Kios'){
            // dd($cekRumah);
            if($cekRumah != null){
                /* dihapus dulu kepemilikan kios */
                $updatePembelian = pembelian::find($cekPembelian->id)->update(['rumah_id'=>null]);
                /* buat rumah baru di kavling terpilih */
                $data ['kavling_id']=$request->kavling_id;
                $data ['proyek_id']=proyekId();
                $data ['pelanggan_id']=$id->id;
                $data ['luasBangunan']=$request->luasBangunan;
                kios::create($data);
                /* hapus kios */
                rumah::where('pelanggan_id',$id->id)->delete();
            }
            /* cek dan rubah jika pembelian sebelumnya adalah kios */
            if($cekRumah != null){
                /* dihapus dulu kepemilikan rumah */
                $updatePembelian = pembelian::find($cekPembelian->id)->update(['rumah_id'=>null]);
            }
            /* update data kios dari kios sebelumnya */
            $updateKios = kios::where('kavling_id',$request->kavling_id)->update(['luasBangunan'=>$request->luasBangunan,'kavling_id'=>$request->kavling_id]);
            /* update data pembelian */
            $cekKiosKavlingSebelum = kios::where('kavling_id',$request->kavling_id)->first();
            // dd($cariRumah);
            if($cekKiosKavlingSebelum == null){
                $data ['kavling_id']=$request->kavling_id;
                $data ['proyek_id']=proyekId();
                $data ['pelanggan_id']=$id->id;
                $data ['luasBangunan']=$request->luasBangunan;
                kios::create($data);
            }
            if($cekKios !=null){
                $updateKiosPelangganSebelum = kios::where('kavling_id',$cekKavling->id)->delete();
            }
            $cariKios=kios::where('kavling_id',$request->kavling_id)->first();
            $updatePembelian=pembelian::where('kavling_id',$request->kavling_id)->update(['kios_id'=>$cariKios->id]);
            /* update RAB unit */
            $cariKavling=kavling::find($request->kavling_id);
            if($cekRumah != null){
                $cariruRabUnit = rabUnit::where('isi',$cekKavling->blok)->update(['isi'=>$cariKavling->blok,'jenisUnit'=>'kios']);
            }else{
                $cariruRabUnit = rabUnit::where('isi',$cekKavling->blok)->update(['isi'=>$cariKavling->blok]);
            }
            /* update Akun */
            $updateAkun= akun::where('kodeAkun','IH-30-'.$cekKavling->blok)->update(['kodeAkun'=>'IH-30-'.$cariKavling->blok,'namaAkun'=>'Biaya Pembangunan Kios '.$cariKavling->blok]);
            $updateAkun= akun::where('kodeAkun','IH-31-'.$cekKavling->blok)->update(['kodeAkun'=>'IH-31-'.$cariKavling->blok,'namaAkun'=>'Biaya Pembebanan Per-Unit '.$cariKavling->blok]);
            /* update kavling */
            $updateKepemilikanKavling=kavling::find($cekKavling->id)->update(['pelanggan_id'=>0]);
            $updateKavling = kavling::find($cariKavling->id)->update(['pelanggan_id'=>$id->id]);
        }
        return redirect()->back()->with('startus','Data Unit Pelanggan berhasil diedit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\pelanggan  $pelanggan
     * @return \Illuminate\Http\Response
     */
    public function destroy(pelanggan $id)
    {
        $pelanggan = pelanggan::find($id->id);
        $cekKavling = kavling::where('pelanggan_id',$id->id)->first();
        if($cekKavling!=null){
            $updateKavling = kavling::find($id->kavling->id)->update(['pelanggan_id'=>0]);
            if($id->rumah != null){
                $updateRumah = rumah::find($id->rumah->id)->update(['pelanggan_id'=>0]);
            }
            if($id->kios != null){
                $updateKios = kios::find($id->kios->id)->update(['pelanggan_id'=>0]);
            }
        }
        $pelanggan->delete();
        return redirect()->back()->with('status','Pelanggan Dihapus!');
    }
    public function batalAkad(Pelanggan $id){
        // dd($id->kavling->id);
        $updateKavling = kavling::find($id->kavling->id)->update(['pelanggan_id'=>0]);
        if($id->rumah != null){
            $updateRumah = rumah::find($id->rumah->id)->update(['pelanggan_id'=>0]);
        }
        if($id->kios != null){
            $updateKios = kios::find($id->kios->id)->update(['pelanggan_id'=>0]);
        }
        return redirect()->back()->with('status','Akad Dibatalkan!');
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
}
