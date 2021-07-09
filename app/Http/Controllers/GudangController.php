<?php

namespace App\Http\Controllers;
use App\transaksi;
use App\akun;
use App\rab;
use App\rabUnit;
use App\gudang;
use App\alokasiGudang;
use Illuminate\Http\Request;

class GudangController extends Controller
{
    public function index(){
        $daftarGudang = gudang::where('proyek_id',proyekId())->get();
        return view('gudang/gudangIndex',compact('daftarGudang'));
    }
    public function transferGudang(Transaksi $id, Request $request){
        $cekAkun= akun::find($request->akun_id);
        // dd($cekAkun);
        $sisa = $request->banyaknya - $request->terpakai;
        $requestData = $request->all();
        $requestData['proyek_id']=proyekId();
        $requestData['sisa']=$sisa;
        $requestData['tanggalPembelian']=$request->tanggal;
        $requestData['jenisBarang']=$request->uraian;
        $requestData['harga']=str_replace(',', '', $request->harga);
        $requestData['total']=str_replace(',', '', $request->total);
        // dd($requestData);
        gudang::create($requestData);
        return redirect()->route('transaksiKeluar')->with('statusGudang','Data Transaksi '.$request->uraian.' berhasil ditransfer ke Gudang');
    }
    public function alokasiGudang(Gudang $id, Request $request){

        // dd($request);
        $requestData = $request->all();
        $requestData['sisa']=$request->sisaSebelumnya-$request->jumlahAlokasi;
        $requestData['alokasi']=$request->keterangan;

        $id->update($requestData);
        return redirect()->back()->with('status','Alokasi gudang berhasil disimpan');
    }
    public function alokasi(Gudang $id){
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
        /* Data Gudang */

        return view('gudang/alokasiIndex',compact('id','semuaAkun','perKategori','kategoriAkun','perHeader','semuaRAB','perJudul','perHeaderUnit','semuaRABUnit','perJudulUnit'));
    }
    public function alokasiSimpan(Request $request){
        // dd($request);
        $jumlah = str_replace(',', '', $request->total);
        $hargaSatuan = str_replace(',', '', $request->hargaSatuan);
        $rules=[
            'jumlah'=>'required',
            'tanggal'=>'required',
            'uraian'=>'required',
        ];
        $costumMessages = [
            'required'=>':attribute tidak boleh kosong'
        ];
        $this->validate($request,$rules,$costumMessages);
        $requestData=$request->all();
        $requestData['hargaSatuan']=$hargaSatuan;
        $requestData['debet']=$jumlah;
        $requestData['gudang_id']=$request->gudang_id;
        $requestData['proyek_id']=proyekId();
        $requestData['sumber']="Gudang";
        alokasiGudang::create($requestData);
        
        $gudang=gudang::find($request->gudang_id);
        $updateStok = $gudang->sisa - $request->jumlah;
        $gudang->update(['sisa'=>$updateStok]);

        /* insert Data ke kas besar */
        /* cek apakah ada transaksi sebelumnya */
        $cekTransaksiSebelum=transaksi::where('tanggal','<=',$request->tanggal)->orderBy('no')->where('proyek_id',proyekId())->get();
        /* jika transaksi sebelumnya ada value */
        $requestKasBesar = $request->all();
        $requestKasBesar['sumber'] = "Gudang";
        if($cekTransaksiSebelum != null){
            $sebelum = $cekTransaksiSebelum->last();
            $requestKasBesar['no']=$sebelum->no+1;
            $requestKasBesar['saldo']=$sebelum->saldo-$jumlah;
        }else{
            /* jika tidak ada value simpan ke akhir transaksi */
            $requestKasBesar['no']=1;
            $requestKasBesar['saldo']=$jumlah;
        }
        // dd($requestKasBesar);
        $cekTransaksi=transaksi::where('tanggal','>',$request->tanggal)->orderBy('no')->where('proyek_id',proyekId())->get();
            if($cekTransaksi != null){
                /* jika ada, update transaksi sesudah sesuai perubahan input*/
                foreach($cekTransaksi as $updateTransaksi){
                    $updateTransaksi['no'] = $updateTransaksi->no +1;
                    $updateTransaksi['saldo'] = $updateTransaksi->saldo - $jumlah;
                    $updateTransaksi->save();
                }
            }
        kasBesarKeluar($requestKasBesar);
        /* split transaksi sebelumnya */
        $transaksi = transaksi::find($gudang->transaksi_id);
        // dd($transaksi);
        if($transaksi != null){
            $transaksi->update([
                'jumlah'=>$transaksi->jumlah - $request->jumlah,
                'debet'=>$transaksi->debet - $jumlah,
            ]);
            /* update saldo */
            $cekTransaksiSaldo = transaksi::where('no','>=',$transaksi->no)->orderBy('no')->where('proyek_id',proyekId())->get();
            if($cekTransaksiSaldo != null){
                /* jika ada, update transaksi sesudah sesuai perubahan input*/
                foreach($cekTransaksiSaldo as $updateTransaksi){
                    $updateTransaksi['saldo'] = $updateTransaksi->saldo - $jumlah;
                    $updateTransaksi->save();
                }
            }
        }
        return redirect()->back()->with('status','Alokasi Berhasil Disimpan');
    }
}
