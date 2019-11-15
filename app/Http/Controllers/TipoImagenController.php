<?php

namespace App\Http\Controllers;

use App\TipoImagen;
use Illuminate\Http\Request;

class TipoImagenController extends Controller
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
    public function obtenerImagenes($id)
    {

        $tipoImagen = TipoImagen::find($id);

        if ($tipoImagen != null) {
            $imagenes = $tipoImagen->imagenes;
            return ['imagenes' => $imagenes, 'tipoImagen' => $tipoImagen];
        }
        return null;
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
     * @param  \App\TipoImagen  $tipoImagen
     * @return \Illuminate\Http\Response
     */
    public function show(TipoImagen $tipoImagen)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TipoImagen  $tipoImagen
     * @return \Illuminate\Http\Response
     */
    public function edit(TipoImagen $tipoImagen)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TipoImagen  $tipoImagen
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TipoImagen $tipoImagen)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TipoImagen  $tipoImagen
     * @return \Illuminate\Http\Response
     */
    public function destroy(TipoImagen $tipoImagen)
    {
        //
    }
}
