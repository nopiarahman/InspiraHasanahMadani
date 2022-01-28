<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\kabarBerita;
use App\proyekweb;
use App\galeri;
use Carbon\Carbon;

class WebController extends Controller
{
    public function blog(Request $request){
        $listBerita = kabarBerita::selectRaw("tanggal, date_format(tanggal, '%M') bulan, date_format(tanggal, '%Y') tahun")
        ->get()
        ->sortBy('bulan');
        if($request->filter){
            $start = Carbon::parse($request->filter)->firstOfMonth()->isoFormat('YYYY-MM-DD');
            $end = Carbon::parse($request->filter)->endOfMonth()->isoFormat('YYYY-MM-DD');

            $blog= kabarBerita::whereBetween('tanggal',[$start,$end])->paginate(5);
        }else{
            $blog = kabarBerita::latest()->paginate(5);
        }
        $banner = galeri::where('kategori','banner')->first();
        return view('web/blog',compact('blog','banner','listBerita'));
        
    }
    public function kabar_berita(kabarBerita $id){
        // dd($id);
        return view('web/kabar_berita',compact('id'));
    }
    
    public function proyekdetail(proyekweb $id){
        // dd($id);
        return view('web/project-single',compact('id'));
    }
    public function daftarProyek(){
        $daftarProyek = proyekweb::latest()->paginate(6);
        return view('web/project',compact('daftarProyek'));
    }
    public function galeri(){
        $semuaGaleri = galeri::latest()->paginate(12);
        $kategori = galeri::all()->unique('kategori');
        // dd($kategori);

        return view('web/galeri',compact('semuaGaleri','kategori'));
    }
    public function kontak(){
        return view('web/kontak');
    }
    public function tentang(){
        return view('web/tentang');
    }
}