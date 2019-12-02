<?php

namespace App\Http\Controllers;

use App\Medida;
use Illuminate\Http\Request;

class MedidaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $medidas = Medida::all();
        return view('medida.index', compact('medidas'));
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
        //obtengo  las borradas si el nombre se repite la reuso
        $medidaExistente = Medida::where('nombre', $request->nombre)->where('deleted_at', "<>", null)->withTrashed()->first();
        if ($medidaExistente != null) {
            //*****************************************************************************************************8 */
            //si el nombre esta repetido en un medida eliminado 
            //la volvemos a revivir y le actualizamos con los datos del nuevo
            $request->hidden_id = $medidaExistente->id;
            $this->update($request);
            return redirect()->back()->with('success', 'Medida Creada Con Exito!');
        }

        $rules = [
            'nombre'    =>  'required|unique:medidas'
        ];

        $messages = [
            'nombre.required' => 'Agrear nombre de la medida',

            'nombre.unique' => 'La medida debe ser unica, ya existe una con el mismo nombre',
        ];

        $this->validate($request, $rules, $messages);

        $form_data = array(
            'nombre'    =>  $request->nombre,
            'detalle'    =>  $request->detalle
        );

        $medida = Medida::create($form_data);

        return redirect()->back()->with('success', 'Meida Creada Con Exito!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Medida  $medida
     * @return \Illuminate\Http\Response
     */
    public function show(Medida $medida)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Medida  $medida
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (request()->ajax()) {
            $data = Medida::findOrFail($id);

            return response()->json([
                'data' => $data,
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Medida  $medida
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $rules = [
            'nombre'    =>  'required|unique:medidas,nombre,' . $request->hidden_id,
        ];

        $messages = [
            'nombre.required' => 'Agregar nombre de la medida',

            'nombre.unique' => 'La medida debe ser unico, ya existe uno con el mismo nombre',
        ];

        $request->nombre = strtoupper($request->nombre);
        $this->validate($request, $rules, $messages);

        $form_data = array(
            'nombre'    =>  $request->nombre,
            'detalle'    =>  $request->detalle,
        );
        $medida = Medida::withTrashed()->find($request->hidden_id);
        $medida->restore();
        $medida->update($form_data);

        return redirect()->back()->with('success', 'Actualizado Correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Medida  $medida
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //el boton_delete guarda el id de la medida a borrar
        $medida = Medida::find($request->boton_delete);
        if (!is_null($medida)) {
            if (!($medida->materiaPrimas)->isEmpty() || !($medida->modelos)->isEmpty()) {

                return redirect()->back()->withErrors('No se puede eliminar la unidad de medida esta relacionada a productos');
            }
        }
        $medida->delete();
        return redirect()->back();
    }
}
