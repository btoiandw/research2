<?php

namespace App\Http\Controllers;

use App\Models\TbResearch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TbResearchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id, $roles)
    {
        $list_user = DB::table('users')->get();
        $list_fac = DB::table('tb_faculties')->get();
        $list_source = DB::table('tb_research_sources')->get();
        $data = DB::table('users')->join('tb_faculties', 'users.organization_id', '=', 'tb_faculties.id')->where('users.employee_id', $id)->get();
        return view('research.add_research')->with([
            'id' => $id,
            'roles' => $roles,
            'data' => $data,
            'list_source' => $list_source,
            'list_fac' => $list_fac,
            'list_user' => $list_user
        ]);
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
     * @param  \App\Models\TbResearch  $tbResearch
     * @return \Illuminate\Http\Response
     */
    public function show(TbResearch $tbResearch)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TbResearch  $tbResearch
     * @return \Illuminate\Http\Response
     */
    public function edit(TbResearch $tbResearch)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TbResearch  $tbResearch
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TbResearch $tbResearch)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TbResearch  $tbResearch
     * @return \Illuminate\Http\Response
     */
    public function destroy(TbResearch $tbResearch)
    {
        //
    }
}
