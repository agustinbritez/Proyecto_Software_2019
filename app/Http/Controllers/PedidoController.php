<?php

namespace App\Http\Controllers;

use App\DetallePedido;
use App\FlujoTrabajo;
use App\Modelo;
use App\Pedido;
use App\Producto;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pedidos = Pedido::all();
        $modelos = Modelo::all();
        return view('pedido.index', compact('pedidos', 'modelos'));
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
    public function store(Request $request, $idUsuario)
    {
        //
    }

    public function agregarCarrito(Producto $producto, $cantidad, $usuario)
    {
        $verificado = 1;
        if ($usuario->pedidoAPagar() != null) {
            foreach ($producto->sublimaciones as $key => $sublimacion) {

                if ($sublimacion->nuevaImagen != null) {
                    $verificado = null;
                    break;
                }
            }
            $flujoTrabajo = FlujoTrabajo::where('nombre', 'FLUJO PRODUCCION GENERAL')->first();
            $estado = null;
            if ($producto->modelo->flujoTrabajo != null) {
                if ($producto->modelo->flujoTrabajo->getEstadoInicial() != null) {

                    $estado = $producto->modelo->flujoTrabajo->getEstadoInicial()->id;
                }
            }

            $detallePedido = DetallePedido::create([
                'cantidad' => $cantidad,
                'verificado' => $verificado,
                'pedido_id' => $usuario->pedidoAPagar()->id,
                'producto_id' => $producto->id,
                'estado_id'         =>  $estado,


            ]);
        }
        return 0;
    }

    public function misPedidos()
    {
        $misPedidos = auth()->user()->pedidos;
        $estados = (FlujoTrabajo::find(1))->getEstados();
        $productosVenta = Modelo::where('venta', '<>', 0)->where('venta', '<>', null)->get();

        return view('pedido.misPedidos', compact('misPedidos', 'estados', 'productosVenta'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Pedido  $pedido
     * @return \Illuminate\Http\Response
     */
    public function show(Pedido $pedido)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Pedido  $pedido
     * @return \Illuminate\Http\Response
     */
    public function edit(Pedido $pedido)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Pedido  $pedido
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pedido $pedido)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pedido  $pedido
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pedido = Pedido::find($id);
        if ($pedido->terminado == null) {
            $pedido->delete();
            return redirect()->back()->with('warning', 'Se elimino el pedido de manera correcta');
        }
        if ($pedido->terminado) {
            return redirect()->back()->withErrors(['message2' => 'No se puede eliminar el pedido porque ha finalizado']);
        } else {
            return redirect()->back()->withErrors(['message2' => 'No se puede eliminar el pedido porque se ha pagado']);
        }

        return redirect()->back()->withErrors('No se pudo eliminar el pedido');
    }
}
