<?php

namespace App\Http\Controllers;

use App\Models\Iron;
use App\Http\Requests\StoreIronRequest;
use App\Http\Requests\UpdateIronRequest;

class IronController extends Controller
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
     * @param  \App\Http\Requests\StoreIronRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreIronRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Iron  $iron
     * @return \Illuminate\Http\Response
     */
    public function show(Iron $iron)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Iron  $iron
     * @return \Illuminate\Http\Response
     */
    public function edit(Iron $iron)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateIronRequest  $request
     * @param  \App\Models\Iron  $iron
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateIronRequest $request, Iron $iron)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Iron  $iron
     * @return \Illuminate\Http\Response
     */
    public function destroy(Iron $iron)
    {
        //
    }
}
