<?php

namespace App\Http\Controllers;

use App\kavling;
use Illuminate\Http\Request;

class KavlingController extends Controller
{
    public function index (){
        $semuaKavling = kavling::where('proyek_id',proyekId())->paginate(20);
        // dd($semuaKavling);
        return view ('proyek/DataProyek/kavlingIndex',compact('semuaKavling'));
    }

    public function kavlingSimpan(Request $request){

        /* Pilih semua kavling */
        $semuaKavling = kavling::where('proyek_id',proyekId())->paginate(20);
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
        $this->validate($request,$rules,$costumMessages);
        // dd($requestData);
        kavling::create($requestData);

        return redirect()->route('kavling',compact('semuaKavling'))->with('status','Data Kavling Berhasil ditambahkan');
    }
}
