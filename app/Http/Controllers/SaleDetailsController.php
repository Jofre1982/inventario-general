<?php

namespace App\Http\Controllers;

use App\Models\saleDetails;
use App\Http\Requests\StoresaleDetailsRequest;
use App\Http\Requests\UpdatesaleDetailsRequest;

class SaleDetailsController extends Controller
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
     * @param  \App\Http\Requests\StoresaleDetailsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoresaleDetailsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\saleDetails  $saleDetails
     * @return \Illuminate\Http\Response
     */
    public function show(saleDetails $saleDetails)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\saleDetails  $saleDetails
     * @return \Illuminate\Http\Response
     */
    public function edit(saleDetails $saleDetails)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatesaleDetailsRequest  $request
     * @param  \App\Models\saleDetails  $saleDetails
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatesaleDetailsRequest $request, saleDetails $saleDetails)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\saleDetails  $saleDetails
     * @return \Illuminate\Http\Response
     */
    public function destroy(saleDetails $saleDetails)
    {
        //
    }
}
