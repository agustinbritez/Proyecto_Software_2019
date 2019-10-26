<?php

namespace App\Http\Controllers;

use App\Localidad;
use Illuminate\Http\Request;

class LocalidadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $localidades = Localidad::all();
        return view('localidad.index', compact('localidades'));
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
        $localidadExistente = Localidad::where('nombre', $request->nombre)->where('deleted_at', "<>", null)->withTrashed()->first();
        //*****************************************************************************************************8 */
        //si el nombre esta repetido en una materia prima eliminada 
        //la volvemos a revivir y le actualizamos con los datos del nuevo
        if ($localidadExistente != null) {
            $request->hidden_id = $localidadExistente->id;
            $this->update($request);
            return redirect()->back()->with('success', 'Localidad Creada Con Exito!');
        }
        $rules = [
            'nombre'    =>  'required|unique:localidads',
            'codigoPostal' => 'required'
        ];

        $messages = [
            'nombre.required' => 'Agrega el nombre del localidad.',
            'nombre.unique' => 'El nombre debe ser unico.',

            'codigoPostal.required' => 'Agregar el codigo postal.'

        ];

        $this->validate($request, $rules, $messages);



        $form_data = array(
            'nombre'        =>  $request->nombre,
            'codigoPostal'        =>  $request->codigoPostal
        );
        $localidad = Localidad::create($form_data);

        return redirect()->back()->with('success', 'Localidad creada con exito!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Pais  $localidad
     * @return \Illuminate\Http\Response
     */
    public function show(Pais $localidad)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Pais  $localidad
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (request()->ajax()) {
            $data = Localidad::findOrFail($id);
            return response()->json([
                'data' => $data
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Pais  $localidad
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $rules = [
            'nombre'    =>  'required|unique:localidads,nombre,' . $request->hidden_id,
            'codigoPostal'    =>  'required'

        ];

        $messages = [
            'nombre.required' => 'Agregar el nombre del localidad.',
            'nombre.unique' => 'El nombre debe ser unico.',

            'codigoPostal.required' => 'Agregar el codigo postal.'
        ];
        $request->nombre = strtoupper($request->nombre);

        $this->validate($request, $rules, $messages);

        $form_data = array(
            'nombre'        =>  $request->nombre,
            'codigoPostal'        =>  $request->codigoPostal
        );

        //si el id que crea es uno borrado lo revivimos
        $localidad = Localidad::withTrashed()->find($request->hidden_id);
        //revive a la materia prima borrada anteriormente.
        $localidad->restore();
        $localidad->update($form_data);
        return redirect()->back()->with('success', 'Actualizado Correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pais  $localidad
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $localidad = Localidad::find($request->button_delete);
        if ($localidad->direcciones->isEmpty()) {
            return redirect()->back()->withErrors(['message2' => 'No se puede eliminar el pais por estar relacionado a direcciones']);
        }
        $localidad->delete();
        return redirect()->back();
    }
}
