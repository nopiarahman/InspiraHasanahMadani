<?php

namespace App\Http\Controllers;

use App\cicilan;
use Carbon\Carbon;
use App\pembelian;
use App\rekening;
use App\transferUnit;
use App\transaksi;
use Illuminate\Http\Request;
class CicilanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function cicilanRumah()
    {
        return view ('cicilanUnit/rumah');
    }
    
    public function cicilanKavling()
    {
        $semuaCicilanUnit = pembelian::where('statusCicilan','Credit')->where('proyek_id',proyekId())->orderBy('kavling_id')->get();
        $transferUnit = transferUnit::where('proyek_id',proyekId())->get();
        return view ('cicilanUnit/kavling',compact('semuaCicilanUnit','transferUnit'));
    }
    public function unitKavlingDetail(Pembelian $id){
        $daftarCicilanUnit = cicilan::where('pembelian_id',$id->id)->get();
        
        $cicilanPerBulan = $id->sisaKewajiban/$id->tenor;
        $terbayar=cicilan::where('pembelian_id',$id->id)->get();
        $totalTerbayar=0;
        foreach($terbayar as $tb){
            $totalTerbayar = $totalTerbayar+$tb->jumlah;
        }
        $rekening = rekening::where('proyek_id',proyekId())->get();
        // dd($id);

        return view('cicilanUnit/kavlingTambah',compact('id','daftarCicilanUnit','cicilanPerBulan','totalTerbayar','rekening'));
    }
    public function cicilanKavlingSimpan(Request $request){
        // dd($request);
        
        $jumlah = str_replace(',', '', $request->jumlah);
        $rekening=rekening::find($request->rekening_id);
        if($request->has('rekening_id')){
            $sumber = 'Transfer Ke '.$rekening->namaBank;
            $cekTransferUnit = transferUnit::where('pembelian_id',$request->pembelian_id)->first();
            $cekTransferUnit->delete();
        }elseif($request->metode == 'transfer'){
            $rekening=rekening::find($request->rekening);
            $sumber = 'Transfer Ke '.$rekening->namaBank;
        }else{
            $sumber = 'Cash';
        }
        $rules=[
            'jumlah'=>'required',
            'tanggal'=>'required',
        ];
        $costumMessages = [
            'required'=>':attribute tidak boleh kosong'
        ];
        $id=$request->pembelian_id;
        $cekCicilan=pembelian::find($id);
        $cicilan=$cekCicilan->sisaKewajiban;
        /* Jatuh Tempo */
        $totalBulan = ($cekCicilan->sisaKewajiban-$cekCicilan->sisaCicilan)/($cekCicilan->sisaKewajiban/$cekCicilan->tenor);
        $tambahBulan = str_replace(',', '', $request->jumlah)/($cekCicilan->sisaKewajiban/$cekCicilan->tenor);
        $tenorBulan = round($totalBulan+$tambahBulan,0);
        $cicilanPertama = cicilan::where('pembelian_id',$cekCicilan->id)->first();
        /* cek performa pembayaran */
        $cekCicilanlagi = cicilan::where('pembelian_id',$request->pembelian_id)->get();
        // dd($cekCicilanlagi);
        if($cekCicilanlagi->last()){
            $cicilanTerakhir=$cekCicilanlagi->last();
            $tempoTerakhir=Carbon::parse($cicilanTerakhir->tempo)->firstOfMonth();
        }else{
            $tempoTerakhir = Carbon::parse($request->tanggal)->firstOfMonth();
        }
        $tanggalPembayaran=Carbon::parse($request->tanggal)->firstOfMonth();
        $cek=$tanggalPembayaran->diffInMonths($tempoTerakhir,false);
        if($cek>0){
            $status = "lancar";
        }else{
            $status = "nunggak";
        }
        if($cicilanPertama != null){
            /* cicilan selanjutnya */
            if($status == 'lancar'){
                $tempo=Carbon::parse($cicilanPertama->tanggal)->addMonth($tenorBulan)->isoFormat('YYYY-MM-DD');
            }elseif($status=='nunggak'){
                $tempo=Carbon::parse($request->tanggal)->addMonth(1)->isoFormat('YYYY-MM-DD');
            }
        }else{
            /* cicilan pertama */
            $tempo=Carbon::parse($request->tanggal)->addMonth($tenorBulan)->isoFormat('YYYY-MM-DD');
        }
        /* menghitung cicilan yang telah terbayar */
        $awal = Carbon::parse($request->tanggal)->firstOfMonth()->isoFormat('YYYY-MM-DD');
        $akhir = Carbon::parse($request->tanggal)->endOfMonth()->isoFormat('YYYY-MM-DD');
        $cekBulan = cicilan::whereBetween('tanggal',[$awal,$akhir])->count();
        $urut = cicilan::where('pembelian_id',$id)->orderBy('urut','desc')->first();
        if($urut != null){
            $urutan = $urut->urut;
        }else{
            $urutan=0;
        }
        $terbayar=cicilan::where('pembelian_id',$id)->get();
        $totalTerbayar=0;
        $terbayarSekarang=str_replace(',', '', $request->jumlah);
        foreach($terbayar as $tb){
            $totalTerbayar = $totalTerbayar+$tb->jumlah;
        }
        $requestCicilan=[
            'pembelian_id'=>$request->pembelian_id,
            'pelanggan_id'=>$request->pelanggan_id,
            'urut'=>$urutan+1,
            'ke'=>$cekBulan+1,
            'tanggal'=>$request->tanggal,
            'jumlah'=>str_replace(',', '', $request->jumlah),
            'sisaKewajiban'=>$cicilan-$totalTerbayar-$terbayarSekarang,
            'tempo'=>$tempo,
            'sumber'=>$sumber,
            'proyek_id'=>proyekId(),
            'uraian'=>'Penerimaan Cicilan Unit '.jenisKepemilikan($cekCicilan->pelanggan_id).' '.$cekCicilan->kavling->blok.' a/n '.$cekCicilan->pelanggan->nama,
        ];
        $this->validate($request,$rules,$costumMessages);
        cicilan::create($requestCicilan);
        $requestData=$request->all();
        $requestData=[
            'pembelian_id'=>$request->pembelian_id,
            'urut'=>$urutan+1,
            'ke'=>$cekBulan+1,
            'tanggal'=>$request->tanggal,
            'sisaKewajiban'=>$cicilan-$totalTerbayar-$terbayarSekarang,
            'tempo'=>$tempo,
            'sumber'=>$sumber,
            'uraian'=>'Penerimaan Cicilan Unit '.jenisKepemilikan($cekCicilan->pelanggan_id).' '.$cekCicilan->kavling->blok.' a/n '.$cekCicilan->pelanggan->nama,
        ];
        $requestData['kredit']=str_replace(',', '', $request->jumlah);
        $requestData['proyek_id']=proyekId();
        /* cek apakah ada transaksi sebelumnya */
        $cekTransaksiSebelum=transaksi::where('tanggal','<=',$request->tanggal)->orderBy('no')->where('proyek_id',proyekId())->get();
        /* jika transaksi sebelumnya ada value */
        if($cekTransaksiSebelum != null){
            $sebelum = $cekTransaksiSebelum->last();
            $requestData['no']=$sebelum->no+1;
            $requestData['saldo']=$sebelum->saldo+$jumlah;
        }else{
            /* jika tidak ada value simpan ke awal transaksi */
            $requestData['no']=1;
            $requestData['saldo']=$jumlah;
        }
        /* cek transaksi sesudah input */
        $cekTransaksi=transaksi::where('tanggal','>',$request->tanggal)->orderBy('no')->where('proyek_id',proyekId())->get();
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
        $update=pembelian::find($id)->update(['sisaCicilan'=>$cicilan-$totalTerbayar-$terbayarSekarang]);
        $daftarCicilanUnit = cicilan::where('pembelian_id',$id)->get();
        $cicilanPerBulan = $cekCicilan->sisaKewajiban/$cekCicilan->tenor;
        return redirect()->route('unitKavlingDetail',['id'=>$id,'daftarCicilanUnit'=>$daftarCicilanUnit,'cicilanPerBulan'=>$cicilanPerBulan])
                ->with('status','Cicilan Unit Berhasil Ditambahkan');
    }
    public function cicilanKios()
    {
        return view ('cicilanUnit/kios');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\cicilan  $cicilan
     * @return \Illuminate\Http\Response
     */
    public function destroy(cicilan $id)
    {
        // dd($id);
        $cekCicilan=pembelian::find($id->pembelian_id);
        $cicilan=$cekCicilan->sisaKewajiban;
        /* UPDATE KAS BESAR */
        /* hapus Kas besar */
        $dari = Carbon::parse($id->created_at)->subSeconds(5);
        $sampai = Carbon::parse($id->created_at)->addSeconds(5);
        $hapusKasBesar = transaksi::whereBetween('created_at',[$dari,$sampai])
                                    ->where('kredit',$id->jumlah)->where('tanggal',$id->tanggal)->first();
        // dd($hapusKasBesar);
        $terbayar=cicilan::where('pembelian_id',$id->pembelian_id)->get();
        $totalTerbayar = $terbayar->sum('jumlah');
        /* cek transaksi sesudah input */
        $cekTransaksi=transaksi::where('tanggal','>=',$id->tanggal)->where('no','>',$hapusKasBesar->no)->orderBy('no')->get();
        if($cekTransaksi != null){
            /* jika ada, update transaksi sesudah sesuai perubahan input*/
            foreach($cekTransaksi as $updateTransaksi){
                $updateTransaksi['no'] = $updateTransaksi->no -1;
                $updateTransaksi['saldo'] = $updateTransaksi->saldo -$id->jumlah;
                $updateTransaksi->save();
            }
        }
        $hapusKasBesar->delete();
        $id->delete();
        /* update data pembelian pelanggan */
        $update=pembelian::find($id->pembelian_id)->update(['sisaCicilan'=>$cicilan-$totalTerbayar+$id->jumlah]);

        return redirect()->back()->with('status','Transaksi cicilan berhasil dihapus');
    }
    public function cekTransferUnitPelanggan(){
        $transfer = transferUnit::where('proyek_id',proyekId())->paginate(40);
        return view('transfer/cekUnit',compact('transfer'));
    }
    public function lihatTransferPelanggan(transferUnit $id){
        
        $rekening = rekening::where('proyek_id',proyekId())->get();
        return view('transfer/lihat',compact('id','rekening'));
    }
    public function tolakTransfer(transferUnit $id, Request $request){
        // dd($id);
        $requestData= $request->all();
        $requestData['status']="review";
        $id->update($requestData);
        return redirect()->route('cekTransferUnitPelanggan')->with('status','Transfer Ditolak');
    }
}
