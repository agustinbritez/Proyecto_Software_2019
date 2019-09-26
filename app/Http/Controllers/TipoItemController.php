<?php

namespace App\Http\Controllers;

use App\Categoria;
use App\FlujoTrabajo;
use App\Medida;
use App\TipoItem;
use Illuminate\Http\Request;
use DataTables;
use Validator;

class TipoItemController extends Controller
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
            return DataTables::of(TipoItem::latest()->get())
            ->addColumn('action', function($data){
                $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-primary btn-sm">Editar</button>';
                $button .= '&nbsp;&nbsp;';
                $button .= '<button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-sm">Eliminar</button>';
                return $button;
            })->addColumn('flujoTrabajo',function($data){
                $flujoTrabajo=FlujoTrabajo::find($data->flujoTrabajo_id);
                
                if( $flujoTrabajo!=null){
                    return  $flujoTrabajo->nombre;
                }
                return  'Vacio';
            })->addColumn('categoria',function($data){
                $categoria=Categoria::find($data->categoria_id);
                if( $categoria!=null){
                    return  $categoria->nombre;
                }
                return  'Vacio';
                
            })->addColumn('medida',function($data){
                $medida=Medida::find($data->medida_id);
                
                if( $medida!=null){
                    return  $medida->nombre;
                }
                return  'Vacio';
            })
            ->rawColumns(['action'])
            ->make(true);
        }
        
        
        
        $medidas=Medida::all();
        $flujosTrabajos=FlujoTrabajo::all();
        $categorias=Categoria::all();
        
        
        return view('tipoItem.index',compact('medidas','flujosTrabajos','categorias'));
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
        // $rules = array(
            //     'nombre'    =>  'required',
            //     'detalle'     =>  'required'
            // );
            
            // $error = Validator::make($request->all(), $rules);
            
            // if($error->fails())
            // {
                //     return response()->json(['errors' => $error->errors()->all()]);
                // }
                
                $form_data = array(
                    'nombre'        =>  $request->nombre ,
                    'detalle'         =>  $request->detalle,
                    'flujoTrabajo_id' => $request->input('flujoTrabajo_id'),
                    'categoria_id' => $request->input('categoria_id'),
                    'medida_id' => $request->input('medida_id'),
                    
                );
                
                TipoItem::create($form_data);
                
                return response()->json(['success' => 'Data Added successfully.']);
            }
            
            /**
            * Display the specified resource.
            *
            * @param  \App\TipoItem  $tipoItem
            * @return \Illuminate\Http\Response
            */
            public function show(TipoItem $tipoItem)
            {
                //
            }
            
            /**
            * Show the form for editing the specified resource.
            *
            * @param  \App\TipoItem  $tipoItem
            * @return \Illuminate\Http\Response
            */
            public function edit( $id)
            {
                //obtengo el objeto  para ser usado en el javascript click edit
                if(request()->ajax())
                {
                    $data = TipoItem::findOrFail($id);
                    return response()->json(['data' => $data]);
                }
            }
            
            /**
            * Update the specified resource in storage.
            *
            * @param  \Illuminate\Http\Request  $request
            * @param  \App\TipoItem  $tipoItem
            * @return \Illuminate\Http\Response
            */
            public function update(Request $request)
            {
                // $rules = array(
                    //     'nombre'    =>  'required',
                    //     'detalle'     =>  'required'
                    // );
                    
                    // $error = Validator::make($request->all(), $rules);
                    
                    // if($error->fails())
                    // {
                        //     return response()->json(['errors' => $error->errors()->all()]);
                        // }
                        
                        
                        $form_data = array(
                            'nombre'       =>   $request->nombre,
                            'detalle'        =>   $request->detalle,
                            'flujoTrabajo_id' => $request->input('flujoTrabajo_id'),
                            'categoria_id' => $request->input('categoria_id'),
                            'medida_id' => $request->input('medida_id')
                        );
                        TipoItem::whereId($request->hidden_id)->update($form_data);
                        
                        return response()->json(['success' => 'Data is successfully updated']);
                    }
                    
                    /**
                    * Remove the specified resource from storage.
                    *
                    * @param  \App\TipoItem  $tipoItem
                    * @return \Illuminate\Http\Response
                    */
                    public function destroy($id)
                    {
                        TipoItem::find($id)->delete();
                        return response()->json(['success'=>'Product deleted successfully.']);
                    }
                }
                