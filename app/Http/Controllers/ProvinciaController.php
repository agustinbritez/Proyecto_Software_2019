<?php

namespace App\Http\Controllers;

use App\Provincia;
use Illuminate\Http\Request;

class ProvinciaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $provincias = Provincia::all();
        return view('provincia.index', compact('provincias'));
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

        $request->nombre = strtoupper($request->nombre);
        //obtengo la tipos movimientos borradas si elnombre se repite la reuso
        $provinciaExistente = Provincia::where('nombre', $request->nombre)->where('deleted_at', "<>", null)->withTrashed()->first();
        //*****************************************************************************************************8 */
        //si el nombre esta repetido en una materia prima eliminada 
        //la volvemos a revivir y le actualizamos con los datos del nuevo
        if ($provinciaExistente != null) {
            $request->hidden_id = $provinciaExistente->id;
            $this->update($request);
            return redirect()->back()->with('success', 'Provincia Creado Con Exito!');
        }
        $rules = [
            'nombre'    =>  'required|unique:provincias'

        ];

        $messages = [
            'nombre.required' => 'Agrega el nombre del provincia.',
            'nombre.unique' => 'El nombre debe ser unico.',
        ];

        $this->validate($request, $rules, $messages);



        $form_data = array(
            'nombre'        =>  $request->nombre,
        );
        $provincia = Provincia::create($form_data);

        return redirect()->back()->with('success', 'Provincia creado con exito!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\provincia  $provincia
     * @return \Illuminate\Http\Response
     */
    public function show(provincia $provincia)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\provincia  $provincia
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (request()->ajax()) {
            $data = Provincia::findOrFail($id);
            return response()->json([
                'data' => $data
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\provincia  $provincia
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $rules = [
            'nombre'    =>  'required|unique:provincias,nombre,' . $request->hidden_id

        ];

        $messages = [
            'nombre.required' => 'Agrega el nombre del provincia.',
            'nombre.unique' => 'El nombre debe ser unico.',
        ];
        $request->nombre = strtoupper($request->nombre);

        $this->validate($request, $rules, $messages);

        $form_data = array(
            'nombre'        =>  $request->nombre,
        );

        //si el id que crea es uno borrado lo revivimos
        $provincia = Provincia::withTrashed()->find($request->hidden_id);
        //revive a la materia prima borrada anteriormente.
        $provincia->restore();
        $provincia->update($form_data);
        return redirect()->back()->with('success', 'Actualizado Correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\provincia  $provincia
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $provincia = Provincia::find($request->button_delete);
        if ($provincia->direcciones->isEmpty()) {
            return redirect()->back()->withErrors(['message2' => 'No se puede eliminar el provincia por estar relacionado a direcciones']);
        }
        $provincia->delete();
        return redirect()->back();
    }
}
