<?php

namespace App\Http\Controllers;

use App\Calle;
use App\Direccion;
use App\Localidad;
use App\Pais;
use App\Provincia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DireccionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $direcciones = Direccion::all();
        return view('direccion.index', compact('direcciones'));
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
            'calle'    =>  'required|alpha_num',
            'localidad'    =>  'required|alpha_num',
            'codigoPostal'    =>  'required|integer',
            'provincia'    =>  'required|alpha_num',
            'pais'    =>  'required|alpha_num',
        ];;

        $messages = [

            'domicilio.required' => 'Agregar el numero de la direccion',
            'integer' => 'El domicilio, localidad debe ser un valor entero',
            'calle.required' => 'Agregar la calle de la direccion',
            'localidad.required' => 'Agregar la localidad de la direccion',
            'provincia.required' => 'Agregar la provincia de la direccion',
            'pais.required' => 'Agregar el pais de la direccion',
            '*.alpha_num' => 'Los campos Pais, Provincia, Localidad, son solo permiten valores alfanumérico'
        ];
        $this->validate($request, $rules, $messages);
        $calle_filtro = strtoupper($request->calle);
        $domicilio_filtro = ($request->domicilio);
        $codigoPostal_filtro = ($request->codigoPostal);
        $localidad_filtro = strtoupper($request->localidad);
        $provincia_filtro = strtoupper($request->provincia);
        $pais_filtro = strtoupper($request->pais);

        DB::beginTransaction();

        $pais = Pais::where('nombre', strtoupper($request->pais))->first();
        if (is_null($pais)) {
            $pais = Pais::create(['nombre' => $pais_filtro]);
            $pais == null ? DB::rollBack() : 0;
        }

        $provincia = Provincia::where('nombre', $provincia_filtro)->first();
        if (is_null($provincia)) {
            $provincia = provincia::create(['nombre' => $provincia_filtro]);
        }
        $localidad = Localidad::where('nombre', $localidad_filtro)->first();
        if (is_null($localidad)) {
            $localidad = Localidad::create(['nombre' => $localidad_filtro, 'codigoPostal' => $codigoPostal_filtro]);
        }
        $calle = Calle::where('nombre', $calle_filtro)->first();
        if (is_null($calle)) {
            $calle = Calle::create(['nombre' => $calle_filtro]);
        }


        (is_null($pais) || is_null($provincia) || is_null($provincia) || is_null($localidad) || is_null($calle)) ? DB::rollBack() : DB::commit();



        $direccion = Direccion::where('numero', $request->domicilio)->where('calle_id', $request->calle_id)
            ->where('localidad_id', $request->localidad_id)
            ->where('provincia_id', $request->provincia_id)
            ->where('pais_id', $request->pais_id)->first();



        if ($direccion == null) {
            $direccion = Direccion::create([
                'numero'    =>  $domicilio_filtro,
                'calle_id'    =>  $calle->id,
                'localidad_id'    =>  $localidad->id,
                'provincia_id'    =>  $provincia->id,
                'pais_id'    =>  $pais->id
            ]);
        }


        return redirect()->back()->with('success', 'Direccion Creada Con Exito!');
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
            'calle.required' => 'Agregar la calle de la direccion',
            'numero.required' => 'Agregar el numero de la direccion',
            'codigoPostal.required' => 'Agregar el codigo postal de la direccion',
            'localidad.required' => 'Agregar la localidad de la direccion',
            'provincia.required' => 'Agregar la provincia de la direccion',
            'pais.required' => 'Agregar el pais de la direccion',

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


        if (!is_null($direccion)) {
            if (!$direccion->direccionEnvios->isEmpty()) {
                return redirect()->back()->withErrors('No se elimino la direccion porque esta relacionada a usuarios');
            }
            if (!$direccion->proveedores->isEmpty()) {
                return redirect()->back()->withErrors('No se elimino la direccion porque esta relacionada a proveedores');
            }


            if (sizeof($direccion->pais->direcciones) == 1) {

                $direccion->pais->delete();
            }
            if (sizeof($direccion->provincia->direcciones) == 1) {
                $direccion->provincia->delete();
            }
            if (sizeof($direccion->localidad->direcciones) == 1) {
                $direccion->localidad->delete();
            }
            if (sizeof($direccion->calle->direcciones) == 1) {
                $direccion->calle->delete();
            }


            $direccion->delete();


            return redirect()->back()->with('warning', 'Se elimino correctamente la direccion');

            return redirect()->back()->withErrors('No se elimino la direccion porque esta asociada');
        }
        return redirect()->back()->withErrors('No existe la direccion');
    }
}
