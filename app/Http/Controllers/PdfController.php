<?php

namespace App\Http\Controllers;

use App\MateriaPrima;
use App\Modelo;
use App\Proveedor;
use Illuminate\Http\Request;
use PDF;
use Psy\Util\Str;

class PdfController extends Controller
{
    public  function materiaPrima(Request $request){
        $materiaPrimas = MateriaPrima::all();
        // CONSANTES
        $_FILTRO_MAXIMO=3;
        $_OPTION_VACIO='Cualquiera';
        
        //******************************* Obtenemos los filtros y contamos cuantos hay ******************************************* */

        $filtro_nombre = $request->filtro_nombre;
        $filtro_cantidad = $request->filtro_cantidad;
        
        $filtro_modelo=Modelo::find($request->filtro_modelo);
        //si no existe el ID que paso entonces le asignamos EL valor VACIO que esta de CONSTANTE
        $filtro_modelo = ($filtro_modelo==null) ? $_OPTION_VACIO : $filtro_modelo ;  
          
        $cantidad_filtros=0;
        if(($filtro_nombre!='')){
            $cantidad_filtros++;
        }
        if($filtro_modelo!=$_OPTION_VACIO){
            $cantidad_filtros++;
        }
        if($filtro_cantidad!=''){
            $cantidad_filtros++;
        }
        

        //******************************* Si no pide filtros devuelve todas las materias primas ******************************************* */

        if($cantidad_filtros==0){

            $pdf=PDF::loadView('pdf.materiaPrima',['materiaPrimas'=>$materiaPrimas]);
            $dom_pdf = $pdf->getDomPDF();
            $canvas = $dom_pdf->get_canvas();
            $y = $canvas->get_height() - 35;
            $pdf->getDomPDF()->get_canvas()->page_text(500, $y, "Pagina {PAGE_NUM} de {PAGE_COUNT}", null, 10, array(0, 0, 0));
          
            return $pdf->stream();
        }
        
        
        //******************************* Si pide  todos los filtros entra aca ******************************************* */
        
        if($cantidad_filtros==$_FILTRO_MAXIMO){
            
            foreach ($materiaPrimas as $key => $materia) {
                $filtro_completos=0;
                //la materia prima contiene al modelo del filtro entonces suma
                $materia->modelos->contains($filtro_modelo)? $filtro_completos++ : 0;
                //la materia prima contiene la cantidad del filtro entonces suma
                ($filtro_cantidad==$materia->cantidad)? $filtro_completos++ :0;
                //la materia prima contiene el nombre del filtro entonces suma
                (str_contains(strtoupper($materia->nombre),  strtoupper($filtro_nombre)))? $filtro_completos++ :0;
                //si cummple con los tres filtro no hace nada, si no cumple con uno borra de la lista
                $filtro_completos==$cantidad_filtros? true:$materiaPrimas->pull($key);
            }
            $pdf=PDF::loadView('pdf.materiaPrima',['materiaPrimas'=>$materiaPrimas]);
            $dom_pdf = $pdf->getDomPDF();
            $canvas = $dom_pdf->get_canvas();
            $y = $canvas->get_height() - 35;
            $pdf->getDomPDF()->get_canvas()->page_text(500, $y, "Pagina {PAGE_NUM} de {PAGE_COUNT}", null, 10, array(0, 0, 0));
          
            return $pdf->stream('pdf.materiaPrima');
        }
        //******************************* Si pide 1 o 2 filtro entra aca ******************************************* */
        foreach ($materiaPrimas as $key => $materia) {
            
            $filtro_completos=0;
            //si la meteria prima tiene el modelo del filtro se suma el filtro completo
            if(($filtro_modelo!=$_OPTION_VACIO)){
                $materia->modelos->contains($filtro_modelo)? $filtro_completos++ : 0;
            }
            //si la meteria prima tiene la cantidad de materia prima del filtro se suma el filtro completo
            if(($filtro_cantidad>-1)){
                ($filtro_cantidad==$materia->cantidad)? $filtro_completos++ :0;
            }
            //si la meteria prima tiene el nombre del filtro se suma el filtro completo
            if(($filtro_nombre!='')){
                (str_contains(strtoupper($materia->nombre),  strtoupper($filtro_nombre)))? $filtro_completos++ :0;
            }
            //si la materia prima no cumple con algun filtro se borra de la lista
            $filtro_completos==$cantidad_filtros? true:$materiaPrimas->pull($key);
        }

        
        $pdf=PDF::loadView('pdf.materiaPrima',['materiaPrimas'=>$materiaPrimas,
        'filtro_nombre'=>$filtro_nombre,'filtro_cantidad'=>$filtro_cantidad,'filtro_modelo'=>$filtro_modelo]);
        // return $pdf->stream('pdf.materiaPrima');
        $dom_pdf = $pdf->getDomPDF();

        $canvas = $dom_pdf->get_canvas();
        $y = $canvas->get_height() - 35;
        $pdf->getDomPDF()->get_canvas()->page_text(500, $y, "Pagina {PAGE_NUM} de {PAGE_COUNT}", null, 10, array(0, 0, 0));
      
        return $pdf->stream();
        // return view('pdf.materiaPrima',compact('materiaPrimas'));
    } 

    public  function proveedor(Request $request){
        $proveedores = Proveedor::all();
        // CONSANTES
        $_FILTRO_MAXIMO=3;
        $_OPTION_VACIO='Cualquiera';
        
        //******************************* Obtenemos los filtros y contamos cuantos hay ******************************************* */

        $filtro_nombre = $request->filtro_nombre;
        $filtro_documento = $request->filtro_documento;
        $filtro_email = $request->filtro_email;
        
          
        $cantidad_filtros=0;
        if(($filtro_nombre!='')){
            $cantidad_filtros++;
        }
        if(($filtro_documento!='')){
            $cantidad_filtros++;
        }
        if(($filtro_email!='')){
            $cantidad_filtros++;
        }
       
        //******************************* Si no pide filtros devuelve todas las materias primas ******************************************* */

        if($cantidad_filtros==0){
            $pdf=PDF::loadView('pdf.proveedor',['proveedores'=>$proveedores,'filtro_nombre'=>$filtro_nombre,
            'filtro_documento'=>$filtro_documento,'filtro_email'=>$filtro_email]);
            return $pdf->stream('pdf.proveedor');
        }
        
        
        //******************************* Si pide  todos los filtros entra aca ******************************************* */
        
        if($cantidad_filtros==$_FILTRO_MAXIMO){
            
            foreach ($proveedores as $key => $proveedor) {
                $filtro_completos=0;
                //la proveedor prima contiene el nombre del filtro entonces suma
                (str_contains(strtoupper($proveedor->nombre),  strtoupper($filtro_nombre)))? $filtro_completos++ :0;
                foreach ($proveedor->documentos as $key => $documento) {
                    // if($filtro_documento==$documento->numero){
                    if(str_contains(strtoupper($documento->numero),  strtoupper($filtro_documento))){
                        $filtro_completos++;
                        break;
                    }
                }

                (str_contains(strtoupper($proveedor->email),  strtoupper($filtro_email)))? $filtro_completos++ :0;
                //si cummple con los tres filtro no hace nada, si no cumple con uno borra de la lista
                $filtro_completos==$cantidad_filtros? true:$proveedores->pull($key);
            }
            $pdf=PDF::loadView('pdf.proveedor',['proveedores'=>$proveedores]);
            return $pdf->stream('pdf.proveedor');
        }
        //******************************* Si pide 1 o 2 filtro entra aca ******************************************* */
        foreach ($proveedores as $key => $proveedor) {
            
            $filtro_completos=0;
           
            //si la meteria prima tiene el nombre del filtro se suma el filtro completo
            if(($filtro_nombre!='')){
                (str_contains(strtoupper($proveedor->nombre),  strtoupper($filtro_nombre)))? $filtro_completos++ :0;
            }

            if(($filtro_documento!='')){
                foreach ($proveedor->documentos as $key => $documento) {
                    if(str_contains(strtoupper($documento->numero),  strtoupper($filtro_documento))){
                        $filtro_completos++;
                        break;
                    }
                }
            }

            if(($filtro_email!='')){
                (str_contains(strtoupper($proveedor->email),  strtoupper($filtro_email)))? $filtro_completos++ :0;
            }
            //si la materia prima no cumple con algun filtro se borra de la lista
            $filtro_completos==$cantidad_filtros? true:$proveedores->pull($key);
        }

        $pdf=PDF::loadView('pdf.proveedor',['proveedores'=>$proveedores]);
        return $pdf->stream('pdf.proveedor');
        // return view('pdf.materiaPrima',compact('proveedores'));
    } 
}
