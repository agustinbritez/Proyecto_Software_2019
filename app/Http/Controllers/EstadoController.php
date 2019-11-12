<?php

namespace App\Http\Controllers;

use App\Estado;
use Illuminate\Http\Request;

class EstadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $estados = Estado::all();
        return view('estado.index', compact('estados'));
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
        $estadoExistente = Estado::where('nombre', $request->nombre)->where('deleted_at', "<>", null)->withTrashed()->first();
        //*****************************************************************************************************8 */
        //si el nombre esta repetido en una materia prima eliminada 
        //la volvemos a revivir y le actualizamos con los datos del nuevo
        if ($estadoExistente != null) {
            $request->hidden_id = $estadoExistente->id;
            $this->update($request);
            return redirect()->back()->with('success', 'Estado Creado Con Exito!');
        }
        $rules = [
            'nombre'    =>  'required|unique:estados'
        ];

        $messages = [
            'nombre.required' => 'Agrega el estado.',
            'nombre.unique' => 'El nombre debe ser unico.',


        ];

        $this->validate($request, $rules, $messages);



        $form_data = array(
            'nombre'        =>  $request->nombre
        );
        $estado = Estado::create($form_data);

        return redirect()->back()->with('success', 'Estado creado con exito!')->with('returnModal', 'mostrar modal');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Estado  $estado
     * @return \Illuminate\Http\Response
     */
    public function show(Estado $estado)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Estado  $estado
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (request()->ajax()) {
            $data = Estado::findOrFail($id);
            return response()->json([
                'data' => $data
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Estado  $estado
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {


        $rules = [
            'nombre'    =>  'required|unique:estados,nombre,' . $request->hidden_id

        ];

        $messages = [
            'nombre.required' => 'Agregar el nombre del estado.',
            'nombre.unique' => 'El nombre debe ser unico.'

        ];
        $request->nombre = strtoupper($request->nombre);

        $this->validate($request, $rules, $messages);

        $form_data = array(
            'nombre'        =>  $request->nombre
        );

        //si el id que crea es uno borrado lo revivimos
        $estado = Estado::withTrashed()->find($request->hidden_id);
        //revive a la materia prima borrada anteriormente.
        $estado->restore();
        $estado->update($form_data);
        return redirect()->back()->with('success', 'Actualizado Correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Estado  $estado
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $estado = Estado::find($id);
        if (!$estado->transiciones->isEmpty()) {
            return redirect()->back()->withErrors(['message2' => 'No se puede eliminar el estado se encuentra utilizado por una transicion']);
        }
        $estado->delete();
        return redirect()->back()->with('warning', 'Se elimino el estado');
    }
}
