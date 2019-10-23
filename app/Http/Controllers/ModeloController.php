<?php

namespace App\Http\Controllers;

use App\MateriaPrima;
use App\Modelo;
use Illuminate\Http\Request;

class ModeloController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $modelos = Modelo::all();
        return view('modelo.index', compact('modelos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $modelos = Modelo::all();
        return view('modelo.create', compact('modelos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        if (request()->ajax()) {
            // $data = TipoMovimiento::findOrFail($id);
            $receta= $this->cargarReceta();
            return response()->json(['success'=>'Modelo creado correctamente.','receta'=>$receta]);
        }
    }

 
    /**
     * Display the specified resource.
     *
     * @param  \App\Modelo  $modelo
     * @return \Illuminate\Http\Response
     */
    public function show(Modelo $modelo)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Modelo  $modelo
     * @return \Illuminate\Http\Response
     */
    public function cargarListaIngrediente($variable)
    {

        //si el checkbox esta seleccionado tiene que devolver solo las materias primas
        if ($variable) {
            $data = MateriaPrima::all();
        } else {
            $data = Modelo::all();
        }

        return $data;
    }

    public function cargarReceta()
    {
        $receta = '
        <div class="card text-left">
        <div class="card-header">
    
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                        class="fas fa-minus"></i></button>
            </div>
            <h3>Crear Recetas Para el Modelo</h3>
        </div>

        <div class="card-body">
            <div class="form-group">
                <form action="" name="formCheck" id="formCheck">

                    <div class="form-group clearfix ">
                        <label for="">Mostrar solo materia prima: </label>
                        <div class="icheck-success d-inline">

                            <input type="checkbox" id="cambiarIngrediente" name="cambiarIngrediente">
                            <label for="cambiarIngrediente" id="labelOperacion">
                        </div>
                        </label>
                    </div>
                </form>
            </div>

            <div class=" row">

                <div class="form-group col">
                    <label id="labelIngrediente">Ingredientes : </label>

                    <select class="select2" name="ingredientes" id="ingredientes"
                        data-placeholder="Seleccione Un Modelo" style="width: 100%;">';

                        $modelos=Modelo::all();
                        $options='';
                        if(!$modelos->isEmpty()){
                            foreach ($modelos as $key => $modelo) {
                            $options=$options. '<option value="'.$modelo->id.'">'.$modelo->nombre.'</option>';
                            }
                        }
                        $receta=$receta.$options;


                      $receta=$receta.'
                        
                    </select>
                </div>

                <div class="form-group col">
                    <label>Cantidad : </label>
                    <input class="form-control" type="number" name="cantidad" id="cantidad"
                        style="width: 100%;">
                </div>

                <div class="form-group col">
                    <label>Prioridad : </label>
                    <input class="form-control" type="number" name="prioridad" id="prioridad"
                        style="width: 100%;">
                </div>
                
                <div class="form-group col">
                    <button type="button" name="filtrar" id="agregar_receta"
                        class="btn btn-success btn-sm">Agregar</button>

                </div>
            </div>


            <div class="card-deck  " id="add_receta">

            </div>

        </div>

        <div class="card-footer text-muted">
        </div>
    </div>';
    
    return $receta;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Modelo  $modelo
     * @return \Illuminate\Http\Response
     */
    public function edit(Modelo $modelo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Modelo  $modelo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Modelo $modelo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Modelo  $modelo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Modelo $modelo)
    {
        //
    }
}
