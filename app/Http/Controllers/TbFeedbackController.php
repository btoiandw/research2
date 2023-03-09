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
        for ($i = 0; $i < 3; $i++) {
            $f_feed = new TbFeedback();
            $f_feed->research_id = $request->id_r;
            $f_feed->employee_referees_id = $request->referees[$i];
            $f_feed->date_send_referess = $nowDate;
            $f_feed->save();
        }
        DB::table('tb_research')
            ->where('research_id','=',$request->id_r)
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
}
