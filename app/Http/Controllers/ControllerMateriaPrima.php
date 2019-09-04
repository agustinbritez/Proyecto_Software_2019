<?php

namespace App\Http\Controllers;

use App\MateriaPrima;
use Illuminate\Http\Request;

class ControllerMateriaPrima extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $materiasPrimas= MateriaPrima::all();
        return view ('materiaPrima.index',compact('materiasPrimas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('materiaPrima.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validacion de los campos de entrada
        $validateData = $request->validate([
            'nombre'=>'required|max: 50',
            'medida'=>'required'
        ]);

        $materiaPrima = new MateriaPrima();
        //busca el inpunt con el nombre 'name' y guar su valor en el atributo 'name'
        $materiaPrima->nombre= $request->input('nombre');
        $materiaPrima->medida=$request->input('medida');
        //guarda en la base de datos
        $materiaPrima->save();
        return 'Saved';
        //return $request->all();

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(MateriaPrima $materiaPrima)
    {
       // $materiaPrima= MateriaPrima::find($id);
        return view('materiaPrima.show',compact('materiaPrima'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit (MateriaPrima $materiaPrima)
    {
        return view('materiaPrima.edit',compact('materiaPrima'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MateriaPrima $materiaPrima)
    {
        $materiaPrima->fill($request->all());
        $materiaPrima->save();
        return 'updated';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
