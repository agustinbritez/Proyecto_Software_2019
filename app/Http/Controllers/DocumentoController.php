<?php

namespace App\Http\Controllers;

use App\Documento;
use Illuminate\Http\Request;

class DocumentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $documentos = Documento::all();
        return view('documento.index', compact('documentos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    { 

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->nombre = strtoupper($request->nombre);
        //obtengo  las borradas si el nombre se repite la reuso
        $documentoExistente = Documento::where('nombre', $request->nombre)->where('deleted_at', "<>", null)->withTrashed()->first();
        if ($documentoExistente != null) {
        //*****************************************************************************************************8 */
        //si el nombre esta repetido en un documento eliminado 
        //la volvemos a revivir y le actualizamos con los datos del nuevo
            $request->hidden_id = $documentoExistente->id;
            $this->update($request);
            return redirect()->back()->with('success', 'Documento Creado Con Exito!');
        }

        $rules = [
            'nombre'    =>  'required|unique:documentos'
        ];

        $messages = [
            'nombre.required' => 'Agrear nombre del documento',

            'nombre.unique' => 'El documento debe ser unico, ya existe uno con el mismo nombre',
        ];

        $this->validate($request, $rules, $messages);

        $form_data = array(
            'nombre'    =>  $request->nombre
        );

        $documento = Documento::create($form_data);

        return redirect()->back()->with('success', 'Documento Creado Con Exito!')->with('returnModal', 'mostrar modal');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Documento  $documento
     * @return \Illuminate\Http\Response
     */
    public function show(Documento $documento)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Documento  $documento
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (request()->ajax()) {
            $data = Documento::findOrFail($id);

            return response()->json([
                'data' => $data, 
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Documento  $documento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $rules = [
            'nombre'    =>  'required|unique:documentos,nombre,' . $request->hidden_id,
        ];

        $messages = [
            'nombre.required' => 'Agrear nombre del documento',

            'nombre.unique' => 'El documento debe ser unico, ya existe uno con el mismo nombre',
        ];

        $request->nombre = strtoupper($request->nombre);
        $this->validate($request, $rules, $messages);

        $form_data = array(
            'nombre'    =>  $request->nombre,
        );
        $documento = Documento::withTrashed()->find($request->hidden_id);
        $documento->restore();
        $documento->update($form_data);
    
        return redirect()->back()->with('success', 'Actualizado Correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Documento  $documento
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $documento = Documento::find($request->boton_delete);
        if( !$documento->proveedores->isEmpty()||( $documento->user!=null)){
            return redirect()->back()->withErrors(['message2'=>'No se puede eliminar el documento porque esta relacionado']);
        }
        $documento->delete();
        return redirect()->back();
    }
}
