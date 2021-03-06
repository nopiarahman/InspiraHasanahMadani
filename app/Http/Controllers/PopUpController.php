<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\popup;
use App\galeri;
class PopUpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function banner()
    {
        $detail = galeri::firstOrCreate([
            'kategori'=>'banner'
        ]);
        return view ('popup/banner',compact('detail'));   
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $find = popup::first();
        // dd($find->status);
        if($find){
            $popup=$find;
        }else{
            $popup =null;
        }
        return view('popup/createPopUp',compact('popup'));
    }
    public function gantiBanner(galeri $id, Request $request){
        // dd($request);
        $requestData=$request->all();
        $file_nama            = $request->file('foto')->store('public/user/banner');
        if ($request->hasFile('foto')) {
            $requestData['path'] = $file_nama;
        } else {
            unset($requestData['path']);
        }
        // dd($file_nama);
        $id->update($requestData);
        return redirect()->back()->with('status','Foto berhasil diganti');
    }
    public function linkBanner(galeri $id, Request $request){
        // dd($request);?
        $requestData=$request->all();
        $id->update($requestData);
        return redirect()->back()->with('status','Link berhasil diganti');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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
        if(popup::first()==null){
            popup::create($requestData);
        }else{
            $find = popup::first();
            $find->update($requestData);
        }
        return redirect()->route('popup')->with('status','Berhasil Di Update');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
