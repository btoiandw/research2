<?php

namespace App\Http\Controllers;

use App\Models\TbFeedback;
use App\Models\TbResearch;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class TbFeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //$id = 1;
        $re_referess = $request->referees;

        $data_c = DB::table('tb_feedback')->where('research_id', $request->id_r)->count();
        //dd($request->all(), $data_c);
        //dd($request->all(), $nowDate, $request->referees[0], $request->referees[1], $request->referees[2]);
        if ($data_c > 0) {
            DB::table('tb_feedback')->where('research_id', $request->id_r)->delete();
        }
        for ($i = 0; $i < sizeof($re_referess); $i++) {
            /*   dd($id); */
            $f_feed = new TbFeedback();
            $f_feed->research_id = $request->id_r;
            $f_feed->employee_referees_id = $request->referees[$i];
            $f_feed->date_send_referess = $nowDate;
            $f_feed->save();
            //  $id++;
        }
        $status = '';
        $d_st = DB::table('tb_research')->where('research_id', '=', $request->id_r)->get();

        if ($d_st[0]->research_status == 0) {
            $status = '1';
        } elseif ($d_st[0]->research_status == 3) {
            $status = '4';
        } elseif ($d_st[0]->research_status == 6) {
            $status = '7';
        } else {
            $status = '10';
        }
        // dd($d_st[0]->research_status,$status);
        DB::table('tb_research')
            ->where('research_id', '=', $request->id_r)
            ->update(['research_status' => $status]);
        /*  $research = TbResearch::find($request->id_r);
        $research->research_status = '1';
        $research->save(); */
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TbFeedback  $tbFeedback
     * @return \Illuminate\Http\Response
     */
    public function show(TbFeedback $tbFeedback)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TbFeedback  $tbFeedback
     * @return \Illuminate\Http\Response
     */
    public function edit(TbFeedback $tbFeedback)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TbFeedback  $tbFeedback
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TbFeedback $tbFeedback)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TbFeedback  $tbFeedback
     * @return \Illuminate\Http\Response
     */
    public function destroy(TbFeedback $tbFeedback)
    {
        //
    }

    public function viewFeed($id, $val)
    {
        $data_fe = DB::table('tb_feedback')
            ->join('tb_directors', 'tb_feedback.employee_referees_id', 'tb_directors.employee_referees_id')
            ->join('tb_research', 'tb_feedback.research_id', '=', 'tb_feedback.research_id')
            ->where('tb_feedback.research_id', $id)
            //->where('tb_feedback.employee_referees_id', $val)
            ->get();
        //dd($data_fe);
        return response()->json(['data_fe' => $data_fe]);
    }

    public function addFeed(Request $request)
    {
        $research_id = $request->id_re;
        $direc_id = $request->id_director;
        //DB::update('update research set research_summary_feedback = ?,research_status=? where research_id = ?', [$request->suggestion,'1',$$request->research_id]);
        $data = DB::table('tb_research')
            ->where('research_id', '=', $research_id)
            //->update(['research_summary_feedback'=>$request->suggestion,'research_status'=>'1'])
            ->get();
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
        $status = '';
        if ($data[0]->research_status == 1) {
            $status = '0';
        } elseif ($data[0]->research_status == 4) {
            $status = '3';
        } elseif ($data[0]->research_status == 7) {
            $status = '6';
        } elseif ($data[0]->research_status == 10) {
            $status = '9';
        }


        if ($filefeed != '') {
            $reYear = $data[0]->year_research;
            $file_name = $filefeed->getClientOriginalName();
            $eNamep = explode('.', $file_name);
            $infop = end($eNamep);

            $file = $research_id . "_" . $status . "_" . $direc_id . "_Feedback." . $infop;
            $path = 'uploads/research/' . $reYear . '/' . $research_id; //path save file

            $filefeed->move($path, $file);
        } else {
            $file = null;
        }
        //dd($request->all(), $status, $data, $file, $suggestion, $submit);

        /* if radio ผ่าน/ไม่ผ่าน */
        if ($request->AssessmentResults == 'ไม่ผ่าน') {
            if ($submit == "บันทึก") {
                DB::table('tb_feedback')
                    ->where('employee_referees_id', $direc_id)
                    ->where('research_id', $research_id)
                    ->update(['status' => '0', 'feedback' => $feedResult, 'Assessment_result' => $request->AssessmentResults, 'suggestionFile' => $file]);
                return redirect()->back();

                //DB::update();
            } elseif ($submit == "ส่งการประเมิน") {
                /// DB::update();
                DB::table('tb_feedback')
                    ->where('employee_referees_id', $direc_id)
                    ->where('research_id', $research_id)
                    ->update([
                        'status' => '1',
                        'feedback' => $feedResult,
                        'Assessment_result' => $request->AssessmentResults,
                        'suggestionFile' => $file,
                        'Date_feedback_research' => Carbon::now()->format('Y-m-d H:i:m'),
                    ]);
                return redirect()->back();
            }
        } elseif ($request->AssessmentResults == 'ผ่าน') {
            /// DB::update();

            DB::table('tb_feedback')
                ->where('employee_referees_id', $direc_id)
                ->where('research_id', $research_id)
                ->update([
                    'status' => '1',
                    'feedback' => $feedResult,
                    'Assessment_result' => $request->AssessmentResults,
                    'suggestionFile' => $file,
                    'Date_feedback_research' => Carbon::now()->format('Y-m-d H:i:m'),
                ]);
            return redirect()->back();
        }
    }
    public function FeedDetail($id, $u_id)
    {
        $dt = DB::table('tb_feedback')
            ->join('tb_directors', 'tb_feedback.employee_referees_id', '=', 'tb_directors.employee_referees_id')
            ->join('tb_research', 'tb_feedback.research_id', '=', 'tb_research.research_id')
            ->where('tb_feedback.research_id', $id)
            ->where('tb_feedback.employee_referees_id', $u_id)
            ->get();

        return response()->json(['dt' => $dt]);
    }

    public function sumFeed(Request $request)
    {
        $research_id = $request->id;


        $data = DB::table('tb_research')
            ->where('research_id', $research_id)
            //->update(['research_summary_feedback'=>$request->suggestion,'research_status'=>'1'])
            ->get();

        $reYear = $data[0]->year_research;
        $status_re = $data[0]->research_status;
        $submit = $request->save;
        $suggestion = $request->suggestion;
        $filefeed = $request->file('suggestionFile');
        $u_id = $request->u_id;
        $status = '';
        if ($status_re == 1) {
            $status = '0';
        } elseif ($status_re == 4) {
            $status = '3';
        } elseif ($status_re == 7) {
            $status = '6';
        } elseif ($status_re == 10) {
            $status = '9';
        }
        // dd($request->all(),$u_id,$status, $status_re, $data);
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

            $file = $research_id . "_" . $status . "_SumFeedback." . $infop;
            $path = 'uploads/research/' . $reYear . '/' . $research_id; //path save file
            // dd($request->all(), $data, $file, $suggestion, $submit);
            $filefeed->move($path, $file);
        } else {
            $file = null;
        }
        //

        /* if radio ผ่าน/ไม่ผ่าน */
        if ($request->AssessmentResults == 'ไม่ผ่าน') {
            if ($status == '0') {
                if ($submit == "บันทึก") {
                    DB::table('tb_research')
                        //->where('employee_referees_id', $direc_id)
                        ->where('research_id', $research_id)
                        ->update([
                            //'research_status' => '1',
                            //'feedback' => $feedResult,
                            'research_summary_feedback_0' => $request->suggestion,
                            'summary_feedback_file_0' => $file,
                            'updated_at' => Carbon::now()->format('Y-m-d H:i:m'),
                        ]);
                    return redirect()->route('admin.request', ['id' => $u_id]);
                    //DB::update();
                } elseif ($submit == "ส่งการประเมิน") {
                    /// DB::update();
                    DB::table('tb_research')
                        //->where('employee_referees_id', $direc_id)
                        ->where('research_id', $research_id)
                        ->update([
                            'research_status' => '2',
                            //'feedback' => $feedResult,
                            'research_summary_feedback_0' => $request->suggestion,
                            'summary_feedback_file_0' => $file,
                            'updated_at' => Carbon::now()->format('Y-m-d H:i:m'),
                        ]);
                    return redirect()->route('admin.request', ['id' => $u_id]);
                }
            } elseif ($status == '3') {
                if ($submit == "บันทึก") {
                    DB::table('tb_research')
                        //->where('employee_referees_id', $direc_id)
                        ->where('research_id', $research_id)
                        ->update([
                            //'research_status' => '1',
                            //'feedback' => $feedResult,
                            'research_summary_feedback_1' => $request->suggestion,
                            'summary_feedback_file_1' => $file,
                            'updated_at' => Carbon::now()->format('Y-m-d H:i:m'),
                        ]);
                    return redirect()->route('admin.request', ['id' => $u_id]);
                    //DB::update();
                } elseif ($submit == "ส่งการประเมิน") {
                    /// DB::update();
                    DB::table('tb_research')
                        //->where('employee_referees_id', $direc_id)
                        ->where('research_id', $research_id)
                        ->update([
                            'research_status' => '5',
                            //'feedback' => $feedResult,
                            'research_summary_feedback_1' => $request->suggestion,
                            'summary_feedback_file_1' => $file,
                            'updated_at' => Carbon::now()->format('Y-m-d H:i:m'),
                        ]);
                    return redirect()->route('admin.request', ['id' => $u_id]);
                }
            } elseif ($status == '6') {
                if ($submit == "บันทึก") {
                    DB::table('tb_research')
                        //->where('employee_referees_id', $direc_id)
                        ->where('research_id', $research_id)
                        ->update([
                            //'research_status' => '1',
                            //'feedback' => $feedResult,
                            'research_summary_feedback_2' => $request->suggestion,
                            'summary_feedback_file_2' => $file,
                            'updated_at' => Carbon::now()->format('Y-m-d H:i:m'),
                        ]);
                    return redirect()->route('admin.request', ['id' => $u_id]);


                    //DB::update();
                } elseif ($submit == "ส่งการประเมิน") {
                    /// DB::update();
                    DB::table('tb_research')
                        //->where('employee_referees_id', $direc_id)
                        ->where('research_id', $research_id)
                        ->update([
                            'research_status' => '8',
                            //'feedback' => $feedResult,
                            'research_summary_feedback_2' => $request->suggestion,
                            'summary_feedback_file_2' => $file,
                            'updated_at' => Carbon::now()->format('Y-m-d H:i:m'),
                        ]);
                    return redirect()->route('admin.request', ['id' => $u_id]);
                }
            } else {
                if ($submit == "บันทึก") {
                    DB::table('tb_research')
                        //->where('employee_referees_id', $direc_id)
                        ->where('research_id', $research_id)
                        ->update([
                            //'research_status' => '1',
                            //'feedback' => $feedResult,
                            'research_summary_feedback_3' => $request->suggestion,
                            'summary_feedback_file_3' => $file,
                            'updated_at' => Carbon::now()->format('Y-m-d H:i:m'),
                        ]);
                    return redirect()->route('admin.request', ['id' => $u_id]);
                    //DB::update();
                } elseif ($submit == "ส่งการประเมิน") {
                    /// DB::update();
                    DB::table('tb_research')
                        //->where('employee_referees_id', $direc_id)
                        ->where('research_id', $research_id)
                        ->update([
                            'research_status' => '13',
                            //'feedback' => $feedResult,
                            'research_summary_feedback_3' => $request->suggestion,
                            'summary_feedback_file_3' => $file,
                            'updated_at' => Carbon::now()->format('Y-m-d H:i:m'),
                        ]);
                    return redirect()->route('admin.request', ['id' => $u_id]);
                }
            }
        } elseif ($request->AssessmentResults == 'ผ่าน') {
            /// DB::update();

            DB::table('tb_research')
                //->where('employee_referees_id', $direc_id)
                ->where('research_id', $research_id)
                ->update([
                    'research_status' => '15',
                    //'feedback' => $feedResult,
                    // 'research_summary_feedback' => $request->AssessmentResults,
                    // 'summary_feedback_file' => $file,
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:m'),
                ]);
            return redirect()->route('admin.request', ['id' => $u_id]);
        }
    }

    public function viewFileFeed($id, $val)
    {
        $re = DB::table('tb_research')->where('research_id', $id)->get();

        $year = $re[0]->year_research;
        $re_id = $re[0]->research_id;
        $path = 'uploads/research/' . $year . '/' . $re_id;

        $file = $path . '/' . $val;
        return response()->file($file);

        //dd($id, $val, $file, $year, $re, $re_id, $path);
    }

    public function viewFile($id, $val)
    {
        $re = DB::table('tb_research')->where('research_id', $id)->get();

        $year = $re[0]->year_research;
        $re_id = $re[0]->research_id;
        $path = 'uploads/research/' . $year . '/' . $re_id;

        $file = $path . '/' . $val;
        //dd($id, $val, $file, $year, $re, $re_id, $path);
        return response()->file($file);
    }

    public function viewcComment($id)
    {
        $data = DB::table('tb_research')->where('research_id',$id)->get();
        dd($id,$data);
    }
}
