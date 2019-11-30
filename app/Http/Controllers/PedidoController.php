<?php

namespace App\Http\Controllers;

use App\DetallePedido;
use App\Estado;
use App\FlujoTrabajo;
use App\MateriaPrimaSeleccionada;
use App\Modelo;
use App\Pedido;
use App\Producto;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function confirmarPedido($id)
    {
        # code...

        $pedido = Pedido::find($id);
        $nombre = 'Pedro';
        if ($pedido != null) {
            if ($pedido->detallePedidos->isEmpty()) {
                return redirect()->back()->withErrors('El pedido no tienen ningun producto');
            }
            if (!is_null($pedido->pago_id)) {
                return redirect()->back()->withErrors('El pedido ya se encuentra confirmado');
            }
            $mesajito = ['No se cuenta con las siguientes materas primas para producir'];
            $noHayMateria = false;
            foreach ($pedido->detallePedidos as $key => $detalle) {
                # code...
                $materiasPrimasSelec = $detalle->producto->modelo->comprobarResta($detalle->cantidad, $detalle->producto->materiaPrimaSeleccionadas);
                if ($materiasPrimasSelec != []) {
                    $noHayMateria = true;
                    foreach ($materiasPrimasSelec as $key => $materia) {
                        # code...
                        $mesajito = array_merge($mesajito, [$materia->nombre . ' en el detalle con ID: ' . $detalle->id]);
                    }
                }
            }
            if ($noHayMateria) {
                return redirect()->back()->withErrors($mesajito);
            }

            // TEST-7806727451891484-112420-84bc4622e2e2695653bd6a496d4f71a8-166999392
            // $mercadoPago= ;
            //pagos en prueba
            try {
                //code...
                \MercadoPago\SDK::setAccessToken('TEST-7806727451891484-112420-84bc4622e2e2695653bd6a496d4f71a8-166999392');
                $preference = new \MercadoPago\Preference();
                $item = new \MercadoPago\Item();
            } catch (Exception $th) {
                //throw $th;
                return view('errors.internet');
            }
            $item->title = $nombre;
            $item->description = $nombre;
            $item->quantity = 1;
            $item->unit_price = $pedido->getPrecio();
            $preference->back_urls = array(
                "success" => route('pedido.pagarPedido', $pedido->id),
                "failure" => route('pedido.misPedidos'),
                "pending" => route('pedido.misPedidos')
            );
            $preference->auto_return = "approved";
            $preference->external_reference = $pedido->id;
            $preference->items = [$item];
            $preference->save();
            // dd($preference);
            $pedido->preference_id = $preference->id;
            // $pedido->precio = $item->unit_price;
            // $pedido->rutaDePago = $preference->sandbox_init_point;
            // $pedido->estado_id = $pedido->flujoTrabajo->siguienteEstado($pedido->estado)->id;
            // $pedido->cambioEstado = Carbon::now();
            $pedido->update();
            return redirect($preference->sandbox_init_point);
            // dd($preference);
            return redirect()->back()->withErrors('El pedido no se pudo confirmar');
        }
        return redirect()->back()->withErrors('El pedido no se pudo confirmar');
    }

    public function pagarPedido(Request $request, $id)
    {

        $pedido = Pedido::find($id);
        if (is_null($pedido)) {
            return redirect()->route('pedido.misPedidos')->withErrors('El pedido  no existe');
        }


        try {
            //code...
            \MercadoPago\SDK::setAccessToken('TEST-7806727451891484-112420-84bc4622e2e2695653bd6a496d4f71a8-166999392');
        } catch (Exception $th) {
            //throw $th;
            return view('errors.404');
        }
        if (!$request->has('preference_id')) {
            return redirect()->route('pedido.misPedidos')->withErrors('No existe el encargo del pedido');
        }
        $preference = \MercadoPago\Preference::find_by_id($request->preference_id);
        // dd(['UNO' => $pago, 'DOS' => $request]);
        // return $pago = \MercadoPago\Payment::find_by_id($pedido->pago_id);
        // return dd($pago);

        $espera = Estado::where('nombre', 'CARRITO')->first();
        if (!is_null($pedido->pago_id)) {
            return redirect()->route('pedido.misPedidos')->withErrors('El pedido ya se encuentra pagado');
        }
        if ($request != null) {

            if (strtoupper($pedido->estado->nombre) == strtoupper($espera->nombre)) {
                if ($request->collection_status == 'approved' && $request->external_reference == $id && $request->preference_id == $pedido->preference_id) {
                    $pedido->estado_id = $pedido->flujoTrabajo->siguienteEstado($pedido->estado)->id;
                    $pedido->cambioEstado = Carbon::now();
                    //el pago_id me sirve para 
                    $pedido->pago_id = $request->collection_id;
                    $pedido->fechaPago = Carbon::now();
                    $pedido->cambioEstado = Carbon::now();
                    $pedido->precio = $preference->items[0]->unit_price;
                    //si terminado es 0 significa que pago pero no se termino de producir el producto
                    $pedido->terminado = 0;
                    $pedido->restarMateriaPrimas();
                    $pedido->update();
                    $conMate = new ControllerMateriaPrima();
                    $conMate->verificarStock();
                } else {

                    return redirect()->route('pedido.misPedidos')->withErrors('Error al Asignar Pago');
                    // return redirect()->route('pedido.misPedidos', $id)->withErrors('Error al Asignar Pago');
                }
            } else {
                return redirect()->route('pedido.misPedidos')->withErrors('Su pago ya se encuetra realizado');
                // return redirect()->route('pedido.misPedidos', $id)->withErrors('Su pago ya se encuetra realizado');
            }
        } else {
            return redirect()->route('pedido.misPedidos')->withErrors('Error al Asignar Pago');
            // return redirect()->route('pedido.misPedidos', $id)->withErrors('Error al Asignar Pago');
        }
        return redirect()->route('pedido.misPedidos')->with('success', 'Su pago ha sido Efectuado Correctamente, Gracias.');
        // view('pedido.misPedidos', compact('misPedidos', 'estados', 'productosVenta'))->with('success', 'Su pago ha sido Efectuado Correctamente, Gracias.');
        // return redirect()->route('pedido.misPedidos', $id)->with('success', 'Su pago ha sido Efectuado Correctamente, Gracias.');
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

    public function agregarCarrito(Producto $producto, $cantidad, $usuario, $materiasPrimasSeleccionadas)
    {
        //creamos el pedido y asociamos el producto a un detalle de pedido

        if ($usuario->pedidoAPagar() != null) {


            $verificado = 1;

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
            $pedido = Pedido::find($usuario->pedidoAPagar()->id);
            $detallePedido = DetallePedido::create([
                'cantidad' => $cantidad,
                'verificado' => $verificado,
                'pedido_id' => $pedido->id,
                'producto_id' => $producto->id,
                'estado_id'         =>  $estado,

            ]);

            if ($detallePedido != null) {
                foreach ($materiasPrimasSeleccionadas as $key => $padreEHijo) {
                    # code...
                    // return $padreEHijo;
                    $materiaSeleccionada = MateriaPrimaSeleccionada::create([
                        'recetaPadre_id' => $padreEHijo[0],
                        'recetaHijo_id' => $padreEHijo[1],
                        'producto_id' => $detallePedido->id
                    ]);
                }
            }
            // $detallePedido->recetas()->sync($materiasPrimasSeleccionadas);
            // $detallePedido->recetasPadres()->sync($materiasPrimasSeleccionadas);

            // $pedido->precio +=  $producto->modelo->precioUnitario * $detallePedido->cantidad;
            $pedido->update();
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
    //el pedido finaliza por completo con su produccion
    public function terminarPedido($id)
    {
        # code...
        $pedido = Pedido::find($id);
        if ($pedido != null) {
            if ($pedido->terminado) {
                return redirect()->back()->with('success', 'Pedido se encuentra finalizado');
            }
            foreach ($pedido->detallePedidos as $key => $detalle) {
                # code...
                if (!$detalle->verificado) {
                    return redirect()->back()->withErrors('No se puede finalizar un pedido que tiene productos sin verificar');
                }
                if ($detalle->producto->modelo->flujoTrabajo->getEstadoFinal()->id != $detalle->estado->id) {

                    return redirect()->back()->withErrors('No se puede finalizar un pedido que tiene detalles de pedido sin terminar');
                }
            }

            //las materias primas que no se pudieron restar porque su rresultado es negativo
            $materiaPrimasNoRestadas = [];
            foreach ($pedido->detallePedidos as $key => $detalle) {
                $materiaPrimasNoRestadas = array_merge($materiaPrimasNoRestadas, $detalle->producto->modelo->comprobarResta($detalle->cantidad));
            }

            if ($materiaPrimasNoRestadas == []) {
                # code...
                foreach ($pedido->detallePedidos as $key => $detalle) {
                    $detalle->producto->modelo->restarMateriaPrima($detalle->cantidad);
                }

                $pedido->terminado = 1;
                $pedido->estado_id = $pedido->flujoTrabajo->getEstadoFinal()->id;
                $pedido->update();
                return redirect()->back()->with('success', 'Pedido finalizado con exito!');
            }
            return redirect()->back()->with('materiasPrimasNoRestadas', $materiaPrimasNoRestadas);
        }
        return redirect()->back()->withErrors('No existe el pedido');
    }

    public function trabajo()
    {
        # code...
        // $pedidos = Pedido::all()->where('pago_id', '<>', null)->where('terminado', 0);
        $pedidos = Pedido::where('pago_id', '<>', null)->where('terminado', 0)->orderBy('fechaPago', 'asc')->get();
        $modelos = Modelo::all()->where('venta', true);
        return view('pedido.trabajo', compact('pedidos', 'modelos'));
    }

    public function filtrarTrabajo(Request $request)
    {

        // $pedidos = DB::table('pedidos');
        // $pedidos = Pedido::query();
        $pedidos = Pedido::where('pago_id', '<>', null)->where('terminado', 0);


        if (($request->desde != '') && ($request->hasta != '')) {
            $pedidos = $pedidos
                ->whereDate('fechaPago', '>=', $request->desde)
                ->whereDate('fechaPago', '<=', $request->hasta);
        } else if (($request->desde != '')) {
            $pedidos = $pedidos
                ->whereDate('fechaPago', '>=', $request->desde);
        } else if (($request->hasta != '')) {
            $pedidos = $pedidos
                ->whereDate('fechaPago', '<=', $request->hasta);
        }
        if ($request->has('modelo')) {
            $pedidos = $pedidos->where('modelo_id', $request->modelo);
        }
        //el pedido mas nuevo tiene un valor mas grande por ejemplo 2019-12-1 < 2019-12-2

        if ($request->filtro_pedido == 0) {
            //si es 1 entonces el pedido mas antiguo primero
            $pedidos = $pedidos->orderBy('fechaPago', 'asc');
        } else if ($request->filtro_pedido == 1) {

            $pedidos = $pedidos->orderBy('fechaPago', 'desc');
        }
        $pedidos = $pedidos->get();
        $modelos = Modelo::all()->where('venta', true);
        // return redirect()->back()->with('pedidos',$pedidos)->with('modelos',$modelos);
        $desde = $request->desde;
        $hasta = $request->hasta;
        return view('pedido.trabajo', compact('pedidos', 'modelos', 'desde', 'hasta'));
    }
    // ordena los productos en el orden de cuales se produjeron mas rapidos hasta el dia de la fecha 
    public function ordenamientoInteligente()
    {
        # code...
        //obtenemos todos los pedidos pagados
        $pedidos = Pedido::where('pago_id', '<>', null)->where('terminado', 0)->orderBy('fechaPago', 'asc')->get();
        $detallesOrdenados = collect();

        foreach ($pedidos as $key => $pedido) {
            # code...
            foreach ($pedido->detallePedidos as $key => $detalle) {
                # code...
                $detallesOrdenados->add($detalle);
                // $promedioDeProduccion = $detalle->producto->modelo->promedioProduccion();
            }
        }
        for ($i = 1; $i < count($detallesOrdenados); $i++) {
            for ($j = 0; $j < count($detallesOrdenados) - $i; $j++) {
                if ($detallesOrdenados[$j]->producto->modelo->promedioProduccion() > $detallesOrdenados[$j + 1]->producto->modelo->promedioProduccion()) {
                    $k = $detallesOrdenados[$j + 1];
                    $detallesOrdenados[$j + 1] = $detallesOrdenados[$j];
                    $detallesOrdenados[$j] = $k;
                }
            }
        }
        $modelos = Modelo::all()->where('venta', true);


        return view('pedido.trabajo', compact('pedidos', 'modelos', 'detallesOrdenados'));
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
        if ($pedido == null) {
            return redirect()->back()->withErrors('No existe el pedido');
        }

        if (!is_null($pedido->pago_id)) {
            return redirect()->back()->withErrors('No se puede eliminar un pedido pagado');
        }
        if ($pedido->user->id != auth()->user()->id) {

            return redirect()->back()->withErrors('Usted no es el propietario del pedido no puede eliminarlo');
        }
        if ($pedido->terminado) {
            return redirect()->back()->withErrors(['message2' => 'No se puede eliminar el pedido porque ha finalizado']);
        }




        $pedido->delete();
        return redirect()->back()->with('warning', 'Se elimino el pedido de manera correcta');


        return redirect()->back()->withErrors('No se pudo eliminar el pedido');
    }
}
