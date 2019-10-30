<?php

namespace App\Http\Controllers;

use App\Pais;
use Illuminate\Http\Request;

class PaisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paises = Pais::all();
        return view('pais.index', compact('paises'));
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
        $paisExistente = Pais::where('nombre', $request->nombre)->where('deleted_at', "<>", null)->withTrashed()->first();
        //*****************************************************************************************************8 */
        //si el nombre esta repetido en una materia prima eliminada 
        //la volvemos a revivir y le actualizamos con los datos del nuevo
        if ($paisExistente != null) {
            $request->hidden_id = $paisExistente->id;
            $this->update($request);
            return redirect()->back()->with('success', 'Pais Creado Con Exito!');
        }
        $rules = [
            'nombre'    =>  'required|unique:pais'

        ];

        $messages = [
            'nombre.required' => 'Agrega el nombre del pais.',
            'nombre.unique' => 'El nombre debe ser unico.',
        ];

        $this->validate($request, $rules, $messages);



        $form_data = array(
            'nombre'        =>  $request->nombre,
        );
        $pais = Pais::create($form_data);

        return redirect()->back()->with('success', 'Pais creado con exito!')->with('returnModal', 'mostrar modal');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Pais  $pais
     * @return \Illuminate\Http\Response
     */
    public function show(Pais $pais)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Pais  $pais
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (request()->ajax()) {
            $data = Pais::findOrFail($id);
            return response()->json([
                'data' => $data
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Pais  $pais
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $rules = [
            'nombre'    =>  'required|unique:pais,nombre,' . $request->hidden_id

        ];

        $messages = [
            'nombre.required' => 'Agrega el nombre del pais.',
            'nombre.unique' => 'El nombre debe ser unico.',
        ];
        $request->nombre = strtoupper($request->nombre);

        $this->validate($request, $rules, $messages);

        $form_data = array(
            'nombre'        =>  $request->nombre,
        );

        //si el id que crea es uno borrado lo revivimos
        $pais = Pais::withTrashed()->find($request->hidden_id);
        //revive a la materia prima borrada anteriormente.
        $pais->restore();
        $pais->update($form_data);
        return redirect()->back()->with('success', 'Actualizado Correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pais  $pais
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $pais = Pais::find($request->button_delete);
        if (!$pais->direcciones->isEmpty()) {
            return redirect()->back()->withErrors(['message2' => 'No se puede eliminar el pais por estar relacionado a direcciones']);
        }
        $pais->delete();
        return redirect()->back();
    }
}
