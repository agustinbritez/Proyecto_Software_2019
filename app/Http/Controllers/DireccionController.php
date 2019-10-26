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
            'domicilio'     =>  'required|integer',
            'calle_id'    =>  'required',
            'localidad_id'    =>  'required',
            'provincia_id'    =>  'required',
            'pais_id'    =>  'required',
        ];;
        
        $messages = [
            
            'domicilio.required' => 'Agregar el numero de la direccion',
            'domicilio.integer' => 'El domicilio debe ser un valor entero',
            'calle_id.required' => 'Agregar la calle de la direccion',
            'localidad_id.required' => 'Agregar la localidad de la direccion',
            'provincia_id.required' => 'Agregar la provincia de la direccion',
            'pais_id.required' => 'Agregar el pais de la direccion'
        ];
        $this->validate($request, $rules, $messages);

        $direccion = Direccion::where('numero',$request->domicilio)->where('calle_id',$request->calle_id)
        ->where('localidad_id',$request->localidad_id)
        ->where('provincia_id',$request->provincia_id)
        ->where('pais_id',$request->pais_id)->first();

        
        if($direccion==null){
            $direccion = Direccion::create([
                'numero'    =>  $request->domicilio,
                'calle_id'    =>  $request->calle_id,
                'localidad_id'    =>  $request->localidad_id,
                'provincia_id'    =>  $request->provincia_id,
                'pais_id'    =>  $request->pais_id
            ]);
            
        }
     
        
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
