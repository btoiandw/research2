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

        $list_user = DB::table('users')->join('tb_admins', 'users.employee_id', '!=', 'tb_admins.employee_id')->get('users.*');
        //dd($list_user);
        $list_fac = DB::table('tb_majors')->join('tb_faculties', 'tb_majors.organization_id', '=', 'tb_faculties.organization_id')->get();
        $list_source = DB::table('tb_research_sources')->get();
        $data = DB::table('users')
            ->join('tb_majors', 'users.major_id', '=', 'tb_majors.major_id')
            ->join('tb_faculties', 'tb_majors.organization_id', '=', 'tb_faculties.organization_id')
            ->where('users.employee_id', $id)
            ->get();
        $data_research = DB::table('tb_research')
            ->join('tb_send_research', 'tb_research.research_id', '=', 'tb_send_research.research_id')
            ->where('tb_send_research.id', '=', $id)
            ->orderBy('tb_research.updated_at', 'desc')
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

        //dd($request->all(), sizeof($request->pc), sizeof($request->type));
        $validation = $request->validate(
            [
                'year_research' => 'required|max:4',
                'research_nameTH' => 'required|unique:tb_research,research_th',
                'research_nameEN' => 'required|unique:tb_research,research_en',
                // 'researcher' => "unique:tb_send_research.research_id,tb_send_research.id",
                // 'researcher.*' => "unique:tb_send_research.research_id,tb_send_research.id",
                //'faculty' => 'required',
                //'faculty.*' => 'required',
                // 'role-research' => 'required',
                // 'role-research.*' => 'required',
                'pc' => 'required',
                'pc.*' => 'required|',
                'source_id' => 'required',
                // 'type' => 'required',
                // 'type.*' => 'required',
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
                // "researcher.unique:tb_send_research.research_id,tb_send_research.id" => 'โปรดระบุชื่อนักวิจัยไม่ซ้ำกัน',
                // "researcher.*.unique:tb_send_research.research_id,tb_send_research.id" => 'โปรดระบุชื่อนักวิจัยไม่ซ้ำกัน',
                //'faculty.required' => 'โปรดระบุสังกัด/คณะ',
                //'faculty.*.required' => 'โปรดระบุสังกัด/คณะ',
                // 'role-research.required' => 'โปรดระบุบทบาทในการวิจัย',
                // 'role-research.*.required' => 'โปรดระบุบทบาทในการวิจัย',
                'pc.required' => 'โปรดระบุร้อยละบทบาทในการวิจัย',
                'pc.*.required' => 'โปรดระบุร้อยละบทบาทในการวิจัย',
                'source_id.required' => 'โปรดระบุชื่อแหล่งทุน',
                // 'type.required' => 'โปรดระบุประเภทในการวิจัย',
                // 'type.*.required' => 'โปรดระบุประเภทในการวิจัย',
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
        if (count($request->type) == 3 && $type[2] != null) {
            $allType = $type[0] . "_" . $type[1] . "_" . $type[2];
        } elseif (count($type) == 3 && $type[2] == null) {
            $allType = $type[0] . "_" . $type[1];
        } else {
            $allType = $type[0];
        }
        //dd($type[0], count($type), $allType, $request->all(), sizeof($request->pc), sizeof($request->type));
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


                            for ($i = 0; $i <= sizeof($pc_re); $i++) {
                                $da_send = DB::table('tb_send_research')->where('research_id', $id_re)->get();
                                //dd($da_send, $request->all(), sizeof($pc_re), $sumpc, $pc_re, $id_re, $area, $allType, $fileName_w, $fileName_p);
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


                                if (!$send->save()) {
                                    Alert::error('โปรดระบุชื่อนักวิจัยไม่ซ้ำกัน');
                                    return redirect()->back();
                                } else {
                                    $send->save();
                                }
                            }
                            //dd($send);

                            $research = new TbResearch();
                            $research->research_id = $id_re;
                            $research->date_upload_file_0 = $nowDate;
                            $research->research_th = $request->research_nameTH;
                            $research->research_en = $request->research_nameEN;
                            $research->research_source_id = $request->source_id;
                            $research->type_research_id = $allType;
                            $research->keyword = $request->keyword;
                            $research->date_research_start = $request->sdate;
                            $research->date_research_end = $request->edate;
                            $research->research_area = $area;
                            $research->budage_research = $request->budage;
                            $research->word_file_0 = $fileName_w;
                            $research->pdf_file_0 = $fileName_p;
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
            ->join('tb_majors', 'users.major_id', '=', 'tb_majors.major_id')
            ->join('tb_faculties', 'tb_majors.organization_id', '=', 'tb_faculties.organization_id')
            ->where('tb_research.research_id', '=', $id)
            ->get();
        $data_r = DB::table('tb_research')
            ->join('tb_send_research', 'tb_research.research_id', '=', 'tb_send_research.research_id')
            ->join('users', 'tb_send_research.id', '=', 'users.employee_id')
            ->where('tb_research.research_id', '=', $id)
            ->get('tb_send_research.id');
        $data_feed = DB::table('tb_feedback')->where('research_id', $id)->get();
        //dd($data_r);
        /* for ($i = 0; $i < sizeof($data_re); $i++) {
            //$data_u[$i] = $data_re[$i]->employee_id;
            $data_u = DB::table('users')->where('employee_id', '!=', $data_re->employee_id)->get('employee_id');
        } */
        //dd($id, $data_u);
        return response()->json(['data_re' => $data_re, 'data_feed' => $data_feed]);
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
        $send_old = DB::table('tb_send_research')->where('research_id', $request->id)->get();
        $research = DB::table('tb_research')
            ->where('research_id', $request->id)
            ->first();
        $researcher_id = array();
        $researcher_pc = array();

        $send_e = DB::table('tb_send_research')->where('research_id', $request->id)->delete();
        $area = $request->ad . '_' . $request->ct . '_' . $request->zp;
        //dd($request->all(), $send_old, sizeof($researcher_id), sizeof($researcher_pc), $area, sizeof($request->pc_ed));
        //$research[0]->save();
        if ($request->file('f_pdf') || $request->file('f_word')) {
            $path = 'uploads/research/' . $research->year_research . '/' . $request->id;

            if ($research->word_file_3 != null) {
                $file_name_word = $research->word_file_3;
            } elseif ($research->word_file_2 != null) {
                $file_name_word = $research->word_file_2;
            } elseif ($research->word_file_1 != null) {
                $file_name_word = $research->word_file_1;
            } else {
                $file_name_word = $research->word_file_0;
            }

            if ($research->pdf_file_3 != null) {
                $file_name_pdf = $research->pdf_file_3;
            } elseif ($research->pdf_file_2 != null) {
                $file_name_pdf = $research->pdf_file_2;
            } elseif ($research->pdf_file_1 != null) {
                $file_name_pdf = $research->pdf_file_1;
            } else {
                $file_name_pdf = $research->pdf_file_0;
            }
            $file_word = $path . '/' . $file_name_word;
            $file_pdf = $path . '/' . $file_name_pdf;
            $status = '';
            if ($research->research_status == 0 || $research->research_status == 2) {
                $status = '0';
            } elseif ($research->research_status == 3 || $research->research_status == 5) {
                $status = '3';
            } elseif ($research->research_status == 6 || $research->research_status == 8) {
                $status = '6';
            } elseif ($research->research_status == 9) {
                $status = '9';
            }
            //dd($status, $research->research_status, $file_name_pdf, $file_name_word, $file_word, $file_pdf);
            if ($file_p = $request->file('f_pdf')) {
                File::delete(public_path($file_pdf));
                $namep = $file_p->getClientOriginalName();
                $eNamep = explode('.', $namep);
                $infop = end($eNamep);
                $fileName_p = $research->research_id . "_" . $status . "." . $infop;
                $file_p->move($path, $fileName_p);

                if ($status == '0') {
                    DB::table('tb_research')->where('research_id', $request->id)->update([
                        'pdf_file_0' => $fileName_p,
                        'date_upload_file_0' => Carbon::now()->format('Y-m-d H:i:m'),
                        'updated_at' => Carbon::now()->format('Y-m-d H:i:m'),
                    ]);
                } elseif ($status == '3') {
                    DB::table('tb_research')->where('research_id', $request->id)->update([
                        'pdf_file_1' => $fileName_p,
                        'date_upload_file_1' => Carbon::now()->format('Y-m-d H:i:m'),
                        'updated_at' => Carbon::now()->format('Y-m-d H:i:m'),
                    ]);
                } elseif ($status == '6') {
                    DB::table('tb_research')->where('research_id', $request->id)->update([
                        'pdf_file_2' => $fileName_p,
                        'date_upload_file_2' => Carbon::now()->format('Y-m-d H:i:m'),
                        'updated_at' => Carbon::now()->format('Y-m-d H:i:m'),
                    ]);
                } elseif ($status == '9') {
                    DB::table('tb_research')->where('research_id', $request->id)->update([
                        'pdf_file_3' => $fileName_p,
                        'date_upload_file_3' => Carbon::now()->format('Y-m-d H:i:m'),
                        'updated_at' => Carbon::now()->format('Y-m-d H:i:m'),
                    ]);
                } else {
                }
            }

            if ($file_w = $request->file('f_word')) {
                File::delete(public_path($file_word));
                $namew = $file_w->getClientOriginalName();
                $eNamew = explode('.', $namew);
                $infow = end($eNamew);
                $fileName_w = $research->research_id . "_" . $status . "." . $infow;

                $file_w->move($path, $fileName_w);

                if ($status == '0') {
                    DB::table('tb_research')->where('research_id', $request->id)->update([
                        'word_file_0' => $fileName_w,
                        'date_upload_file_0' => Carbon::now()->format('Y-m-d H:i:m'),
                        'updated_at' => Carbon::now()->format('Y-m-d H:i:m'),
                    ]);
                } elseif ($status == '3') {
                    DB::table('tb_research')->where('research_id', $request->id)->update([
                        'word_file_1' => $fileName_w,
                        'date_upload_file_1' => Carbon::now()->format('Y-m-d H:i:m'),
                        'updated_at' => Carbon::now()->format('Y-m-d H:i:m'),
                    ]);
                } elseif ($status == '6') {
                    DB::table('tb_research')->where('research_id', $request->id)->update([
                        'word_file_2' => $fileName_w,
                        'date_upload_file_2' => Carbon::now()->format('Y-m-d H:i:m'),
                        'updated_at' => Carbon::now()->format('Y-m-d H:i:m'),
                    ]);
                } elseif ($status == '9') {
                    DB::table('tb_research')->where('research_id', $request->id)->update([
                        'word_file_3' => $fileName_w,
                        'date_upload_file_3' => Carbon::now()->format('Y-m-d H:i:m'),
                        'updated_at' => Carbon::now()->format('Y-m-d H:i:m'),
                    ]);
                } else {
                }
            }
            //return redirect()->back()->with('success_edit');
        }

        //dd($file_p->move($path, $fileName_p), $file_w->move($path, $fileName_w));

        try {

            for ($i = 1; $i <= sizeof($request->pc_ed); $i++) {
                $send = new TbSendResearch();
                $send->research_id = $request->id;
                $send->id = $request->researcher_ed[$i];
                $send->pc = $request->pc_ed[$i];

                $send->save();
            }
        } catch (\Exception $e) {
            /* for ($i = 0; $i < sizeof($send_old); $i++) {
                // $researcher_id[$i] = $send_old[$i]->id;
                // $researcher_pc[$i] = $send_old[$i]->pc;
                $send_o = new TbSendResearch();
                $send_o->research_id = $send_old[$i]->research_id;
                $send_o->id = $send_old[$i]->id;
                $send_o->pc = $send_old[$i]->pc;
                $send_o->save();
            } */
            Alert::error('โปรดระบุชื่อนักวิจัยไม่ซ้ำกัน');
            return redirect()->back();
        }

        $re = DB::table('tb_research')->where('research_id', $request->id)->update([
            'research_th' => $request->TH,
            'research_en' => $request->EN,
            'keyword' => $request->keyword,
            'research_area' => $area,
            'date_research_start' => $request->sdate,
            'date_research_end' => $request->edate,
            'budage_research' => $request->budage,
            'updated_at' => Carbon::now()->format('Y-m-d H:i:m'),
        ]);

        // $research->save();
        Alert::success('แก้ไขข้อมูลโครงร่างงานวิจัยสำเร็จ!');
        return redirect()->back()->with('success_edit');
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
        $p = DB::table('tb_research')->select('*')->where('research_id', '=', $id)->first();


        $path = 'uploads/research/' . $p->year_research . '/' . $p->research_id;
        //$u = Auth::user()->id;
        if ($p->word_file_3 != null) {
            $file_name = $p->word_file_3;
        } elseif ($p->word_file_2 != null) {
            $file_name = $p->word_file_2;
        } elseif ($p->word_file_1 != null) {
            $file_name = $p->word_file_1;
        } else {
            $file_name = $p->word_file_0;
        }

        //dd($d);
        $file = $path . '/' . $file_name;
        //dd($p,$path,$file_name,$file);
        return response()->file($file);
    }
    public function viewFilePDF($id)
    {
        $p = DB::table('tb_research')->where('research_id', '=', $id)->first();

        $path = 'uploads/research/' . $p->year_research . '/' . $p->research_id;
        //$u = Auth::user()->id;
       // dd($path, $p);
        if ($p->pdf_file_3 != null) {
            $file_name = $p->pdf_file_3;
        } elseif ($p->pdf_file_2 != null) {
            $file_name = $p->pdf_file_2;
        } elseif ($p->pdf_file_1 != null) {
            $file_name = $p->pdf_file_1;
        } else {
            $file_name = $p->pdf_file_0;
        }
        //dd($d);
        $file = $path . '/' . $file_name;
        //dd($file_name, $file, $p);
        return response()->file($file);
    }

    public function cancel($id)
    {
        DB::table('tb_research')->where('research_id', $id)->update([
            'research_status' => '12',
            'updated_at' => Carbon::now()->format('Y-m-d H:i:m'),
        ]);
        return response()->json(['status' => true]);
    }


    public function adminComment(Request $request)
    {
        //dd($request->all());
        $research_id = $request->id_f_ad;


        $data = DB::table('tb_research')
            ->where('research_id', $research_id)
            //->update(['research_summary_feedback'=>$request->suggestion,'research_status'=>'1'])
            ->get();
        //dd($request->all(), $data);
        $reYear = $data[0]->year_research;
        $submit = $request->save;
        $suggestion = $request->suggestion;
        $filefeed = $request->file('suggestionFile');

        //dd($u,$filefeed);
        if ($suggestion != '') {
            $feedResult = $suggestion;
        } else {
            $feedResult = null;
        }

        if ($filefeed != '') {
            $reYear = $data[0]->year_research;
            $file_name = $filefeed->getClientOriginalName();
            $eNamep = explode('.', $file_name);
            $infop = end($eNamep);

            $file = $research_id . "_0_SumFeedback." . $infop;
            $path = 'uploads/research/' . $reYear . '/' . $research_id; //path save file

            $filefeed->move($path, $file);
        } else {
            $file = null;
        }
        // dd($request->all(), $data, $file, $suggestion, $submit);

        /* if radio ผ่าน/ไม่ผ่าน */
        if ($request->AssessmentResults == 'ไม่ผ่าน') {
            if ($submit == "บันทึก") {
                DB::table('tb_research')
                    //->where('employee_referees_id', $direc_id)
                    ->where('research_id', $research_id)
                    ->update([
                        //'research_status' => '1',
                        //'feedback' => $feedResult,
                        'research_summary_feedback' => $request->AssessmentResults,
                        'summary_feedback_file' => $file,
                        'updated_at' => Carbon::now()->format('Y-m-d H:i:m'),
                    ]);
                return redirect()->back();

                //DB::update();
            } elseif ($submit == "ส่งการประเมิน") {
                /// DB::update();
                DB::table('tb_research')
                    //->where('employee_referees_id', $direc_id)
                    ->where('research_id', $research_id)
                    ->update([
                        'research_status' => '14',
                        //'feedback' => $feedResult,
                        'research_summary_feedback' => $request->AssessmentResults,
                        'summary_feedback_file' => $file,
                        'updated_at' => Carbon::now()->format('Y-m-d H:i:m'),
                    ]);
                return redirect()->back();
            }
        }
    }

    public function viewSumFeed($id, $val)
    {
        //dd($id, $val);
        $p = DB::table('tb_research')->select('*')->where('research_id', '=', $id)->get();

        $path = 'uploads/research/' . $p[0]->year_research . '/' . $p[0]->research_id;
        //$u = Auth::user()->id;
        if ($p[0]->summary_feedback_file_0 == $val) {
            $file_name = $p[0]->summary_feedback_file_0;
        } elseif ($p[0]->summary_feedback_file_1 == $val) {
            $file_name = $p[0]->summary_feedback_file_1;
        } elseif ($p[0]->summary_feedback_file_2 == $val) {
            $file_name = $p[0]->summary_feedback_file_2;
        } else {
            $file_name = $p[0]->summary_feedback_file_3;
        }
        // $file_name = $p[0]->word_file;
        //dd($d);
        $file = $path . '/' . $file_name;
        //dd($p, $path, $file_name, $file);
        return response()->file($file);
    }

    public function addET(Request $request)
    {
        $validation = $request->validate(
            [
                'word' => 'required|file|mimes:doc,docx',
                'pdf' => 'required|file|mimes:pdf'
            ],
            [
                'word.required' => 'โปรดระบุไฟล์ word',
                'pdf.required' => 'โปรดระบุไฟล์ pdf',
                'word.mimes' => 'โปรดระบุไฟล์ word นามสกุล .doc และ .docx เท่านั้น',
                'pdf.mimes' => 'โปรดระบุไฟล์ pdf นามสกุล .pdf เท่านั้น',
            ]
        );
        $data_e = DB::table('tb_research')->where('research_id', $request->e1_id)->get();
        $status = '';
        if ($data_e[0]->research_status == 2) {
            $status = '3';
        } elseif ($data_e[0]->research_status == 5) {
            $status = '6';
        } elseif ($data_e[0]->research_status == 8) {
            $status = '9';
        }

        if ($filew = $request->file('word')) {
            if ($filep = $request->file('pdf')) {
                //get ชื่อไฟล์จากที่กรอก
                $namep = $filep->getClientOriginalName();
                $name = $filew->getClientOriginalName();

                //แยกชื่ออกจากนามสกุลไฟล์ word
                $eNamew = explode('.', $name);
                $infow = end($eNamew);
                //mix name+status to file name
                $fileName_w = $data_e[0]->research_id . "_" . $status . "." . $infow; //ทำการรวมตัวแปร $id กับ $status และ $infow
                //แยกชื่ออกจากนามสกุลไฟล์ pdf
                $eNamep = explode('.', $namep);
                $infop = end($eNamep);
                $fileName_p = $data_e[0]->research_id . "_" . $status . "." . $infop;

                $path = 'uploads/research/' . $data_e[0]->year_research . '/' . $data_e[0]->research_id;
                //$filew->move('uploads/research/'.$reYear.'/'.$id_re, $fileName_w);
                if ($filew->move($path, $fileName_w)) { //move=>เซฟในโฟลเดอร์ ''=>''แรกชื่อโฟลเดอร์ $name=>ชื่อไฟล์  ->จะอยู่ในโฟลเดอร์ public
                    if ($filep->move($path, $fileName_p)) {

                        if ($data_e[0]->research_status == 2) {
                            DB::table('tb_research')
                                ->where('research_id', '=', $request->e1_id)
                                ->update([
                                    'research_status' => $status,
                                    'word_file_1' => $fileName_w,
                                    'pdf_file_1' => $fileName_p,
                                    'date_upload_file_1' => Carbon::now()->format('Y-m-d H:i:m'),
                                    'updated_at' => Carbon::now()->format('Y-m-d H:i:m'),
                                ]);
                        } elseif ($data_e[0]->research_status == 5) {
                            DB::table('tb_research')
                                ->where('research_id', '=', $request->e1_id)
                                ->update([
                                    'research_status' => $status,
                                    'word_file_2' => $fileName_w,
                                    'pdf_file_2' => $fileName_p,
                                    'date_upload_file_2' => Carbon::now()->format('Y-m-d H:i:m'),
                                    'updated_at' => Carbon::now()->format('Y-m-d H:i:m'),
                                ]);
                        } elseif ($data_e[0]->research_status == 8) {
                            DB::table('tb_research')
                                ->where('research_id', '=', $request->e1_id)
                                ->update([
                                    'research_status' => $status,
                                    'word_file_3' => $fileName_w,
                                    'pdf_file_3' => $fileName_p,
                                    'date_upload_file_3' => Carbon::now()->format('Y-m-d H:i:m'),
                                    'updated_at' => Carbon::now()->format('Y-m-d H:i:m'),
                                ]);
                        }
                        Alert::success('เพิ่มไฟล์ปรับแก้สำเร็จ');
                        return redirect()->back();
                    }
                }
            }
        }


        //dd($request->all(), $data_e[0]->research_status);
    }
}
