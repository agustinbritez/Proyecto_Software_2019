<?php

namespace App\Http\Controllers;

use App\Proveedor;
use Illuminate\Http\Request;
use DataTables;
class ProveedorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->ajax())
        {
            return DataTables::of(Proveedor::latest()->get())
            ->addColumn('action', function($data){
                $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-primary btn-sm">Editar</button>';
                $button .= '&nbsp;&nbsp;';
                $button .= '<button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-sm">Eliminar</button>';
                return $button;
            })->rawColumns(['action'])
            ->make(true);
        }

        
        return view('proveedor.index');
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
        $proveedor= new Proveedor();
        $proveedor->nombre=$request->input('nombre');
        $proveedor->email=$request->input('email');
        $proveedor->razonSocial=$request->input('razonSocial');
        $proveedor->save();
        // $form_data = array(
        //     'nombre' =>  $request->input('nombre'),
        //     'email' =>  $request->input('email'),
        //     'razonSocial' => $request->input('razonSocial'),
            
        // );
        
        // Proveedor::create($form_data);
        
        return response()->json(['success' => 'Proveedor creado exitosamente.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Proveedor  $proveedor
     * @return \Illuminate\Http\Response
     */
    public function show(Proveedor $proveedor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Proveedor  $proveedor
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         //obtengo el objeto  para ser usado en el javascript click edit
         if(request()->ajax())
         {
             $data = Proveedor::findOrFail($id);
             return response()->json(['data' => $data]);
         }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Proveedor  $proveedor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $form_data = array(
            'nombre'       =>   $request->nombre,
            'email'        =>   $request->email,
            'razonSocial' => $request->input('razonSocial')
        );
        Proveedor::whereId($request->hidden_id)->update($form_data);
        
        return response()->json(['success' => 'Se actualizo correctamente']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Proveedor  $proveedor
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Proveedor::find($id)->delete();
        return response()->json(['success'=>'El proveedor  fue eliminado exitosamente.']);
    }
}
