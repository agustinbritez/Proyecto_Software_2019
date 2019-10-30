<?php

namespace App\Http\Controllers;

use App\Calle;
use App\Componente;
use App\DetallePedido;
use App\Direccion;
use App\Estado;
use App\FlujoTrabajo;
use App\Localidad;
use App\MateriaPrima;
use App\Modelo;
use App\Movimiento;
use App\Pais;
use App\Pedido;
use App\Producto;
use App\Proveedor;
use App\Provincia;
use App\Receta;
use App\TipoMovimiento;
use App\Transicion;
use App\User;
use Illuminate\Http\Request;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Models\Audit;

class AuditoriaController extends Controller
{
    public function index()
    {
        // if (request()->ajax()) {
        //     return datatables()->of(Audit::latest()->get())
        //         ->addColumn('tabla', function ($data) {
        //             return  str_replace(['App\\', '$', ' '], '', $data->auditable_type);
        //         })
        //         ->addColumn('usuario', function ($data) {
        //             return  $data->user->name . ' ' . $data->user->apellido;
        //         })
        //         ->addColumn('fecha', function ($data) {
        //             return  $data->created_at->format('d/m/Y ( H:m:s )');
        //         })
        //         ->addColumn('action', function ($data) {
        //             $button = '<a href="' . route('auditoria.show', $data->id) . '" type="button" name="show" id="' . $data->id . '" class="btn btn-outline-info btn-sm">Ver detalle</a>';
        //             return $button;
        //         })
        //         ->rawColumns(['action'])
        //         ->make(true);
        // }

        $auditorias = Audit::latest()->get();
        return view('auditoria.index', compact('auditorias'));

        $auditoriasMovimientos = Movimiento::withTrashed()->get();
        $auditoriasModelos = Modelo::withTrashed()->get();
        $auditoriasMateriaPrimas = MateriaPrima::withTrashed()->get();
        $auditoriasRecetas = Receta::withTrashed()->get();
        $auditoriasProveedores = Proveedor::withTrashed()->get();
        $auditoriasUsuarios = User::withTrashed()->get();

        $auditorias = collect();
        foreach ($auditoriasMovimientos as $value) {
            if (!$value->audits->isEmpty()) {
                $auditorias->add($value->audits()->latest()->first());
            }
        }
        foreach ($auditoriasModelos as $value) {
            if (!$value->audits->isEmpty()) {
                $auditorias->add($value->audits()->latest()->first());
            }
        }
        foreach ($auditoriasMateriaPrimas as $value) {
            if (!$value->audits->isEmpty()) {
                $auditorias->add($value->audits()->latest()->first());
            }
        }
        foreach ($auditoriasRecetas as $value) {
            if (!$value->audits->isEmpty()) {
                $auditorias->add($value->audits()->latest()->first());
            }
        }
        foreach ($auditoriasProveedores as $value) {
            if (!$value->audits->isEmpty()) {
                $auditorias->add($value->audits()->latest()->first());
            }
        }
        foreach ($auditoriasUsuarios as $value) {
            if (!$value->audits->isEmpty()) {
                $auditorias->add($value->audits()->latest()->first());
            }
        }
        $auditorias = Audit::latest()->get();
        return view('auditoria.index', compact('auditorias'));
    }

    public function show($id)
    {
        $auditoria = Audit::find($id);

        return view('auditoria.show', compact('auditoria'));
    }

    public function historial($id)
    {
        $auditoria = Audit::find($id);
        //no es el nombre de la tabla sino el nombre del modelo
        $tabla = '';
        $auditorias = [new Audit()];
        if ($auditoria != null) {
            $tabla = str_replace(['App\\', '$', ' '], '', $auditoria->auditable_type);
            if (strtoupper($tabla) == strtoupper('Movimiento')) {
                $movimiento = Movimiento::find($auditoria->auditable_id);
                $auditorias = $movimiento->audits()->latest()->get();
            }
            if (strtoupper($tabla) == strtoupper('modelo')) {
                $modelo = Modelo::find($auditoria->auditable_id);
                $auditorias = $modelo->audits()->latest()->get();
            }
            if (strtoupper($tabla) == strtoupper('materiaPrima')) {
                $materiaPrima = MateriaPrima::find($auditoria->auditable_id);
                $auditorias = $materiaPrima->audits()->latest()->get();
            }
            if (strtoupper($tabla) == strtoupper('tipoMovimiento')) {
                $tipoMovimiento = TipoMovimiento::find($auditoria->auditable_id);
                $auditorias = $tipoMovimiento->audits()->latest()->get();
            }
            if (strtoupper($tabla) == strtoupper('pais')) {
                $pais = Pais::find($auditoria->auditable_id);
                $auditorias = $pais->audits()->latest()->get();
            }
            if (strtoupper($tabla) == strtoupper('provincia')) {
                $provincia = Provincia::find($auditoria->auditable_id);
                $auditorias = $provincia->audits()->latest()->get();
            }
            if (strtoupper($tabla) == strtoupper('localidad')) {
                $localidad = Localidad::find($auditoria->auditable_id);
                $auditorias = $localidad->audits()->latest()->get();
            }
            if (strtoupper($tabla) == strtoupper('calle')) {
                $calle = Calle::find($auditoria->auditable_id);
                $auditorias = $calle->audits()->latest()->get();
            }
            if (strtoupper($tabla) == strtoupper('proveedor')) {
                $proveedor = Proveedor::find($auditoria->auditable_id);
                $auditorias = $proveedor->audits()->latest()->get();
            }
            if (strtoupper($tabla) == strtoupper('user')) {
                $user = User::find($auditoria->auditable_id);
                $auditorias = $user->audits()->latest()->get();
            }
            if (strtoupper($tabla) == strtoupper('producto')) {
                $producto = Producto::find($auditoria->auditable_id);
                $auditorias = $producto->audits()->latest()->get();
            }
            if (strtoupper($tabla) == strtoupper('componente')) {
                $componente = Componente::find($auditoria->auditable_id);
                $auditorias = $componente->audits()->latest()->get();
            }
            if (strtoupper($tabla) == strtoupper('direccion')) {
                $direccion = Direccion::find($auditoria->auditable_id);
                $auditorias = $direccion->audits()->latest()->get();
            }
            if (strtoupper($tabla) == strtoupper('pedido')) {
                $pedido = Pedido::find($auditoria->auditable_id);
                $auditorias = $pedido->audits()->latest()->get();
            }
            if (strtoupper($tabla) == strtoupper('detallePedido')) {
                $detallePedido = DetallePedido::find($auditoria->auditable_id);
                $auditorias = $detallePedido->audits()->latest()->get();
            }
            if (strtoupper($tabla) == strtoupper('flujoTrabajo')) {
                $flujoTrabajo = FlujoTrabajo::find($auditoria->auditable_id);
                $auditorias = $flujoTrabajo->audits()->latest()->get();
            }
            if (strtoupper($tabla) == strtoupper('transicion')) {
                $transicion = Transicion::find($auditoria->auditable_id);
                $auditorias = $transicion->audits()->latest()->get();
            }
            if (strtoupper($tabla) == strtoupper('estado')) {
                $estado = Estado::find($auditoria->auditable_id);
                $auditorias = $estado->audits()->latest()->get();
            }
        }



        return view('auditoria.historial', compact('auditorias', 'tabla'));
    }
}
