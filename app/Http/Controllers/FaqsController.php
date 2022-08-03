<?php

namespace App\Http\Controllers;

use App\Models\Faqs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Http\Requests\StorefaqsRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdatefaqsRequest;
use RealRashid\SweetAlert\Facades\Alert;

class FaqsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index (Request $request)
    {
        $cari = $request->query("cari");
        if(!empty($cari)){
            $faqs = Faqs::sortable()->where('judul', 'like', '%'.$cari.'%')->orWhere('deskripsi', 'like', '%'.$cari.'%')->get();
        }else{
        $faqs = Faqs::sortable()->get();
        }
        return view("8_Knowledge_Base", compact(['faqs', 'cari']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, Faqs $newFaq) 
    {
        $data = $request->all(); 
        $file = $request->file("faq-attachment");
        
        $newFaq->judul = $data["judul"];
        $newFaq->deskripsi = $data["deskripsi"];
        
        if ($file == null)
        {   
            Alert::success('Success', "Tambah Knowledge Base Berhasil")->autoClose(3000);
            $newFaq->save();
        }else{
            $path = "faqs/";
            $file_name = $file->getClientOriginalName();
            $file_id =  date('Y-m-d_H-i-s_').$file_name;
            // dd($file_id);
            $file->move(public_path($path), $file_id);

            $newFaq->faq_attachment = $file_id;
            $newFaq->save();
        }
        return redirect()->back();
    }
    
    public function update(Request $request, Faqs $newFaq) 
    {
        // dd($idFaq);
        
        $data = $request->all(); 
        $file = $request->file("faq-attachment");
        
        // dd($data);
        
        $newFaq = Faqs::find($data["id"]);
        $newFaq->judul = $data["judul"];
        $newFaq->deskripsi = $data["deskripsi"];
        if ($file == null)
        {   
            Alert::success('Success', "Tambah Knowledge Base Berhasil")->autoClose(3000);
            $newFaq->save();
        }else{
            $path = "faqs/";
            $file_name = $file->getClientOriginalName();
            $file_id =  date('Y-m-d_H-i-s_').$file_name;
            // dd($file_id);
            $file->move(public_path($path), $file_id);

            $newFaq->faq_attachment = $file_id;
            $newFaq->save();
        }

        return redirect()->back();

    }

    public function delete($id)
    {
        $id = Faqs::find($id);
        $judul = $id->judul;
        
        $id->delete();
        Alert::success('Delete', $judul.", Berhasil Dihapus")->hideCloseButton();

        return redirect()->back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorefaqsRequest  $request
     * @return \Illuminate\Http\Response
     */
    // public function download($file_id, Request $request)
    // {   
    //     // $path = public_path()."/faqs";
    //     // $file = File::files($path);
    //     // $file->each();
    //     // dd($file);
        
    //     $path = public_path()."/faqs";
    //     $file = File::files($path);
        
        
    //     // dd($file);
    //     $content = Storage::get($file);

    //     return response($content)->withHeaders(([
    //         'Content-Type' => mime_content_type($path)
    //     ]));

    //     // if (Storage::disk('public')->exists("faqs/$request->file")){
    //     //     $path = Storage::disk('public')->path("faqs/$request->file");
    //     //     $content = file_get_contents($path);
    //     //     return response($content)->withHeaders(([
    //     //        'Content-Type' => mime_content_type($path)
    //     //     ]));
    //     // }
    // }

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
