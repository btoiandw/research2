<?php

namespace App\Http\Controllers\Pre;

use App\Http\Controllers\Controller;
// use Barryvdh\DomPDF\PDF;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PDFController extends Controller
{
    //
    public function generatePDF(Request $request)
    {
        $dc = DB::table('tb_contracts')
            ->join('tb_research', 'tb_contracts.research_id', '=', 'tb_research.research_id')
            ->join('tb_deliver_lists', 'tb_contracts.deliver_id', '=', 'tb_deliver_lists.deliver_id')
            ->join('tb_research_sources', 'tb_deliver_lists.research_source_id', '=', 'tb_research_sources.research_sources_id')
            ->join('tb_send_research', 'tb_research.research_id', '=', 'tb_send_research.research_id')
            ->join('users', 'tb_send_research.id', '=', 'users.employee_id')
            ->get();
        dd($request->all(), $dc);
        $data = [
            'title' => 'Welcome to CodeSolutionStuff.com',
            'date' => date('m/d/Y'),
            'source_name' => 'PMU',
            'year' => '2565'
        ];

        $pdf = PDF::loadView('pre-research/testPdf', $data)->setPaper('a4');

        return $pdf->stream('test.pdf');
    }
}
