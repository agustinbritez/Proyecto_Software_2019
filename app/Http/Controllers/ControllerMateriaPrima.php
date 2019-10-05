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
        $medidas = Medida::all();
        $modelos = Modelo::all();
        $materiaPrimas = MateriaPrima::all();
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
            // 'imagenPrincipal'     =>  'required|imagenPrincipal|mimes:jpeg,png,jpg,gif,svg|max:2048',
            // 'imagenPrincipal'     =>  'required|imagenPrincipal|mimes:jpeg,png,jpg,gif,svg',
            'cantidad'     =>  'required|integer',
            'precioUnitario'     =>  'required|numeric',
            'medida_id'     =>  'required',
            'modelos'     =>  'required'
        ];
        //transformamos la mascara de precio unitario a un valor double normal
        $tr = str_replace([',', '$', ' '], '', $request->precioUnitario);
        // $tr= str_replace('.',',',$tr);

        $request->precioUnitario = $tr;
        $messages = [
            'nombre.required' => 'Agrega el nombre de la materia prima.',
            'nombre.unique' => 'El nombre de la materia prima debe ser unico.',
            // 'detalle.required' =>'Agrega el detalle de la materia prima.',
            'cantidad.required' => 'Agrega la  cantidad de materias primas.',
            'cantidad.integer' => 'La cantidad debe ser un valor entero',
            'precioUnitario.required' => 'Agrege el precio de la materia prima.',
            'precioUnitario.numeric' => 'El precio debe ser un valor numerico',
            'medida_id.required' => 'Debe seleccionar una unidad de medida',
            'modelos.required' => 'Debe seleccionar un modelo como minimo'
        ];

        $this->validate($request, $rules, $messages);





        $imagen = null;
        if ($request->hasFile('imagenPrincipal')) {
            $file = $request->file('imagenPrincipal');
            $imagen = time() . '.' . $request->file('imagenPrincipal')->getClientOriginalExtension();
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
            'medida_id'         =>  $request->input('medida_id')
        );
        // $materiaPrima= new MateriaPrima();
        // $materiaPrima->fill($request->all());
        // $materiaPrima->save();
        // return $materiaPrima;
        //si no crea es porque hay agun atributo que no permite null que esta vacio
        $form_data;
        $materiaPrima = MateriaPrima::create($form_data);
        if ($request->has('modelos')) {
            $materiaPrima->modelos()->sync($request->input('modelos', []));
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
            // 'imagenPrincipal'     =>  'required|imagenPrincipal|mimes:jpeg,png,jpg,gif,svg|max:2048',
            // 'imagenPrincipal'     =>  'required|imagenPrincipal|mimes:jpeg,png,jpg,gif,svg',
            'cantidad'     =>  'required|integer',
            'precioUnitario'     =>  'required|numeric',
            'medida_id'     =>  'required',
            'modelos'     =>  'required'
        ];

        //transformamos la mascara de precio unitario a un valor double normal
        $tr = str_replace([',', '$', ' '], '', $request->precioUnitario);
        // $tr= str_replace('.',',',$tr);

        $request->precioUnitario = $tr;
        $request->nombre = strtoupper($request->nombre);

        $messages = [
            'nombre.required' => 'Agrega el nombre de la materia prima.',
            'nombre.unique' => 'El nombre de la materia prima debe ser unico.',
            // 'detalle.required' =>'Agrega el detalle de la materia prima.',
            'cantidad.required' => 'Agrega la  cantidad de materias primas.',
            'cantidad.integer' => 'La cantidad debe ser un valor entero',
            'precioUnitario.required' => 'Agrege el precio de la materia prima.',
            'precioUnitario.numeric' => 'El precio debe ser un valor numerico',
            'medida_id.required' => 'Debe seleccionar una unidad de medida',
            'modelos.required' => 'Debe seleccionar un modelo como minimo'
        ];
        $this->validate($request, $rules, $messages);
        $imagen = null;
        if ($request->hasFile('imagenPrincipal')) {
            $file = $request->file('imagenPrincipal');
            $imagen = time() . '.' . $request->file('imagenPrincipal')->getClientOriginalExtension();
            $file->move(public_path('/imagenes/materia_primas/'), $imagen);
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
        $form_data = array(
            'nombre'        =>  $request->nombre,
            'imagenPrincipal'        =>  $imagen,
            'detalle'         =>  $request->detalle,
            'precioUnitario'         =>  $request->precioUnitario,
            'cantidad'         =>  $request->cantidad,
            'medida_id'         =>  $request->medida_id
        );
        //si no crea es porque hay agun atributo que no permite null que esta vacio


        //si el id que crea es uno borrado lo revivimos
        $materiaPrima = MateriaPrima::withTrashed()->find($request->hidden_id);
        //revive a la materia prima borrada anteriormente.
        $materiaPrima->restore();

        $materiaPrima->update($form_data);
        // $materiaPrima->modelos()->detach($request->input('modelos',[]),$request->input('modelos',[]) );

        $materiaPrima->modelos()->sync($request->input('modelos', []));
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
