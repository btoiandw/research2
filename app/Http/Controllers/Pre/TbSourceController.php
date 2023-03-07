<?php

namespace App\Http\Controllers\Pre;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TbSourceController extends Controller
{
    //
    public function manageSource($id)
    {
        $data = DB::table('users')->where('employee_id', $id)->get();
        $data_s = DB::table('tb_research_sources')->get();
        //dd($data_s);
        return view('pre-research.admin.manage_source')->with(['id' => $id, 'data' => $data[0], 'data_s' => $data_s]);
    }
}
