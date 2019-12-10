<?php

namespace App\Http\Controllers;

use App\Charts\Estadistica;
use App\DetallePedido;
use App\Modelo;
use App\Movimiento;
use App\Pedido;
use App\Producto;
use App\TipoMovimiento;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class EstadisticaController extends Controller
{

    public function index()
    {
        // return $start = new Carbon('last day of this month');
        $productosMasVendidos = $this->productosMasVendidos();
        // $productosMasVendidos = $this->filtroEvolucionMasVendido(new Request(), 4);
        // $materiaPrimasMasConsumidas = $this->materiaPrimasMasConsumidas();
        $ingresoPorProducto = $this->ingresoPorProducto(new Request());

        // $materiaPrimasMasConsumidas = $this->materiaPrimasMasConsumidas();
        return view('estadistica.index', compact('productosMasVendidos', 'materiaPrimasMasConsumidas', 'ingresoPorProducto'));
    }

    public function evolucionProducto(Request $request)
    {
        $productosMasVendidos = $this->productosMasVendidos();
        // $productosMasVendidos = $this->filtroEvolucionMasVendido(new Request(), 4);
        $modelo = Modelo::where('venta', true)->first();
        $evolucionProducto = $this->filtroEvolucionMasVendido($request, [$modelo->id]);
        $modelos = Modelo::where('venta', true)
            ->join('productos', 'productos.modelo_id', '=', 'modelos.id')
            ->join('detalle_pedidos', 'detalle_pedidos.producto_id', '=', 'productos.id')
            ->where('detalle_pedidos.fechaPago', '<>', null)
            ->groupBy('modelos.id')
            ->select('modelos.*')
            ->get();
        $vuelto = $request;
        return view('estadistica.productosMasVendidos', compact('productosMasVendidos', 'evolucionProducto', 'modelos', 'vuelto'));
    }
    public function filtroEvolucionProducto(Request $request)
    {
        $productosMasVendidos = $this->filtroProductosMasVendidos($request);
        // $productosMasVendidos = $this->filtroEvolucionMasVendido(new Request(), 4);
        if (!$request->has('modelosEvolucionProducto')) {
            $modelo = Modelo::where('venta', true)->first();

            $evolucionProducto = $this->filtroEvolucionMasVendido($request, [$modelo->id]);
        } else {
            $evolucionProducto = $this->filtroEvolucionMasVendido($request, $request->modelosEvolucionProducto);
        }
        $modelos = Modelo::where('venta', true)
            ->join('productos', 'productos.modelo_id', '=', 'modelos.id')
            ->join('detalle_pedidos', 'detalle_pedidos.producto_id', '=', 'productos.id')
            ->where('detalle_pedidos.fechaPago', '<>', null)
            ->groupBy('modelos.id')
            ->select('modelos.*')
            ->get();
        $vuelto = $request;
        return view('estadistica.productosMasVendidos', compact('productosMasVendidos', 'evolucionProducto', 'modelos', 'vuelto'));
    }
    public function ingresosProductos(Request $request)
    {
        $ingresoPorProducto = $this->ingresoPorProducto($request);
        // $productosMasVendidos = $this->filtroEvolucionMasVendido(new Request(), 4);
        if (!$request->has('modelos')) {
            $modelo = Modelo::where('venta', true)->first();
            $evolucionProducto = $this->evolucionIngresoPorProducto($request, [$modelo->id]);
        } else {
            $evolucionProducto = $this->evolucionIngresoPorProducto($request, $request->modelos);
        }
        $modelos = Modelo::where('venta', true)
            ->join('productos', 'productos.modelo_id', '=', 'modelos.id')
            ->join('detalle_pedidos', 'detalle_pedidos.producto_id', '=', 'productos.id')
            ->where('detalle_pedidos.fechaPago', '<>', null)
            ->groupBy('modelos.id')
            ->select('modelos.*')
            ->get();
        $vuelto = $request;
        return view('estadistica.ingresosPorProducto', compact('ingresoPorProducto', 'evolucionProducto', 'modelos', 'vuelto'));
    }

    public function prueba()
    {
        # code...
        $estadistica = new Estadistica();
        $estadistica->labels(['1', '2', '3', '4']);
        $estadistica->title('Prueba');
        $estadistica->dataset('nombreDelConjunto', 'bar', [8, 2, 3, 4, 5, 6, 7, 8]);
        return View('estadistica.productosMasVendidos', compact('estadistica'));
    }
    //son los modelos que tienen mas roductos vendidos
    public function productosMasVendidos()
    {


        //     $desde = new Carbon('first day of this month');
        //     $hasta = new Carbon('last day of this month');
        //    return $productos = Producto::where('modelo_id', 4)
        //     ->join('detalle_pedidos', 'detalle_pedidos.producto_id', '=', 'productos.id')
        //     ->whereBetween('detalle_pedidos.fechaPago', [$desde, $hasta->addDays(1)])
        //     // ->select('productos.id')
        //     ->select('productos.*', 'detalle_pedidos.fechaPago as x',DB::raw('count(detalle_pedidos.cantidad) as cantidadNueva'))
        //     ->groupBy('productos.id')
        //     // ->orderBy('detalle_pedidos.fechaPago', 'asc')
        //     ->get();


        $cantidadProductosVendidos = collect();
        $nombreProducto = collect();
        // modelo->productos->pago_id != null pagado
        $modelos = Modelo::all();
        foreach ($modelos as  $modelo) {
            $cantidad = 0;
            # code...
            foreach ($modelo->productosModelos as  $producto) {
                # code...
                // return $producto->detallePedido;
                if ($producto != null) {

                    foreach ($producto->detallePedido as  $detalle) {

                        if (!is_null($detalle->pedido['pago_id'])) {
                            # code...
                            $cantidad += $detalle->cantidad;
                        }
                    }
                }
            }

            if ($cantidad > 0) {
                $cantidadProductosVendidos->add($cantidad);
                $nombreProducto->add($modelo->nombre);
            }
        }
        $estadistica = new Estadistica();
        $estadistica->labels($nombreProducto);
        // $estadistica->title('Productos Vendidos');
        $estadistica->dataset('Cantidad Productos Mas Vendidos', 'bar', $cantidadProductosVendidos)->color("rgba(54, 162, 235)")->backgroundColor("rgba(54, 162, 235, 0.2)");

        // $estadistica->dataset('Frecuencia', 'bar', $cantidad)->color("rgba(54, 162, 235)")->backgroundColor("rgba(54, 162, 235, 0.2)");

        $estadistica->options([
            'scales'              => [
                'xAxes' => [
                    [
                        'scaleLabel' => [
                            'display' => true,
                            'labelString' => 'Productos',
                        ]
                    ]
                ],
                'yAxes' => [
                    [
                        'ticks' => [
                            'beginAtZero' => true,
                        ],
                        'scaleLabel' => [
                            'display' => true,
                            'labelString' => 'Cantidad Vendida',
                        ]
                    ],
                ],
            ],
        ]);
        return $productosMasVendidosTotal = $estadistica;
        return View('estadistica.index', compact('estadistica'));
    }

    public function filtroProductosMasVendidos($request)
    {
        $desde = new Carbon('first day of this month');
        $hasta = new Carbon('last day of this month');

        if (($request->productosMasVendidosDesde != '') && ($request->productosMasVendidosHasta != '')) {
            $desde = new Carbon($request->productosMasVendidosDesde);
            $hasta = new Carbon($request->productosMasVendidosHasta);
        }

        $modelos = Modelo::join('productos', 'modelos.id', '=', 'productos.modelo_id')
            // ->select('modelos.*')
            ->join('detalle_pedidos', 'detalle_pedidos.producto_id', '=', 'productos.id')
            ->leftJoin('pedidos', 'pedidos.id', '=', 'detalle_pedidos.producto_id')

            ->where('modelos.venta', true)
            // ->where('pedidos.pago_id', '<>', null)
            ->whereBetween('detalle_pedidos.fechaPago', [$desde, $hasta->addDays(1)])
            ->select('modelos.*', DB::raw('sum(detalle_pedidos.cantidad) as cantidadNueva'))
            ->groupBy('modelos.id')
            // ->groupBy('modelos.id')
            ->get();


        $cantidadProductosVendidos = collect();
        $nombreProducto = collect();

        foreach ($modelos as $key => $producto) {
            # code...
            $cantidad = Producto::where('productos.modelo_id', $producto->id)
                ->join('detalle_pedidos', 'detalle_pedidos.producto_id', '=', 'productos.id')
                ->whereBetween('detalle_pedidos.fechaPago', [$desde, $hasta->addDays(1)])
                ->sum('detalle_pedidos.cantidad');

            $cantidadProductosVendidos->add($cantidad);
            $nombreProducto->add($producto->nombre);
        }

        $estadistica = new Estadistica();
        $estadistica->labels($nombreProducto);
        // $estadistica->title('Productos Vendidos');
        $estadistica->dataset('Estadistica Productos Mas Vendidos', 'bar', $cantidadProductosVendidos)->color("rgba(54, 162, 235)")->backgroundColor("rgba(54, 162, 235, 0.2)");

        // $estadistica->dataset('Frecuencia', 'bar', $cantidad)->color("rgba(54, 162, 235)")->backgroundColor("rgba(54, 162, 235, 0.2)");

        $estadistica->options([
            'scales'              => [
                'xAxes' => [
                    [
                        'scaleLabel' => [
                            'display' => true,
                            'labelString' => 'Productos',
                        ]
                    ]
                ],
                'yAxes' => [
                    [
                        'ticks' => [
                            'beginAtZero' => true,
                        ],
                        'scaleLabel' => [
                            'display' => true,
                            'labelString' => 'Cantidad Vendida',
                        ]
                    ],
                ],
            ],
        ]);
        return $productosMasVendidosTotal = $estadistica;
        return View('estadistica.index', compact('estadistica'));
    }
    //se obtiene la cantidad  que se vendio  un modelo en una fecha
    public function filtroEvolucionMasVendido(Request $request, $id)
    {
        $modelosCollect = collect();
        foreach ($id as  $value) {
            $modelo = Modelo::find($value);
            if ($modelo == null) {
                return redirect()->back()->withErrors('No existe el producto');
            }
            $modelosCollect->add($modelo);
        }

        $desde = new Carbon('first day of this month');
        $hasta = new Carbon('last day of this month');
        if (intval($request->diasSeparacion) >= 1) {
            $espacioEntreDias = intval($request->diasSeparacion);
        } else {

            $espacioEntreDias = 1;
        }
        if (($request->evolucionProductoDesde != '') && ($request->evolucionProductoHasta)) {
            $desde = new Carbon($request->evolucionProductoDesde);
            $hasta = new Carbon($request->evolucionProductoHasta);
        }

        //ultimo pago de pedido
        $ultimoPedido = DetallePedido::max('detalle_pedidos.fechaPago');


        $fechaUltimoPedido = new Carbon($ultimoPedido);
        $fechaUltimoPedido->addDays(1);
        if ($fechaUltimoPedido->lessThan($hasta)) {
            $hasta = $fechaUltimoPedido;
        }

        // $espacioEntreDias=$request->dias;

        $diaActual = new Carbon($desde);
        $diaSiguiente = new Carbon($diaActual);
        $diaSiguiente->addDays($espacioEntreDias);
        //lo que se muestra vertical
        //lo que se muestra horizontal
        $diasEvaluado = collect();
        while ($diaActual < $hasta) {
            $diasEvaluado->add($diaActual->format('d/m/Y'));
            $diaActual->addDays($espacioEntreDias);
        }
        $estadistica = new Estadistica();

        $estadistica->labels($diasEvaluado);


        foreach ($modelosCollect as $key => $modelo) {
            # code...
            $cantidadPorFecha = collect();
            $diaActual = new Carbon($desde);
            $diaSiguiente = new Carbon($diaActual);
            $diaSiguiente->addDays($espacioEntreDias);
            // return $diaActual->lessThan($hasta) ? 1: 2;
            while ($diaActual < $hasta) {
                # code...
                //obtenemos la cantidad de productos que se obtiene en un rango de dias 
                $cantidad = Producto::where('modelo_id', $modelo->id)
                    ->join('detalle_pedidos', 'detalle_pedidos.producto_id', '=', 'productos.id')
                    ->whereBetween('detalle_pedidos.fechaPago', [$diaActual, $diaSiguiente])
                    // ->select('productos.id',DB::raw('sum(detalle_pedidos.cantidad) as cantidadNueva'))
                    // ->groupBy('productos.id')
                    // ->orderBy('detalle_pedidos.fechaPago', 'asc')
                    // ->select('productos.*')
                    ->sum('detalle_pedidos.cantidad');

                $cantidadPorFecha->add($cantidad);

                $diaActual->addDays($espacioEntreDias);
                $diaSiguiente->addDays($espacioEntreDias);
            }
            $r = rand(0, 255);
            $g = rand(0, 255);
            $b = rand(0, 255);
            $estadistica->dataset('Evolucion de ' . $modelo->nombre, 'line', $cantidadPorFecha)->color("rgba(" . $r . ", " . $g . ", " . $b . ")")->backgroundColor("rgba(" . $r . ", " . $g . ", " . $b . ", 0.05)");
        }



        // $estadistica->title('');

        // $estadistica->dataset('Frecuencia', 'line', $cantidad)->color("rgba(54, 162, 235)")->backgroundColor("rgba(54, 162, 235, 0.2)");

        $estadistica->options([
            'scales'              => [
                'xAxes' => [
                    [
                        'scaleLabel' => [
                            'display' => true,
                            'labelString' => 'Fechas',
                        ]
                    ]
                ],
                'yAxes' => [
                    [
                        'ticks' => [
                            'beginAtZero' => true,
                        ],
                        'scaleLabel' => [
                            'display' => true,
                            'labelString' => 'Cantidad Vendida',
                        ]
                    ],
                ],
            ],
        ]);
        return $productosMasVendidosTotal = $estadistica;
        return View('estadistica.index', compact('estadistica'));
    }

    public function materiaPrimasMasConsumidas()
    {
        $primerDia = new Carbon('first day of this month');
        $ultimoDia = new Carbon('last day of this month');

        $cantidadMateriaPrimaConsumida = collect();
        $nombreMateriaPrima = collect();

        //************************************************************************************************* */
        // si quiero obtener los datos de una tabla debo ponerlo como el ultimo JOIN asi ell pisa el id de las otras tablas
        $movimientos = DB::table('materia_primas')->whereBetween('movimientos.created_at', [$primerDia, $ultimoDia])
            ->join('movimientos', 'movimientos.materiaPrima_id', '=', 'materia_primas.id')
            ->join('tipo_movimientos', 'movimientos.tipoMovimiento_id', '=', 'tipo_movimientos.id')
            ->where('tipo_movimientos.operacion', 0)
            ->select('movimientos.*', 'materia_primas.nombre')->get();
        // $materiaPrimasContadas = [];

        $materiaPrimasContadas = collect();
        //inicializamos cada posciion de la collecion en 0, cada indice de la coleccion es el ID de la materia prima
        foreach ($movimientos as $key => $movimiento) {
            $materiaPrimasContadas->put($movimiento->materiaPrima_id, 0);
            $nombreMateriaPrima->put($movimiento->materiaPrima_id, $movimiento->nombre);
        }
        foreach ($movimientos as  $movimiento) {
            $materiaPrimasContadas->put($movimiento->materiaPrima_id, $materiaPrimasContadas[$movimiento->materiaPrima_id] + $movimiento->cantidad);
        }
        $materiaContadaFinal = collect();
        $nombreMateriaFinal = collect();

        foreach ($materiaPrimasContadas as $key => $conta) {
            # code...
            $materiaContadaFinal->add($materiaPrimasContadas[$key]);
            $nombreMateriaFinal->add($nombreMateriaPrima[$key]);
        }


        $estadistica = new Estadistica();
        $estadistica->labels($nombreMateriaFinal);
        // $estadistica->title('Materia Prima Mas Consumidas');
        $estadistica->dataset('Venta de materia prima ', 'bar', $materiaContadaFinal)->color("rgba(54, 162, 235)")->backgroundColor("rgba(54, 162, 235, 0.2)");

        // $estadistica->dataset('Frecuencia', 'bar', $cantidad)->color("rgba(54, 162, 235)")->backgroundColor("rgba(54, 162, 235, 0.2)");

        $estadistica->options([
            'scales'              => [
                'xAxes' => [
                    [
                        'scaleLabel' => [
                            'display' => true,
                            'labelString' => 'Materia Primas',
                        ]
                    ]
                ],
                'yAxes' => [
                    [
                        'ticks' => [
                            'beginAtZero' => true,
                        ],
                        'scaleLabel' => [
                            'display' => true,
                            'labelString' => 'Cantidad Vendida',
                        ]
                    ],
                ],
            ],
        ]);
        return $estadistica;
        // return $productosMasVendidosTotal = $estadistica;
        return View('estadistica.index', compact('estadistica'));
    }

    public function ingresoPorProducto($request)
    {





        $desde = new Carbon('first day of this month');
        $hasta = new Carbon('last day of this month');

        if (($request->ingresoPorProductoDesde != '') && ($request->ingresoPorProductoHasta != '')) {
            $desde = new Carbon($request->ingresoPorProductoDesde);
            $hasta = new Carbon($request->ingresoPorProductoHasta);
        }
        //precio de los productos mas vendidos
        $modelos = Producto::join('modelos', 'modelos.id', '=', 'productos.modelo_id')
            ->where('modelos.venta', true)
            ->join('detalle_pedidos', 'detalle_pedidos.producto_id', '=', 'productos.id')
            // ->leftJoin('pedidos', 'pedidos.id', '=', 'detalle_pedidos.producto_id')
            ->where('detalle_pedidos.fechaPago', '<>', null)
            ->whereBetween('detalle_pedidos.fechaPago', [$desde, $hasta->addDays(1)])
            // ->select('modelos.*', DB::raw('sum(detalle_pedidos.cantidad) as cantidadNueva'))
            ->select('modelos.*')
            // ->groupBy('modelos.id')
            // ->select('modelos.*')
            ->groupBy('modelos.id')
            ->get();
        $preciosProductos = collect();
        $nombreProducto = collect();

        foreach ($modelos as $key => $producto) {
            # code...
            $consulta = Producto::where('productos.modelo_id', $producto->id)
                ->join('detalle_pedidos', 'detalle_pedidos.producto_id', '=', 'productos.id')
                ->whereBetween('detalle_pedidos.fechaPago', [$desde, $hasta->addDays(1)]);

            $cantidad = $consulta->sum('detalle_pedidos.cantidad');
            if ($cantidad > 0) {
                $preciosProductos->add($producto->precioUnitario * $cantidad);
                $nombreProducto->add($producto->nombre);
            }
        }
        $estadistica = new Estadistica();
        $estadistica->labels($nombreProducto);
        // $estadistica->title('Productos Vendidos');
        $estadistica->dataset('Precio Productos Mas Vendidos', 'bar', $preciosProductos)->color("rgba(54, 162, 235)")->backgroundColor("rgba(54, 162, 235, 0.2)");

        // $estadistica->dataset('Frecuencia', 'bar', $cantidad)->color("rgba(54, 162, 235)")->backgroundColor("rgba(54, 162, 235, 0.2)");

        $estadistica->options([
            'scales'              => [
                'xAxes' => [
                    [
                        'scaleLabel' => [
                            'display' => true,
                            'labelString' => 'Productos',
                        ]
                    ]
                ],
                'yAxes' => [
                    [
                        'ticks' => [
                            'beginAtZero' => true,
                        ],
                        'scaleLabel' => [
                            'display' => true,
                            'labelString' => 'Precio del Producto',
                        ]
                    ],
                ],
            ],
        ]);
        return $productosMasVendidosTotal = $estadistica;
    }

    public function evolucionIngresoPorProducto($request, $id)
    {


        //************************************************************* */
        $modelosCollect = collect();
        foreach ($id as  $value) {
            $modelo = Modelo::find($value);
            if ($modelo == null) {
                return redirect()->back()->withErrors('No existe el producto');
            }
            $modelosCollect->add($modelo);
        }

        $desde = new Carbon('first day of this month');
        $hasta = new Carbon('last day of this month');

        if (intval($request->diasSeparacion) >= 1) {
            $espacioEntreDias = intval($request->diasSeparacion);
        } else {

            $espacioEntreDias = 1;
        }
        if (($request->evolucionProductoDesde != '') && ($request->evolucionProductoHasta)) {
            $desde = new Carbon($request->evolucionProductoDesde);
            $hasta = new Carbon($request->evolucionProductoHasta);
        }

        //ultimo pago de pedido
        $ultimoPedido = DetallePedido::max('detalle_pedidos.fechaPago');

        $fechaUltimoPedido = new Carbon($ultimoPedido);
        $fechaUltimoPedido->addDays(1);
        if ($fechaUltimoPedido->lessThan($hasta)) {
            $hasta = $fechaUltimoPedido;
        }

        // $espacioEntreDias=$request->dias;

        $diaActual = new Carbon($desde);
        $diaSiguiente = new Carbon($diaActual);
        $diaSiguiente->addDays($espacioEntreDias);
        //lo que se muestra vertical
        //lo que se muestra horizontal
        $diasEvaluado = collect();
        while ($diaActual < $hasta) {
            $diasEvaluado->add($diaActual->format('d/m/Y'));
            $diaActual->addDays($espacioEntreDias);
        }

        $estadistica = new Estadistica();

        $estadistica->labels($diasEvaluado);


        foreach ($modelosCollect as $key => $modelo) {
            # code...
            $cantidadPorFecha = collect();
            $diaActual = new Carbon($desde);
            $diaSiguiente = new Carbon($diaActual);
            $diaSiguiente->addDays($espacioEntreDias);
            // return $diaActual->lessThan($hasta) ? 1: 2;
            while ($diaActual < $hasta) {
                # code...
                //obtenemos la cantidad de productos que se obtiene en un rango de dias 
                $cantidad = Producto::where('modelo_id', $modelo->id)
                    ->join('detalle_pedidos', 'detalle_pedidos.producto_id', '=', 'productos.id')
                    ->whereBetween('detalle_pedidos.fechaPago', [$diaActual, $diaSiguiente])
                    // ->select('productos.id',DB::raw('sum(detalle_pedidos.cantidad) as cantidadNueva'))
                    // ->groupBy('productos.id')
                    // ->orderBy('detalle_pedidos.fechaPago', 'asc')
                    // ->select('productos.*')
                    ->sum('detalle_pedidos.cantidad');

                $cantidadPorFecha->add($cantidad * $modelo->precioUnitario);

                $diaActual->addDays($espacioEntreDias);
                $diaSiguiente->addDays($espacioEntreDias);
            }
            $r = rand(0, 255);
            $g = rand(0, 255);
            $b = rand(0, 255);
            $estadistica->dataset('Evolucion de ' . $modelo->nombre, 'line', $cantidadPorFecha)->color("rgba(" . $r . ", " . $g . ", " . $b . ")")->backgroundColor("rgba(" . $r . ", " . $g . ", " . $b . ", 0.05)");
        }


        $estadistica->options([
            'scales'              => [
                'xAxes' => [
                    [
                        'scaleLabel' => [
                            'display' => true,
                            'labelString' => 'Fechas',
                        ]
                    ]
                ],
                'yAxes' => [
                    [
                        'ticks' => [
                            'beginAtZero' => true,
                        ],
                        'scaleLabel' => [
                            'display' => true,
                            'labelString' => 'Cantidad Vendida',
                        ]
                    ],
                ],
            ],
        ]);
        return $productosMasVendidosTotal = $estadistica;
    }
}
