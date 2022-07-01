<?php

namespace App\Http\Controllers;

use App\dp;
use App\history;
use App\rekening;
use App\pembelian;
use App\transaksi;
use Carbon\Carbon;
use App\transferDp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DPController extends Controller
{

    public function DPKavling(){
        $semuaCicilanDp = pembelian::where('statusDp','Credit')->where('proyek_id',proyekId())->orderBy('kavling_id')->get();
        // $transferDp = transferDp::where('proyek_id',proyekId())->get();
        
        return view ('cicilanDP/kavling',compact('semuaCicilanDp'));
    }
    public function DPKavlingTambah(Pembelian $id){
        // dd($id);
        if(auth()->user()->proyek_id != $id->proyek_id){
            return redirect()->route('pelangganIndex')->with('status',$id->pelanggan->nama .' adalah pelanggan '.$id->pelanggan->proyek->nama);
        }
        $daftarCicilanDp = dp::where('pembelian_id',$id->id)->orderBy('tanggal')->get();
        $rekening = rekening::where('proyek_id',proyekId())->get();
        // dd($rekening);
        $DpPertama = Dp::where('pembelian_id',$id->id)->first();
        $sampaiSekarang = dp::where('pembelian_id',$id->id)->get();
        // dd($sampaiSekarang);
        return view ('cicilanDP/kavlingTambah',compact('id','daftarCicilanDp','rekening','sampaiSekarang'));
    }
    public function DPKavlingSimpan(Request $request){
        // dd($request);
        DB::beginTransaction();
        try {
            //code...
            $jumlah = str_replace(',', '', $request->jumlah);
            $rekening=rekening::find($request->rekening_id);
            if($request->has('rekening_id')){
                $sumber = 'Transfer Ke '.$rekening->namaBank;
                $cekTransferUnit = transferDp::where('pembelian_id',$request->pembelian_id)->first();
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
            /* Cek Akad DP */
            $cekDp=pembelian::find($id);
            $akadDp=$cekDp->dp;
            /* Jatuh Tempo */
            $tempo=Carbon::parse($request->tanggal)->addMonth(1)->isoFormat('YYYY-MM-DD');
            
            $urut = dp::where('pembelian_id',$id)->where('tanggal','>=',$request->tanggal)->first();
            if($urut != null){
                $urutan = $urut->urut-1;
                // $urutan=0;
            }else{
                $urut = dp::where('pembelian_id',$id)->orderBy('urut','desc')->first();
                // dd($urut);
                if($urut != null){
                    $urutan = $urut->urut+1;
                }else{
                    $urutan=1;
                }
            }
            /* Cek DP per bulan */
            $awal = Carbon::parse($request->tanggal)->firstOfMonth()->isoFormat('YYYY-MM-DD');
            $akhir = Carbon::parse($request->tanggal)->endOfMonth()->isoFormat('YYYY-MM-DD');
            $cekBulan = dp::whereBetween('tanggal',[$awal,$akhir])->count();
            
            /* menghitung dp yang telah terbayar */
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
                'pelanggan_id'=>$request->pelanggan_id,
                'proyek_id'=>proyekId(),
                'urut'=>$urutan,
                'ke'=>$cekBulan+1,
                'tanggal'=>$request->tanggal,
                'jumlah'=>str_replace(',', '', $request->jumlah),
                'sisaDp'=>$akadDp-$totalTerbayar-$terbayarSekarang,
                'tempo'=>$tempo,
                'sumber'=>$sumber,
                'uraian'=>'Penerimaan Cicilan DP '.jenisKepemilikan($cekDp->pelanggan_id).' '.$cekDp->kavling->blok.' a/n '.$cekDp->pelanggan->nama,
            ];
            $this->validate($request,$rules,$costumMessages);
    
            dp::create($requestDp);
            $requestData=$request->all();
            $requestData=[
                'urut'=>$urutan,
                'ke'=>$cekBulan+1,
                'tanggal'=>$request->tanggal,
                'sisaDp'=>$akadDp-$totalTerbayar-$terbayarSekarang,
                'tempo'=>$tempo,
                'sumber'=>$sumber,
                'uraian'=>'Penerimaan Cicilan DP '.jenisKepemilikan($cekDp->pelanggan_id).' '.$cekDp->kavling->blok.' a/n '.$cekDp->pelanggan->nama,
            ];
            $requestData['kredit']=str_replace(',', '', $request->jumlah);
            $requestData['proyek_id']=proyekId();
            /* cek apakah ada transaksi sebelumnya */
            $cekTransaksiSebelum=transaksi::where('tanggal','<=',$request->tanggal)->where('tambahan',0)->orderBy('no')->where('proyek_id',proyekId())->get();
            /* jika transaksi sebelumnya ada value */
            // dd($cekTransaksiSebelum->first());
            if($cekTransaksiSebelum->first() != null){
                $sebelum = $cekTransaksiSebelum->last();
                $requestData['no']=$sebelum->no+1;
                $requestData['saldo']=$sebelum->saldo+$jumlah;
            }else{
                /* jika tidak ada value simpan ke awal transaksi */
                $requestData['no']=1;
                $requestData['saldo']=$jumlah;
            }
            /* cek transaksi sesudah input */
            $cekTransaksi=transaksi::where('tanggal','>',$request->tanggal)->where('tambahan',0)->orderBy('no')->where('proyek_id',proyekId())->get();
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
            // History
            historyAdd($requestData['uraian'],'penambahan',$jumlah);
            DB::commit();
            return redirect()->route('DPKavlingTambah',['id'=>$id])->with('status','Cicilan DP Berhasil ditambahkan');
    
        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->back()->with('error','Gagal. Pesan Error: '.$ex->getMessage());
        }
    }
    public function destroy(Dp $id){
        /* Cek Akad DP */
        DB::beginTransaction();
        try {
            // dd($id);
            $cekDp=pembelian::find($id->pembelian_id);
            // dd($cekDp->kavling->blok);
            $akadDp=$cekDp->dp;
            /* UPDATE KAS BESAR */
            /* hapus Kas besar */
            $uraian = 'Penerimaan Cicilan DP '.jenisKepemilikan($cekDp->pelanggan_id).' '.$cekDp->kavling->blok.' a/n '.$cekDp->pelanggan->nama;
            $dari = Carbon::parse($id->created_at);
            $sampai = Carbon::parse($id->created_at)->addSeconds(240);
            $hapusKasBesar = transaksi::whereBetween('created_at',[$dari,$sampai])
                                        ->where('kredit',$id->jumlah)->where('tambahan',0)->where('uraian',$uraian)->first();
            // dd($hapusKasBesar);
            /* cek transaksi sesudah input */
            $cekTransaksi=transaksi::where('tanggal','>=',$id->tanggal)->where('tambahan',0)->where('no','>',$hapusKasBesar->no)->orderBy('no')->get();
            // dd($cekTransaksi);
            $terbayar=dp::where('pembelian_id',$id->pembelian_id)->get();
            $totalTerbayar=$terbayar->sum('jumlah');
            if($cekTransaksi != null){
                /* jika ada, update transaksi sesudah sesuai perubahan input*/
                foreach($cekTransaksi as $updateTransaksi){
                    $updateTransaksi['no'] = $updateTransaksi->no -1;
                    $updateTransaksi['saldo'] = $updateTransaksi->saldo -$id->jumlah;
                    $updateTransaksi->save();
                }
            }
            $hapusKasBesar->delete();
            dp::destroy($id->id);
            $update=pembelian::find($id->pembelian_id)->update(['sisaDp'=>$akadDp-$totalTerbayar+$id->jumlah]);
            // History
            historyAdd($uraian,'hapus',$id->jumlah);
            DB::commit();
            return redirect()->back()->with('status','Transaksi DP berhasil dihapus');
        } catch (\Exception $ex) {
            DB::rollback();
            // dd($ex);
            return redirect()->back()->with('error','Gagal. Pesan Error: '.$ex->getMessage());
        }
        
    }
    public function cekTransferDPPelanggan(){
        $transfer = transferDp::where('proyek_id',proyekId())->paginate(40);
        return view('transfer/cekDp',compact('transfer'));
    }
    public function lihatTransferDPPelanggan(transferDp $id){
        // dd($id);
        $rekening = rekening::where('proyek_id',proyekId())->get();
        return view('transfer/lihatDP',compact('id','rekening'));
    }
    public function tolakTransferDP(transferDp $id, Request $request){
        // dd($id);
        $requestData= $request->all();
        $requestData['status']="review";
        $id->update($requestData);
        return redirect()->route('cekTransferDPPelanggan')->with('status','Transfer Ditolak');
    }

}
