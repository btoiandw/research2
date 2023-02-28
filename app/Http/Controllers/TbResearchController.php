<?php

namespace App\Http\Controllers;

use App\Models\TbResearch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

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
        return view('research.add_research')->with([
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
                'research_nameTH' => 'required|unique:research,research_th',
                'research_nameEN' => 'required|unique:research,research_en',
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
                'sdate' => 'required|date|after:tomorrow',
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
                'pdf.mimes' => 'โปรดระบุเป็นไฟล์ pdf เท่านั้น'
            ]
        );
        dd($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TbResearch  $tbResearch
     * @return \Illuminate\Http\Response
     */
    public function show(TbResearch $tbResearch)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TbResearch  $tbResearch
     * @return \Illuminate\Http\Response
     */
    public function edit(TbResearch $tbResearch)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TbResearch  $tbResearch
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TbResearch $tbResearch)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TbResearch  $tbResearch
     * @return \Illuminate\Http\Response
     */
    public function destroy(TbResearch $tbResearch)
    {
        //
    }
}
