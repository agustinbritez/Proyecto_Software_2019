<?php

namespace App\Http\Controllers;

use App\MateriaPrima;
use App\Medida;
use App\TipoMateriaPrima;
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
        // $materiasPrimas= MateriaPrima::all();
       
        // return view ('materiaPrima.index',compact('materiasPrimas'));
   return view ('materiaPrima.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $materiaPrima=new MateriaPrima();
        
        $tipoMateriaPrimas= TipoMateriaPrima::all();
        $medidas= Medida::all();
        return view('materiaPrima.create',compact('materiaPrima','tipoMateriaPrimas','medidas'));
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
            
        ]);

        $materiaPrima = new MateriaPrima();
        //busca el inpunt con el nombre 'name' y guar su valor en el atributo 'name'
        $materiaPrima->nombre= $request->input('nombre');
        $materiaPrima->detalle= $request->input('detalle');
        $materiaPrima->cantidad= $request->input('cantidad');
        $materiaPrima->precioUnitario= $request->input('precioUnitario');
        $materiaPrima->color= $request->input('color');

        $materiaPrima->medida_id=$request->input('medida_id');
        $materiaPrima->tipoMateriaPrima_id=$request->input('tipoMateriaPrima_id');
        //guarda en la base de datos
        $materiaPrima->save();
        return redirect('/materiaPrima');
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
        $tipoMateriaPrimas= TipoMateriaPrima::all();
        $medidas= Medida::all();
        return view('materiaPrima.edit',compact('materiaPrima','tipoMateriaPrimas','medidas'));
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
        $materiaPrima->update();
        
        return redirect('/materiaPrima');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(MateriaPrima $materiaPrima)
    {
        // $materiaPrima= MateriaPrima::find($id);
        // return $materiaPrima ;
        
        // Flash::warning('La materia prima' . $materiaPrima->nombre . ' ha sido borrado exitosamente' );
        $materiaPrima->delete();
        
        return redirect('/materiaPrima');//->route('materiaPrima.index');
    }
}
