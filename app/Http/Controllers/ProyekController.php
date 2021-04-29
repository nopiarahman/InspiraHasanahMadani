<?php

namespace App\Http\Controllers;

use App\proyek;
use App\kavling;
use Illuminate\Http\Request;

class ProyekController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $proyek=proyek::all()->sortDesc();
        // dd($proyek);
        return view ('proyek/index',compact('proyek'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ('proyek/tambah');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules=[
            'nama'=>'required',
            'lokasi'=>'required',
            'proyekStart'=>'required'
        ];
        $costumMessages = [
            'required'=>':attribute tidak boleh kosong'
        ];

        $requestData = $request->all();
        $this->validate($request,$rules,$costumMessages);
        proyek::create($requestData);

        return redirect()->route('proyek')->with('status','Data Proyek Berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\proyek  $proyek
     * @return \Illuminate\Http\Response
     */
    public function show(proyek $proyek)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\proyek  $proyek
     * @return \Illuminate\Http\Response
     */
    public function edit(Proyek $id)
    {
        $proyek=$id;
        return view ('proyek/edit',compact('proyek'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\proyek  $proyek
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, proyek $id)
    {
        $rules=[
            'nama'=>'required',
            'lokasi'=>'required',
            'proyekStart'=>'required'
        ];
        $costumMessages = [
            'required'=>':attribute tidak boleh kosong'
        ];
        $requestData = $request->all();
        $this->validate($request,$rules,$costumMessages);
        $id->update($requestData);
        return redirect()->route('proyek')->with('status','Data Proyek Berhasil dirubah');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\proyek  $proyek
     * @return \Illuminate\Http\Response
     */
    public function destroy(proyek $proyek)
    {
        //
    }

    

    public function RAB (){
        return view ('proyek/DataProyek/RAB');
    }

    public function pengeluaran (){
        return view ('proyek/DataProyek/pengeluaran');
    }
}
