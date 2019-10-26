<?php

namespace App\Http\Controllers;

use App\TipoMovimiento;
use Illuminate\Http\Request;

class TipoMovimientoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tipoMovimientos = TipoMovimiento::all();
        return view('tipoMovimiento.index', compact('tipoMovimientos'));
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
        $tipoMovimientoExistente = TipoMovimiento::where('nombre', $request->nombre)->where('deleted_at', "<>", null)->withTrashed()->first();
        //*****************************************************************************************************8 */
        //si el nombre esta repetido en una materia prima eliminada 
        //la volvemos a revivir y le actualizamos con los datos del nuevo
        if ($tipoMovimientoExistente != null) {
            $request->hidden_id = $tipoMovimientoExistente->id;
            $this->update($request);
            return redirect()->back()->with('success', 'Tipo Movimiento Creado Con Exito!');
        }
        $rules = [
            'nombre'    =>  'required|unique:tipo_movimientos'

        ];

        $messages = [
            'nombre.required' => 'Agrega el nombre del proveedor.',
            'nombre.unique' => 'El nombre debe ser unico.',
        ];

        $this->validate($request, $rules, $messages);
        
        //si el check box es verdadero se le asigna un valor distinto a '0' 
        if ($request->has('operacion')) {
            $da = 1;
        } else {
            $da = 0;
        }

        $form_data = array(
            'nombre'        =>  $request->nombre,
            'detalle'        =>  $request->detalle,
            'operacion'         =>  $da
        );
        $tipoMovimiento = TipoMovimiento::create($form_data);

        return redirect()->back()->with('success', 'Tipo Movimiento creado con exito!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\TipoMovimiento  $tipoMovimiento
     * @return \Illuminate\Http\Response
     */
    public function show(TipoMovimiento $tipoMovimiento)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TipoMovimiento  $tipoMovimiento
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (request()->ajax()) {
            $data = TipoMovimiento::findOrFail($id);
            return response()->json([
                'data' => $data
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TipoMovimiento  $tipoMovimiento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $rules = [
            'nombre'    =>  'required|unique:tipo_movimientos,nombre,' . $request->hidden_id

        ];

        $messages = [
            'nombre.required' => 'Agrega el nombre del proveedor.',
            'nombre.unique' => 'El nombre debe ser unico.',
        ];
        $request->nombre = strtoupper($request->nombre);

        $this->validate($request, $rules, $messages);

        //si el check box es verdadero se le asigna un valor distinto a '0' 
        if ($request->has('operacion')) {
            $da = 1;
        } else {
            $da = 0;
        }

        $form_data = array(
            'nombre'        =>  $request->nombre,
            'detalle'        =>  $request->detalle,
            'operacion'         =>  $da
        );

        //si el id que crea es uno borrado lo revivimos
        $tipoMovimiento = TipoMovimiento::withTrashed()->find($request->hidden_id);
        //revive a la materia prima borrada anteriormente.
        $tipoMovimiento->restore();
        $tipoMovimiento->update($form_data);
        return redirect()->back()->with('success', 'Actualizado Correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TipoMovimiento  $tipoMovimiento
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $tipoMovimiento = TipoMovimiento::find($request->button_delete);
        $tipoMovimiento->delete();
        return redirect()->back();
    }
}
