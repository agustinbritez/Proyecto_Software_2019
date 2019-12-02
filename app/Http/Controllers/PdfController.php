<?php

namespace App\Http\Controllers;

use App\Estado;
use App\MateriaPrima;
use App\Modelo;
use App\Movimiento;
use App\Pedido;
use App\Proveedor;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use OwenIt\Auditing\Models\Audit;
use PDF;
use Psy\Util\Str;

class PdfController extends Controller
{


    public function auditoria(Request $request)
    {
        # code...
        $auditorias = DB::table('audits');

        if ($request->has('filtro_tabla') && !is_null($request->filtro_tabla) && ($request->filtro_tabla != '-1')) {
            $auditorias = $auditorias->where('auditable_type', 'App\\' . $request->filtro_tabla);
        }
        if ($request->has('filtro_user') && !is_null($request->filtro_user) && ($request->filtro_user != '-1')) {
            $auditorias = $auditorias->where('user_id',  $request->filtro_user);
        }
        if ($request->has('filtro_objeto') && !is_null($request->filtro_objeto) && ($request->filtro_objeto != '')) {
            $auditorias = $auditorias->where('auditable_id',  $request->filtro_objeto);
        }

        if ($request->has('filtro_operacion') && !is_null($request->filtro_operacion) && ($request->filtro_operacion != 'Cualquiera')) {
            $auditorias = $auditorias->where('event',  $request->filtro_operacion);
        }

        if (($request->desde != '') && ($request->hasta != '') && ($request->desde != null) && ($request->hasta != null)) {
            $auditorias = $auditorias
                ->whereDate('created_at', '>=', $request->desde)
                ->whereDate('created_at', '<=', $request->hasta);
        } else if (($request->desde != '') && ($request->desde != null)) {
            $auditorias = $auditorias
                ->whereDate('created_at', '>=', $request->desde);
        } else if (($request->hasta != '') && ($request->hasta != null)) {
            $auditorias = $auditorias
                ->whereDate('created_at', '<=', $request->hasta);
        }

        $auditorias = $auditorias->latest()->get();
        // $filtro = collect();
        // foreach ($auditorias as $value) {
        //     # code...
        //     $filtro->add(Audit::find($value->id));
        // }
        // $auditorias = $filtro;
        $usuario = User::find($request->filtro_user);
        if (is_null($usuario)) {
            $usuario = new User();
        }
        // return $filtro->all();
        if ($request->filtro_tabla == '-1') {
            # code...
            $request->filtro_tabla = 'Cualquiera';
        }
        $pdf = PDF::loadView(
            'pdf.auditoria',
            [
                'auditorias' => $auditorias,
                'cantidadRegistros' => sizeof($auditorias),
                'filtro_tabla' => $request->filtro_tabla,
                'usuario' => $usuario,
                'filtro_objeto' => $request->filtro_objeto,
                'filtro_operacion' => $request->filtro_operacion,
                'desde' => $request->desde,
                'hasta' => $request->hasta,
            ]
        );

        $dom_pdf = $pdf->getDomPDF();
        $canvas = $dom_pdf->get_canvas();
        $y = $canvas->get_height() - 35;
        $pdf->getDomPDF()->get_canvas()->page_text(500, $y, "Pagina {PAGE_NUM} de {PAGE_COUNT}", null, 10, array(0, 0, 0));
        // return $pdf->download(Carbon::now() . '-Auditoria.pdf');
        return $pdf->stream();
    }
    public function auditoriaUnObjeto($id)
    {
        # code...
        $auditoria = Audit::find($id);
        $auditorias = [];
        if (!is_null($auditoria)) {
            $auditorias = Audit::where('auditable_id', $auditoria->auditable_id)->where('auditable_type', $auditoria->auditable_type)->latest()->get();
        }
        $pdf = PDF::loadView(
            'pdf.auditoriaUnObjeto',
            [
                'auditorias' => $auditorias,
                'cantidadRegistros' => sizeof($auditorias)
            ]
        );

        $dom_pdf = $pdf->getDomPDF();
        $canvas = $dom_pdf->get_canvas();
        $y = $canvas->get_height() - 35;
        $pdf->getDomPDF()->get_canvas()->page_text(500, $y, "Pagina {PAGE_NUM} de {PAGE_COUNT}", null, 10, array(0, 0, 0));
        // return $pdf->download(Carbon::now() . '-Auditoria.pdf');
        return $pdf->stream();
    }

    public function pedido(Request $request)
    {
        # code...
        $pedidos = DB::table('pedidos')->where('deleted_at', null);
        if (($request->filtro_precioUnitarioMin != '') && ($request->filtro_precioUnitarioMax != '') && ($request->filtro_precioUnitarioMin != null) && ($request->filtro_precioUnitarioMax != null)) {
            $pedidos = $pedidos
                ->where('precio', '>=', $request->filtro_precioUnitarioMin)
                ->where('precio', '<=', $request->filtro_precioUnitarioMax);
        } else if (($request->filtro_precioUnitarioMin != '') && ($request->filtro_precioUnitarioMin != null)) {
            $pedidos = $pedidos
                ->where('precio', '>=', $request->filtro_precioUnitarioMin);
        } else if (($request->filtro_precioUnitarioMax != '') && ($request->filtro_precioUnitarioMax != null)) {
            $pedidos = $pedidos
                ->where('precio', '<=', $request->filtro_precioUnitarioMax);
        }


        if ($request->has('filtro_terminado') && !is_null($request->filtro_terminado) && ($request->filtro_terminado != '-1')) {
            $pedidos = $pedidos->where('terminado',  $request->filtro_terminado);
        }
        if ($request->has('filtro_estado') && !is_null($request->filtro_estado) && ($request->filtro_estado != '-1')) {
            $pedidos = $pedidos->where('estado_id',  $request->filtro_estado);
        }


        if (($request->fechaPagoDesde != '') && ($request->fechaPagoHasta != '') && ($request->fechaPagoDesde != null) && ($request->fechaPagoHasta != null)) {
            $pedidos = $pedidos
                ->whereDate('fechaPago', '>=', $request->fechaPagoDesde)
                ->whereDate('fechaPago', '<=', $request->fechaPagoHasta);
        } else if (($request->fechaPagoDesde != '') && ($request->fechaPagoDesde != null)) {
            $pedidos = $pedidos
                ->whereDate('fechaPago', '>=', $request->fechaPagoDesde);
        } else if (($request->fechaPagoHasta != '') && ($request->fechaPagoHasta != null)) {
            $pedidos = $pedidos
                ->whereDate('fechaPago', '<=', $request->fechaPagoHasta);
        }
        if (($request->estadoDesde != '') && ($request->estadoHasta != '') && ($request->estadoDesde != null) && ($request->estadoHasta != null)) {
            $pedidos = $pedidos
                ->whereDate('cambioEstado', '>=', $request->estadoDesde)
                ->whereDate('cambioEstado', '<=', $request->estadoHasta);
        } else if (($request->estadoDesde != '') && ($request->estadoDesde != null)) {
            $pedidos = $pedidos
                ->whereDate('cambioEstado', '>=', $request->estadoDesde);
        } else if (($request->estadoHasta != '') && ($request->estadoHasta != null)) {
            $pedidos = $pedidos
                ->whereDate('cambioEstado', '<=', $request->estadoHasta);
        }
        $pedidos = $pedidos->latest()->get();
        $pedidoFiltro = collect();
        foreach ($pedidos as $key => $pedido) {
            # code...
            $pedido2 = Pedido::find($pedido->id);
            if (($request->cantidadMin <= $pedido2->getCantidadProductos()) && ($request->cantidadMax >= $pedido2->getCantidadProductos())) {
                $pedidoFiltro->add($pedido2);
            } else if ($request->cantidadMin <= $pedido2->getCantidadProductos()) {

                $pedidoFiltro->add($pedido2);
            } else if ($request->cantidadMax >= $pedido2->getCantidadProductos()) {
                $pedidoFiltro->add($pedido2);
            }
        }
        $pedidos = $pedidoFiltro;
        $terminado = 'No Aplicado';
        if ($request->filtro_terminado != '-1') {

            if ($request->filtro_terminado == '1') {
                $terminado = 'Si';
            } else {
                $terminado = 'No';
            }
        }
        $estado = 'No Aplicado';

        if ($request->filtro_estado != '-1') {
            # code...
            $estado2 = Estado::find($request->filtro_estado);
            if ($estado2 != null) {
                $estado = $estado2->nombre;
            }
        }

        $fPagoDesde = $request->fechaPagoDesde;
        $fPagoHasta =  $request->fechaPagoHasta;

        if (($request->fechaPagoDesde == '') && ($request->fechaPagoHasta == '')) {
            $fPagoDesde = 'No Aplicado';
            $fPagoHasta = 'No Aplicado';
        } else {
            if (($request->fechaPagoDesde != '')) {

                $fPagoDesde = Carbon::create($request->fechaPagoDesde)->format('d/m/Y');
            }
            if (($request->fechaPagoHasta != '')) {

                $fPagoHasta = Carbon::create($request->fechaPagoHasta)->format('d/m/Y');
            }
        }
        $fEstadoDesde = $request->estadoDesde;
        $fEstadoHasta =  $request->estadoHasta;
        if (($request->fechaPagoDesde == '') && ($request->fechaPagoHasta == '')) {
            $fEstadoDesde = 'No Aplicado';
            $fEstadoHasta = 'No Aplicado';
        } else {
            if (($request->estadoDesde != '')) {

                $fEstadoDesde = Carbon::create($request->estadoDesde)->format('d/m/Y');
            }
            if (($request->estadoHasta != '')) {

                $fEstadoHasta =  Carbon::create($request->estadoHasta)->format('d/m/Y');
            }
        }
        if (sizeof($pedidos) == 0) {
            return redirect()->back()->with('warning', 'No se encontraron registros con el filtro ingresado');
        }

        $pdf = PDF::loadView(
            'pdf.pedido',
            [
                'pedidos' => $pedidos,
                'cantidadRegistros' => sizeof($pedidos),
                'cantidadMax' => $request->cantidadMax,
                'cantidadMin' => $request->cantidadMin,
                'fechaPagoDesde' => $fPagoDesde,
                'fechaPagoHasta' => $fPagoHasta,
                'estadoDesde' => $fEstadoDesde,
                'estadoHasta' => $fEstadoHasta,
                'filtro_precioUnitarioMin' => $request->filtro_precioUnitarioMin,
                'filtro_precioUnitarioMax' => $request->filtro_precioUnitarioMax,
                'filtro_terminado' => $terminado,
                'filtro_estado' => $estado,
            ]
        );

        $dom_pdf = $pdf->getDomPDF();
        $canvas = $dom_pdf->get_canvas();
        $y = $canvas->get_height() - 35;
        $pdf->getDomPDF()->get_canvas()->page_text(500, $y, "Pagina {PAGE_NUM} de {PAGE_COUNT}", null, 10, array(0, 0, 0));
        // return $pdf->download(Carbon::now() . '-Auditoria.pdf');
        return $pdf->stream();
    }

    public function movimiento(Request $request)
    {
        // $movimientos = DB::table('movimientos')
        $movimientos = DB::table('movimientos');
        $filtro = collect();


        if ($request->filtro_id != '') {
            $movimientos = $movimientos
                ->where('id', $request->filtro_id);
            $filtro = $filtro->union(['filtro_numero_movimiento' => $request->filtro_id]);
        }

        if ((($request->filtro_precioUnitarioMin != '') && ($request->filtro_precioUnitarioMin > 0.00)) && (($request->filtro_precioUnitarioMax != '') && ($request->filtro_precioUnitarioMax > 0.00))) {
            $movimientos = $movimientos
                ->whereBetween('precioUnitario', [$request->filtro_precioUnitarioMin, $request->filtro_precioUnitarioMax]);

            $filtro = $filtro->union(
                [
                    'filtro_precio_unitario_minimo' =>
                    $request->filtro_precioUnitarioMin
                ]
            );
            $filtro = $filtro->union(
                [
                    'filtro_precio_unitario_maximo' =>
                    $request->filtro_precioUnitarioMax
                ]
            );
        } else if (($request->filtro_precioUnitarioMin != '') && ($request->filtro_precioUnitarioMin > 0.00)) {
            $movimientos = $movimientos
                ->where('precioUnitario', '>', $request->filtro_precioUnitarioMin);
            $filtro = $filtro->union(['filtro_precio_unitario_minimo' => $request->filtro_precioUnitarioMin]);
        } else if (($request->filtro_precioUnitarioMax != '') && ($request->filtro_precioUnitarioMax > 0.00)) {
            $movimientos = $movimientos
                ->where('precioUnitario', '<', $request->filtro_precioUnitarioMax);

            $filtro = $filtro->union(['filtro_precio_unitario_maximo' => $request->filtro_precioUnitarioMax]);
        }

        if (($request->desde != '') && ($request->hasta != '')) {
            $movimientos = $movimientos
                ->whereDate('fecha', '>=', $request->desde)
                ->whereDate('fecha', '<=', $request->hasta);
            $filtro = $filtro->union(
                [
                    'filtro_fecha_desde' =>
                    Carbon::create($request->desde)->format('d/m/Y')
                ]
            );
            $filtro = $filtro->union(
                [
                    'filtro_fecha_hasta' =>
                    Carbon::create($request->hasta)->format('d/m/Y')
                ]
            );
        }

        $movimientos = $movimientos->get();
        $filtro = $filtro->union(['movimientos' => $movimientos]);
        $filtro = $filtro->union(['movimientos' => $movimientos]);


        // return $filtro->all();
        $pdf = PDF::loadView(
            'pdf.movimiento',
            $filtro
        );

        $dom_pdf = $pdf->getDomPDF();
        $canvas = $dom_pdf->get_canvas();
        $y = $canvas->get_height() - 35;
        $pdf->getDomPDF()->get_canvas()->page_text(500, $y, "Pagina {PAGE_NUM} de {PAGE_COUNT}", null, 10, array(0, 0, 0));
        return $pdf->stream();
    }


    public  function materiaPrima(Request $request)
    {
        $materiaPrimas = MateriaPrima::all();
        // CONSANTES
        $_FILTRO_MAXIMO = 3;
        $_OPTION_VACIO = 'Cualquiera';

        //******************************* Obtenemos los filtros y contamos cuantos hay ******************************************* */

        $filtro_nombre = $request->filtro_nombre;
        $filtro_cantidad = $request->filtro_cantidad;

        $filtro_modelo = Modelo::find($request->filtro_modelo);
        //si no existe el ID que paso entonces le asignamos EL valor VACIO que esta de CONSTANTE
        $filtro_modelo = ($filtro_modelo == null) ? $_OPTION_VACIO : $filtro_modelo;

        $cantidad_filtros = 0;
        if (($filtro_nombre != '')) {
            $cantidad_filtros++;
        }
        if ($filtro_modelo != $_OPTION_VACIO) {
            $cantidad_filtros++;
        }
        if ($filtro_cantidad != '') {
            $cantidad_filtros++;
        }


        //******************************* Si no pide filtros devuelve todas las materias primas ******************************************* */

        if ($cantidad_filtros == 0) {
            if (sizeof($materiaPrimas) == 0) {
                return redirect()->back()->with('warning', 'No se encontraron registros con el filtro ingresado');
            }
            $pdf = PDF::loadView('pdf.materiaPrima', [
                'materiaPrimas' => $materiaPrimas,
                'cantidadRegistros' => sizeof($materiaPrimas),
            ]);
            $dom_pdf = $pdf->getDomPDF();
            $canvas = $dom_pdf->get_canvas();
            $y = $canvas->get_height() - 35;
            $pdf->getDomPDF()->get_canvas()->page_text(500, $y, "Pagina {PAGE_NUM} de {PAGE_COUNT}", null, 10, array(0, 0, 0));

            return $pdf->stream();
        }


        //******************************* Si pide  todos los filtros entra aca ******************************************* */

        if ($cantidad_filtros == $_FILTRO_MAXIMO) {

            foreach ($materiaPrimas as $key => $materia) {
                $filtro_completos = 0;
                //la materia prima contiene al modelo del filtro entonces suma
                $materia->modelos->contains($filtro_modelo) ? $filtro_completos++ : 0;
                //la materia prima contiene la cantidad del filtro entonces suma
                ($filtro_cantidad == $materia->cantidad) ? $filtro_completos++ : 0;
                //la materia prima contiene el nombre del filtro entonces suma
                (str_contains(strtoupper($materia->nombre),  strtoupper($filtro_nombre))) ? $filtro_completos++ : 0;
                //si cummple con los tres filtro no hace nada, si no cumple con uno borra de la lista
                $filtro_completos == $cantidad_filtros ? true : $materiaPrimas->pull($key);
            }
            if (sizeof($materiaPrimas) == 0) {
                return redirect()->back()->with('warning', 'No se encontraron registros con el filtro ingresado');
            }
            $pdf = PDF::loadView('pdf.materiaPrima', [
                'materiaPrimas' => $materiaPrimas,
                'cantidadRegistros' => sizeof($materiaPrimas),
            ]);
            $dom_pdf = $pdf->getDomPDF();
            $canvas = $dom_pdf->get_canvas();
            $y = $canvas->get_height() - 35;
            $pdf->getDomPDF()->get_canvas()->page_text(500, $y, "Pagina {PAGE_NUM} de {PAGE_COUNT}", null, 10, array(0, 0, 0));

            return $pdf->stream('pdf.materiaPrima');
        }
        //******************************* Si pide 1 o 2 filtro entra aca ******************************************* */
        foreach ($materiaPrimas as $key => $materia) {

            $filtro_completos = 0;
            //si la meteria prima tiene el modelo del filtro se suma el filtro completo
            if (($filtro_modelo != $_OPTION_VACIO)) {
                $materia->modelos->contains($filtro_modelo) ? $filtro_completos++ : 0;
            }
            //si la meteria prima tiene la cantidad de materia prima del filtro se suma el filtro completo
            if (($filtro_cantidad > -1)) {
                ($filtro_cantidad == $materia->cantidad) ? $filtro_completos++ : 0;
            }
            //si la meteria prima tiene el nombre del filtro se suma el filtro completo
            if (($filtro_nombre != '')) {
                (str_contains(strtoupper($materia->nombre),  strtoupper($filtro_nombre))) ? $filtro_completos++ : 0;
            }
            //si la materia prima no cumple con algun filtro se borra de la lista
            $filtro_completos == $cantidad_filtros ? true : $materiaPrimas->pull($key);
        }
        if (sizeof($materiaPrimas) == 0) {
            return redirect()->back()->with('warning', 'No se encontraron registros con el filtro ingresado');
        }

        $pdf = PDF::loadView('pdf.materiaPrima', [
            'materiaPrimas' => $materiaPrimas,
            'cantidadRegistros' => sizeof($materiaPrimas),
            'filtro_nombre' => $filtro_nombre, 'filtro_cantidad' => $filtro_cantidad, 'filtro_modelo' => $filtro_modelo,

        ]);
        // return $pdf->stream('pdf.materiaPrima');
        $dom_pdf = $pdf->getDomPDF();

        $canvas = $dom_pdf->get_canvas();
        $y = $canvas->get_height() - 35;
        $pdf->getDomPDF()->get_canvas()->page_text(500, $y, "Pagina {PAGE_NUM} de {PAGE_COUNT}", null, 10, array(0, 0, 0));

        return $pdf->stream();
        // return view('pdf.materiaPrima',compact('materiaPrimas'));
    }

    public  function proveedor(Request $request)
    {
        $proveedores = Proveedor::all();
        // CONSANTES
        $_FILTRO_MAXIMO = 3;

        //******************************* Obtenemos los filtros y contamos cuantos hay ******************************************* */

        $filtro_nombre = $request->filtro_nombre;
        $filtro_documento = $request->filtro_documento;
        $filtro_email = $request->filtro_email;


        $cantidad_filtros = 0;
        if (($filtro_nombre != '')) {
            $cantidad_filtros++;
        }
        if (($filtro_documento != '')) {
            $cantidad_filtros++;
        }
        if (($filtro_email != '')) {
            $cantidad_filtros++;
        }

        //******************************* Si no pide filtros devuelve todas las materias primas ******************************************* */

        if ($cantidad_filtros == 0) {
            if (sizeof($proveedores) == 0) {
                return redirect()->back()->with('warning', 'No se encontraron registros con el filtro ingresado');
            }
            $pdf = PDF::loadView('pdf.proveedor', [
                'proveedores' => $proveedores, 'filtro_nombre' => $filtro_nombre,
                'cantidadRegistros' => sizeof($proveedores),

                'filtro_documento' => $filtro_documento, 'filtro_email' => $filtro_email
            ]);
            $dom_pdf = $pdf->getDomPDF();
            $canvas = $dom_pdf->get_canvas();
            $y = $canvas->get_height() - 35;
            $pdf->getDomPDF()->get_canvas()->page_text(500, $y, "Pagina {PAGE_NUM} de {PAGE_COUNT}", null, 10, array(0, 0, 0));

            return $pdf->stream();
        }


        //******************************* Si pide  todos los filtros entra aca ******************************************* */

        if ($cantidad_filtros == $_FILTRO_MAXIMO) {

            foreach ($proveedores as $key => $proveedor) {
                $filtro_completos = 0;
                //la proveedor prima contiene el nombre del filtro entonces suma
                (str_contains(strtoupper($proveedor->nombre),  strtoupper($filtro_nombre))) ? $filtro_completos++ : 0;
                //comparamos el documento
                (str_contains(strtoupper($proveedor->documento->numero),  strtoupper($filtro_documento))) ? $filtro_completos++ : 0;
                //comparamos  el email
                (str_contains(strtoupper($proveedor->email),  strtoupper($filtro_email))) ? $filtro_completos++ : 0;
                //si cummple con los tres filtro no hace nada, si no cumple con uno borra de la lista
                $filtro_completos == $cantidad_filtros ? true : $proveedores->pull($key);
            }
            if (sizeof($proveedores) == 0) {
                return redirect()->back()->with('warning', 'No se encontraron registros con el filtro ingresado');
            }
            $pdf = PDF::loadView('pdf.proveedor', [
                'proveedores' => $proveedores,
                'cantidadRegistros' => sizeof($proveedores),
                'filtro_nombre' => $filtro_nombre,
                'filtro_documento' => $filtro_documento, 'filtro_email' => $filtro_email
            ]);
            $dom_pdf = $pdf->getDomPDF();
            $canvas = $dom_pdf->get_canvas();
            $y = $canvas->get_height() - 35;
            $pdf->getDomPDF()->get_canvas()->page_text(500, $y, "Pagina {PAGE_NUM} de {PAGE_COUNT}", null, 10, array(0, 0, 0));

            return $pdf->stream();
        }
        //******************************* Si pide 1 o 2 filtro entra aca ******************************************* */
        foreach ($proveedores as $key => $proveedor) {

            $filtro_completos = 0;

            //si la meteria prima tiene el nombre del filtro se suma el filtro completo
            if (($filtro_nombre != '')) {
                (str_contains(strtoupper($proveedor->nombre),  strtoupper($filtro_nombre))) ? $filtro_completos++ : 0;
            }

            if (($filtro_documento != '')) {
                //comparamos el documento
                (str_contains(strtoupper($proveedor->documento->numero),  strtoupper($filtro_documento))) ? $filtro_completos++ : 0;
            }

            if (($filtro_email != '')) {
                (str_contains(strtoupper($proveedor->email),  strtoupper($filtro_email))) ? $filtro_completos++ : 0;
            }
            //si la materia prima no cumple con algun filtro se borra de la lista
            $filtro_completos == $cantidad_filtros ? true : $proveedores->pull($key);
        }
        if (sizeof($proveedores) == 0) {
            return redirect()->back()->with('warning', 'No se encontraron registros con el filtro ingresado');
        }
        $pdf = PDF::loadView('pdf.proveedor', [
            'proveedores' => $proveedores,
            'cantidadRegistros' => sizeof($proveedores),
            'filtro_nombre' => $filtro_nombre,
            'filtro_documento' => $filtro_documento, 'filtro_email' => $filtro_email
        ]);
        $dom_pdf = $pdf->getDomPDF();
        $canvas = $dom_pdf->get_canvas();
        $y = $canvas->get_height() - 35;
        $pdf->getDomPDF()->get_canvas()->page_text(500, $y, "Pagina {PAGE_NUM} de {PAGE_COUNT}", null, 10, array(0, 0, 0));

        return $pdf->stream();
        // return view('pdf.materiaPrima',compact('proveedores'));
    }
    public function modelo(Request $request, $base)
    {

        // $movimientos = DB::table('movimientos')
        $modelos = DB::table('modelos')->where('deleted_at', null)->where('base', $base);

        $filtro = collect();


        if ($request->filtro_nombre != '') {
            $modelos = $modelos
                ->where('nombre', 'like', '%' . $request->filtro_nombre . '%');
            $filtro = $filtro->union(['filtro_nombre_modelo' => $request->filtro_nombre]);
        }

        if ((($request->filtro_precioUnitarioMin != '') && ($request->filtro_precioUnitarioMin > 0.00)) && (($request->filtro_precioUnitarioMax != '') && ($request->filtro_precioUnitarioMax > 0.00))) {
            $modelos = $modelos
                ->whereBetween('precioUnitario', [$request->filtro_precioUnitarioMin, $request->filtro_precioUnitarioMax]);

            $filtro = $filtro->union(
                [
                    'filtro_precio_unitario_minimo' =>
                    $request->filtro_precioUnitarioMin
                ]
            );
            $filtro = $filtro->union(
                [
                    'filtro_precio_unitario_maximo' =>
                    $request->filtro_precioUnitarioMax
                ]
            );
        } else if (($request->filtro_precioUnitarioMin != '') && ($request->filtro_precioUnitarioMin > 0.00)) {
            $modelos = $modelos
                ->where('precioUnitario', '>', $request->filtro_precioUnitarioMin);
            $filtro = $filtro->union(['filtro_precio_unitario_minimo' => $request->filtro_precioUnitarioMin]);
        } else if (($request->filtro_precioUnitarioMax != '') && ($request->filtro_precioUnitarioMax > 0.00)) {
            $modelos = $modelos
                ->where('precioUnitario', '<', $request->filtro_precioUnitarioMax);

            $filtro = $filtro->union(['filtro_precio_unitario_maximo' => $request->filtro_precioUnitarioMax]);
        }


        $modelos = $modelos->get();
        $filtro = $filtro->union(['modelos' => $modelos]);
        $filtro = $filtro->union(['cantidadRegistros' => sizeof($modelos),]);

        if (sizeof($filtro['modelos']) == 0) {
            return redirect()->back()->with('warning', 'No se encontraron registros con el filtro ingresado');
        }
        // return $filtro->all();
        $pdf = PDF::loadView(
            'pdf.modelo',

            $filtro
        );

        $dom_pdf = $pdf->getDomPDF();
        $canvas = $dom_pdf->get_canvas();
        $y = $canvas->get_height() - 35;
        $pdf->getDomPDF()->get_canvas()->page_text(500, $y, "Pagina {PAGE_NUM} de {PAGE_COUNT}", null, 10, array(0, 0, 0));
        return $pdf->stream();
    }
}
