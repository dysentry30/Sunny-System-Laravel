<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Models\TeamProyek;

class TeamProyekController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("/MasterData/TeamProyek", ["teams" => TeamProyek::all()->reverse()]);
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
     * @param  \App\Http\Requests\StoreTeamProyekRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TeamProyek  $teamProyek
     * @return \Illuminate\Http\Response
     */
    public function show(TeamProyek $teamProyek)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TeamProyek  $teamProyek
     * @return \Illuminate\Http\Response
     */
    public function edit(TeamProyek $teamProyek)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTeamProyekRequest  $request
     * @param  \App\Models\TeamProyek  $teamProyek
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TeamProyek $teamProyek)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TeamProyek  $teamProyek
     * @return \Illuminate\Http\Response
     */
    public function destroy(TeamProyek $teamProyek)
    {
        //
    }
}
