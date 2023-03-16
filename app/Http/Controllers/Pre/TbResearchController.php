<?php

namespace App\Http\Controllers\Pre;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\TbResearch;
use App\Models\TbSendResearch;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

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
        $data = DB::table('users')
            ->join('tb_faculties', 'users.organization_id', '=', 'tb_faculties.id')
            ->where('users.employee_id', $id)
            ->get();
        $data_research = DB::table('tb_research')
            ->join('tb_send_research', 'tb_research.research_id', '=', 'tb_send_research.research_id')
            ->where('tb_send_research.id', '=', $id)
            ->get();
        //dd($id,$roles,$data,$list_source,$list_fac,$list_user,$data_research);
        return view('pre-research.research.add_research')->with([
            'id' => $id,
            'roles' => $roles,
            'data' => $data,
            'list_source' => $list_source,
            'list_fac' => $list_fac,
            'list_user' => $list_user,
            'data_research' => $data_research,
            //'users_login'=>DB::table('users')->where('users.employee_id', $id)
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

        //dd($request->all(), $request->pc[0], $request->pc[2], $request->pc[3], sizeof($request->pc));
        $validation = $request->validate(
            [
                'year_research' => 'required|max:4',
                'research_nameTH' => 'required|unique:tb_research,research_th',
                'research_nameEN' => 'required|unique:tb_research,research_en',
                'researcher' => 'required',
                'researcher.*' => 'required',
                //'faculty' => 'required',
                //'faculty.*' => 'required',
                // 'role-research' => 'required',
                // 'role-research.*' => 'required',
                'pc' => 'required',
                'pc.*' => 'required|',
                'source_id' => 'required',
                'type' => 'required',
                'type.*' => 'required',
                'keyword' => 'required',
                'address' => 'required',
                'city' => 'required',
                'zipcode' => 'required',
                'sdate' => 'required|date',
                'edate' => 'required|date|after:start_date',
                'budage' => 'required|numeric',
                'word' => 'required|file|mimes:doc,docx',
                'pdf' => 'required|file|mimes:pdf'
            ],
            [
                'year_research.required' => 'ข้อมูลห้ามเกิน 4 ตัว',
                'research_nameTH.required' => 'โปรดระบุชื่อโครงร่างภาษาไทย',
                'research_nameEN.required' => 'โปรดระบุชื่อโครงร่างภาษาอังกฤษ',
                'researcher.required' => 'โปรดระบุชื่อนักวิจัย',
                'researcher.*.required' => 'โปรดระบุชื่อนักวิจัย',
                //'faculty.required' => 'โปรดระบุสังกัด/คณะ',
                //'faculty.*.required' => 'โปรดระบุสังกัด/คณะ',
                // 'role-research.required' => 'โปรดระบุบทบาทในการวิจัย',
                // 'role-research.*.required' => 'โปรดระบุบทบาทในการวิจัย',
                'pc.required' => 'โปรดระบุร้อยละบทบาทในการวิจัย',
                'pc.*.required' => 'โปรดระบุร้อยละบทบาทในการวิจัย',
                'source_id.required' => 'โปรดระบุชื่อแหล่งทุน',
                'type.required' => 'โปรดระบุประเภทในการวิจัย',
                'type.*.required' => 'โปรดระบุประเภทในการวิจัย',
                'keyword.required' => 'โปรดระบุคำสำคัญในการวิจัย',
                'address.required' => 'โปรดระบุพื้นที่ในการวิจัย',
                'city.required' => 'โปรดระบุพื้นที่ในการวิจัย',
                'zipcode.required' => 'โปรดระบุพื้นที่ในการวิจัย',
                //'area_research.required' => '',
                'sdate.required' => 'โปรดระบุวันที่เริ่มทำการวิจัย',
                'edate.required' => 'โปรดระบุวันที่สิ้นสุดการทำการวิจัย',
                'budage.required' => 'โปรดระบุจำนวนเงินในการทำการวิจัย',
                'word.required' => 'โปรดระบุไฟล์ word และเป็นไฟล์ word เท่านั้น',
                'pdf.required' => 'โปรดระบุไฟล์ pdf และเป็นไฟล์ pdf เท่านั้น',
                'word.mimes' => 'โปรดระบุไฟล์ word เท่านั้น',
                'pdf.mimes' => 'โปรดระบุเป็นไฟล์ pdf เท่านั้น',
                'edate.after:start_date' => ' วันสิ้นสุดต้องหลังวันเริ่มต้น'
            ]
        );

        $nowDate = Carbon::now()->format('Y-m-d H:i:m');
        $type = $request->type;
        //$cType = count($type);
        $allType = array();
        if (count($type) > 1) {
            $allType = $type[0] . "_" . $type[1];
        } else {
            $allType = $type[0];
        }
        //dd($type[0], count($type), $allType);
        $address = $request->address;
        $city = $request->city;
        $zipcode = $request->zipcode;
        $area = $address . "_" . $city . "_" . $zipcode;

        //dd($type,$allType,$request->all());
        $re_id = DB::table('tb_research')->count();
        if ($re_id == 0) {
            $id_re = 1;
        } else {
            $id_re = $re_id + 1;
        }
        //dd($id);
        $reYear = $request->year_research;
        $status = 0; //รอการตรวจสอบ

        //หา id user ตามชื่อที่กรอกมา

        /* $rc = $request->researcher;
        $us = array();
        $result = DB::table('users')->whereIn('full_name_th', $rc)->get('employee_id'); //whereIn ใช้กับ where array
        //dd($result,$id_re,$area,$allType);
        for ($i = 0; $i < sizeof($rc); $i++) {
            if (empty($result[$i])) {
                $us = $request->researcher[$i];
                Alert::error('ไม่พบข้อมูลชื่อ-นามสกุลนักวิจัย', $us);
                return redirect()->back();
                //dd($rc, $result, sizeof($rc), $us,$i);
            }
        } */


        //เช็คค่าร้อยละงานวิจัยว่าครบ100มั้ย
        $pc = collect($request->pc);  //collect=>จับ array เป็นกลุ่มเพื่อนับจำนวน
        $sumpc = $pc->reduce(function ($value, $sum) { //reduce => ค่าทุกตัวบวกกัน
            return $sum + $value;
        });

        if ($sumpc > 100) {
            Alert::error('ร้อยละบทบาทในการวิจัยไม่ควรเกิน 100');
            return redirect()->back();
        } elseif ($sumpc < 100) {
            Alert::error('ร้อยละบทบาทในการวิจัยไม่ควรน้อยกว่า 100');
            return redirect()->back();
        } else {
            if ($filew = $request->file('word')) {
                if ($filep = $request->file('pdf')) {
                    //get ชื่อไฟล์จากที่กรอก
                    $namep = $filep->getClientOriginalName();
                    $name = $filew->getClientOriginalName();

                    //แยกชื่ออกจากนามสกุลไฟล์ word
                    $eNamew = explode('.', $name);
                    $infow = end($eNamew);
                    //mix name+status to file name
                    $fileName_w = $id_re . "_" . $status . "." . $infow; //ทำการรวมตัวแปร $id กับ $status และ $infow
                    //แยกชื่ออกจากนามสกุลไฟล์ pdf
                    $eNamep = explode('.', $namep);
                    $infop = end($eNamep);
                    $fileName_p = $id_re . "_" . $status . "." . $infop;

                    $path = 'uploads/research/' . $reYear . '/' . $id_re;
                    //$filew->move('uploads/research/'.$reYear.'/'.$id_re, $fileName_w);
                    if ($filew->move($path, $fileName_w)) { //move=>เซฟในโฟลเดอร์ ''=>''แรกชื่อโฟลเดอร์ $name=>ชื่อไฟล์  ->จะอยู่ในโฟลเดอร์ public
                        if ($filep->move($path, $fileName_p)) {
                            $pc_re = $request->pc;
                            //dd($request->all(), $result, $pc_re, $id_re, $area, $allType, $us, $sumpc, $fileName_w, $fileName_p);
                            for ($i = 0; $i <= sizeof($pc_re); $i++) {
                                if ($i == 0) {
                                    $send = new TbSendResearch();
                                    $send->research_id = $id_re;
                                    $send->id = $request->id_users;
                                    $send->pc = $request->pc[0];
                                } elseif ($i == 1) {
                                } else {
                                    $send = new TbSendResearch();
                                    $send->research_id = $id_re;
                                    $send->id = $request->researcher[$i];
                                    $send->pc = $request->pc[$i];
                                }
                                $send->save();
                            }
                            //dd($send);

                            $research = new TbResearch();
                            $research->research_id = $id_re;
                            $research->date_upload_file = $nowDate;
                            $research->research_th = $request->research_nameTH;
                            $research->research_en = $request->research_nameEN;
                            $research->research_source_id = $request->source_id;
                            $research->type_research_id = $allType;
                            $research->keyword = $request->keyword;
                            $research->date_research_start = $request->sdate;
                            $research->date_research_end = $request->edate;
                            $research->research_area = $area;
                            $research->budage_research = $request->budage;
                            $research->word_file = $fileName_w;
                            $research->pdf_file = $fileName_p;
                            $research->research_status = $status;
                            $research->year_research = $reYear;
                            $research->save();
                            //dd( $research,/*$send*/ );
                            if ($research->save() && $send->save()) {
                                return redirect()->back()->with('success');
                            }
                        }
                    }
                }
            }
        }
        //dd($request->all());
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
        $data_re = DB::table('tb_research')
            ->join('tb_send_research', 'tb_research.research_id', '=', 'tb_send_research.research_id')
            ->join('tb_research_sources', 'tb_research.research_source_id', '=', 'tb_research_sources.research_sources_id')
            ->join('users', 'tb_send_research.id', '=', 'users.employee_id')
            ->join('tb_faculties', 'users.organization_id', '=', 'tb_faculties.id')
            ->where('tb_research.research_id', '=', $id)
            ->get();
        return response()->json(['data_re' => $data_re]);
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
    public function update(Request $request)
    {
        //
        $research = DB::table('tb_research')
            ->where('research_id', $request->id)
            ->first();
        //dd($research) ;
        $area = $request->ad . '_' . $request->ct . '_' . $request->zp;

        //$research[0]->save();
        $path = 'uploads/research/' . $research->year_research . '/' . $request->id;
        $file_word = $path . '/' . $research->word_file;
        $file_pdf = $path . '/' . $research->pdf_file;
        if ($file_p = $request->file('f_pdf')) {
            File::delete(public_path($file_pdf));
            $namep = $file_p->getClientOriginalName();
            $eNamep = explode('.', $namep);
            $infop = end($eNamep);
            $fileName_p = $research->research_id . "_0." . $infop;

            $file_p->move($path, $fileName_p);
        }

        if ($file_w = $request->file('f_word')) {
            File::delete(public_path($file_word));
            $namew = $file_w->getClientOriginalName();
            $eNamew = explode('.', $namew);
            $infow = end($eNamew);
            $fileName_w = $research->research_id . "_0." . $infow;

            $file_w->move($path, $fileName_w);
        }
        //dd($file_p->move($path, $fileName_p), $file_w->move($path, $fileName_w));

        $re = DB::table('tb_research')->where('research_id', $request->id)->update([
            'research_th' => $request->TH,
            'research_en' => $request->EN,
            'keyword' => $request->keyword,
            'research_area' => $area,
            'date_research_start' => $request->sdate,
            'date_research_end' => $request->edate,
            'research_th' => $request->budage,
            'pdf_file' => $fileName_p,
            'word_file' => $fileName_w,
            'updated_at' => Carbon::now()->format('Y-m-d H:i:m'),
        ]);
        // $research->save();
        if ($re) {
            return redirect()->back()->with('success_edit');
        }
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

    public function addDirector($id)
    {
        //modal add director
        $data_re = DB::table('tb_research')
            ->join('tb_research_sources', 'tb_research.research_source_id', '=', 'tb_research_sources.research_sources_id')
            ->join('tb_send_research', 'tb_research.research_id', '=', 'tb_send_research.research_id')
            ->join('users', 'tb_send_research.id', '=', 'users.employee_id')
            ->where('tb_research.research_id', '=', $id)
            ->get();

        return response()->json(['data_re' => $data_re]);
    }

    public function viewFile($id)
    {
        $p = DB::table('tb_research')->select('*')->where('research_id', '=', $id)->get();

        $path = 'uploads/research/' . $p[0]->year_research . '/' . $p[0]->research_id;
        //$u = Auth::user()->id;

        $file_name = $p[0]->word_file;
        //dd($d);
        $file = $path . '/' . $file_name;
        //dd($p,$path,$file_name,$file,$p[0]->word_file);
        return response()->file($file);
    }
    public function viewFilePDF($id)
    {
        $p = DB::table('tb_research')->select('*')->where('research_id', '=', $id)->get();

        $path = 'uploads/research/' . $p[0]->year_research . '/' . $p[0]->research_id;
        //$u = Auth::user()->id;

        $file_name = $p[0]->pdf_file;
        //dd($d);
        $file = $path . '/' . $file_name;
        //dd($file_name,$file);
        return response()->file($file);
    }
}
