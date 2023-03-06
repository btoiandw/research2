<?php

namespace App\Http\Controllers\Pre;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TbAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $data = DB::table('users')->where('employee_id',$id)->get();
        //dd($data[0]);
        return view('pre-research.admin.index')->with(['data'=>$data[0],'id' => $id]);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function rePages($id)
    {
        $data_re = DB::table('tb_research')->get();
        $data= DB::table('users')->where('employee_id',$id)->get();
        return view('pre-research.admin.research_request')->with(['data_re' => $data_re,'id'=>$id,'data'=>$data[0]]);
    }
    public function manaUser($id){
        $data= DB::table('users')->where('employee_id',$id)->get();
        $data_u = DB::table('tb_admins')->join('users','tb_admins.employee_id','=','users.employee_id')->where('tb_admins.status_workadmin','=','1')->get();
        $data_d =DB::table('tb_directors')->where('work_status','=','1')->get();
        //dd($data_u,$data_d);
        return view('pre-research.admin.manage_user')->with(['id'=>$id,'data'=>$data[0],'data_u'=>$data_u,'data_d'=>$data_d]);
    }
}
