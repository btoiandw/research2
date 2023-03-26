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
        dd($request->all());
        $allType = array();
        if (count($request->type) == 3 && $type[2] != null) {
            $allType = $type[0] . "_" . $type[1] . "_" . $type[2];
        } elseif (count($type) == 3 && $type[2] == null) {
            $allType = $type[0] . "_" . $type[1];
        } elseif (count($type) == 2) {
            $allType = $type[0] . "_" . $type[1];
        } else {
            $allType = $type[0];
        }

        $c_list = DB::table('tb_deliver_lists')->latest('deliver_id')->first();
        if ($c_list == null) {
            $d_id = 1;
        } else {
            $d_id = $c_list->deliver_id + 1;
        }
        // dd($c_list, $d_id);
        dd($request->all(), Carbon::now()->format('Y-m-d H:i:m'), $request->lesson, $nowDate, $allType, $type);

        for ($i = 0; $i < sizeof($request->lesson); $i++) {
            $deliver = new TbDeliverList();
            $deliver->deliver_id = $d_id;
            $deliver->research_source_id = $request->source_id;
            $deliver->num_lesson = ($i + 1);
            $deliver->Type_research = $allType;
            $deliver->Date_start_contract = $request->contact_start;
            $deliver->Date_end_contract = $request->contact_end;
            $deliver->status = '1';
            $deliver->lesson = $request->lesson[$i];
            $deliver->updated_at = $nowDate;
            // dd($deliver);
            $deliver->save();
        }
        // return $deliver;
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
        //$num = $request->number - 1;
        /* $ls_1 = $request->lesson_1;*/
        $d = DB::table('tb_deliver_lists')->where('deliver_id', $request->id_dl)->delete();

        //dd($request->all());
        $now = Carbon::now()->format('Y-m-d H:i:m');

        for ($i = 0; $i < sizeof($request->lesson); $i++) {

            $dt = new TbDeliverList();
            $dt->lesson = $request->lesson[$i];
            $dt->deliver_id = $request->id_dl;
            $dt->Date_start_contract = $request->contact_start;
            $dt->Date_end_contract = $request->contact_end;
            $dt->num_lesson = ($i + 1);
            $dt->updated_at = $now;
            $dt->research_source_id = $request->s;
            $dt->Type_research = $request->t;

            $dt->save();
            // ->update([
            //     '
            // ]);
        }
        //dd($dt);
        Alert::success('แก้ไขรายการส่งมอบสำเร็จ');
        return redirect()->back();


        //dd($request->all(), sizeof($request->lesson));
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
        $dt = DB::table('tb_deliver_lists')->where('deliver_id', $id)->get();
        //dd($dt);
        $data = DB::update('update tb_deliver_lists set status = 0 where deliver_id = ?', [$id]);
        return response()->json(['status' => true, 'data' => $data]);
    }
}
