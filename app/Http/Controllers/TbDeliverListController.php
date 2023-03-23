<?php

namespace App\Http\Controllers;

use App\Models\TbDeliverList;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;

class TbDeliverListController extends Controller
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
        $validation = $request->validate(
            [
                'source_id' => 'required',
                'source_id.*' => 'required',
                'type' => 'required',
                'type.*' => 'required',
                'contact_start' => 'required|date',
                'contact_end' => 'required|date',
            ],
            [
                'source_id.required' => 'โปรดระบุแหล่งทุนงานวิจัย',
                'source_id.*.required' => 'โปรดระบุแหล่งทุนงานวิจัย',
                'type.required' => 'โปรดระบุประเภทงานวิจัย',
                'type.*.required' => 'โปรดระบุประเภทงานวิจัย',
                'contact_start.required' => 'โปรดระบุวันที่เริ่มต้นสัญญาวิจัย',
                'contact_end.required' => 'โปรดระบุวันที่สิ้นสุดสัญญาวิจัย',
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
        //
        if (sizeof($request->lesson) == 1) {
            $lesson1 = $request->lesson[0];
            $lesson2 = null;
            $lesson3 = null;
            $lesson4 = null;
            $lesson5 = null;
            $lesson6 = null;
            $lesson7 = null;
            $lesson8 = null;
            $lesson9 = null;
            $lesson10 = null;
        } elseif (sizeof($request->lesson) == 2) {
            $lesson1 = $request->lesson[0];
            $lesson2 = $request->lesson[1];
            $lesson3 = null;
            $lesson4 = null;
            $lesson5 = null;
            $lesson6 = null;
            $lesson7 = null;
            $lesson8 = null;
            $lesson9 = null;
            $lesson10 = null;
        } elseif (sizeof($request->lesson) == 3) {
            $lesson1 = $request->lesson[0];
            $lesson2 = $request->lesson[1];
            $lesson3 = $request->lesson[2];
            $lesson4 = null;
            $lesson5 = null;
            $lesson6 = null;
            $lesson7 = null;
            $lesson8 = null;
            $lesson9 = null;
            $lesson10 = null;
        } elseif (sizeof($request->lesson) == 4) {
            $lesson1 = $request->lesson[0];
            $lesson2 = $request->lesson[1];
            $lesson3 = $request->lesson[2];
            $lesson4 = $request->lesson[3];
            $lesson5 = null;
            $lesson6 = null;
            $lesson7 = null;
            $lesson8 = null;
            $lesson9 = null;
            $lesson10 = null;
        } elseif (sizeof($request->lesson) == 5) {
            $lesson1 = $request->lesson[0];
            $lesson2 = $request->lesson[1];
            $lesson3 = $request->lesson[2];
            $lesson4 = $request->lesson[3];
            $lesson5 = $request->lesson[4];
            $lesson6 = null;
            $lesson7 = null;
            $lesson8 = null;
            $lesson9 = null;
            $lesson10 = null;
        } elseif (sizeof($request->lesson) == 6) {
            $lesson1 = $request->lesson[0];
            $lesson2 = $request->lesson[1];
            $lesson3 = $request->lesson[2];
            $lesson4 = $request->lesson[3];
            $lesson5 = $request->lesson[4];
            $lesson6 = $request->lesson[5];
            $lesson7 = null;
            $lesson8 = null;
            $lesson9 = null;
            $lesson10 = null;
        } elseif (sizeof($request->lesson) == 7) {
            $lesson1 = $request->lesson[0];
            $lesson2 = $request->lesson[1];
            $lesson3 = $request->lesson[2];
            $lesson4 = $request->lesson[3];
            $lesson5 = $request->lesson[4];
            $lesson6 = $request->lesson[5];
            $lesson7 = $request->lesson[6];
            $lesson8 = null;
            $lesson9 = null;
            $lesson10 = null;
        } elseif (sizeof($request->lesson) == 8) {
            $lesson1 = $request->lesson[0];
            $lesson2 = $request->lesson[1];
            $lesson3 = $request->lesson[2];
            $lesson4 = $request->lesson[3];
            $lesson5 = $request->lesson[4];
            $lesson6 = $request->lesson[5];
            $lesson7 = $request->lesson[6];
            $lesson8 = $request->lesson[7];
            $lesson9 = null;
            $lesson10 = null;
        } elseif (sizeof($request->lesson) == 9) {
            $lesson1 = $request->lesson[0];
            $lesson2 = $request->lesson[1];
            $lesson3 = $request->lesson[2];
            $lesson4 = $request->lesson[3];
            $lesson5 = $request->lesson[4];
            $lesson6 = $request->lesson[5];
            $lesson7 = $request->lesson[6];
            $lesson8 = $request->lesson[7];
            $lesson9 = $request->lesson[8];
            $lesson10 = null;
        } else {
            $lesson1 = $request->lesson[0];
            $lesson2 = $request->lesson[1];
            $lesson3 = $request->lesson[2];
            $lesson4 = $request->lesson[3];
            $lesson5 = $request->lesson[4];
            $lesson6 = $request->lesson[5];
            $lesson7 = $request->lesson[6];
            $lesson8 = $request->lesson[7];
            $lesson9 = $request->lesson[8];
            $lesson10 = $request->lesson[9];
        }

        //dd($request->all(), sizeof($request->lesson), $nowDate, $allType, $type);
        $deliver = new TbDeliverList();
        $deliver->research_source_id = $request->source_id;
        $deliver->Type_research = $allType;
        $deliver->Date_start_contract = $request->contact_start;
        $deliver->Date_end_contract = $request->contact_end;
        $deliver->status = '1';
        $deliver->lesson1 = $lesson1;
        $deliver->lesson2 = $lesson2;
        $deliver->lesson3 = $lesson3;
        $deliver->lesson4 = $lesson4;
        $deliver->lesson5 = $lesson5;
        $deliver->lesson6 = $lesson6;
        $deliver->lesson7 = $lesson7;
        $deliver->lesson8 = $lesson8;
        $deliver->lesson9 = $lesson9;
        $deliver->lesson10 = $lesson10;

        //dd($deliver);
        $deliver->save();
        Alert::success('เพิ่มข้อมูลรายการส่งมอบสำเร็จ');
        return redirect()->back();

        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TbDeliverList  $tbDeliverList
     * @return \Illuminate\Http\Response
     */
    public function show(TbDeliverList $tbDeliverList)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TbDeliverList  $tbDeliverList
     * @return \Illuminate\Http\Response
     */
    public function edit(TbDeliverList $tbDeliverList)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TbDeliverList  $tbDeliverList
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TbDeliverList $tbDeliverList)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TbDeliverList  $tbDeliverList
     * @return \Illuminate\Http\Response
     */
    public function destroy(TbDeliverList $tbDeliverList)
    {
        //
    }

    public function view($id)
    {
        $data_dl = DB::table('tb_deliver_lists')
            ->join('tb_research_sources', 'tb_deliver_lists.research_source_id', '=', 'tb_research_sources.research_sources_id')
            ->where('tb_deliver_lists.deliver_id', $id)
            ->get();
        //$list = DB::table('tb_deliver_lists')->get();
        return response()->json(['data_dl' => $data_dl]);
    }

    public function cancel($id)
    {
        $data = DB::update('update tb_deliver_lists set status = 0 where deliver_id = ?', [$id]);
        return response()->json(['status' => true, 'data' => $data]);
    }
}
