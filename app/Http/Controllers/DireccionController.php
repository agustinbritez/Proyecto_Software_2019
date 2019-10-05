<?php

namespace App\Http\Controllers;

use App\Direccion;
use Illuminate\Http\Request;

class DireccionController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $direcciones=Direccion::all();
        return view ('direccion.index',compact('direcciones'));
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
        
     
        $rules = [
            'calle'    =>  'required',
            'numero'    =>  'required|integer',
            'codigoPostal'    =>  'required|integer',
            'localidad'    =>  'required',
            'provincia'    =>  'required',
            'pais'    =>  'required',
            
        ];
        
        $messages = [
            'calle.required'=>'Agregar la calle de la direccion',
            'numero.required'=>'Agregar el numero de la direccion',
            'codigoPostal.required'=>'Agregar el codigo postal de la direccion',
            'localidad.required'=>'Agregar la localidad de la direccion',
            'provincia.required'=>'Agregar la provincia de la direccion',
            'pais.required'=>'Agregar el pais de la direccion',
            
            'numero.integer' => 'El numero debe ser un valor entero',
            'codigoPostal.integer' => 'El codigo postal debe ser un valor entero'
        ];
        
        $this->validate($request, $rules, $messages);
        
        $form_data = array(
            'calle'    =>  $request->calle,
            'numero'    =>  $request->numero,
            'codigoPostal'    =>  $request->codigoPostal,
            'localidad'    =>  $request->localidad,
            'provincia'    =>  $request->provincia,
            'pais'    =>  $request->pais
        );
    
        $direccion=Direccion::create($form_data);
     
        
return redirect()->back()->with('success','Direccion Creada Con Exito!');
    }
    
    /**
    * Display the specified resource.
    *
    * @param  \App\Direccion  $direccion
    * @return \Illuminate\Http\Response
    */
    public function show(Direccion $direccion)
    {
        //
    }
    
    /**
    * Show the form for editing the specified resource.
    *
    * @param  \App\Direccion  $direccion
    * @return \Illuminate\Http\Response
    */
    public function edit($id)
    {
        if (request()->ajax()) {
            $data = Direccion::findOrFail($id);

            return response()->json([
                'data' => $data, 
            ]);
        }
    }
    
    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\Direccion  $direccion
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, Direccion $direccion)
    {
        
        $rules = [
            'calle'    =>  'require',
            'numero'    =>  'required|integer',
            'codigoPostal'    =>  'required|integer',
            'localidad'    =>  'required',
            'provincia'    =>  'required',
            'pais'    =>  'required',
            
        ];
        
        $messages = [
            'calle.required'=>'Agregar la calle de la direccion',
            'numero.required'=>'Agregar el numero de la direccion',
            'codigoPostal.required'=>'Agregar el codigo postal de la direccion',
            'localidad.required'=>'Agregar la localidad de la direccion',
            'provincia.required'=>'Agregar la provincia de la direccion',
            'pais.required'=>'Agregar el pais de la direccion',
            
            'numero.integer' => 'El numero debe ser un valor entero',
            'codigoPostal.integer' => 'El codigo postal debe ser un valor entero'
        ];
        
        $this->validate($request, $rules, $messages);
        
        $form_data = array(
            'calle'    =>  $request->calle,
            'numero'    =>  $request->numero,
            'codigoPostal'    =>  $request->codigoPostal,
            'localidad'    =>  $request->localidad,
            'provincia'    =>  $request->provincia,
            'pais'    =>  $request->pais
        );
    
        

        //si el id que crea es uno borrado lo revivimos
        $materiaPrima = MateriaPrima::find($request->hidden_id);

        $materiaPrima->update($form_data);
    
        // return response()->json(['success' => 'Materia Prima Actualizada Correctamente']);
        return redirect()->back()->with('success', 'Actualizado Correctamente');
    }
    
    /**
    * Remove the specified resource from storage.
    *
    * @param  \App\Direccion  $direccion
    * @return \Illuminate\Http\Response
    */
    public function destroy(Request $request)
    {
        $direccion = Direccion::find($request->boton_delete);
        $direccion->delete();
        return redirect()->back();
    }
}
