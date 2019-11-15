<?php

namespace App\Http\Controllers;

use App\Componente;
use Illuminate\Http\Request;

class ComponenteController extends Controller
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
     * @param  \App\Componente  $componente
     * @return \Illuminate\Http\Response
     */
    public function show(Componente $componente)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Componente  $componente
     * @return \Illuminate\Http\Response
     */
    public function edit(Componente $componente)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Componente  $componente
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Componente $componente)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Componente  $componente
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $receta=Receta::find($request->hidden_receta_id);
        $componente = Componente::find($id);
        if ($componente != null) {
            if (!$componente->sublimaciones->isEmpty()) {
                return redirect()->back()->withErrors('No se elimino el componente, tiene sublimaciones asociadas')->with('returnModal', 'mostrar modal');
            }
            $componente->delete();
            return redirect()->back()->with('warning', 'Componente Eliminado Correctamente')->with('returnModal', 'mostrar modal');
        }
        return redirect()->back()->withErrors('No se encontro el componente que se desea quitar')->with('returnModal', 'mostrar modal');
    }
}
