<?php

namespace App\Http\Controllers\Pre;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TbDirectorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id, $roles)
    {
        //
        $data = DB::table('tb_directors')->where('employee_referees_id', $id)->get();
        return view('pre-research.director.index')->with(['id' => $id, 'roles' => $roles, 'data' => $data]);
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

    public function feedPages($id, $roles)
    {
        if ($roles == 4) {
            $data = DB::table('tb_directors')->where('employee_id', $id)->get();
            //dd($data[0]->employee_referees_id);
            $re = DB::table('tb_feedback')
                ->join('tb_directors', 'tb_feedback.employee_referees_id', '=', 'tb_directors.employee_referees_id')
                ->join('tb_research', 'tb_feedback.research_id', '=', 'tb_research.research_id')
                ->where('tb_feedback.employee_referees_id', '=', $data[0]->employee_referees_id)
                ->get();
        } else {
            $data = DB::table('tb_directors')->where('employee_referees_id', $id)->get();
            $re = DB::table('tb_feedback')
                ->join('tb_directors', 'tb_feedback.employee_referees_id', '=', 'tb_directors.employee_referees_id')
                ->join('tb_research', 'tb_feedback.research_id', '=', 'tb_research.research_id')
                ->where('tb_feedback.employee_referees_id', '=', $id)
                ->get();
        }
       // dd($id, $roles, $data, $re);
        return view('pre-research.director.feedback_research')->with(['id' => $id, 'roles' => $roles, 'data' => $data, 're' => $re]);
    }
}
