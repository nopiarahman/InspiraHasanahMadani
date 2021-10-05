<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\kabarBerita;
class WebController extends Controller
{
    public function blog(){
        $blog = kabarBerita::latest()->paginate(5);
        // dd($blog);
        return view('web/blog',compact('blog'));
    }
    public function kabar_berita(kabarBerita $id){
        // dd($id);
        return view('web/kabar_berita',compact('id'));
    }
}