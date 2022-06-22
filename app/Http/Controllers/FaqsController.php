<?php

namespace App\Http\Controllers;

use App\Models\Faqs;
use Illuminate\Http\Request;
use App\Http\Requests\StorefaqsRequest;
use App\Http\Requests\UpdatefaqsRequest;

class FaqsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index ()
    {
        return view("8_Knowledge_Base", ['faqs' => Faqs::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, Faqs $newFaq) 
    {
        $data = $request->all(); 

        $newFaq->judul = $data["judul"];
        $newFaq->deskripsi = $data["deskripsi"];

        $newFaq->save();
        return redirect()->back();

    }
    
    public function update(Request $request, Faqs $newFaq) 
    {
        // dd($idFaq);
        
        $data = $request->all(); 
        
        // dd($data);
        
        $newFaq = Faqs::find($data["id"]);
        $newFaq->judul = $data["judul"];
        $newFaq->deskripsi = $data["deskripsi"];

        $newFaq->save();
        return redirect()->back();

    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorefaqsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorefaqsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Faqs  $Faqs
     * @return \Illuminate\Http\Response
     */
    public function show(Faqs $Faqs)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Faqs  $Faqs
     * @return \Illuminate\Http\Response
     */
    public function edit(Faqs $Faqs)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\FpdatefaqsRequest  $request
     * @param  \App\Models\Faqs  $Faqs
     * @return \Illuminate\Http\Response
     */
    // public function update(UpdatefaqsRequest $request, Faqs $Faqs)
    // {
    //     //
    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Faqs  $Faqs
     * @return \Illuminate\Http\Response
     */
    public function destroy(Faqs $Faqs)
    {
        //
    }
}
