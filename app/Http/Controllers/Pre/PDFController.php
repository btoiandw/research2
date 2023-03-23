<?php

namespace App\Http\Controllers\Pre;

use App\Http\Controllers\Controller;
// use Barryvdh\DomPDF\PDF;
use PDF;
use Illuminate\Http\Request;

class PDFController extends Controller
{
    //
    public function generatePDF()
    {
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
