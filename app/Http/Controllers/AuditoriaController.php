<?php

namespace App\Http\Controllers;

use App\Movimiento;
use Illuminate\Http\Request;

class AuditoriaController extends Controller
{
    public function index()
    {
        $auditoriasMovimientos = Movimiento::withoutTrashed()->get();
        $auditorias = collect();
        foreach ($auditoriasMovimientos as $value) {
            if (!$value->audits->isEmpty()) {
                $auditorias->add($value->audits()->latest()->first());
            }
        }
        return view('auditoria.index', compact('auditorias'));
    }
}
