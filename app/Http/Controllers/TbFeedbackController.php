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
        //dd($request->all(), $nowDate, $request->referees[0], $request->referees[1], $request->referees[2]);
        for ($i = 0; $i < sizeof($re_referess); $i++) {
            /*   dd($id); */
            $f_feed = new TbFeedback();
            $f_feed->research_id = $request->id_r;
            $f_feed->employee_referees_id = $request->referees[$i];
            $f_feed->date_send_referess = $nowDate;
            $f_feed->save();
            //  $id++;
        }

        DB::table('tb_research')
            ->where('research_id', '=', $request->id_r)
            ->update(['research_status' => '1']);
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

    public function viewFeed($id)
    {
        $data_fe = DB::table('tb_feedback')
            ->join('tb_directors', 'tb_feedback.employee_referees_id', 'tb_directors.employee_referees_id')
            ->join('tb_research', 'tb_feedback.research_id', '=', 'tb_feedback.research_id')
            ->where('tb_feedback.research_id', $id)
            ->get();
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

        if ($filefeed != '') {
            $reYear = $data[0]->year_research;
            $file_name = $filefeed->getClientOriginalName();
            $eNamep = explode('.', $file_name);
            $infop = end($eNamep);

            $file = $research_id . "_0_" . $direc_id . "_Feedback." . $infop;
            $path = 'uploads/research/' . $reYear . '/' . $research_id; //path save file

            $filefeed->move($path, $file);
        } else {
            $file = null;
        }
        // dd($request->all(), $data, $file, $suggestion, $submit);

        /* if radio ผ่าน/ไม่ผ่าน */
        if ($request->AssessmentResults == 'ไม่ผ่าน') {
            if ($submit == "บันทึก") {
                DB::table('tb_feedback')
                    ->where('employee_referees_id', $direc_id)
                    ->where('research_id', $research_id)
                    ->update(['status' => '0', 'feedback' => $feedResult, 'Assessment_result' => $request->AssessmentResults, 'suggestionFile' => $file]);
                return redirect()->back();

                //DB::update();
            } elseif ($submit == "ยืนยัน") {
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
                    'status' => 'ตรวจสอบแล้ว',
                    'feedback' => $feedResult,
                    'Assessment_result' => $request->AssessmentResults,
                    'suggestionFile' => $file,
                    'Date_feedback_research' => Carbon::now()->format('Y-m-d H:i:m'),
                ]);
            return redirect()->back();
        }
    }
}
