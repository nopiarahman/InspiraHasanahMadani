<?php

namespace App\Http\Controllers;

use App\cicilan;
use Illuminate\Http\Request;

class CicilanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function cicilanRumah()
    {
        return view ('cicilanUnit/rumah');
    }
    
    public function cicilanKavling()
    {
        return view ('cicilanUnit/kavling');
    }
    
    public function cicilanKios()
    {
        return view ('cicilanUnit/kios');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\cicilan  $cicilan
     * @return \Illuminate\Http\Response
     */
    public function show(cicilan $cicilan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\cicilan  $cicilan
     * @return \Illuminate\Http\Response
     */
    public function edit(cicilan $cicilan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\cicilan  $cicilan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, cicilan $cicilan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\cicilan  $cicilan
     * @return \Illuminate\Http\Response
     */
    public function destroy(cicilan $cicilan)
    {
        //
    }
}
