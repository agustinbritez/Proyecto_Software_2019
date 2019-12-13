<?php

namespace App\Http\Controllers;

use App\ImagenIndividual;
use App\Mail\ProveedorMail;
use App\MateriaPrima;
use App\Medida;
use App\Modelo;
use App\PropuestaMateriaPrima;
use App\Proveedor;
use App\Receta;
use Carbon\Carbon;
use CreateMateriaPrimasModelosTable;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
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


        $medidas = Medida::all();
        $modelos = Modelo::all();
        $materiaPrimas = MateriaPrima::all();
        $proveedores = Proveedor::all();
        return view('materiaPrima.index', compact('medidas', 'modelos', 'materiaPrimas', 'proveedores'));
    }
    public function stockMinimo(Request $request)
    {
        $medidas = Medida::all();

        $modelos = Modelo::all();
        $materiaPrimas = MateriaPrima::whereColumn('cantidad', '<=', 'stockMinimo')->get();
        $propuestasJoin = MateriaPrima::join('propuesta_materia_primas', 'propuesta_materia_primas.materiaPrima_id', '=', 'materia_primas.id')
            ->whereColumn('materia_primas.cantidad', '<=', 'materia_primas.stockMinimo')
            ->where('realizado',true)
            ->get();
        $propuestas = collect();

        foreach ($propuestasJoin as $key => $propuestaJoin) {
            # code...
            $propuestas->add(PropuestaMateriaPrima::find($propuestaJoin['id']));
        }

        //cantidad de productos que no se pueden realizar por falta de materia prima.
        // $cantidadDePedidosNoAtendidos=
        return view('materiaPrima.stockMinimo', compact('medidas', 'modelos', 'materiaPrimas', 'propuestas'));
    }
    //recibe una propuesta
    public function propuesta($id)
    {
        $propuesta = PropuestaMateriaPrima::where('realizado',true)->where('id',$id)->first();
        if (is_null($propuesta)) {
            # code...
            return redirect()->back()->withErrors('No existe la propuesta');
        }
        return view('materiaPrima.propuesta', compact('propuesta'));
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    { }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->nombre = strtoupper($request->nombre);
        //obtengo la materias primas borradas si elnombre se repite la reuso
        $materiaPrimaExistente = MateriaPrima::where('nombre', $request->nombre)->where('deleted_at', "<>", null)->withTrashed()->first();
        //*****************************************************************************************************8 */
        //si el nombre esta repetido en una materia prima eliminada 
        //la volvemos a revivir y le actualizamos con los datos del nuevo
        if ($materiaPrimaExistente != null) {
            // $materiaPrimaExistente->restore();
            $request->hidden_id = $materiaPrimaExistente->id;
            $this->update($request);
            return redirect()->back()->with('success', 'Materia Prima Creada Con Exito!');
        }
        $rules = [
            'nombre'    =>  'required|unique:materia_primas',
            'imagenPrincipal'     =>  'required|mimes:jpeg,png,jpg,gif,svg|max:2048',
            // 'imagenPrincipal'     =>  'required|imagenPrincipal|mimes:jpeg,png,jpg,gif,svg',
            'cantidad'     =>  'required|min:0',
            'stockMinimo'     =>  'required|min:1',
            'precioUnitario'     =>  'required|numeric',
            'medida_id'     =>  'required',
            'proveedores'     =>  'required',
            // 'modelos'     =>  'required'
        ];
        //transformamos la mascara de precio unitario a un valor double normal
        $tr = str_replace([',', '$', ' '], '', $request->precioUnitario);
        $cant = str_replace([',', '$', ' '], '', $request->cantidad);
        $stock = str_replace([',', '$', ' '], '', $request->stockMinimo);
        // $tr= str_replace('.',',',$tr);



        $request->precioUnitario = $tr;
        $request->cantidad = $cant;
        $request->stockMinimo = $stock;
        $messages = [
            'nombre.required' => 'Agrega el nombre de la materia prima.',
            'nombre.unique' => 'El nombre de la materia prima debe ser unico.',

            'cantidad.required' => 'Agrega la  cantidad de materias primas.',
            'cantidad.integer' => 'La cantidad debe ser un valor entero',
            'cantidad.min' => 'La cantidad minima es 0',

            'stockMinimo.required' => 'Agrega la  cantidad del stock minimo.',
            'stockMinimo.integer' => 'La cantidad debe ser un valor entero',
            'stockMinimo.min' => 'La cantidad minima es 1 para el stock minimo',

            'precioUnitario.required' => 'Agrege el precio de la materia prima.',
            'precioUnitario.numeric' => 'El precio debe ser un valor numerico',

            'medida_id.required' => 'Debe seleccionar una unidad de medida',

            'proveedores.required' => 'Debe seleccionar un Proveedor como minimo',

            'modelos.required' => 'Debe seleccionar un modelo como minimo',

            'imagenPrincipal.required'     => 'La imagen es obligatoria',
            'imagenPrincipal.mimes'     => 'El tipo de la imagen debe ser cualquiera de los siguientes tipos peg,png,jpg,gif,svg',
            'imagenPrincipal.max'     => 'La resolucion maxima de la imagen es 2048',
        ];

        $this->validate($request, $rules, $messages);





        $imagen = null;
        if ($request->hasFile('imagenPrincipal')) {
            $file = $request->file('imagenPrincipal');
            $hoy = Carbon::now();
            $imagen =  $hoy->format('dmYHi') . '' . time() . '.' . $request->file('imagenPrincipal')->getClientOriginalExtension();
            $file->move(public_path('/imagenes/materia_primas/'), $imagen);
        }
        // $validator = Validator::make($request->all(),$rules);
        // if ($validator->passes()) {


        // 	return response()->json(['success'=>'Added new records.']);

        // }


        // return response()->json(['errors'=>$validator->errors()->all()]);

        // $validator = Validator::make($request->all(), $rules);
        // if (!$validator->passes()) {


        //     return response()->json(['error'=>$validator->errors()->all()]);

        // }

        // if($error->fails())
        // {
        //     return response()->json(['errors' => $error->errors()->all()]);
        // }
        // request()->validate([
        //     'imagenPrincipal' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        //     ]);

        // if ($files = $request->file('imagenPrincipal')) {


        // }
        // return $request;
        $form_data = array(
            'nombre'        =>  $request->nombre,
            'imagenPrincipal'        =>  $imagen,
            'detalle'         =>  $request->detalle,
            'precioUnitario'         =>  $request->precioUnitario,
            'cantidad'         =>  $request->cantidad,
            'stockMinimo' => $request->stockMinimo,
            'medida_id'         =>  $request->input('medida_id')
        );
        // $materiaPrima= new MateriaPrima();
        // $materiaPrima->fill($request->all());
        // $materiaPrima->save();
        // return $materiaPrima;
        //si no crea es porque hay agun atributo que no permite null que esta vacio

        $materiaPrima = MateriaPrima::create($form_data);


        //creamos la receta para relacionar la materia prima con el modelo 
        $modelos = null;
        if ($request->has('modelos')) {
            // $materiaPrima->modelos()->sync($request->input('modelos', []));
            $modelos = $request->input('modelos', []);
        }
        if ($modelos != null) {
            foreach ($modelos as $key => $modelo) {
                $modeloEncontrado = Modelo::find($modelo);
                if ($modeloEncontrado != null) {
                    $form_data = array(
                        'modeloPadre_id' => $modeloEncontrado->id,
                        'materiaPrima_id' => $materiaPrima->id,
                        'cantidad'        =>  0,
                        'prioridad' => 0
                    );

                    //si no crea es porque hay agun atributo que no permite null que esta vacio
                    $receta = Receta::create($form_data);
                }
            }
        }

        if ($request->has('proveedores')) {
            // $syncArray = [];

            foreach ($request->input('proveedores', []) as  $idProve) {
                $provedor = Proveedor::find($idProve);
                if (!is_null($provedor)) {

                    $propuesta = PropuestaMateriaPrima::where('materiaPrima_id', $materiaPrima->id)->where('proveedor_id', $idProve)->first();
                    if (is_null($propuesta)) {
                        $propuesta = PropuestaMateriaPrima::create([
                            'materiaPrima_id' => $materiaPrima->id,
                            'proveedor_id' => $idProve,
                            'precioUnitario' => $materiaPrima->precioUnitario,
                        ]);
                    } else {
                        $propuesta->precioUnitario = $materiaPrima->precioUnitario;
                        $propuesta->update();
                    }
                }

                // $syncArray = array_merge($syncArray, [$idProve => ['precioUnitario' => $materiaPrima->precioUnitario]]);
            }

            // $materiaPrima->proveedores()->sync($syncArray);
        }


        // return response()->json(['success' => 'Materia Prima Guardada Con Exito.']);
        return redirect()->back()->with('success', 'Materia Prima Creada Con Exito!');
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
        return view('materiaPrima.show', compact('materiaPrima'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function edit($id)
    {
        if (request()->ajax()) {
            $data = MateriaPrima::findOrFail($id);

            return response()->json([
                'data' => $data, 'medida' => $data->medida, 'modelos' => $data->modelos,
                'totalModelos' => Modelo::all(), 'totalMedidas' => Medida::all(),
                'totalProveedores' => Proveedor::all(), 'proveedores' => $data->proveedores
            ]);
        }
    }

    public function obtenerParametros(Request $request)
    {
        if (request()->ajax()) {
            return response()->json(['totalModelos' => Modelo::all(), 'totalMedidas' => Medida::all()]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $rules = [
            'nombre'    =>  'required|unique:materia_primas,nombre,' . $request->hidden_id,
            'imagenPrincipal'     =>  'mimes:jpeg,png,jpg,gif,svg|max:2048',
            // 'imagenPrincipal'     =>  'required|imagenPrincipal|mimes:jpeg,png,jpg,gif,svg',
            // 'cantidad'     =>  'required|integer',
            'stockMinimo'     =>  'required|min:1',
            'proveedores'     =>  'required',

            'precioUnitario'     =>  'required|numeric',
            'medida_id'     =>  'required'
            // 'modelos'     =>  'required'
        ];
        $tr = str_replace([',', '$', ' '], '', $request->precioUnitario);
        $cant = str_replace([',', '$', ' '], '', $request->cantidad);
        $stock = str_replace([',', '$', ' '], '', $request->stockMinimo);
        // $tr= str_replace('.',',',$tr);

        $request->precioUnitario = $tr;
        $request->cantidad = $cant;
        $request->stockMinimo = $stock;

        $request->nombre = strtoupper($request->nombre);

        $messages = [
            'nombre.required' => 'Agrega el nombre de la materia prima.',
            'nombre.unique' => 'El nombre de la materia prima debe ser unico.',

            'stockMinimo.required' => 'Agregar la  cantidad de stock minimo .',
            'stockMinimo.min' => 'La cantidad minima del stock es 1',

            'precioUnitario.required' => 'Agrege el precio de la materia prima.',
            'precioUnitario.numeric' => 'El precio debe ser un valor numerico',

            'medida_id.required' => 'Debe seleccionar una unidad de medida',

            'proveedores.required' => 'Debe seleccionar un Proveedor como minimo',

            'modelos.required' => 'Debe seleccionar un modelo como minimo',

            'imagenPrincipal.required'     => 'La imagen es obligatoria',
            'imagenPrincipal.mimes'     => 'El tipo de la imagen debe ser cualquiera de los siguientes tipos peg,png,jpg,gif,svg',
            'imagenPrincipal.max'     => 'La resolucion maxima de la imagen es 2048',
        ];

        $this->validate($request, $rules, $messages);

        //si el id que crea es uno borrado lo revivimos
        $materiaPrima = MateriaPrima::withTrashed()->find($request->hidden_id);


        $imagen = null;
        
        if ($request->hasFile('imagenPrincipal') ) {
            $file = $request->file('imagenPrincipal');
            $hoy = Carbon::now();
            $imagen =  $hoy->format('dmYHi') . '' . time() . '.' . $request->file('imagenPrincipal')->getClientOriginalExtension();

            $file->move(public_path('/imagenes/materia_primas/'), $imagen);
            $form_data = array(
                'nombre'        =>  $request->nombre,
                'imagenPrincipal'        =>  $imagen,
                'detalle'         =>  $request->detalle,
                'precioUnitario'         =>  $request->precioUnitario,
                'stockMinimo' => $request->stockMinimo,
                // 'cantidad'         =>  $request->cantidad,
                'medida_id'         =>  $request->medida_id,

            );
            //creamos el camino de la imagen vieja
            $file_path = public_path() . '/imagenes/materia_primas/' . $materiaPrima->imagenPrincipal;
            //borramos la imagen vieja
            unlink($file_path);
        } else {
            $form_data = array(
                'nombre'        =>  $request->nombre,
                'detalle'         =>  $request->detalle,
                'precioUnitario'         =>  $request->precioUnitario,
                'stockMinimo' => $request->stockMinimo,
                // 'cantidad'         =>  $request->cantidad,
                'medida_id'         =>  $request->medida_id
            );
        }

        // $rules = array(
        //     'nombre'    =>  'required',
        //     'detalle'     =>  'required'
        // );

        // $error = Validator::make($request->all(), $rules);

        // if($error->fails())
        // {
        //     return response()->json(['errors' => $error->errors()->all()]);
        // }

        //si no crea es porque hay agun atributo que no permite null que esta vacio



        //revive a la materia prima borrada anteriormente.
        $materiaPrima->restore();

        $materiaPrima->update($form_data);
        // if ($request->has('proveedores')) {
        //     $materiaPrima->proveedores()->sync($request->input('proveedores', []));
        // }
        if ($request->has('proveedores')) {
            // $syncArray = [];

            foreach ($request->input('proveedores', []) as  $idProve) {
                $provedor = Proveedor::find($idProve);
                if (!is_null($provedor)) {

                    $propuesta = PropuestaMateriaPrima::where('materiaPrima_id', $materiaPrima->id)->where('proveedor_id', $idProve)->first();
                    if (is_null($propuesta)) {
                        $propuesta = PropuestaMateriaPrima::create([
                            'materiaPrima_id' => $materiaPrima->id,
                            'proveedor_id' => $idProve,
                            'precioUnitario' => $materiaPrima->precioUnitario,
                        ]);
                    } else {
                        $propuesta->precioUnitario = $materiaPrima->precioUnitario;
                        $propuesta->update();
                    }
                }

                // $syncArray = array_merge($syncArray, [$idProve => ['precioUnitario' => $materiaPrima->precioUnitario]]);
            }

            // $materiaPrima->proveedores()->sync($syncArray);
        }
        // $materiaPrima->modelos()->detach($request->input('modelos',[]),$request->input('modelos',[]) );

        // $materiaPrima->modelos()->sync($request->input('modelos', []));
        // return response()->json(['success' => 'Materia Prima Actualizada Correctamente']);
        return redirect()->back()->with('success', 'Actualizado Correctamente');
    }

    //verifica el stock minimo de todo  y envia correo a los proveedores
    //retorna flase si no existen materia prima con stock minimo
    public function verificarStock()
    {
        $proveedores = MateriaPrima::join('propuesta_materia_primas', 'materia_primas.id', '=', 'propuesta_materia_primas.materiaPrima_id')
            ->join('proveedors', 'proveedors.id', '=', 'propuesta_materia_primas.proveedor_id')
            ->where('propuesta_materia_primas.realizado',false)
            ->whereColumn('materia_primas.cantidad', '<=', 'materia_primas.stockMinimo')
            ->get();
        $ca = 0;
        foreach ($proveedores as $proveedor) {
            # code...
            // new ProveedorMail($proveedor);
            $proveedor = Proveedor::find($proveedor->id);
            try {
                //code...
                $email = $proveedor->email;
                Mail::send('mail.proveedor', ['proveedor' => $proveedor], function ($message) use ($email) {
                    $message->to($email)
                        ->subject('Pedido de Lista de Precios');
                });
            } catch (Exception $th) {
                //throw $th;
            }
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        // $materiaPrima= MateriaPrima::find($id);
        // return $materiaPrima ;

        // Flash::warning('La materia prima' . $materiaPrima->nombre . ' ha sido borrado exitosamente' );
        $materiaPrima = MateriaPrima::find($request->materia_delete);
        if($materiaPrima!=null){
            if($materiaPrima->modelos->isEmpty()){
                
                $materiaPrima->delete();
                return redirect()->back()->with('warning','Se elimino la materia prima con exito');
            }
            return redirect()->back()->withErrors('No se puedo eliminar la materia prima porque esta asociada a opciondes de pedidos');

        }
    }
}
