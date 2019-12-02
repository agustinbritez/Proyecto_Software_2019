<?php

namespace App\Http\Controllers;

use App\Charts\Estadistica;
use App\Modelo;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EstadisticaController extends Controller
{

    public function index()
    {
        return view('estadistica.index');
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
        $estadistica->title('Productos Vendidos');
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

        return View('estadistica.productosMasVendidos', compact('estadistica'));
    }
}
