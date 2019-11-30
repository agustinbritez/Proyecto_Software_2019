<?php

namespace App\Http\Controllers;

use App\MateriaPrima;
use App\Movimiento;
use App\Proveedor;
use App\TipoMovimiento;
use Carbon\Carbon;
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
        $proveedores = Proveedor::all();
        $tipoMovimientos = TipoMovimiento::all();
        $materiaPrimas = MateriaPrima::all();
        $movimientos = Movimiento::all();
        return view('movimiento.index', compact('proveedores', 'tipoMovimientos', 'materiaPrimas', 'movimientos'));
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
        //constantes
        $proveedor_vacio = 'NINGUNO';
        $tipoMovimientoAux = TipoMovimiento::find($request->tipoMovimiento_id);
        $rules = [
            'precioUnitario'        => 'required|numeric',
            'cantidad'         => 'required|integer|min:1',
            'materiaPrima_id'         =>  'required|exists:materia_primas,id',
            'tipoMovimiento_id'         =>  'required|exists:tipo_movimientos,id'
        ];


        //transformamos la mascara de precio unitario a un valor double normal
        $tr = str_replace([',', '$', ' '], '', $request->precioUnitario);
        // $tr= str_replace('.',',',$tr);

        $request->precioUnitario = $tr;

        $messages = [
            'cantidad.required' => 'Agrega la  cantidad de materias primas.',
            'cantidad.integer' => 'La cantidad debe ser un valor entero',
            'cantidad.min' => 'La cantidad no puede ser menor a 1',

            'precioUnitario.required' => 'Agrege el precio de la materia prima.',
            'precioUnitario.numeric' => 'El precio debe ser un valor numerico',

            'proveedor_id.required' => 'Debe seleccionar un proveedor',

            'tipoMovimiento_id.required' => 'Debe seleccionar un tipo movimiento',
            'tipoMovimiento_id.exists' => 'No existe el tipo de movimiento seleccionado',

            'materiaPrima_id.required' => 'Debe seleccionar una materia prima',
            'materiaPrima_id.exists' => 'No existe la materia prima seleccionado'

        ];
        if ($tipoMovimientoAux != null) {
            if ($tipoMovimientoAux->operacion) {
                $rules = array_merge($rules, [
                    'proveedor_id'         =>  'required'
                ]);
            }
        }
        $request->validate($rules, $messages);
        //segunda validacion

        if ((($proveedor = Proveedor::find($request->proveedor_id)) == null) && ($tipoMovimientoAux->operacion)) {
            return redirect()->back()->withErrors(['message2' => 'El proveedor seleccionado no existe']);
        }


        $materiaPrima = MateriaPrima::find($request->materiaPrima_id);
        $tipoMovimiento = TipoMovimiento::find($request->tipoMovimiento_id);
        //si es distitno a 0 es porqu es verdadero osea suar 
        if ($tipoMovimiento->operacion != 0) {
            $materiaPrima->cantidad = $materiaPrima->cantidad + $request->cantidad;
        } else {
            if ($materiaPrima->cantidad < $request->cantidad) {
                return redirect()->back()->withErrors(['message1' => 'La cantidad ingresada supera a la cantidad de materia prima almacenada']);
            }
            $materiaPrima->cantidad = $materiaPrima->cantidad - $request->cantidad;
        }

        //si la operacion es positiva osea '0' sumamos al stock de la materia prima
        $materiaPrima->update();


        if ($proveedor != null) {
            $form_data = array(
                'precioUnitario'        =>  $request->precioUnitario,
                'fecha'         =>  Carbon::now(),
                'cantidad'         =>  $request->cantidad,
                'proveedor_id'         =>  $proveedor->id,
                'tipoMovimiento_id'         =>  $request->input('tipoMovimiento_id'),
                'materiaPrima_id'         =>  $request->input('materiaPrima_id')
            );
        } else {
            $form_data = array(
                'precioUnitario'        =>  $request->precioUnitario,
                'fecha'         =>  Carbon::now(),
                'cantidad'         =>  $request->cantidad,
                'proveedor_id'         =>  null,
                'tipoMovimiento_id'         =>  $request->input('tipoMovimiento_id'),
                'materiaPrima_id'         =>  $request->input('materiaPrima_id')
            );
        }
        $movimiento = Movimiento::create($form_data);
        //si no crea es porque hay agun atributo que no permite null que esta vacio

        return redirect()->back()->with('success', 'Movimiento Creado Con Exito!');
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

        // if (request()->ajax()) {
        //     $data = Movimiento::findOrFail($id);

        //     return response()->json([
        //         'data' => $data, 'proveedor' => $data->proveedor,
        //         'totalProveedores' => Proveedor::all(),
        //         'totalTipoMovimientos' => TipoMovimiento::all(),
        //         'totalMateriaPrimas' => MateriaPrima::all()
        //     ]);
        // }
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
        // $form_data = array(
        //     'precioUnitario'        =>  $request->precioUnitario,
        //     'fecha'         =>  $request->fecha,
        //     'cantidad'         =>  $request->cantidad,
        //     'proveedor_id'         =>  $request->input('proveedor_id'),
        //     'tipoMovimiento_id'         =>  $request->input('tipoMovimiento_id'),
        //     'materiaPrima_id'         =>  $request->input('materiaPrima_id')
        // );
        // $movimiento = Movimiento::find($request->hidden_id);
        // $movimiento->update($form_data);
        // return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Movimiento  $movimiento
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        // $movimiento = Movimiento::find($request->movimiento_delete);
        // $movimiento->delete();
        // return redirect()->back()->with('success', 'Actualizado Correctamente');
    }
}
