<?php

namespace App\Http\Controllers;

use App\Estado;
use App\FlujoTrabajo;
use App\Modelo;
use App\Transicion;
use Dotenv\Validator;
use Illuminate\Http\Request;

class FlujoTrabajoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $estados = Estado::all();
        $flujosTrabajos = FlujoTrabajo::all();
        $modelos = Modelo::all();
        return view('flujoTrabajo.index', compact('estados', 'flujosTrabajos', 'modelos'));
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
        //obtengo la materias primas borradas si elnombre se repite la reuso
        $flujoExistente = FlujoTrabajo::where('nombre', $request->nombre)->where('deleted_at', "<>", null)->withTrashed()->first();
        // return response()->json(['success' => 'Modelo creado con exito!.', 'modelo' => 1]);
        //*****************************************************************************************************8 */
        //si el nombre esta repetido en una materia prima eliminada 
        //la volvemos a revivir y le actualizamos con los datos del nuevo
        if ($flujoExistente != null) {
            // $flujoExistente->restore();
            $request->hidden_id = $flujoExistente->id;
            $this->update($request);

            // return redirect()->back()->with('success', 'Modelo Creado Con Exito!');
            return redirect()->back()->with('success', 'Flujo de Trabajo creado con exito!');
        }
        $rules = [
            'nombre'    =>  'required|unique:flujo_trabajos',
            'estado' => 'required',

        ];
        //transformamos la mascara de precio unitario a un valor double normal
        $tr = str_replace([',', '$', ' '], '', $request->precioUnitario);
        // $tr= str_replace('.',',',$tr);

        $request->precioUnitario = $tr;
        $messages = [
            'nombre.required' => 'Agrega el nombre del flujo de trabajo.',
            'nombre.unique' => 'El nombre del flujo de trabajo debe ser unico.',

            'estado.required' => 'El estado inicial es requerido.'
        ];

        $this->validate($request, $rules, $messages);

        if (Estado::find($request->estado) == null) {
            return redirect()->back()->withErrors(['errors', 'El estado seleccionado no existe']);
        }

        $form_data = array(
            'nombre'        =>  $request->nombre,
            'detalle'         =>  $request->detalle

        );


        //si no crea es porque hay agun atributo que no permite null que esta vacio
        $flujoTrabajo = FlujoTrabajo::create($form_data);
        if ($flujoTrabajo != null) {
            $transicion = Transicion::create(['flujoTrabajo_id' => $flujoTrabajo->id, 'estadoInicio_id' => null, 'estadoFin_id' => $request->estado]);


            if ($request->has('modelos')) {
                $modelosSeleccionados = $request->modelos;
                foreach ($modelosSeleccionados as $idmodelo) {
                    $modelo = Modelo::find($idmodelo);
                    if (($modelo->flujoTrabajo_id != $flujoTrabajo->id) && ($modelo->flujoTrabajo_id != null)) {
                        return redirect()->back()->with('warning', 'Se creo el flujo de trabajo pero el modelo: ' . $modelo->nombre . ' ya tiene un flujo asignado que es ' . $modelo->flujoTrabajo->nombre);
                    }
                    $modelo->flujoTrabajo_id = $flujoTrabajo->id;
                    $modelo->update();
                }
            }



            return redirect()->back()->with('success', 'Flujo de Trabajo creado con exito!');
        }
        return redirect()->back()->withErrors(['errors', 'No se creo el flujo de trabajo!']);

        // if ($request->has('modelos')) {
        //     $modelo->modelos()->sync($request->input('modelos', []));
        // }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\FlujoTrabajo  $flujoTrabajo
     * @return \Illuminate\Http\Response
     */
    public function show(FlujoTrabajo $flujoTrabajo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\FlujoTrabajo  $flujoTrabajo
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {


        $flujo = FlujoTrabajo::findOrFail($id);

        return [
            'data' => $flujo, 'estadosDelFlujo' => $flujo->getEstados(), 'estadoInicial' => $flujo->getEstadoInicial(),
            'estadoFinal' => $flujo->getEstadoFinal(), 'totalModelos' => Modelo::all(),
            'modelos' => $flujo->modelos
        ];
    }

    public function agregarEstado($idFlujo, $estadoID)
    {

        $flujo = FlujoTrabajo::find($idFlujo);
        $estado = Estado::find($estadoID);
        $mensaje = '';
        $transicion = null;
        if (($estado != null) && ($flujo != null)) {
            if (($idFlujo == 1) || ($idFlujo == 2)) {
                // if (!(($idFlujo == 1) || ($idFlujo == 2))) {
                $mensaje = ['errors' => 'El flujo de trabajo a actualizar es parte del sistema no puede ser modificado'];
            } else {
                if ($flujo->transiciones->isEmpty()) {
                    $transicion = Transicion::create(['flujoTrabajo_id' => $idFlujo, 'estadoInicio_id' => null, 'estadoFin_id' => $estado->id]);
                } else {


                    $estadoFinal = $flujo->getEstadoFinal();
                    if ($estadoFinal->id != $estado->id) {
                        if ($flujo->existeEstado($estado)) {
                            $mensaje = ['errors' => 'Flujo no creado porque el estado a ingresar ya esta relacionado'];
                        } else {

                            $transicion = Transicion::create(['flujoTrabajo_id' => $idFlujo, 'estadoInicio_id' => $estadoFinal->id, 'estadoFin_id' => $estado->id]);
                        }
                    } else {
                        $mensaje = ['errors' => 'No se puede relaconar el ultimo estado de nuevo'];
                    }
                    if ($transicion != null) {
                        $mensaje = ['success' => 'Flujo de Trabajo creado con exito!'];
                    } else {
                        $mensaje = ['errors' => 'Flujo no creado'];
                    }
                }
            }


            $flujo = FlujoTrabajo::find($idFlujo);
            // return redirect()->back()->with('success', 'Estado Agregado correctamente!');
            return ['mensaje' => $mensaje, 'data' => $flujo, 'estadosDelFlujo' => $flujo->getEstados(), 'estadoInicial' => $flujo->getEstadoInicial(), 'estadoFinal' => $flujo->getEstadoFinal()];
        }
        return null;
        // return ['mensaje' => $mensaje, 'estados' => $flujoTrabajo->getEstados()];
    }

    public function quitarEstado($idFlujo)
    {
        $flujo = FlujoTrabajo::find($idFlujo);
        if ($flujo != null) {
            //los flujos 1 y 2 son estaticos y forman parte del sistema no se pueden crear ni borrar nuvos estados
            if (($idFlujo == 1) || ($idFlujo == 2)) {
                // if (!(($idFlujo == 1) || ($idFlujo == 2))) {
                $mensaje = ['errors' => 'El flujo de trabajo a actualizar es parte del sistema no puede ser modificado'];
            } else {
                $transFinal = $flujo->getTransicionFinal();
                $transFinal->delete();
            }
        }
        $flujo = FlujoTrabajo::find($idFlujo);
        return ['data' => $flujo, 'estadosDelFlujo' => $flujo->getEstados(), 'estadoInicial' => $flujo->getEstadoInicial(), 'estadoFinal' => $flujo->getEstadoFinal()];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\FlujoTrabajo  $flujoTrabajo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $rules = [
            'nombre'    =>  'required|unique:flujo_trabajos,nombre,' . $request->hidden_id
        ];
        //transformamos la mascara de precio unitario a un valor double normal
        $tr = str_replace([',', '$', ' '], '', $request->precioUnitario);
        // $tr= str_replace('.',',',$tr);

        $request->precioUnitario = $tr;
        $request->nombre = strtoupper($request->nombre);
        $messages = [
            'nombre.required' => 'Agrega el nombre del flujo de trabajo.',
            'nombre.unique' => 'El nombre del flujo de trabajo debe ser unico.'
        ];
        $this->validate($request, $rules, $messages);

        //si el id que crea es uno borrado lo revivimos
        $flujoTrabajo = FlujoTrabajo::withTrashed()->find($request->hidden_id);

        if ($flujoTrabajo == null) {
            return redirect()->back()->withErrors(['errors' => 'No se pudo actualizar']);
        }
        //revive a la materia prima borrada anteriormente.
        $flujoTrabajo->restore();
        $form_data = array(
            'nombre'        =>  $request->nombre,
            'detalle'         =>  $request->detalle

        );
        $flujoTrabajo->update($form_data);
        if ($flujoTrabajo != null) {
            // foreach ($flujoTrabajo->modelos as $key => $modelo) {
            //     # code...
            //     $modelo->flujoTrabajo_id = null;
            //     $modelo->update();
            // }

            if ($request->has('modelos')) {
                $modelosSeleccionados = $request->modelos;
                foreach ($modelosSeleccionados as $idmodelo) {
                    $modelo = Modelo::find($idmodelo);

                    if (($modelo->flujoTrabajo_id != $flujoTrabajo->id) && ($modelo->flujoTrabajo_id != null)) {
                        return redirect()->back()->with('warning', 'Se creo el flujo de trabajo pero el modelo: ' . $modelo->nombre . ' ya tiene un flujo asignado que es ' . $modelo->flujoTrabajo->nombre);
                    }
                    $modelo->flujoTrabajo_id = $flujoTrabajo->id;
                    $modelo->update();
                }
            }



            return redirect()->back()->with('success', 'Flujo de Trabajo actualizado con exito!');
        }
        // $flujoTrabajo->modelos()->detach($request->input('modelos',[]),$request->input('modelos',[]) );

        // $flujoTrabajo->modelos()->sync($request->input('modelos', []));
        // return response()->json(['success' => 'Materia Prima Actualizada Correctamente']);
        return redirect()->back()->with('success', 'Actualizado Correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\FlujoTrabajo  $flujoTrabajo
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (($id == 1) || ($id == 2)) {
            return redirect()->back()->withErrors(['message2' => 'El Flujo de Trabajo que desea eliminar es parte del sistema']);
        }
        $flujoTrabajo = FlujoTrabajo::find($id);
        //obtiene todos los modelos que tienen deleted_at null osea que no estan borrados
        if (!$flujoTrabajo->modelos->isEmpty()) {

            return redirect()->back()->withErrors(['message2' => 'No se puede eliminar el flujo de trabajo porque es usado en modelos']);
        }

        $flujoTrabajo->delete();
        return redirect()->back()->with('warning', 'Se elimino el flujo de trabajo de manera correcta');
    }
}
