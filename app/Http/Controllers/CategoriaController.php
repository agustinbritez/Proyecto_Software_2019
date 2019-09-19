<?php

namespace App\Http\Controllers;

use App\Categoria;
use Illuminate\Http\Request;
use DataTables;
use Validator;
// FUENTE https://www.webslesson.info/2019/04/laravel-58-ajax-crud-tutorial-using-datatables.html
class CategoriaController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index(Request $request)
    {
        
        if(request()->ajax())
        {
            return datatables()->of(Categoria::latest()->get())
            ->addColumn('action', function($data){
                $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-primary btn-sm">Editar</button>';
                $button .= '&nbsp;&nbsp;';
                $button .= '<button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-sm">Eliminar</button>';
                return $button;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
        return view('categoria/index');
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
        
        $rules = array(
            'nombre'    =>  'required',
            'detalle'     =>  'required'
        );
        
        $error = Validator::make($request->all(), $rules);
        
        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        if($request->has('base')){
            $da=0;
        }else{
            $da=1;
        }
        $form_data = array(
            'nombre'        =>  $request->nombre,
            'detalle'         =>  $request->detalle,
            'base'=> $da
        );
        
        Categoria::create($form_data);
        
        return response()->json(['success' => 'Data Added successfully.']);
    }
    
    /**
    * Display the specified resource.
    *
    * @param  \App\Categoria  $categoria
    * @return \Illuminate\Http\Response
    */
    public function show(Categoria $categoria)
    {
        //
    }
    
    /**
    * Show the form for editing the specified resource.
    *
    * @param  \App\Categoria  $categoria
    * @return \Illuminate\Http\Response
    */
    public function edit( $id)
    {
        if(request()->ajax())
        {
            $data = Categoria::findOrFail($id);
            return response()->json(['data' => $data]);
        }
    }
    
    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\Categoria  $categoria
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request)
    {
        
        
    
            $rules = array(
                'nombre'    =>  'required',
                'detalle'     =>  'required'
            );

            $error = Validator::make($request->all(), $rules);

            if($error->fails())
            {
                return response()->json(['errors' => $error->errors()->all()]);
            }
        

        $form_data = array(
            'nombre'       =>   $request->nombre,
            'detalle'        =>   $request->detalle
        );
        Categoria::whereId($request->hidden_id)->update($form_data);

        return response()->json(['success' => 'Data is successfully updated']);
    }
    
    /**
    * Remove the specified resource from storage.
    *
    * @param  \App\Categoria  $categoria
    * @return \Illuminate\Http\Response
    */
    public function destroy($id)
    {
        //$categoria = Categoria::where('id',$id)->delete();
        
        // return Response::json($categoria);
        Categoria::find($id)->delete();
        return response()->json(['success'=>'Product deleted successfully.']);
    }
}
