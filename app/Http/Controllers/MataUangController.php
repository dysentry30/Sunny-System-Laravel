<?php

namespace App\Http\Controllers;

use App\Models\MataUang;
use App\Http\Requests\StoreMataUangRequest;
use App\Http\Requests\UpdateMataUangRequest;

class MataUangController extends Controller
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
     * @param  \App\Http\Requests\StoreMataUangRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMataUangRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MataUang  $mataUang
     * @return \Illuminate\Http\Response
     */
    public function show(MataUang $mataUang)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MataUang  $mataUang
     * @return \Illuminate\Http\Response
     */
    public function edit(MataUang $mataUang)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMataUangRequest  $request
     * @param  \App\Models\MataUang  $mataUang
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMataUangRequest $request, MataUang $mataUang)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MataUang  $mataUang
     * @return \Illuminate\Http\Response
     */
    public function destroy(MataUang $mataUang)
    {
        //
    }
}
