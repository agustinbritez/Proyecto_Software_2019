<?php

namespace App\Http\Controllers;

use App\MateriaPrima;
use App\Medida;
use App\Modelo;
use App\Receta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use File;
use Illuminate\Database\Eloquent\Model;

class ModeloController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $modelos = Modelo::all();
        return view('modelo.index', compact('modelos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $modelo = new Modelo();
        $modelos = Modelo::all();
        $modificar = false;
        $medidas = Medida::all();
        return view('modelo.create', compact('modelos', 'modificar', 'modelo', 'medidas'));
    }


    public function modificar(Request $request, $id)
    {
        $modelo = Modelo::find($id);
        $modelos = Modelo::all();
        $modificar = true;
        $medidas = Medida::all();
        return view('modelo.create', compact('modelos', 'modificar', 'modelo', 'medidas'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if (request()->ajax()) {

            $request->nombre = strtoupper($request->nombre);
            //obtengo la materias primas borradas si elnombre se repite la reuso
            $modeloExistente = Modelo::where('nombre', $request->nombre)->where('deleted_at', "<>", null)->withTrashed()->first();
            // return response()->json(['success' => 'Modelo creado con exito!.', 'modelo' => 1]);
            //*****************************************************************************************************8 */
            //si el nombre esta repetido en una materia prima eliminada 
            //la volvemos a revivir y le actualizamos con los datos del nuevo
            if ($modeloExistente != null) {
                // $modeloExistente->restore();
                $request->hidden_id = $modeloExistente->id;
                $this->update($request);

                // return redirect()->back()->with('success', 'Modelo Creado Con Exito!');
                return response()->json(['success' => 'Modelo creado con exito!.', 'modelo' => $modeloExistente]);
            }
            $rules = [
                'nombre'    =>  'required|unique:modelos',
                'imagenPrincipal'     =>  'required|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'precioUnitario'     =>  'required|numeric',
                'medida_id' => 'required'
            ];
            //transformamos la mascara de precio unitario a un valor double normal
            $tr = str_replace([',', '$', ' '], '', $request->precioUnitario);
            // $tr= str_replace('.',',',$tr);

            $request->precioUnitario = $tr;
            $messages = [
                'nombre.required' => 'Agrega el nombre del modelo.',
                'nombre.unique' => 'El nombre del modelo debe ser unico.',

                'precioUnitario.required' => 'Agrege el precio del modelo.',
                'precioUnitario.numeric' => 'El precio debe ser un valor numerico',

                'imagenPrincipal.required'     => 'La imagen es obligatoria',
                'imagenPrincipal.mimes'     => 'El tipo de la imagen debe ser cualquiera de los siguientes tipos peg,png,jpg,gif,svg',
                'imagenPrincipal.max'     => 'La resolucion maxima de la imagen es 2048',

                'medida_id.required' => 'No selecciono una medida'
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {

                return response()->json(['errors' => $validator->errors()->all()]);
            }



            // return response()->json(['success' => 'Modelo creado con exito!.', 'modelo' => 1]);
            // $this->validate($request, $rules, $messages);



            $imagen = null;
            if ($request->hasFile('imagenPrincipal')) {
                $file = $request->file('imagenPrincipal');
                $imagen = time() . '.' . $request->file('imagenPrincipal')->getClientOriginalExtension();
                $file->move(public_path('/imagenes/modelos/'), $imagen);
            }
            $venta = 0;
            //El modelo va a estar disponibles para la venta
            if ($request->has('venta')) {
                $venta = 1;
            }

            $form_data = array(
                'nombre'        =>  $request->nombre,
                'imagenPrincipal'        =>  $imagen,
                'detalle'         =>  $request->detalle,
                'precioUnitario'         =>  $request->precioUnitario,
                'medida_id' => $request->medida_id,
                'venta' => $venta
            );

            //si no crea es porque hay agun atributo que no permite null que esta vacio
            $modelo = Modelo::create($form_data);
            // if ($request->has('modelos')) {
            //     $modelo->modelos()->sync($request->input('modelos', []));
            // }
            return response()->json(['success' => 'Modelo creado correctamente.', 'modelo' => $modelo]);

            return redirect()->back()->with('success', 'Materia Prima Creada Con Exito!');
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Modelo  $modelo
     * @return \Illuminate\Http\Response
     */
    public function show(Modelo $modelo)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Modelo  $modelo
     * @return \Illuminate\Http\Response
     */
    public function cargarListaIngrediente($variable)
    {

        //si el checkbox esta seleccionado tiene que devolver solo las materias primas
        if ($variable) {
            $data = MateriaPrima::all();
        } else {
            $data = Modelo::all();
        }

        return $data;
    }

    public function getMedidaMateriaPrima($id)
    {
        $materia = MateriaPrima::find($id);
        if ($materia != null) {
            return $materia->medida;
        }
    }
    public function getMedidaModelo($id)
    {
        $modelo = Modelo::find($id);
        if ($modelo != null) {
            return $modelo->medida;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Modelo  $modelo
     * @return \Illuminate\Http\Response
     */

    public function addRelation(Request $request)
    {
        // return response()->json(['success' => 'Modelo creado con exito!.', 'request' => $request->has('cambiarIngrediente') ]);

        if (request()->ajax()) {
            $agregar = false;
            //el modelo padre
            $modelo = Modelo::find($request->hidden_id_modelo);
            if ($modelo != null) {
                //validamos
                $validator = Validator::make(
                    $request->all(),
                    ['cantidad' => 'required|integer', 'prioridad' => 'required|integer', 'ingredientes' => 'required'],
                    [
                        'cantidad.required' => 'No ingreso la cantidad', 'cantidad.integer' => 'No ingreso un numero',
                        'prioridad.required' => 'No ingreso la prioridad', 'prioridad.integer' => 'No ingreso un numero',
                        'ingredientes' => 'No selecciono un ingrediente'
                    ]
                );

                if ($validator->fails()) {

                    return response()->json(['errors' => $validator->errors()->all()]);
                }
                //si el modelo ya tiene el ingrediente que se desea agregar lo rechaza
                if ($request->has('cambiarIngrediente')) {
                    foreach ($modelo->recetaPadre as $key => $receta) {
                        if ($receta->materiaPrima != null) {
                            if ($receta->materiaPrima->id == $request->ingredientes) {
                                return response()->json(['errors' => ['La materia prima seleccionada se encuentra  relacionada']]);
                            }
                        }
                    }
                } else {
                    foreach ($modelo->recetaPadre as $key => $receta) {
                        if ($receta->modeloHijo != null) {
                            if ($receta->modeloHijo->id == $request->ingredientes) {
                                return response()->json(['errors' => ['El modelo seleccionado se encuentra  relacionado xx']]);
                            }
                        }
                    }
                }

                //si el check esta seleccionado quiere decir que trajo una materia prima
                if ($request->has('cambiarIngrediente')) {


                    $form_data = array(
                        'modeloPadre_id' => $request->hidden_id_modelo,
                        'materiaPrima_id' => $request->ingredientes,
                        'cantidad'        =>  $request->cantidad,
                        'prioridad' => $request->prioridad
                    );

                    //si no crea es porque hay agun atributo que no permite null que esta vacio
                    $receta = Receta::create($form_data);
                    $agregar = true;
                    return response()->json(['success' => 'Relacion agregada correctamente.', 'agregar' => $agregar, 'receta' => $receta, 'hijoModelo' => null, 'hijoMateriaPrima' => $receta->materiaPrima]);
                } else {
                    //si el check no esta seleccionado significa que trajo una relacion de modelo

                    //si llego hasta este punto se puede agregar la relacion de modelo a modelo

                    $form_data = array(
                        'modeloPadre_id' => $request->hidden_id_modelo,
                        'modeloHijo_id' => $request->ingredientes,
                        'cantidad'        =>  $request->cantidad,
                        'prioridad' => $request->prioridad
                    );

                    // return response()->json(['success' => 'Modelo creado con exito!.', 'request' => $form_data]);
                    //si no crea es porque hay agun atributo que no permite null que esta vacio
                    $receta = Receta::create($form_data);
                    $agregar = true;

                    return response()->json(['success' => 'Relacion agregada correctamente.', 'agregar' => $agregar, 'receta' => $receta, 'hijoModelo' => $receta->modeloHijo, 'hijoMateriaPrima' => null]);
                }


                // $modelo->$modelo->modelos()->sync($request->input('modelos', []));


            }

            return response()->json(['errors' => ['El modelo que quiere sincronizar no existe']]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Modelo  $modelo
     * @return \Illuminate\Http\Response
     */
    public function edit(Modelo $modelo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Modelo  $modelo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $rules = [
            'nombre'    =>  'required|unique:modelos,nombre,' . $request->hidden_id,
            'imagenPrincipal'     =>  'mimes:jpeg,png,jpg,gif,svg|max:2048',
            'precioUnitario'     =>  'required|numeric'
        ];

        //transformamos la mascara de precio unitario a un valor double normal
        $tr = str_replace([',', '$', ' '], '', $request->precioUnitario);
        // $tr= str_replace('.',',',$tr);

        $request->precioUnitario = $tr;
        $request->nombre = strtoupper($request->nombre);

        $messages = [
            'nombre.required' => 'Agrega el nombre de la materia prima.',
            'nombre.unique' => 'El nombre de la materia prima debe ser unico.',

            'precioUnitario.required' => 'Agrege el precio de la materia prima.',
            'precioUnitario.numeric' => 'El precio debe ser un valor numerico',

            'imagenPrincipal.mimes'     => 'El tipo de la imagen debe ser cualquiera de los siguientes tipos peg,png,jpg,gif,svg',
            'imagenPrincipal.max'     => 'La resolucion maxima de la imagen es 2048'

        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {

            return response()->json(['errors' => $validator->errors()->all()]);
        }

        //si el id que crea es uno borrado lo revivimos
        $modelo = Modelo::withTrashed()->find($request->hidden_id);


        $imagen = null;
        if ($request->hasFile('imagenPrincipal')) {
            $file = $request->file('imagenPrincipal');
            $imagen = time() . '.' . $request->file('imagenPrincipal')->getClientOriginalExtension();
            $file->move(public_path('/imagenes/modelos/'), $imagen);
            $form_data = array(
                'nombre'        =>  $request->nombre,
                'imagenPrincipal'        =>  $imagen,
                'detalle'         =>  $request->detalle,
                'precioUnitario'         =>  $request->precioUnitario,
                'medida_id' => $request->medida_id
            );
            //creamos el camino de la imagen vieja
            $file_path = public_path() . '/imagenes/modelos/' . $modelo->imagenPrincipal;
            //borramos la imagen vieja
            unlink($file_path);
        } else {
            $form_data = array(
                'nombre'        =>  $request->nombre,
                'detalle'         =>  $request->detalle,
                'precioUnitario'         =>  $request->precioUnitario,
                'medida_id' => $request->medida_id
            );
        }


        //revive a la materia prima borrada anteriormente.
        $modelo->restore();
        //Actualizamos
        // $modelo->fill($request->all());
        $modelo->update($form_data);

        return response()->json(['success' => 'Modelo Actualizado Exitosamente!', 'modelo' => $modelo]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Modelo  $modelo
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $modelo = Modelo::find($id);
        if (!$modelo->recetaHijo->isEmpty()) {
            return redirect()->back()->withErrors(['message2' => 'No se puede eliminar el modelo porque es ingrediente de otras recetas']);
        }
        if (!$modelo->materiasPrimas->isEmpty()) {
            return redirect()->back()->withErrors(['message2' => 'No se puede eliminar el modelo, esta relacionado a materias primas']);
        }
        // if (!$modelo->componentes->isEmpty()) {
        //     return redirect()->back()->withErrors(['message2' => 'No se puede eliminar el modelo, esta relacionado a componentes']);
        // }
        // if (!$modelo->productosModelos->isEmpty()) {
        //     return redirect()->back()->withErrors(['message2' => 'No se puede eliminar el modelo, esta relacionado a productos']);
        // }
        //borramos todas sus recetas
        foreach ($modelo->recetaPadre as $key => $receta) {
            $receta->delete();
        }

        $modelo->delete();
        return redirect()->back()->with('warning', 'Se elimino el modelo de manera correcta');
    }
}
