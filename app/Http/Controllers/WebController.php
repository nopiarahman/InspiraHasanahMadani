<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\kabarBerita;
use App\proyekweb;
use App\galeri;
class WebController extends Controller
{
    public function blog(){
        $blog = kabarBerita::latest()->paginate(5);
        
        return view('web/blog',compact('blog'));
        
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
        $semuaGaleri = galeri::latest()->paginate(2);
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