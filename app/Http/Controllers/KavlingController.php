<?php

namespace App\Http\Controllers;

use App\kavling;
use App\pembelian;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class KavlingController extends Controller
{
    public function index (){
        $semuaKavling = kavling::where('proyek_id',proyekId())->orderBy('b')->orderBy('nr')->get()->groupBy('b');
        $perBlok = $semuaKavling;
        return view ('proyek/DataProyek/kavlingIndex',compact('semuaKavling','perBlok'));
    }

    public function kavlingSimpan(Request $request){
        // dd($request->blok);
        $nomorRumah = preg_match_all('!\d+!',$request->blok,$matchesRumah); /* extract int from string */
        $nr = implode('',$matchesRumah[0]); /* imploae array ke single value */
        $nomorRumah = preg_match_all('![a-zA-Z]+!',$request->blok,$matchesBlok);
        $b = implode('',$matchesBlok[0]); 
        // dd($b);
        /* Pilih semua kavling */
        $semuaKavling = kavling::where('proyek_id',proyekId())->paginate(50);
        $rules=[
            'blok'=>'required',
            'luas'=>'numeric',
        ];
        $costumMessages = [
            'required'=>':attribute tidak boleh kosong',
            'numeric'=>'harus berbentuk angka'
        ];

        $requestData = $request->all();
        $requestData['proyek_id']=proyekId();
        $requestData['b']=$b;
        $requestData['nr']=$nr;
        $this->validate($request,$rules,$costumMessages);
        // dd($requestData);
        kavling::create($requestData);

        return redirect()->route('kavling',compact('semuaKavling'))->with('status','Data Kavling Berhasil ditambahkan');
    }
    public function update(Request $request, Kavling $id){
        // dd($request);
        $nomorRumah = preg_match_all('!\d+!',$request->blok,$matchesRumah); /* extract int from string */
        $nr = implode('',$matchesRumah[0]); /* imploae array ke single value */
        $nomorRumah = preg_match_all('![a-zA-Z]+!',$request->blok,$matchesBlok);
        $b = implode('',$matchesBlok[0]); 
        $rules=[
            'blok'=>'required',
            'luas'=>'numeric',
        ];
        $costumMessages = [
            'required'=>':attribute tidak boleh kosong',
            'numeric'=>'harus berbentuk angka'
        ];
        $requestData = $request->all();
        $requestData['proyek_id']=proyekId();
        $requestData['b']=$b;
        $requestData['nr']=$nr;
        $this->validate($request,$rules,$costumMessages);
        $id->update($requestData);

        return redirect()->back()->with('status','Unit berhasil dirubah');
    }
    public function destroy (Kavling $id){
        
        $relasi = $id->pelanggan;
        // dd($id->pembelian);
        if($relasi != null ){
            return redirect()->back()->with('error','Gagal Terhapus, Unit ini dimiliki oleh '.$id->pelanggan->nama);
        }elseif($relasi == null && $id->pembelian != null){
            return redirect()->back()->with('error','Gagal Terhapus, Unit ini Memiliki Transaksi dari pelanggan sebelumnya (Batal Akad)');
        }
        else{
            kavling::destroy($id->id);
            return redirect()->back()->with('status','Unit Berhasil dihapus');
            
        }
    }
    public function gantiStatus(Request $request, Kavling $id){
        // dd($request);
        $update=pembelian::where('kavling_id',$id->id)->where('pelanggan_id',$request->pelanggan_id)->first();
        // dd($update);
        $update->update(['statusPembelian'=>'Sold']);
        return redirect()->back()->with('status','Berhasil Mengganti Status');
    }
}
