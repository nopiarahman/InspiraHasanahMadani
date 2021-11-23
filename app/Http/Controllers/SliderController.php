<?php

namespace App\Http\Controllers;
use App\slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{

    public function index(){
        $slider = slider::all();
        return view ('slider/sliderIndex',compact('slider'));
    }

    public function create(){
        return view ('slider/createSlider');
    }
    public function store(Request $request){
        $rules=[
            'judul'=>'required',
            'gambar'=>'required',
            'status'=>'required',
        ];
        $costumMessages = [
            'required'=>':attribute tidak boleh kosong'
        ];
        $this->validate($request,$rules,$costumMessages);
        $requestData = $request->all();
        if ($request->hasFile('gambar')) {
            $file_nama            = $request->file('gambar')->store('public/popup/gambar');
            $requestData['gambar'] = $file_nama;
        } else {
            unset($requestData['gambar']);
        }

        slider::create($requestData);
        return redirect()->route('slider')->with('status','Slider berhasil Di Simpan');

    }
    public function edit(slider $id){
        // dd($id);
        return view ('slider/sliderEdit',compact('id'));
    }
    public function update(Request $request, slider $id){
        // dd($request);
        $rules=[
            'judul'=>'required',
            'status'=>'required',
        ];
        $costumMessages = [
            'required'=>':attribute tidak boleh kosong'
        ];
        $this->validate($request,$rules,$costumMessages);
        $requestData = $request->all();
        if ($request->hasFile('gambar')) {
            $file_nama            = $request->file('gambar')->store('public/popup/gambar');
            $requestData['gambar'] = $file_nama;
        } else {
            unset($requestData['gambar']);
        }
        $id->update($requestData);
        return redirect()->route('slider')->with('status','Slider berhasil Di Rubah');
    }
}
