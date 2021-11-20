<?php

namespace App\Http\Controllers;

use App\pengembalian;
use App\transaksi;
use App\pelanggan;
use App\rab;
use App\rabUnit;
use App\akun;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengembalianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function buatPengembalian(Pelanggan $id, Request $request)
    {
        /* RAB */
        // dd($id->pembelian);
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

        /* pengembalian */
        $pengembalian=pengembalian::where('pelanggan_id',$id->id)->get();
        return view ('pengembalian/buatPengembalian',compact('id','pengembalian','perHeader','semuaRAB','perJudul','perHeaderUnit','semuaRABUnit','perJudulUnit'));
    }
    public function destroy(Pengembalian $id){
        DB::beginTransaction();
        try {
            $id->delete();
            $transaksi=transaksi::find($id->transaksi_id)->delete();
            DB::commit();
            return redirect()->back()->with('status','Transaksi berhasil dihapus');
        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->back()->with('error','Gagal. Pesan Error: '.$ex->getMessage());
        }
    }
    
}
