<?php

namespace App\Http\Controllers;

use App\Calle;
use Illuminate\Http\Request;

class CalleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $calles = Calle::all();
        return view('calle.index', compact('calles'));
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
        $calleExistente = Calle::where('nombre', $request->nombre)->where('deleted_at', "<>", null)->withTrashed()->first();
        //*****************************************************************************************************8 */
        //si el nombre esta repetido en una materia prima eliminada 
        //la volvemos a revivir y le actualizamos con los datos del nuevo
        if ($calleExistente != null) {
            $request->hidden_id = $calleExistente->id;
            $this->update($request);
            return redirect()->back()->with('success', 'Calle Creada Con Exito!');
        }
        $rules = [
            'nombre'    =>  'required|unique:calles'
        ];

        $messages = [
            'nombre.required' => 'Agrega el nombre del calle.',
            'nombre.unique' => 'El nombre debe ser unico.',


        ];

        $this->validate($request, $rules, $messages);



        $form_data = array(
            'nombre'        =>  $request->nombre
        );
        $calle = Calle::create($form_data);

        return redirect()->back()->with('success', 'Calle creada con exito!')->with('returnModal', 'mostrar modal');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Pais  $calle
     * @return \Illuminate\Http\Response
     */
    public function show(Pais $calle)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Pais  $calle
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (request()->ajax()) {
            $data = Calle::findOrFail($id);
            return response()->json([
                'data' => $data
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Pais  $calle
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $rules = [
            'nombre'    =>  'required|unique:calles,nombre,' . $request->hidden_id

        ];

        $messages = [
            'nombre.required' => 'Agregar el nombre del calle.',
            'nombre.unique' => 'El nombre debe ser unico.'

        ];
        $request->nombre = strtoupper($request->nombre);

        $this->validate($request, $rules, $messages);

        $form_data = array(
            'nombre'        =>  $request->nombre
        );

        //si el id que crea es uno borrado lo revivimos
        $calle = Calle::withTrashed()->find($request->hidden_id);
        //revive a la materia prima borrada anteriormente.
        $calle->restore();
        $calle->update($form_data);
        return redirect()->back()->with('success', 'Actualizado Correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pais  $calle
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $calle = Calle::find($request->button_delete);
        if (!$calle->direcciones->isEmpty()) {
            return redirect()->back()->withErrors(['message2' => 'No se puede eliminar el pais por estar relacionado a direcciones']);
        }
        $calle->delete();
        return redirect()->back();
    }
}
