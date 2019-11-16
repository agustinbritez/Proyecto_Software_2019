<?php

namespace App\Http\Controllers;

use App\TipoImagen;
use Illuminate\Http\Request;

class TipoImagenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $tipoImagenes = TipoImagen::all();

        return view('tipoImagen.index', compact('tipoImagenes'));
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
    public function obtenerImagenes($id)
    {

        $tipoImagen = TipoImagen::find($id);

        if ($tipoImagen != null) {
            $imagenes = $tipoImagen->imagenes;
            return ['imagenes' => $imagenes, 'tipoImagen' => $tipoImagen];
        }
        return null;
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
        //obtengo la tipos movimientos borradas si elnombre se repite la reuso
        $tipoImagenExistente = TipoImagen::where('nombre', $request->nombre)->where('deleted_at', "<>", null)->withTrashed()->first();
        //*****************************************************************************************************8 */
        //si el nombre esta repetido en una materia prima eliminada 
        //la volvemos a revivir y le actualizamos con los datos del nuevo
        if ($tipoImagenExistente != null) {
            $request->hidden_id = $tipoImagenExistente->id;
            $this->update($request);
            return redirect()->back()->with('success', 'Tipo Imagen Creado Con Exito!');
        }

        $rules = [
            'nombre'    =>  'required|unique:tipo_imagens'
        ];


        $messages = [
            'nombre.required' => 'El nombre del tipo es requerido.',
            'nombre.unique' => 'El nombre debe ser unico.'
        ];

        $request->validate($rules, $messages);


        $form_data = array(
            'nombre'        =>  $request->nombre
        );
        $tipoImagen = TipoImagen::create($form_data);
        //si no crea es porque hay agun atributo que no permite null que esta vacio

        return redirect()->back()->with('success', 'Tipo Imagen Creado Con Exito!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\TipoImagen  $tipoImagen
     * @return \Illuminate\Http\Response
     */
    public function show(TipoImagen $tipoImagen)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TipoImagen  $tipoImagen
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (request()->ajax()) {
            $data = TipoImagen::findOrFail($id);

            return response()->json([
                'data' => $data
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TipoImagen  $tipoImagen
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $rules = [

            'nombre'    =>  'required|unique:tipo_imagens,nombre,' . $request->hidden_id


        ];

        $messages = [
            'nombre.required' => 'Agrega el nombre del tipo de imagen.',
            'nombre.unique' => 'El nombre debe ser unico.'
        ];
        $request->nombre = strtoupper($request->nombre);

        $this->validate($request, $rules, $messages);

        $form_data = array(
            'nombre'        =>  $request->nombre,
        );

        //si el id que crea es uno borrado lo revivimos
        $tipoImagen = TipoImagen::withTrashed()->find($request->hidden_id);
        $tipoImagen->restore();
        $tipoImagen->update($form_data);
        return redirect()->back()->with('success', 'Actualizado Correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TipoImagen  $tipoImagen
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $tipoImagen = TipoImagen::find($request->button_delete);
        if (!$tipoImagen->imagenes->isEmpty()) {
            return redirect()->back()->withErrors(['message2' => 'No se puede eliminar el tipo de imagen por estar relacionado a imagenes']);
        }
        $tipoImagen->delete();
        return redirect()->back()->with('warning', 'Se elimino el tipo de imagen correctamente');
    }
}
