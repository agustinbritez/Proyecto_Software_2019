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
        return view('detallePedido.index', compact('detallePedidos', 'modelos'));
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
        $producto = Producto::find($detallePedido->id);
        if ($producto == null) {
            return redirect()->back()->withErrors('El producto no existe');
        }
        $tipoImagenes = TipoImagen::all();
        return view('detallePedido.show', compact('producto', 'tipoImagenes', 'detallePedido'));
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
        $form_data = array(
            'detalle'        =>  $request->detalle,
            'cantidad'         =>  $request->cantidad
        );
        $detallePedido->update($form_data);

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
            if (!$detallePedido->pedido->terminado) {
                //si el pedido no es el final osea que uno nuevo debo borrrarlo
                if (!$detallePedido->producto->final) {
                    $detallePedido->producto->delete();
                    $detallePedido->delete();
                    return redirect()->back()->with('warning', 'El detalle del pedido se elmino y el proucto nuevo tambien');
                }
                $detallePedido->delete();
                return redirect()->back()->with('warning', 'El detalle del pedido se elimino');
            }
            return redirect()->back()->withErrors('No se puede eliminar el detalle del pedido porque el pedido a finalizado');
        }
        return redirect()->back()->withErrors('El detalle de pedido a eliminar no existe');
    }
}
