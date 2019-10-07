<?php

namespace App\Http\Controllers;

use App\Direccion;
use App\Documento;
use App\Proveedor;
use Illuminate\Http\Request;
use DataTables;

class ProveedorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $proveedores = Proveedor::all();
        $documentos= Documento::all();
        return view('proveedor.index', compact('proveedores','documentos'));
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
            'nombre'    =>  'required',
            'email'     =>  'required',
            'razonSocial'     =>  'required',
            'calle'    =>  'required',
            'numero'    =>  'required|integer',
            'codigoPostal'    =>  'required|integer',
            'localidad'    =>  'required',
            'provincia'    =>  'required',
            'pais'    =>  'required',
            // 'documento_nombre'     =>  'required',
            // 'documento_numero'     =>  'required',

            // 'direccion_calle'     =>  'required',
            // 'direccion_numero'     =>  'required'
            // 'direccion_postal'     =>  'required',
            // 'direccion_pais'     =>  'required',
            // 'direccion_provincia'     =>  'required',
            // 'direccion_localidad'     =>  'required',
        ];

        $messages = [
            'nombre.required' => 'Agrega el nombre del proveedor.',
            'email.required' => 'Agrega el email del proveedor.',
            'razonSocial.required' => 'Agrega la  razonSocial del proveedor.',
            'calle.required' => 'Agregar la calle de la direccion',
            'numero.required' => 'Agregar el numero de la direccion',
            'codigoPostal.required' => 'Agregar el codigo postal de la direccion',
            'localidad.required' => 'Agregar la localidad de la direccion',
            'provincia.required' => 'Agregar la provincia de la direccion',
            'pais.required' => 'Agregar el pais de la direccion',

            'numero.integer' => 'El numero debe ser un valor entero',
            'codigoPostal.integer' => 'El codigo postal debe ser un valor entero',

            // 'documento_nombre.required' => 'Agrega el tipo de documento',
            // 'documento_numero.required' => 'Agrega el numero del documento',

            // 'direccion_calle'     =>  'Agrega la calle del proveedor',
            // 'direccion_numero'     =>  'Agrega el numero de la calle del proveedor'
        ];

        $this->validate($request, $rules, $messages);
        // $documento=Documento::create([
        //     'nombre'=>$request->documento_nombre,
        //     'numero'=>$request->documento_numero
        //     ]);

        //     $direccion=Direccion::create([
        //         'calle'=>$request->direccion_calle,
        //         'numero'=>$request->direccion_numero,
        //         'codigopostal'=>$request->direccion_codigoPostal,
        //         'pais'=>$request->direccion_pais,
        //         'provincia'=>$request->direccion_provincia,
        //         'localidad'=>$request->direccion_localidad
        //         ]);   
        $direccion = Direccion::create([
            'calle'    =>  $request->calle,
            'numero'    =>  $request->numero,
            'codigoPostal'    =>  $request->codigoPostal,
            'localidad'    =>  $request->localidad,
            'provincia'    =>  $request->provincia,
            'pais'    =>  $request->pais
        ]);
        

        $form_data = array(
            'nombre'        =>  $request->nombre,
            'email'         =>  $request->email,
            'razonSocial'         =>  $request->razonSocial,
            'numeroDocumento' => $request->numeroDocumento,
            'direccion_id' => $direccion->id,
            'documento_id' => $request->documento_id
        );
        //si no crea es porque hay agun atributo que no permite null que esta vacio
        $proveedor = Proveedor::create($form_data);
        // $proveedor->documentos()->sync($documento);
        // $proveedor->direcciones()->sync($direccion);
        // return response()->json(['success' => 'Materia Prima Guardada Con Exito.']);
        return redirect()->back()->with('success', 'Proveedor creado con exito!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Proveedor  $proveedor
     * @return \Illuminate\Http\Response
     */
    public function show(Proveedor $proveedor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Proveedor  $proveedor
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (request()->ajax()) {
            $data = Proveedor::findOrFail($id);
            $totalDocumento= Documento::all();
            return response()->json(['data' => $data,'totalDocumento'=>$totalDocumento,
            'documento'=>$data->documento,
            'direccion'=>$data->direccion
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Proveedor  $proveedor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $rules = [
            'nombre'    =>  'required',
            'email'     =>  'required',
            'razonSocial'     =>  'required',

            // 'documento_nombre'     =>  'required',
            // 'documento_numero'     =>  'required',

            // 'direccion_calle'     =>  'required',
            // 'direccion_numero'     =>  'required'
            // 'direccion_postal'     =>  'required',
            // 'direccion_pais'     =>  'required',
            // 'direccion_provincia'     =>  'required',
            // 'direccion_localidad'     =>  'required',
        ];

        $messages = [
            'nombre.required' => 'Agrega el nombre del proveedor.',
            'email.required' => 'Agrega el email del proveedor.',
            'razonSocial.required' => 'Agrega la  razonSocial del proveedor.',

            // 'documento_nombre.required' => 'Agrega el tipo de documento',
            // 'documento_numero.required' => 'Agrega el numero del documento',

            // 'direccion_calle'     =>  'Agrega la calle del proveedor',
            // 'direccion_numero'     =>  'Agrega el numero de la calle del proveedor'
        ];

        $this->validate($request, $rules, $messages);
        // $documento=Documento::create([
        //     'nombre'=>$request->documento_nombre,
        //     'numero'=>$request->documento_numero
        //     ]);

        //     $direccion=Direccion::create([
        //         'calle'=>$request->direccion_calle,
        //         'numero'=>$request->direccion_numero,
        //         'codigopostal'=>$request->direccion_codigoPostal,
        //         'pais'=>$request->direccion_pais,
        //         'provincia'=>$request->direccion_provincia,
        //         'localidad'=>$request->direccion_localidad
        //         ]);   

        $proveedor = Proveedor::find($request->hidden_id);
        $proveedor->update($request->all());
        // $proveedor->documentos()->sync($documento);
        // $proveedor->direcciones()->sync($direccion);
        // return response()->json(['success' => 'Materia Prima Guardada Con Exito.']);
        return redirect()->back()->with('success', 'Proveedor actualizado con exito!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Proveedor  $proveedor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $proveedor = Proveedor::find($request->button_delete);
        $proveedor->delete();
        return redirect()->back()->with('success', 'Proveedor eliminado exitosamente');
    }
}
