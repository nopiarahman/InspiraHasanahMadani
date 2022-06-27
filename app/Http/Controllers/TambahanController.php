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
        $rekening = rekening::where('proyek_id', proyekId())->get();
        return view('tambahan/tambah', compact('id','rekening'));
    }
    public function store(Request $request, Pembelian $id)
    {
        DB::beginTransaction();
        try {
            $rules = [
                'total' => 'required|numeric',
                'keterangan' => 'required',
            ];
            $costumMessages = [
                'required' => ':attribute tidak boleh kosong'
            ];
            $this->validate($request, $rules, $costumMessages);
            $requestData = $request->all();
            $requestData['pelanggan_id'] = $id->pelanggan->id;
            tambahan::create($requestData);
            DB::commit();
            return redirect()->back()->with('status', 'Pendapatan Tambahan telah dibuat!');
        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->back()->with('error', 'Gagal. Pesan Error: ' . $ex->getMessage());
        }
        
    }
    public function destroy(tambahan $id)
    {
        // Cek transaksi
        dd($id);
    }
}
