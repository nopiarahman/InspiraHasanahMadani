<?php

namespace App\Http\Controllers;
use App\barang;
use App\pengadaan;
use App\isiPengadaan;
use App\akun;
use App\rabUnit;
use App\rab;
use App\transaksi;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PengadaanController extends Controller
{
    public function pengadaanIndex(Request $request){
        $semuaPengadaan=pengadaan::where('proyek_id',proyekId())->get();
        return view('pengadaan/pengadaanIndex',compact('semuaPengadaan'));
    }

    public function barangIndex(Request $request){
        $semuaBarang = barang::where('proyek_id',proyekId())->orderBy('namaBarang')->get();
        return view('pengadaan/barangIndex',compact('semuaBarang'));
    }
    public function barangSimpan(Request $request){
        // dd($request);
        $jumlah = str_replace(',', '', $request->harga);
        $rules=[
            'namaBarang'=>'required',
            'harga'=>'required',
        ];
        $costumMessages = [
            'required'=>':attribute tidak boleh kosong'
        ];
        $requestData = $request->all();
        $requestData['proyek_id']= proyekId();
        $requestData['harga']= $jumlah;
        $this->validate($request,$rules,$costumMessages);
        barang::create($requestData);
        return redirect()->back()->with('status','Barang berhasil ditambahkan');
    }
    public function pengadaanSimpan(Request $request){
        // dd($request);
        $jumlah = str_replace(',', '', $request->harga);
        $rules=[
            'tanggal'=>'required',
            'yangMengajukan'=>'required',
            'deskripsi'=>'required',
        ];
        $costumMessages = [
            'required'=>':attribute tidak boleh kosong'
        ];
        $requestData = $request->all();
        $requestData['proyek_id']= proyekId();
        $this->validate($request,$rules,$costumMessages);
        pengadaan::create($requestData);
        return redirect()->back()->with('status','Pengadaan berhasil ditambahkan');
    }
    public function hapusBarang(Barang $id){
        $id->delete();
        return redirect()->back()->with('status','Barang Berhasil dihapus');
    }
    public function editBarang(Barang $id, Request $request){
        $jumlah = str_replace(',', '', $request->harga);
        $rules=[
            'namaBarang'=>'required',
            'harga'=>'required',
        ];
        $costumMessages = [
            'required'=>':attribute tidak boleh kosong'
        ];
        $requestData = $request->all();
        $requestData['proyek_id']= proyekId();
        $requestData['harga']= $jumlah;
        $id->update($requestData);
        return redirect()->back()->with('status','Barang Berhasil diedit');
    }
    public function isiPengadaanIndex(Pengadaan $id){
        // dd($id);
        $semuaIsi = isiPengadaan::where('pengadaan_id',$id->id)->get();
        return view('pengadaan/isiPengadaanIndex',compact('id','semuaIsi'));
    }
    public function cariBarang(Request $request){
        if ($request->has('q')) {
    	    $cari = $request->q;
    		$data = barang::select('id', 'namaBarang','merek','satuan','harga')
                            ->where('namaBarang', 'LIKE', '%'.$cari.'%')
                            ->where('proyek_id',proyekId())->get();

    		return response()->json($data);
    	}
    }
    public function isiPengadaanSimpan(Request $request, Pengadaan $id){
        $barang = barang::find($request->barang_id);
        // dd($id);
        $rules=[
            'barang_id'=>'required',
            'jumlahBarang'=>'required|numeric',
            'keterangan'=>'required',
        ];
        $costumMessages = [
            'required'=>':attribute tidak boleh kosong',
            'numeric'=>':attribute hanya angka saja'
        ];
        $this->validate($request,$rules,$costumMessages);
        $requestData = $request->all();
        $requestData['proyek_id']= proyekId();
        $requestData['pengadaan_id']= $id->id;
        $requestData['barang_id']= $request->barang_id;
        $requestData['namaBarang']= $barang->namaBarang;
        $requestData['merek']= $barang->merek;
        $requestData['jumlahBarang']= $request->jumlahBarang;
        $requestData['satuan']= $barang->satuan;
        $requestData['harga']= $barang->harga;
        $requestData['totalHarga']= $barang->harga*$request->jumlahBarang;
        // dd($requestData);
        isiPengadaan::create($requestData);
        return redirect()->back()->with('status','Barang berhasil ditambahkan');
    }
    public function hapusIsiPengadaan(isiPengadaan $id){
        // dd($id);
        isiPengadaan::destroy($id->id);
        return redirect()->back()->with('status','Barang Berhasil dihapus');
    }
    public function terimaPengadaan(isiPengadaan $id){
        $id->update(['status'=>1]);
        pengadaan::find($id->pengadaan_id)->update(['status'=>1]);
        return redirect()->back()->with('status','Pengadaan barang diterima');
    }
    public function tolakPengadaan(isiPengadaan $id){
        $id->update(['status'=>2]);
        pengadaan::find($id->pengadaan_id)->update(['status'=>1]);
        return redirect()->back()->with('error','Pengadaan barang ditolak');
    }
    public function buatTransaksi(isiPengadaan $id, Request $request){
        /* RAB */
        // dd($id);
        $semuaRAB = rab::where('proyek_id',proyekId())->get()->groupBy(['header',function($item){
            return $item['judul'];
        }],$preserveKeys=true);
        $perHeader=$semuaRAB;
        $perJudul=$semuaRAB;

        /* Biaya Unit */
        $semuaRABUnit = rabUnit::where('proyek_id',proyekId())->get()->groupBy(['header',function($item){
            return $item['judul'];
        }],$preserveKeys=true);
        $perHeaderUnit=$semuaRABUnit;
        $perJudulUnit=$semuaRABUnit;

        /* Akun */
        $semuaAkun=akun::where('proyek_id',proyekId())->get();
        $kategoriAkun=akun::where('proyek_id',proyekId())->get()->groupBy('kategori');
        $perKategori = $kategoriAkun;
        
        if($request->get('filter')){
            $start = Carbon::parse($request->start)->isoFormat('YYYY-MM-DD');
            $end = Carbon::parse($request->end)->isoFormat('YYYY-MM-DD');
            $transaksiKeluar=transaksi::whereBetween('tanggal',[$start,$end])
                            ->whereNotNull('debet')->where('proyek_id',proyekId())->orderBy('no')->get();
        }else{
            $start = Carbon::now()->firstOfMonth()->isoFormat('YYYY-MM-DD');
            $end = Carbon::now()->endOfMonth()->isoFormat('YYYY-MM-DD');
            $transaksiKeluar=transaksi::whereBetween('tanggal',[$start,$end])
                            ->whereNotNull('debet')->where('proyek_id',proyekId())->orderBy('no')->get();
        }
        return view ('pengadaan/buatTransaksi',compact('id','semuaAkun','perKategori','kategoriAkun','transaksiKeluar','perHeader','semuaRAB','perJudul','perHeaderUnit','semuaRABUnit','perJudulUnit','start','end'));
    }
    public function hapusPengadaan(Pengadaan $id){
        $id->delete();
        return redirect()->back()->with('status','Pengadaan Berhasil dihapus');
    }
}
