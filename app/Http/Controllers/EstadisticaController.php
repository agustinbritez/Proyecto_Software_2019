<?php

namespace App\Http\Controllers;

use App\Charts\Estadistica;
use App\Modelo;
use App\Movimiento;
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
        $materiaPrimasMasConsumidas = $this->materiaPrimasMasConsumidas();
        return view('estadistica.index', compact('productosMasVendidos', 'materiaPrimasMasConsumidas'));
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
}
