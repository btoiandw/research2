<?php

namespace App\Http\Controllers\Pre;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\TbResearch;
use App\Models\TbSendResearch;
use Illuminate\Support\Carbon;

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
        return view('pre-research.research.add_research')->with([
            'id' => $id,
            'roles' => $roles,
            'data' => $data,
            'list_source' => $list_source,
            'list_fac' => $list_fac,
            'list_user' => $list_user,
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
        $validation = $request->validate(
            [
                'year_research' => 'required|max:4',
                'research_nameTH' => 'required|unique:tb_research,research_th',
                'research_nameEN' => 'required|unique:tb_research,research_en',
                'researcher' => 'required',
                'researcher.*' => 'required',
                //'faculty' => 'required',
                //'faculty.*' => 'required',
                'role-research' => 'required',
                'role-research.*' => 'required',
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
                'role-research.required' => 'โปรดระบุบทบาทในการวิจัย',
                'role-research.*.required' => 'โปรดระบุบทบาทในการวิจัย',
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
        if (count($request->type) > 1) {
            $allType = $type[0] . "_" . $type[1];
        } else {
            $allType = $type;
        }
        //dd($type, count($type), $allType);
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

        $rc = $request->researcher;
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
        }


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
                            //dd($request->all(), $result, $id_re, $area, $allType, $us, $sumpc, $fileName_w, $fileName_p);
                            for ($i = 0; $i < sizeof($rc); $i++) {
                                $send = new TbSendResearch();
                                $send->research_id = $id_re;
                                $send->id = $result[$i]->employee_id;
                                $send->pc = $request->pc[$i];
                                $send->save();
                                /* DB::insert(
                                    'insert into tb_send_research (research_id,id,pc) values (?, ?,?)',
                                    $id_re,
                                    $result[$i],
                                    $request->pc[$i]
                                ); */
                            }

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
                            if ($research->save() && $send->save()) {
                                return redirect()->back()->with('success');
                            }

                            //dd($research,$send);
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
}
