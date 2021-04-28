<?php

namespace App\Http\Controllers;

use App\dp;
use Illuminate\Http\Request;

class DPController extends Controller
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

    public function DPRumah(){
        return view ('cicilanDP/rumah');
    }
    public function DPKavling(){
        return view ('cicilanDP/kavling');
    }
    public function DPKios(){
        return view ('cicilanDP/kios');
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
     * @param  \App\dp  $dp
     * @return \Illuminate\Http\Response
     */
    public function show(dp $dp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\dp  $dp
     * @return \Illuminate\Http\Response
     */
    public function edit(dp $dp)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\dp  $dp
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, dp $dp)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\dp  $dp
     * @return \Illuminate\Http\Response
     */
    public function destroy(dp $dp)
    {
        //
    }

}
