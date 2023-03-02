<?php

namespace App\Http\Controllers;

use App\Models\TbAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TbAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id, $roles)
    {
        return view('admin.index')->with(['id' => $id, 'roles' => $roles]);
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
     * @param  \App\Models\TbAdmin  $tbAdmin
     * @return \Illuminate\Http\Response
     */
    public function show(TbAdmin $tbAdmin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TbAdmin  $tbAdmin
     * @return \Illuminate\Http\Response
     */
    public function edit(TbAdmin $tbAdmin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TbAdmin  $tbAdmin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TbAdmin $tbAdmin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TbAdmin  $tbAdmin
     * @return \Illuminate\Http\Response
     */
    public function destroy(TbAdmin $tbAdmin)
    {
        //
    }
}
