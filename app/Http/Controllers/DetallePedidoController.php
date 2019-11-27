<?php

namespace App\Http\Controllers;

use App\DetallePedido;
use App\Modelo;
use App\Pedido;
use App\Producto;
use App\TipoImagen;
use Illuminate\Http\Request;

class DetallePedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $pedido = Pedido::find($id);
        $detallePedidos = $pedido->detallePedidos;
        $modelos = Modelo::all();
        return view('detallePedido.index', compact('detallePedidos', 'modelos', 'pedido'));
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
     * @param  \App\DetallePedido  $detallePedido
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $detallePedido = DetallePedido::find($id);

        if (($detallePedido == null)) {
            return redirect()->back()->withErrors('El detalle del pedido no existe');
        }
        $producto = Producto::find($detallePedido->producto->id);
        if ($producto == null) {
            return redirect()->back()->withErrors('El producto no existe');
        }

        $tipoImagenes = TipoImagen::all();
        return view('detallePedido.show', compact('producto', 'tipoImagenes', 'detallePedido'));
    }

    public function verificarDetalle($id)
    {
        $detallePedido = DetallePedido::find($id);
        if ($detallePedido != null) {
            $detallePedido->verificado = 1;
            $detallePedido->update();
            return redirect()->back()->with('success', 'El producto se verifico y aprobo para pasar a produccion');
        }
        return redirect()->back()->withErrors('No existe el producto');
    }
    public function rechazarDetalle(Request $request, $id)
    {

        $rules = [
            'aviso_detalle'    =>  'required|max:190'
        ];



        $messages = [
            'aviso_detalle.required' => 'La descripcion del rechazo es obligatorio.',
            'aviso_detalle.max' => 'El tamaño maximo del aviso es 190 caracteres.'
        ];

        $this->validate($request, $rules, $messages);

        $detallePedido = DetallePedido::find($id);
        if ($detallePedido != null) {
            $detallePedido->verificado = 0;
            $detallePedido->aviso = $request->aviso_detalle;
            $detallePedido->update();
            return redirect()->back()->with('warning', 'El producto se rechazo por algun motivo descrito en AVISOS');
        }
        return redirect()->back()->withErrors('No existe el producto');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\DetallePedido  $detallePedido
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $detalle = DetallePedido::findOrFail($id);

        return [
            'data' => $detalle
        ];
    }
    public function estadoAnterior($id)
    {

        $detalle = DetallePedido::findOrFail($id);
        $mensaje = [];
        if ($detalle != null) {
            $estadoAnterior = $detalle->producto->modelo->flujoTrabajo->estadoAnterior($detalle->estado);
            if ($estadoAnterior != null) {
                $detalle->estado_id = $estadoAnterior->id;
                if ($detalle->update()) {
                    $mensaje = array_merge($mensaje, ['success' => 'Cambiado al estado anterior.']);
                    $mensaje = array_merge($mensaje, ['estado' => $estadoAnterior]);
                } else {
                    $mensaje = array_merge($mensaje, ['warning' => 'No se actualizo el producto al  estado anterior.']);
                }
            }


            return response()->json($mensaje);
        }

        $mensaje = array_merge($mensaje,  ['errors' => ['El detalle del producto no existe']]);
        return response()->json($mensaje);
        // return ['errors' => ['El detalle del producto no existe']];
    }
    public function estadoSiguiente($id)
    {

        $detalle = DetallePedido::findOrFail($id);
        $mensaje = [];

        if ($detalle != null) {
            $estadoSiguiente = $detalle->producto->modelo->flujoTrabajo->siguienteEstado($detalle->estado);

            if ($estadoSiguiente != null) {
                $detalle->estado_id = $estadoSiguiente->id;
                if ($detalle->update()) {
                    $mensaje = array_merge($mensaje, ['success' => 'Cambiado al siguiente estado.']);
                    $mensaje = array_merge($mensaje, ['estado' => $estadoSiguiente]);
                } else {
                    $mensaje = array_merge($mensaje, ['warning' => 'No se actualizo el producto al siguiente estado.']);
                }
            }


            return response()->json($mensaje);
        }

        $mensaje = array_merge($mensaje,  ['errors' => ['El detalle del producto no existe']]);
        return response()->json($mensaje);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DetallePedido  $detallePedido
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $id)
    {

        $rules = [

            'cantidad'     =>  'required|integer|min:1'
        ];

        $messages = [

            'cantidad.required' => 'La cantidad del producto es necesario',
            'cantidad.integer' => 'La cantidad debe ser un valor entero',
            'cantidad.min' => 'La cantidad minima es 1'
        ];

        $this->validate($request, $rules, $messages);



        $detallePedido = DetallePedido::find($id);
        if (is_null($detallePedido)) {
            return redirect()->back()->withErrors('El detalle de pedido no existe');
        } else {
            if (!is_null($detallePedido->pedido)) { } else {
                return redirect()->back()->withErrors('El detalle de pedido no esta asociado a ningun pedido');
            }
        }
        if (!is_null($detallePedido->pedido->fechaPago) || !is_null($detallePedido->pedido->preference_id)) {
            $form_data = array(
                'detalle'        =>  $request->detalle
            );
            $detallePedido->update($form_data);
            return redirect()->back()->with('warning', 'El pedido esta confirmado no puede modificar sus cantidades');
        } else {
            $form_data = array(
                'detalle'        =>  $request->detalle,
                'cantidad'         =>  $request->cantidad
            );
            $pedido = $detallePedido->pedido;
            // $pedido->precio -= $detallePedido->producto->modelo->precioUnitario * $detallePedido->cantidad;
            $detallePedido->update($form_data);
            if (!is_null($detallePedido)) {
                // $pedido->precio += $detallePedido->producto->modelo->precioUnitario * $detallePedido->cantidad;
                $pedido->update();
            }
        }


        return redirect()->back()->with('success', 'Detalle del pedido actualizado con exito!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DetallePedido  $detallePedido
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $detallePedido = DetallePedido::find($id);
        if ($detallePedido != null) {
            if (!is_null($detallePedido->pedido->pago_id)) {
                return redirect()->back()->withErrors('No puede eliminar un dealle del pedido pagado');
            }
            if (!is_null($detallePedido->pedido->preference_id)) {
                return redirect()->back()->withErrors('No puede eliminar un dealle del pedido confirmado para el pago');
            }
            if (!$detallePedido->pedido->terminado) {
                $pedido = Pedido::find($detallePedido->pedido->id);
                // $pedido->precio -=  $detallePedido->producto->modelo->precioUnitario * $detallePedido->cantidad;
                $pedido->update();
                //si el pedido no es el final osea que uno nuevo debo borrrarlo
                if (!$detallePedido->producto->final) {

                    $detallePedido->producto->delete();
                    $detallePedido->delete();
                    return redirect()->back()->with('warning', 'El detalle del pedido se elmino y el producto nuevo tambien');
                }
                $detallePedido->delete();
                return redirect()->back()->with('warning', 'El detalle del pedido se elimino');
            }
            return redirect()->back()->withErrors('No se puede eliminar el detalle del pedido porque el pedido a finalizado');
        }
        return redirect()->back()->withErrors('El detalle de pedido a eliminar no existe');
    }
}
