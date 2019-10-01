<?php

namespace App\Http\Controllers;

use App\MateriaPrima;
use App\Movimiento;
use App\Proveedor;
use App\TipoMovimiento;
use Illuminate\Http\Request;

class MovimientoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $proveedores=Proveedor::all();
        $tipoMovimientos=TipoMovimiento::all();
        $materiaPrimas=MateriaPrima::all();
        $movimientos=Movimiento::all();
        return view ('movimiento.index',compact('proveedores','tipoMovimientos','materiaPrimas','movimientos'));
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
          // return $request;
          $form_data = array(
            'precioUnitario'        =>  $request->precioUnitario,
            'fecha'         =>  $request->fecha,
            'cantidad'         =>  $request->cantidad,
            'proveedor_id'         =>  $request->input('proveedor_id'),
            'tipoMovimiento_id'         =>  $request->input('tipoMovimiento_id'),
            'maeriaPrima_id'         =>  $request->input('maeriaPrima_id')
        );
        //si no crea es porque hay agun atributo que no permite null que esta vacio
        $movimiento=Movimiento::create($form_data);
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Movimiento  $movimiento
     * @return \Illuminate\Http\Response
     */
    public function show(Movimiento $movimiento)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Movimiento  $movimiento
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(request()->ajax())
        {
            $data = Movimiento::findOrFail($id);
            
            return response()->json(['data' => $data,'proveedor'=>$data->proveedor,'tipoMovimiento'=> $data->tipoMovimiento,
            'materiaPrima'=> $data->materiaPrima]);
        }
    }

    public function obtenerParametros (Request $request)
                        {   
                            if(request()->ajax())
                            {
                                return response()->json([
                                'totalMateriaPrimas'=> MateriaPrima::all(),
                                'totalProveedores'=> Proveedor::all(),
                                'totalTipoMovimientos'=> TipoMovimiento::all()
                                ]);
                            }
                        }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Movimiento  $movimiento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $form_data = array(
            'precioUnitario'        =>  $request->precioUnitario,
            'fecha'         =>  $request->fecha,
            'cantidad'         =>  $request->cantidad,
            'proveedor_id'         =>  $request->input('proveedor_id'),
            'tipoMovimiento_id'         =>  $request->input('tipoMovimiento_id'),
            'maeriaPrima_id'         =>  $request->input('maeriaPrima_id')
        );       
        $movimiento=Movimiento::find($request->hidden_id);
        $movimiento->update($form_data);        
        return redirect()->back();  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Movimiento  $movimiento
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $movimiento=Movimiento::find($request->movimiento_delete);
        $movimiento->delete();
        return redirect()->back();
    }
}
