<?php

namespace App\Http\Controllers;

use App\dp;
use App\transaksi;
use Carbon\Carbon;
use App\pembelian;

use Illuminate\Http\Request;

class DPController extends Controller
{

    public function DPKavling(){
        $semuaCicilanDp = pembelian::where('statusDp','Credit')->orderBy('kavling_id')->paginate(40);
        

        return view ('cicilanDP/kavling',compact('semuaCicilanDp'));
    }
    public function DPKavlingTambah(Pembelian $id){
        // dd($id);
        $daftarCicilanDp = dp::where('pembelian_id',$id->id)->get();
        // dd($daftarCicilanDp);
        return view ('cicilanDp/kavlingTambah',compact('id','daftarCicilanDp'));
    }
    public function DPKavlingSimpan(Request $request){
        $jumlah = str_replace(',', '', $request->jumlah);
        $rules=[
            'jumlah'=>'required',
            'tanggal'=>'required',
        ];
        $costumMessages = [
            'required'=>':attribute tidak boleh kosong'
        ];
        $id=$request->pembelian_id;
        /* Cek Akad DP */
        $cekDp=pembelian::find($id);
        $akadDp=$cekDp->dp;
        /* Jatuh Tempo */
        $tempo=Carbon::parse($request->tanggal)->addMonth(1)->isoFormat('YYYY-MM-DD');
        /* menghitung dp yang telah terbayar */
        $urut = dp::where('pembelian_id',$id)->orderBy('urut','desc')->first();
        if($urut != null){
            $urutan = $urut->urut;
        }else{
            $urutan=0;
        }
        /* Cek DP per bulan */
        $awal = Carbon::parse($request->tanggal)->firstOfMonth()->isoFormat('YYYY-MM-DD');
        $akhir = Carbon::parse($request->tanggal)->endOfMonth()->isoFormat('YYYY-MM-DD');
        $cekBulan = dp::whereBetween('tanggal',[$awal,$akhir])->count();

        $terbayar=dp::where('pembelian_id',$id)->get();
        $totalTerbayar=0;
        $terbayarSekarang=str_replace(',', '', $request->jumlah);
        // dd($terbayarSekarang);
        foreach($terbayar as $tb){
            $totalTerbayar = $totalTerbayar+$tb->jumlah;
        }
        // dd($cekDp->kavling->blok);
        $requestDp=[
            'pembelian_id'=>$request->pembelian_id,
            'urut'=>$urutan+1,
            'ke'=>$cekBulan+1,
            'tanggal'=>$request->tanggal,
            'jumlah'=>str_replace(',', '', $request->jumlah),
            'sisaDp'=>$akadDp-$totalTerbayar-$terbayarSekarang,
            'tempo'=>$tempo,
            'sumber'=>'Cash',
            'uraian'=>'Penerimaan Cicilan DP '.jenisKepemilikan($cekDp->pelanggan_id).' '.$cekDp->kavling->blok.' a/n '.$cekDp->pelanggan->nama,
        ];
        $this->validate($request,$rules,$costumMessages);

        /* parameter kasBesarMasuk ['tanggal','jumlah','sumber','uraian','no','saldo']*/
        dp::create($requestDp);
        // $requestData=$request->all();
        $requestData=$request->all();
        $requestData=[
            'urut'=>$urutan+1,
            'ke'=>$cekBulan+1,
            'tanggal'=>$request->tanggal,
            'sisaDp'=>$akadDp-$totalTerbayar-$terbayarSekarang,
            'tempo'=>$tempo,
            'sumber'=>'Cash',
            'uraian'=>'Penerimaan Cicilan DP '.jenisKepemilikan($cekDp->pelanggan_id).' '.$cekDp->kavling->blok.' a/n '.$cekDp->pelanggan->nama,
        ];
        $requestData['kredit']=str_replace(',', '', $request->jumlah);
        $requestData['proyek_id']=proyekId();
        /* cek apakah ada transaksi sebelumnya */
        $cekTransaksiSebelum=transaksi::where('tanggal','<=',$request->tanggal)->orderBy('no')->get();
        /* jika transaksi sebelumnya ada value */
        if($cekTransaksiSebelum != null){
            $sebelum = $cekTransaksiSebelum->last();
            $requestData['no']=$sebelum->no+1;
            $requestData['saldo']=$sebelum->saldo+$jumlah;
        }else{
            /* jika tidak ada value simpan ke akhir transaksi */
            $requestData['no']=noTransaksiTerakhir()+1;
            $requestData['saldo']=saldoTerakhir()+$jumlah;
        }
        /* cek transaksi sesudah input */
        $cekTransaksi=transaksi::where('tanggal','>',$request->tanggal)->orderBy('no')->get();
        // dd($requestData);
        if($cekTransaksi != null){
            /* jika ada, update transaksi sesudah sesuai perubahan input*/
            foreach($cekTransaksi as $updateTransaksi){
                $updateTransaksi['no'] = $updateTransaksi->no +1;
                $updateTransaksi['saldo'] = $updateTransaksi->saldo + $jumlah;
                $updateTransaksi->save();
            }
        }
        kasBesarMasuk($requestData);
        $update=pembelian::find($id)->update(['sisaDp'=>$akadDp-$totalTerbayar-$terbayarSekarang]);

        return redirect()->route('DPKavlingTambah',['id'=>$id])->with('status','Cicilan DP Berhasil ditambahkan');


        
    }

}
