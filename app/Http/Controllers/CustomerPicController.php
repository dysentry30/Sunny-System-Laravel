<?php

namespace App\Http\Controllers;

use App\Models\CustomerPic;
use App\Http\Requests\StoreCustomerPicRequest;
use App\Http\Requests\UpdateCustomerPicRequest;

class CustomerPicController extends Controller
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
     * @param  \App\Http\Requests\StoreCustomerPicRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCustomerPicRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CustomerPic  $customerPic
     * @return \Illuminate\Http\Response
     */
    public function show(CustomerPic $customerPic)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CustomerPic  $customerPic
     * @return \Illuminate\Http\Response
     */
    public function edit(CustomerPic $customerPic)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCustomerPicRequest  $request
     * @param  \App\Models\CustomerPic  $customerPic
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCustomerPicRequest $request, CustomerPic $customerPic)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CustomerPic  $customerPic
     * @return \Illuminate\Http\Response
     */
    public function destroy(CustomerPic $customerPic)
    {
        //
    }
}
