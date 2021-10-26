<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\proyekweb;
use App\galeri;


class ProyekWebController extends Controller
{
    public function proyek(){
        $proyek = proyekweb::all();
        return view('proyek/web/proyekWeb',compact('proyek'));
    }
    public function proyekTambah(){
        // $proyek = proyekweb::all();
        return view('proyek/web/proyekWebTambah');
    }
    public function proyekSimpan(Request $request){
        // dd($request);
        $rules=[
            'nama'=>'required',
            'detail'=>'required',
        ];
        $costumMessages = [
            'required'=>':attribute tidak boleh kosong'
        ];
        $requestData = $request->all();
        if ($request->hasFile('logo')) {
            $file_nama            = $request->file('logo')->store('public/proyekWeb/logo');
            $requestData['logo'] = $file_nama;
        } else {
            unset($requestData['logo']);
        }
        if ($request->hasFile('cover')) {
            $file_nama            = $request->file('cover')->store('public/proyekWeb/cover');
            $requestData['cover'] = $file_nama;
        } else {
            unset($requestData['cover']);
        }
        // dd($requestData);
        proyekweb::create($requestData);
        return redirect()->route('proyekWeb')->with('status','Proyek telah ditambahkan');
    }
    public function proyekDetail(proyekweb $id){
        return view('proyek/web/proyekWebDetail',compact('id'));
    }
    public function proyekUpdate(proyekweb $id, Request $request){
        // dd($request);
        $rules=[
            'nama'=>'required',
            'detail'=>'required',
        ];
        $costumMessages = [
            'required'=>':attribute tidak boleh kosong'
        ];
        $requestData = $request->all();
        if ($request->hasFile('logo')) {
            $file_nama            = $request->file('logo')->store('public/proyekWeb/logo');
            $requestData['logo'] = $file_nama;
        } else {
            unset($requestData['logo']);
        }
        if ($request->hasFile('cover')) {
            $file_nama            = $request->file('cover')->store('public/proyekWeb/cover');
            $requestData['cover'] = $file_nama;
        } else {
            unset($requestData['cover']);
        }
        $id->update($requestData);
        return redirect()->back()->with('status','Proyek telah diupdate');
    }
    public function galeriProyek(Request $request,proyekweb $id){
        $requestData = $request->all();
        if($request->hasFile('file')){
            $file_nama            = $request->file('file')->store('public/proyekWeb/galeriProyek');
            $requestData['kategori']=$id->kategori;
            $requestData['path'] = $file_nama;
            $id->galeri()->create($requestData);
        }
        return 'done';

    }
    public function destroy (proyekweb $id){
        $id->delete();
        return redirect()->back()->with('status','Proyek Berhasil Dihapus berhasil dihapus');
    }
    public function hapusGaleriProyek (galeri $id){
        $id->delete();
        return redirect()->back()->with('status','Foto berhasil dihapus');
    }
}
