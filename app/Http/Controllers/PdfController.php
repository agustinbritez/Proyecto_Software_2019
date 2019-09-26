<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
class PdfController extends Controller
{
    public  function materiPrima($request){
        
        
        //vista , datos
        $pdf=PDF::loadView('pdf.materiaPrima',[]);
        return $pdf->stream('materiaPrima.pdf');
    } 
}
