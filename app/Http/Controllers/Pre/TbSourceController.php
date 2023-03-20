<?php

namespace App\Http\Controllers\Pre;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Carbon;
use function GuzzleHttp\Promise\all;

class TbSourceController extends Controller
{
    //
    public function manageSource($id)
    {
        $data = DB::table('users')->where('employee_id', $id)->get();
        $data_s = DB::table('tb_research_sources')->where('status', '=', '1')->get();
        //dd($data_s);
        return view('pre-research.admin.manage_source')->with(['id' => $id, 'data' => $data[0], 'data_s' => $data_s]);
    }

    public function viewSource($id)
    {
        $data = DB::table('tb_research_sources')->where('research_sources_id', $id)->get();
        //dd($data);
        return response()->json(['data' => $data]);
    }

    public function cancelSource($id)
    {
        $data = DB::update('update tb_research_sources set status = 0 where research_sources_id = ?', [$id]);
        return response()->json(['status' => true, 'data' => $data]);
    }

    public function edit(Request $request)
    {
        $source = DB::table('tb_research_sources')->where('research_sources_id', $request->id)->get();
        $file_ex = $source[0]->ex_research;

        $path = 'uploads/source/' . $source[0]->Year_source;
        $file_old = $path . '/' . $file_ex;
        if ($file_p = $request->file('file')) {

            File::delete(public_path($file_old));
            $namep = $file_p->getClientOriginalName();
            $eNamep = explode('.', $namep);
            $infop = end($eNamep);

            $fileName_p = $source[0]->Year_source . "_" . $source[0]->research_source_name . "." . $infop;
            $file_p->move($path, $fileName_p);
            DB::table('tb_research_sources')->where('research_sources_id', $request->id)->update([
                'ex_research' => $fileName_p,
                'updated_at' => Carbon::now()->format('Y-m-d H:i:m'),
            ]);
            //dd($request->all(), $source, $file_p, $file_ex, $fileName_p, $path);
        }

        $re = DB::table('tb_research_sources')->where('research_sources_id', $request->id)->update([
            'research_source_name' => $request->name_so,
            'type_research_source' => $request->type,
            'updated_at' => Carbon::now()->format('Y-m-d H:i:m'),
        ]);

        return redirect()->back()->with('edit_success');

        // $data = DB::update('update tb_research_sources set votes = 100 where research_sources_id = ?', ['John']);

    }

    public function viewFile($id)
    {
        $p = DB::table('tb_research_sources')->select('*')->where('research_sources_id', '=', $id)->get();

        $path = 'uploads/source/' . $p[0]->Year_source;
        //$u = Auth::user()->id;

        $file_name = $p[0]->ex_research;
        //dd($d);
        $file = $path . '/' . $file_name;
        //dd($p,$path,$file_name,$file,$p[0]->word_file);
        return response()->file($file);
    }
}
