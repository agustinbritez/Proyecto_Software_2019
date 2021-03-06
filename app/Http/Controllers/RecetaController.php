<?php

namespace App\Http\Controllers;

use App\Receta;
use Illuminate\Http\Request;

class RecetaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Receta  $receta
     * @return \Illuminate\Http\Response
     */
    public function show(Receta $receta)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Receta  $receta
     * @return \Illuminate\Http\Response
     */
    public function edit(Receta $receta)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Receta  $receta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Receta $receta)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Receta  $receta
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {


        // $receta=Receta::find($request->hidden_receta_id);
        $receta = Receta::find($id);
        if (is_null($receta)) {
            return redirect()->back()->withErrors('No existe la receta a eliminar');
        }
        if (!$receta->modeloPadre->productosModelos->isEmpty()) {

            return redirect()->back()->withErrors('No se elimino el ingrediente porque el modelo tiene asociado productos');
        }
        if (!$receta->materiaPrimaSeleccionadasHijo->isEmpty()) {
            return redirect()->back()->withErrors('No se elimino el ingredientes porque hay productos que lo asociaron');
        }

        $receta->delete();
        return redirect()->back()->with('warning', 'Ingrediente Eliminado Correctamente');
    }
}
