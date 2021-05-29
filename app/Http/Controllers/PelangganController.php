<?php

namespace App\Http\Controllers;

use App\pelanggan;
use App\kavling;
use App\rumah;
use App\kios;
use App\akun;
use App\user;
use App\rab;
use App\rabUnit;
use App\pembelian;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $semuaPelanggan = pelanggan::where('proyek_id',proyekId())->paginate(20);
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
    public function store(Request $request)
    {
        // dd($request);
        // if(preg_match("/^[0-9,]+$/", $a)) 
        // $a = str_replace(',', '', $request->harga);
        // $co=parseInt($request->harga);
        $parts = explode("@",$request->email);
        $username = $parts[0];
        $password = Carbon::parse($request->tanggalLahir)->isoFormat('DDMMYY');
        dd($password);
        
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
        ]);$requestpelanggan->save();
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
            rumah::create($data);
            $cariRumah=rumah::where('kavling_id',$request->kavling_id)->first();
            $updatePembelian=pembelian::where('kavling_id',$request->kavling_id)->update(['rumah_id'=>$cariRumah->id]);
            /* update RAB unit */
            $cariKavling=kavling::find($request->kavling_id);
            $rabUnit=rabUnit::create([
                'proyek_id'=>proyekId(),
                'header'=>'BIAYA PRODUKSI RUMAH',
                'judul'=>'Biaya Produksi Rumah',
                'isi'=>$cariKavling->blok,
                'jenisUnit'=>'rumah',
                'hargaSatuan'=>hargaSatuanRumah(),
            ]);$rabUnit->save();
            /* update Akun */
            $akun=akun::create([
                'proyek_id'=>proyekId(),
                'jenis'=> 'Pembangunan',
                'kategori'=> 'Pembangunan Rumah',
                'kodeAkun'=> 'IH-30-'.$cariKavling->blok,
                'namaAkun'=> 'Biaya Pembangunan Rumah '.$cariKavling->blok,
            ]);$akun->save();
            $akunPembebanan=akun::create([
                'proyek_id'=>proyekId(),
                'jenis'=> 'Pembebanan',
                'kategori'=> 'Biaya Pembebanan Per-Unit',
                'kodeAkun'=> 'IH-31-'.$cariKavling->blok,
                'namaAkun'=> 'Biaya Pembebanan Per-Unit '.$cariKavling->blok,
            ]);$akunPembebanan->save();
        }elseif($request->includePembelian =='Kios'){
            $data ['kavling_id']=$request->kavling_id;
            $data ['pelanggan_id']=$cariPelanggan->id;
            $data ['luasBangunan']=$request->luasBangunan;
            kios::create($data);
            $cariKios=kios::where('kavling_id',$request->kavling_id)->first();
            $updatePembelian=pembelian::where('kavling_id',$request->kavling_id)->update(['kios_id'=>$cariKios->id]);
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
    public function update(Request $request, pelanggan $pelanggan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\pelanggan  $pelanggan
     * @return \Illuminate\Http\Response
     */
    public function destroy(pelanggan $pelanggan)
    {
        //
    }
    public function cariKavling(Request $request)
    {
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
        // dd($id);
        $dataKavling=kavling::where('pelanggan_id',$id->id)->first();
        $dataPembelian=pembelian::where('pelanggan_id',$id->id)->first();
        // dd($dataPembelian->pelanggan->nama);
        $persenDiskon = ($dataPembelian->diskon/$dataPembelian->harga)*100;
        // dd($persenDiskon);
        return view ('pelanggan/pelangganDetail',compact('id','dataKavling','dataPembelian','persenDiskon'));
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
