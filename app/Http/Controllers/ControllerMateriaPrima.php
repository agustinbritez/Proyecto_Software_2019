<?php

namespace App\Http\Controllers;

use App\ImagenIndividual;
use App\MateriaPrima;
use App\Medida;
use App\Modelo;
use CreateMateriaPrimasModelosTable;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;
use Yajra\DataTables\Facades\DataTables;

class ControllerMateriaPrima extends Controller
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
            return DataTables::of(MateriaPrima::latest()->get())
            ->addColumn('action', function($data){
                $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-primary btn-sm">Editar</button>';
                $button .= '&nbsp;&nbsp;';
                $button .= '<button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-sm">Eliminar</button>';
                return $button;
            })->addColumn('medida',function($data){
                $medida=Medida::find($data->medida_id);
                
                if( $medida!=null){
                    return  $medida->nombre;
                }
                return  'Vacio';
            })->addColumn('modelos', function($data){
                //crear cada modelo por materia prima
                //  $materiaPrima=MateriaPrima::find($data->id);
                
                $span='';
                foreach ($data->modelos as  $key => $modelo) {
                    $span=$span . '<span class="badge badge-info" >'.$modelo->nombre.'</span>'.'&nbsp;&nbsp;';    
                }
                
                return $span ;
                
            })
            ->rawColumns(['action','modelos'])
            ->make(true);
        }
        $medidas=Medida::all();
        $modelos=Modelo::all();
        return view ('materiaPrima.index',compact('medidas','modelos'));
    }
    
    public function filtroTable(Request $request)
    {   
        $materiaPrimaFiltro = MateriaPrima::query();

        $start_date = (!empty($_GET["filtro_nombre"])) ? ($_GET["filtro_nombre"]) : ('');
        $end_date = (!empty($_GET["end_date"])) ? ($_GET["end_date"]) : ('');

        if($start_date && $end_date){
    
         $start_date = date('Y-m-d', strtotime($start_date));
         $end_date = date('Y-m-d', strtotime($end_date));
         
         $materiaPrimaFiltro->whereRaw("date(users.created_at) >= '" . $start_date . "' AND date(users.created_at) <= '" . $end_date . "'");
        }
        $users = $materiaPrimaFiltro->select('*');
        return datatables()->of($users)
            ->make(true);
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {
        
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
                //     request()->validate([
                    //         'imagenPrincipal' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                    //    ]);
                    
                    //    if ($files = $request->file('imagenPrincipal')) {
                        
                        
                        // }
                        // return $request;
                        $form_data = array(
                            'nombre'        =>  $request->nombre,
                            'detalle'         =>  $request->detalle,
                            'precioUnitario'         =>  $request->precioUnitario,
                            'cantidad'         =>  $request->cantidad,
                            'medida_id'         =>  $request->input('medida_id')
                        );
                        //si no crea es porque hay agun atributo que no permite null que esta vacio
                        $materiaPrima=MateriaPrima::create($form_data);
                        // if ($request->has('modelos'))
                        // {
                            $materiaPrima->modelos()->sync($request->input('modelos',[]) );
                        // }
                       
                        
                        $medida=Medida::find($request->input('medida_id'));
                        
                        return response()->json(['success' => 'Materia Prima Guardada Con Exito.']);
                        
                    }
                    
                    /**
                    * Display the specified resource.
                    *
                    * @param  int  $id
                    * @return \Illuminate\Http\Response
                    */
                    public function show(MateriaPrima $materiaPrima)
                    {
                        // $materiaPrima= MateriaPrima::find($id);
                        return view('materiaPrima.show',compact('materiaPrima'));
                    }
                    
                    /**
                    * Show the form for editing the specified resource.
                    *
                    * @param  int  $id
                    * @return \Illuminate\Http\Response
                    */
                    public function edit ($id)
                    {   
                        if(request()->ajax())
                        {
                            $data = MateriaPrima::findOrFail($id);
                            
                            return response()->json(['data' => $data,'medida'=>$data->medida]);
                        }
                    }
                    
                    /**
                    * Update the specified resource in storage.
                    *
                    * @param  \Illuminate\Http\Request  $request
                    * @param  int  $id
                    * @return \Illuminate\Http\Response
                    */
                    public function update(Request $request, MateriaPrima $materiaPrima)
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
                                    'nombre'        =>  $request->nombre,
                                    'detalle'         =>  $request->detalle,
                                    'precioUnitario'         =>  $request->precioUnitario,
                                    'cantidad'         =>  $request->cantidad,
                                    'medida_id'         =>  $request->medida_id
                                );
                                //si no crea es porque hay agun atributo que no permite null que esta vacio
                                
                                
                                
                                MateriaPrima::whereId($request->hidden_id)->update($form_data);
                                // $materiaPrima->modelos()->detach($request->input('modelos',[]),$request->input('modelos',[]) );
                                $materiaPrima->modelos()->sync($request->input('modelos',[]) );
                                return response()->json(['success' => 'Materia Prima Actualizada Correctamente']);
                            }
                            
                            /**
                            * Remove the specified resource from storage.
                            *
                            * @param  int  $id
                            * @return \Illuminate\Http\Response
                            */
                            public function destroy($id)
                            {
                                // $materiaPrima= MateriaPrima::find($id);
                                // return $materiaPrima ;
                                
                                // Flash::warning('La materia prima' . $materiaPrima->nombre . ' ha sido borrado exitosamente' );
                                MateriaPrima::find($id)->delete();
                                return response()->json(['success'=>'Materia Prima Eliminada Correctamente.']);
                            }
                        }
                        