<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // return view('home');
        if (auth()->user()->hasRole('admin')) {
            return redirect()->route('estadistica.index');
        }
        if (auth()->user()->hasRole('gerente')) {
            return redirect()->route('estadistica.index');
        }
        if (auth()->user()->hasRole('auditor')) {
            return redirect()->route('auditoria.index');
        }
        if (auth()->user()->hasRole('empleado')) {
            return redirect()->route('pedido.trabajo');
        }
        return redirect()->route('producto.tienda');
        // return view('auditoria.index');
    }
}
