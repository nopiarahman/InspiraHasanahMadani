<?php

namespace App\Http\Controllers;

use App\rekening;
use App\tambahan;
use App\pelanggan;
use App\pembelian;
use App\detailUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class TambahanController extends Controller
{
    public function detail(tambahan $id)
    {
        // dd($id);
        if(auth()->user()->proyek_id != $id->pelanggan->proyek_id){
            return redirect()->route('pelangganIndex')->with('status',$id->pelanggan->nama .' adalah pelanggan '.$id->pelanggan->proyek->nama);
        }
        $rekening = rekening::where('proyek_id', proyekId())->get();
        if($id->tambahanDetail != null){
            $tambahanDetail = $id->tambahanDetail()->get();
        }else{
            $tambahanDetail = [];
        }
        // dd($id->tambahandetail()->get());
        return view('tambahan/tambah', compact('id','rekening','tambahanDetail'));
    }
    public function store(Request $request, Pembelian $id)
    {
        DB::beginTransaction();
        try {
            $jumlah = str_replace(',', '', $request->total);
            $rules = [
                'total' => 'required',
                'keterangan' => 'required',
            ];
            $costumMessages = [
                'required' => ':attribute tidak boleh kosong'
            ];
            $this->validate($request, $rules, $costumMessages);
            $requestData = $request->all();
            $requestData['pelanggan_id'] = $id->pelanggan->id;
            $requestData['total'] = $jumlah;
            tambahan::create($requestData);
            DB::commit();
            return redirect()->back()->with('status', 'Pendapatan Tambahan telah dibuat!');
        } catch (\Exception $ex) {
            DB::rollback();
            dd($ex);
            return redirect()->back()->with('error', 'Gagal. Pesan Error: ' . $ex->getMessage());
        }
        
    }
    public function destroy(tambahan $id)
    {
        if($id->tambahanDetail!=null){
            return redirect()->back()->with('error', 'Gagal. Tambahan memiliki transaksi!');
        }else
        $id->delete();
        return redirect()->back()->with('status', 'Tambahan Berhasil dihapus');

    }
}
