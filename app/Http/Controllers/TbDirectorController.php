<?php

namespace App\Http\Controllers;

use App\Models\TbDirector;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class TbDirectorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        return view('director.index');
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
     * @param  \App\Models\TbDirector  $tbDirector
     * @return \Illuminate\Http\Response
     */
    public function show(TbDirector $tbDirector)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TbDirector  $tbDirector
     * @return \Illuminate\Http\Response
     */
    public function edit(TbDirector $tbDirector)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TbDirector  $tbDirector
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TbDirector $tbDirector)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TbDirector  $tbDirector
     * @return \Illuminate\Http\Response
     */
    public function destroy(TbDirector $tbDirector)
    {
        //
    }
}
