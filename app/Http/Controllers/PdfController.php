<?php

namespace App\Http\Controllers;

use App\MateriaPrima;
use Illuminate\Http\Request;
use PDF;
class PdfController extends Controller
{
    public  function materiPrima(){
        
        $materiaPrimas = MateriaPrima::all();
        //vista , datos
        $pdf=PDF::loadView('pdf.materiaPrima',['materiaPrimas'=>$materiaPrimas]);
        // return $pdf->stream('materiaPrima.pdf');
        return view('pdf.materiaPrima',compact('materiaPrimas'));
    } 
}
