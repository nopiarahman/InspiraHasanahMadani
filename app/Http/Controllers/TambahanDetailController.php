<?php

namespace App\Http\Controllers;

use App\rekening;
use App\tambahan;
use App\transaksi;
use Carbon\Carbon;
use App\tambahanDetail;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TambahanDetailController extends Controller
{
    public function store(tambahan $id, Request $request)
    {
        // dd($request);
        DB::beginTransaction();
        $awal = Carbon::parse($request->tanggal)->firstOfMonth()->isoFormat('YYYY-MM-DD');
        $akhir = Carbon::parse($request->tanggal)->endOfMonth()->isoFormat('YYYY-MM-DD');
        $cekBulan = tambahanDetail::whereBetween('tanggal',[$awal,$akhir])->count();
        try {
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
            $this->validate($request,$rules,$costumMessages);
            $requestData = $request->all();
            $requestData['jumlah']=$jumlah;
            $requestData['tambahan_id']=$id->id;
            $requestData['proyek_id']=proyekId();
            $requestData['ke']=$cekBulan+1;
            tambahanDetail::create($requestData);
            
            $requestKasBesar = Arr::except($requestData,['jumlah']);
            // dd($requestTanpaJumlah);
            $requestKasBesar['kredit']=$jumlah;
            $requestKasBesar['kategori']='Tambahan';
            $requestKasBesar['sumber']=$sumber;
            $requestKasBesar['tambahan']=1;
            $requestKasBesar['uraian']= "Penerimaan Tambahan ".$id->keterangan." ".$id->pelanggan->pembelian->kavling->blok." a/n ". $id->pelanggan->nama;
            // dd($requestKasBesar);
            kasBesarMasuk($requestKasBesar);
            DB::commit();
            return redirect()->back()->with('status','Pembayaran Berhasil Ditambahkan');

        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->back()->with('error','Gagal. Pesan Error: '.$ex->getMessage());
        }
    }
    public function destroy(tambahanDetail $id)
    {
        DB::beginTransaction();
        try {
            $uraian = "Penerimaan Tambahan ".$id->tambahan->keterangan." ".$id->tambahan->pelanggan->pembelian->kavling->blok." a/n ". $id->tambahan->pelanggan->nama;
            $dari = Carbon::parse($id->created_at);
            $sampai = Carbon::parse($id->created_at)->addSeconds(240);
            $hapusKasBesar = transaksi::whereBetween('created_at',[$dari,$sampai])->where('tambahan',1)
                                        ->where('kredit',$id->jumlah)->where('uraian',$uraian)->first();
            
            $hapusKasBesar->delete();
            $id->delete();
            DB::commit();
            return redirect()->back()->with('status', 'Transaksi Berhasil dihapus');
        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->back()->with('error', 'Gagal. Pesan Error: ' . $ex->getMessage());
        }
    
    }
}
