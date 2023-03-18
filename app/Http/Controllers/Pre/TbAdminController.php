<?php

namespace App\Http\Controllers\Pre;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class TbAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $data = DB::table('users')->join('tb_faculties', 'users.organization_id', '=', 'tb_faculties.id')->where('employee_id', $id)->get();
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
        $nowDate = Carbon::now()->format('Y-m-d H:i:m');
        $ad = DB::table('tb_admins')->count();
        if ($ad > 0) {
            $admin_id = $ad + 1;
        } else {
            $admin_id = 1;
        }
        $data_ad = DB::table('users')->where('username', $request->id_card)->get();
        $data = DB::table('tb_admins')->where('username', $request->id_card)->count();
        if ($data == 0) {
            $admin = DB::insert(
                'insert into tb_admins (employee_admin_id, employee_id,username,password,status_workadmin)
            values (?, ?, ?, ?, ?)',
                [$admin_id, $data_ad[0]->employee_id, $data_ad[0]->username, $data_ad[0]->password, '1']
            );
        } else {
            $admin = DB::update('update tb_admins set status_workadmin = 1 where employee_id = ?', [$data_ad[0]->username]);
        }

        return response()->json(['status' => true]);
        //dd($ad, $data, $admin_id, $data_ad, $admin);
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
        //dd($id);
        $data = DB::table('users')->where('employee_id', $id)->get();
        //dd($data);
        return response()->json(['data' => $data]);
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
        //$data = DB::table('tb_admins')->update(['status_workadmin' => '0'])->where('employee_id', $id)->get();
        $data = DB::update('update tb_admins set status_workadmin = 0 where employee_id = ?', [$id]);
        //dd($data);

        return response()->json(['status' => true]);
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
            ->distinct('tb_research.research_id')
            ->join('tb_feedback', 'tb_research.research_id', '=', 'tb_feedback.research_id')
            ->where('tb_research.research_status', '!=', '0')
            ->where('tb_research.research_status', '!=', '2')
            ->where('tb_research.research_status', '!=', '4')
            ->where('tb_research.research_status', '!=', '6')
            ->where('tb_research.research_status', '!=', '8')
            ->where('tb_research.research_status', '!=', '9')
            ->where('tb_research.research_status', '!=', '10')
            ->where('tb_feedback.status', '=', '0')
            //->groupBy('tb_feedback.research_id')
            //->select('tb_feedback.research_id', 'tb_feedback.employee_referees_id', 'tb_feedback.date_send_referess', 'tb_feedback.status', 'tb_research.*')
            //->groupBy('tb_research.research_id')
            ->select('tb_feedback.status', 'tb_research.*')
            ->get()
            /* ->toArray() */;
        //dd($data_re);
        return view('pre-research.admin.research_send_d')->with(['id' => $id, 'data' => $data[0], 'data_re' => $data_re]);
    }

    public function deliverPages($id)
    {
        $data = DB::table('users')->where('employee_id', $id)->get();
        //dd($data[0]);
        return view('pre-research.admin.deliver_list')->with(['data' => $data[0], 'id' => $id]);
    }
    public function cbgPages($id)
    {
        $data = DB::table('users')->where('employee_id', $id)->get();
        //dd($data[0]);
        return view('pre-research.admin.Report.report_cbg')->with(['data' => $data[0], 'id' => $id]);
    }
    public function cresearchPages($id)
    {
        $data = DB::table('users')->where('employee_id', $id)->get();
        //dd($data[0]);
        return view('pre-research.admin.Report.report_cresearch')->with(['data' => $data[0], 'id' => $id]);
    }

    public function searchAdmin(Request $request)
    {
        $data = DB::table('users')->where('username', $request->id_card)->get();
        return response()->json(['data' => $data]);
    }
}
