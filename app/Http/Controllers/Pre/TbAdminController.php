<?php

namespace App\Http\Controllers\Pre;

use App\Http\Controllers\Controller;
use App\Models\TbContract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use RealRashid\SweetAlert\Facades\Alert;

class TbAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $data = DB::table('users')
            ->join('tb_majors', 'users.major_id', '=', 'tb_majors.major_id')
            ->join('tb_faculties', 'tb_majors.organization_id', '=', 'tb_faculties.organization_id')
            ->where('employee_id', $id)->get();
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
            ->where('research_status', '!=', '1') //
            ->where('research_status', '!=', '4')
            ->where('research_status', '!=', '7')
            ->where('research_status', '!=', '10')
            ->where('research_status', '!=', '11')
            ->where('research_status', '!=', '15')
            ->orderBy('updated_at', 'desc')
            ->get();
        $data = DB::table('users')->where('employee_id', $id)->get();
        $data_d = DB::table('tb_directors')->where('work_status', '=', '1')->get();

        $data_list = DB::table('tb_deliver_lists')
            ->join('tb_research_sources', 'tb_deliver_lists.research_source_id', '=', 'tb_research_sources.research_sources_id')
            ->where('tb_deliver_lists.status', '=', '1')
            ->get();
        //dd($data_re, $data, $data_d);
        return view('pre-research.admin.research_request')->with(['data_re' => $data_re, 'id' => $id, 'data' => $data[0], 'data_d' => $data_d, 'data_list' => $data_list]);
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
            //->join('tb_feedback', 'tb_research.research_id', '=', 'tb_feedback.research_id')
            // ->where('tb_feedback.status', '=', '0')
            //->join('tb_directors', 'tb_feedback.employee_referees_id', '=', 'tb_directors.employee_referees_id')
            ->where('tb_research.research_status', '1')
            ->orWhere('tb_research.research_status', '4')
            ->orWhere('tb_research.research_status', '7') //
            ->orWhere('tb_research.research_status', '10') //

            //status research,
            //    0=>รอตรวจ(ส่งครั้งแรก)
            //    1=>admin ส่งให้กรรมการครั้งที่ 1
            //    2=>admin ส่งให้นักวิจัยแก้ครั้งที่ 1

            //    3=>รอตรวสอบการปรับแก้ครั้งที่ 1
            //    4=>admin ส่งให้กรรมการครั้งที่ 1
            //    5=>admin ส่งให้นักวิจัยแก้ครั้งที่ 2

            //    6=>รอตรวสอบการปรับแก้ครั้งที่ 2
            //    7=>admin ส่งให้กรรมการครั้งที่ 2
            //    8=>admin ส่งให้นักวิจัยแก้ครั้งที่ 3

            //    9=>รอตรวสอบการปรับแก้ครั้งที่ 3
            //    10=>admin ส่งให้กรรมการครั้งที่ 3
            //    11=>อนุมัติ
            //    12=>ยกเลิก
            //    13=>ไม่ผ่าน
            //    14=>ไม่ผ่านการตรวจสอบจากแอดมิน
            //    15=>ผ่าน
            ->select('tb_research.*')
            ->get();
        // dd($data_re);
        if (count($data_re) == 0) {
            // return 'is []';
            Alert::error('ไม่พบข้อมูลโครงร่างงานวิจัยที่เสนอพิจารณาแก่กรรมการ');
            return redirect()->back()->with(['id' => $id, 'data' => $data[0]]);
        } else {
            # code...
            // return 'is not [] ';
            $dr = DB::table('tb_feedback')
                ->join('tb_research', 'tb_feedback.research_id', '=', 'tb_research.research_id')
                ->join('tb_directors', 'tb_feedback.employee_referees_id', '=', 'tb_directors.employee_referees_id')
                ->where('tb_research.research_id', $data_re[0]->research_id)
                ->get();
            $c_df = DB::table('tb_feedback')->where('research_id', $data_re[0]->research_id)->where('status', '=', '1')->count();
            $dt_f = DB::table('tb_feedback')
                ->where('research_id', $dr[0]->research_id)
                ->where('employee_referees_id', $dr[0]->employee_referees_id)
                ->get();
            //dd($dr, $dt_f);
            return view('pre-research.admin.research_send_d')->with(['dr' => $dr, 'c_df' => $c_df, 'id' => $id, 'data' => $data[0], 'data_re' => $data_re]);
        }
        /* if () {
            return 'null research';
        } else {
            return 'bt';
        } */

        //dd($data_re);
    }

    public function deliverPages($id)
    {
        $data = DB::table('users')->where('employee_id', $id)->get();
        $data_de = DB::select('SELECT DISTINCT `deliver_id`,tb_deliver_lists.research_source_id,tb_deliver_lists.Type_research,tb_deliver_lists.status,tb_research_sources.research_sources_id,tb_research_sources.research_source_name FROM `tb_deliver_lists` INNER JOIN tb_research_sources ON tb_deliver_lists.research_source_id = tb_research_sources.research_sources_id WHERE tb_deliver_lists.status = "1" ORDER BY tb_deliver_lists.updated_at DESC');
        //dd($dt);
        /* $data_de = DB::table('tb_deliver_lists')
            ->distinct()
            ->join('tb_research_sources', 'tb_deliver_lists.research_source_id', '=', 'tb_research_sources.research_sources_id')
            ->where('tb_deliver_lists.status', '1')
            ->orderBy('tb_deliver_lists.deliver_id', 'desc')
            //->groupBy('tb_deliver_lists.deliver_id')
            ->get(); */
        $data_so = DB::table('tb_research_sources')->where('status', '1')->get();
        $data_ty = DB::table('tb_research')->get('type_research_id');
        $da = DB::table('tb_research')->get('type_research_id');


        //dd($da, $result);
        //dd($data, $data_de, $data_so, $data_ty);
        return view('pre-research.admin.deliver_list')->with(['da' => $da, 'data' => $data[0], 'id' => $id, 'data_de' => $data_de, 'data_so' => $data_so, 'data_ty' => $data_ty]);
    }
    public function cbgPages($id)
    {
        $data = DB::table('users')->where('employee_id', $id)->get();
        $data_de = DB::table('tb_deliver_lists')->where('status', '1')->get();
        $data_so = DB::table('tb_research_sources')->where('status', '1')->get();
        $data_ty = DB::table('tb_research')->get('type_research_id');
        //dd($data[0]);
        return view('pre-research.admin.Report.report_cbg')->with(['data' => $data[0], 'id' => $id, 'data_de' => $data_de, 'data_so' => $data_so, 'data_ty' => $data_ty]);
    }
    public function cresearchPages($id)
    {
        $data = DB::table('users')->where('employee_id', $id)->get();
        $data_de = DB::table('tb_deliver_lists')->where('status', '1')->get();
        $data_so = DB::table('tb_research_sources')->where('status', '1')->get();
        $data_ty = DB::table('tb_research')->get('type_research_id');
        //dd($data[0]);
        return view('pre-research.admin.Report.report_cresearch')->with(['data' => $data[0], 'id' => $id, 'data_de' => $data_de, 'data_so' => $data_so, 'data_ty' => $data_ty]);
    }

    public function searchAdmin(Request $request)
    {
        $data = DB::table('users')->where('username', $request->id_card)->get();
        return response()->json(['data' => $data]);
    }

    public function approve(Request $request)
    {
        $validation = $request->validate(
            [
                'list_app' => 'required'
            ],
            [
                'list_app.required' => 'โปรดระบุรายการส่งมอบในการทำสัญญา'
            ]
        );
        $db_de = DB::table('tb_deliver_lists')->where('deliver_id', $request->list_app)->get();
        $c_db = DB::table('tb_contracts')->count();
        if ($c_db > 0) {
            $id_con = $c_db + 1;
        } else {
            $id_con = 1;
        }

        $con = new TbContract();
        $con->contract_id = $id_con;
        $con->research_id = $request->id_re;
        $con->date_start_cont = $db_de[0]->Date_start_contract;
        $con->date_end_cont = $db_de[0]->Date_end_contract;
        $con->money_cont = $request->bug;
        $con->deliver_id = $request->list_app;
        $con->contract_status = 'กำลังดำเนินการ';
        $con->updated_at = Carbon::now()->format('Y-m-d H:i:m');
        $con->save();

        DB::table('tb_research')->where('research_id', $request->id_re)->update([
            'research_status' => '11',
            'updated_at' => Carbon::now()->format('Y-m-d H:i:m'),
        ]);
        Alert::success('เพิ่มข้อมูลสัญญาทุนโครงร่างงานวิจัยสำเร็จ');
        return redirect()->back();
        //dd($request->all(),$db_de,$c_db,$id_con);
    }


    public function contractPage($id)
    {
        $data = DB::table('users')
            ->join('tb_majors', 'users.major_id', '=', 'tb_majors.major_id')
            ->join('tb_faculties', 'tb_majors.organization_id', '=', 'tb_faculties.organization_id')
            ->where('employee_id', $id)->get();
        //dd($data[0],$id);
        /* $data_re = DB::table('tb_research')
            ->join('tb_contracts', 'tb_research.research_id', '=', 'tb_contracts.research_id')
            ->whereIn('tb_research.research_status',[11,15])
            ->select('tb_research.*','tb_contracts.*')
            ->get(); */
        $data_re =DB::select('SELECT tb_research.*,tb_contracts.contract_id,tb_contracts.contract_status FROM tb_research LEFT JOIN tb_contracts ON tb_research.research_id=tb_contracts.research_id WHERE tb_research.research_status =11 OR tb_research.research_status =15 order by tb_research.updated_at desc');
        /* DB::table('tb_research')
            //->join('tb_contracts', 'tb_research.research_id', '=', 'tb_contracts.research_id')
            // ->distinct('tb_research.resesarch_id')
            ->where('tb_research.research_status', '=', '11')
            ->orWhere('tb_research.research_status', '=', '15')
            //->groupBy('deliver_id')
            ->orderBy('tb_research.updated_at', 'desc')
            ->get(); */
        // dd($data_re);
        //  $data_de = DB::select('SELECT DISTINCT `deliver_id`,tb_deliver_lists.research_source_id,tb_deliver_lists.Type_research,tb_deliver_lists.status,tb_research_sources.research_sources_id,tb_research_sources.research_source_name FROM `tb_deliver_lists` INNER JOIN tb_research_sources ON tb_deliver_lists.research_source_id = tb_research_sources.research_sources_id WHERE tb_deliver_lists.status = "1" ORDER BY tb_deliver_lists.updated_at DESC');
        $db_cont = DB::table('tb_contracts')
            ->join('tb_research', 'tb_contracts.research_id', '=', 'tb_research.research_id')
            //->where('tb_contracts.research_id','=')
            ->get();
        // $db_de_list = DB::table('tb_deliver_lists')->distinct('tb_deliver_lists.deliver_id')->join('tb_research_sources', 'tb_deliver_lists.research_source_id', '=', 'tb_research_sources.research_sources_id')->where('tb_deliver_lists.status', '=', '1')->select('tb_deliver_lists.*','tb_research_sources.research_source_name')->get();
        //dd($data_re, $db_cont, $db_de_list);
        // $db_de_list = DB::select('SELECT tb_deliver_lists.research_source_id,tb_deliver_lists.Type_research, tb_research_sources.research_sources_id,tb_research_sources.research_source_name FROM tb_deliver_lists LEFT JOIN tb_research_sources ON tb_deliver_lists.research_source_id = tb_research_sources.research_sources_id GROUP BY tb_deliver_lists.deliver_id,tb_deliver_lists.Type_research');
        $db_de_list = DB::table('tb_deliver_lists')
            ->join('tb_research_sources', 'tb_deliver_lists.research_source_id', '=', 'tb_research_sources.research_sources_id')
            ->select('tb_deliver_lists.deliver_id', 'tb_deliver_lists.research_source_id', 'tb_deliver_lists.Type_research', 'tb_research_sources.research_sources_id', 'tb_research_sources.research_source_name')
            //->groupBy('tb_deliver_lists.deliver_id', 'tb_deliver_lists.Type_research','tb_research_sources.research_sources_id')
            ->get();

        return view('pre-research.admin.research_contract')->with(['data' => $data[0], 'id' => $id, 'data_re' => $data_re, 'db_de_list' => $db_de_list]);
    }
}
