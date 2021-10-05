<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\kabarBerita;
use Carbon\Carbon;
class KabarBeritaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kabarBerita = kabarBerita::all();
        return view('kabarBerita/kabarBeritaIndex',compact('kabarBerita'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('kabarBerita/kabarBeritaTambah');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $author=auth()->user()->name;
        // dd($request);
        $rules=[
            'judul'=>'required',
            'isi'=>'required',
        ];
        $costumMessages = [
            'required'=>':attribute tidak boleh kosong'
        ];
        $requestData = $request->all();
        if ($request->hasFile('thumbnail')) {
            $file_nama            = $request->file('thumbnail')->store('public/file/berita/thumbnail');
            $requestData['thumbnail'] = $file_nama;
        } else {
            unset($requestData['thumbnail']);
        }
        $requestData['tanggal']=Carbon::now()->isoFormat('YYYY-MM-DD,h:mm:ss');
        $requestData['author']=$author;
        $requestData['proyek_id']=proyekId();
        // dd($requestData);
        kabarBerita::create($requestData);
        return redirect()->route('kabarBerita')->with('status','Kabar Berita telah ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(kabarBerita $id)
    {
        // dd($id);
        
        return view('kabarBerita/kabarBeritaLihat',compact('id'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, kabarBerita $id)
    {
        // dd($request);
        $author=auth()->user()->name;

        $rules=[
            'judul'=>'required',
            'isi'=>'required',
        ];
        $costumMessages = [
            'required'=>':attribute tidak boleh kosong'
        ];
        $requestData = $request->all();
        if ($request->hasFile('thumbnail')) {
            $file_nama            = $request->file('thumbnail')->store('public/file/berita/thumbnail');
            $requestData['thumbnail'] = $file_nama;
        } else {
            unset($requestData['thumbnail']);
        }
        $requestData['tanggal']=Carbon::now()->isoFormat('YYYY-MM-DD,h:mm:ss');
        $requestData['author']=$author;
        $id->update($requestData);
        return redirect()->route('kabarBerita')->with('status','Kabar Berita berhasil diupdate');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(kabarBerita $id)
    {
        $id->delete();
        return redirect()->back()->with('status','Kabar Berita berhasil dihapus');

    }
}
