<?php

namespace App\Http\Controllers;

use App\ImagenIndividual;
use App\MateriaPrima;
use App\Medida;
use App\Modelo;
use App\Receta;
use Carbon\Carbon;
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
        $medidas = Medida::all();
        $modelos = Modelo::all();
        $materiaPrimas = MateriaPrima::all();
        return view('materiaPrima.index', compact('medidas', 'modelos', 'materiaPrimas'));
    }
    public function urgente(Request $request)
    {
        $medidas = Medida::all();
        $modelos = Modelo::all();
        $materiaPrimas = MateriaPrima::all()->where('cantidad', '<=', 'materia_primas.stockMinimo');
        //cantidad de productos que no se pueden realizar por falta de materia prima.
        // $cantidadDePedidosNoAtendidos=
        return view('materiaPrima.index', compact('medidas', 'modelos', 'materiaPrimas'));
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
                'totalModelos' => Modelo::all(), 'totalMedidas' => Medida::all()
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

            'modelos.required' => 'Debe seleccionar un modelo como minimo',

            'imagenPrincipal.required'     => 'La imagen es obligatoria',
            'imagenPrincipal.mimes'     => 'El tipo de la imagen debe ser cualquiera de los siguientes tipos peg,png,jpg,gif,svg',
            'imagenPrincipal.max'     => 'La resolucion maxima de la imagen es 2048',
        ];

        $this->validate($request, $rules, $messages);

        //si el id que crea es uno borrado lo revivimos
        $materiaPrima = MateriaPrima::withTrashed()->find($request->hidden_id);


        $imagen = null;
        if ($request->hasFile('imagenPrincipal')) {
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
        // $materiaPrima->modelos()->detach($request->input('modelos',[]),$request->input('modelos',[]) );

        // $materiaPrima->modelos()->sync($request->input('modelos', []));
        // return response()->json(['success' => 'Materia Prima Actualizada Correctamente']);
        return redirect()->back()->with('success', 'Actualizado Correctamente');
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
        $materiaPrima->delete();
        return redirect()->back();
    }
}
