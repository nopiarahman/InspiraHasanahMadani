<?php

namespace App\Http\Controllers;

use App\costumer;
use Illuminate\Http\Request;

class CostumerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view ('costumer/index');
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
     * @param  \App\costumer  $costumer
     * @return \Illuminate\Http\Response
     */
    public function show(costumer $costumer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\costumer  $costumer
     * @return \Illuminate\Http\Response
     */
    public function edit(costumer $costumer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\costumer  $costumer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, costumer $costumer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\costumer  $costumer
     * @return \Illuminate\Http\Response
     */
    public function destroy(costumer $costumer)
    {
        //
    }
}
