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
        $data = DB::table('users')->where('employee_id', $id)->get();
        //dd($data[0]);
        return view('pre-research.admin.index')->with(['data' => $data[0], 'id' => $id]);
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
        $data_re = DB::table('tb_research')
            ->where('research_status', '!=', '1')
            ->where('research_status', '!=', '3')
            ->where('research_status', '!=', '5')
            ->where('research_status', '!=', '7')
            ->get();
        $data = DB::table('users')->where('employee_id', $id)->get();
        $data_d = DB::table('tb_directors')->where('work_status', '=', '1')->get();
        return view('pre-research.admin.research_request')->with(['data_re' => $data_re, 'id' => $id, 'data' => $data[0], 'data_d' => $data_d]);
    }
    public function manaUser($id)
    {
        $data = DB::table('users')->where('employee_id', $id)->get();
        $data_u = DB::table('tb_admins')->join('users', 'tb_admins.employee_id', '=', 'users.employee_id')->where('tb_admins.status_workadmin', '=', '1')->get();
        $data_d = DB::table('tb_directors')->where('work_status', '=', '1')->get();
        //dd($data_u,$data_d);
        return view('pre-research.admin.manage_user')->with(['id' => $id, 'data' => $data[0], 'data_u' => $data_u, 'data_d' => $data_d]);
    }

    public function ResearchDirector($id)
    {
        $data = DB::table('users')->where('employee_id', $id)->get();
        $data_re = DB::table('tb_research')
            ->distinct()
            ->join('tb_feedback', 'tb_research.research_id', '=', 'tb_feedback.research_id')
            ->where('tb_research.research_status', '!=', '0')
            ->where('tb_research.research_status', '!=', '2')
            ->where('tb_research.research_status', '!=', '4')
            ->where('tb_research.research_status', '!=', '6')
            ->where('tb_research.research_status', '!=', '8')
            ->where('tb_research.research_status', '!=', '9')
            ->where('tb_research.research_status', '!=', '10')
            //->where('tb_feedback.status', '=', '0')
            //->groupBy('tb_feedback.research_id')
            //->select('tb_feedback.research_id', 'tb_feedback.employee_referees_id', 'tb_feedback.date_send_referess', 'tb_feedback.status', 'tb_research.*')
            //->groupBy('tb_research.research_id')
            ->select('tb_feedback.status', 'tb_research.*')
            ->get()
            /* ->toArray() */;
       // dd($data_re);
        return view('pre-research.admin.research_send_d')->with(['id' => $id, 'data' => $data[0], 'data_re' => $data_re]);
    }

    public function deliverPages($id){
        $data = DB::table('users')->where('employee_id', $id)->get();
        //dd($data[0]);
        return view('pre-research.admin.deliver_list')->with(['data' => $data[0], 'id' => $id]);
    }
    public function cbgPages($id){
        $data = DB::table('users')->where('employee_id', $id)->get();
        //dd($data[0]);
        return view('pre-research.admin.Report.report_cbg')->with(['data' => $data[0], 'id' => $id]);
    }
    public function cresearchPages($id){
        $data = DB::table('users')->where('employee_id', $id)->get();
        //dd($data[0]);
        return view('pre-research.admin.Report.report_cresearch')->with(['data' => $data[0], 'id' => $id]);
    }

}
