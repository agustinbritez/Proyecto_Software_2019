<?php

namespace App\Http\Controllers;

use App\Componente;
use App\FlujoTrabajo;
use App\MateriaPrima;
use App\Medida;
use App\Modelo;
use App\Receta;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Date;

use DateTime;

class ModeloController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $modelos = Modelo::all()->where('base', 0);
        $modeloBase = false;
        return view('modelo.index', compact('modelos', 'modeloBase'));
    }
    public function indexBase()
    {
        $modelos = Modelo::all()->where('base', '<>', 0);
        $modeloBase = true;

        return view('modelo.index', compact('modelos', 'modeloBase'));
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
    public function baseCreate()
    {
        $modelo = new Modelo();
        $materiaPrimas = MateriaPrima::all();
        $modificar = false;
        $medidas = Medida::all();
        return view('modelo.modeloBase', compact('materiaPrimas', 'modificar', 'modelo', 'medidas'));
    }
    public function baseModificar(Request $request, $id)
    {
        $modelo = Modelo::find($id);
        $materiaPrimas = MateriaPrima::all();
        $modificar = true;
        $medidas = Medida::all();
        return view('modelo.modeloBase', compact('materiaPrimas', 'modificar', 'modelo', 'medidas'));
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
                'imagenPrincipal'     =>  'required|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
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
                $hoy = Carbon::now();
                $imagen =  $hoy->format('dmYHi') . '' . time() . '.' . $request->file('imagenPrincipal')->getClientOriginalExtension();
                $file->move(public_path('/imagenes/modelos/'), $imagen);
            }
            $venta = 0;
            //El modelo va a estar disponibles para la venta
            if ($request->has('venta')) {
                $venta = 0;
            }
            $flujoGeneral = FlujoTrabajo::find(2);
            $idFlujo = null;
            if ($flujoGeneral != null) {
                $idFlujo = $flujoGeneral->id;
            }
            $base = 0;
            if ($request->hidden_modelo_base == 1) {
                $base = 1;
            }
            $form_data = array(
                'nombre'        =>  $request->nombre,
                'imagenPrincipal'        =>  $imagen,
                'detalle'         =>  $request->detalle,
                'precioUnitario'         =>  $request->precioUnitario,
                'medida_id' => $request->medida_id,
                'venta' => $venta,
                'base' => $base,
                'cantidadDiasProducidos' => 0,
                //el id es del FLUJO PRODUCCION GENERAL
                'flujoTrabajo_id' => $idFlujo
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
    public function addComponente(Request $request)
    {
        // return $request;
        // return response()->json(['success' => 'Modelo creado con exito!.', 'request' => $request->has('cambiarIngrediente') ]);

        if (request()->ajax()) {

            //el modelo padre
            $modelo = Modelo::find($request->hidden_id_modelo_componente);
            if ($modelo != null) {
                //validamos
                $validator = Validator::make(
                    $request->all(),
                    ['nombreComponente' => 'required', 'imagenComponente'     =>  'required|mimes:jpeg,png,jpg,gif,svg,webp|max:2048|dimensions:min_width=400,min_height=400,max_width=600,max_height=500'],
                    [
                        'nombreComponente.required' => 'Agrega el nombre del componente.',
                        'imagenComponente.required'     => 'La imagen es obligatoria',
                        'imagenComponente.mimes'     => 'El tipo de la imagen debe ser cualquiera de los siguientes tipos peg,png,jpg,gif,svg',
                        'imagenComponente.max'     => 'La resolucion maxima de la imagen es 2048',
                        'imagenComponente.dimensions'     => 'Las dimensiones minimas deben ser alto:400 ancho:400 y las maximas alto:600 ancho:500',
                    ]
                );

                if ($validator->fails()) {

                    return response()->json(['errors' => $validator->errors()->all()]);
                }
                if (!$modelo->productosModelos->isEmpty()) {

                    return response()->json(['errors' => ['No se pueden agregar mas componentes porque existen productos creados en base a este modelo']]);
                }

                $imagen = null;
                if ($request->hasFile('imagenComponente')) {
                    $file = $request->file('imagenComponente');
                    $hoy = Carbon::now();
                    $imagen =  $hoy->format('dmYHi') . '' . time() . '.' . $request->file('imagenComponente')->getClientOriginalExtension();



                    $file->move(public_path('/imagenes/componentes/'), $imagen);
                }


                $form_data = array(
                    'nombre' => $request->nombreComponente,
                    'imagenPrincipal' => $imagen,
                    'modelo_id' => $modelo->id
                );

                //si no crea es porque hay agun atributo que no permite null que esta vacio
                $componente = Componente::create($form_data);

                return response()->json(['success' => 'Componente creado correctamente.', 'componente' => $componente]);
            }

            return response()->json(['errors' => ['El modelo no existe por lo tanto no se pueden crear los componentes']]);
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
            $mensaje = [];
            $agregar = false;
            //el modelo padre
            $modelo = Modelo::find($request->hidden_id_modelo);
            if ($modelo != null) {

                //validamos
                if ($request->hidden_modelo_base == 0) {

                    $validator = Validator::make(
                        $request->all(),
                        ['cantidad' => 'required|integer|min:1', 'prioridad' => 'required|integer', 'ingredientes' => 'required'],
                        [
                            'cantidad.required' => 'No ingreso la cantidad', 'cantidad.integer' => 'No ingreso un numero',
                            'cantidad.min' => 'La cantidad no puede ser menor a 1',
                            'prioridad.required' => 'No ingreso la prioridad', 'prioridad.integer' => 'No ingreso un numero',
                            'ingredientes' => 'No selecciono un ingrediente'
                        ]
                    );
                } else {
                    $validator = Validator::make(
                        $request->all(),
                        ['ingredientes' => 'required'],
                        [
                            'ingredientes' => 'No selecciono un ingrediente'
                        ]
                    );
                }

                if ($validator->fails()) {

                    return response()->json(['errors' => $validator->errors()->all()]);
                }
                if (!$modelo->productosModelos->isEmpty()) {
                    return response()->json(['errors' => ['Existen productos asociados al modelo no puede modificar sus recetas']]);
                }
                // if($modelo->){

                // }
                //si el modelo ya tiene el ingrediente que se desea agregar lo rechaza
                if ($request->hidden_modelo_base != 0) {
                    $materiaPrimis = MateriaPrima::find($request->ingredientes);
                    if ($materiaPrimis != null) {
                        if ($materiaPrimis->medida->id != $modelo->medida->id) {
                            return response()->json(['errors' => ['La materia prima que se quiere agregar al modelo tiene la unidad de medida diferente, deben ser iguales']]);
                        }
                    }
                    foreach ($modelo->recetaPadre as $key => $receta) {
                        if ($receta->materiaPrima != null) {
                            if ($receta->materiaPrima->id == $request->ingredientes) {
                                return response()->json(['errors' => ['La materia prima seleccionada se encuentra  relacionada']]);
                            }
                        }
                    }
                    //si el check esta seleccionado quiere decir que trajo una materia prima
                    $cantidadIngrediente = 1;
                    $prioridad = 0;
                    $form_data = array(
                        'modeloPadre_id' => $request->hidden_id_modelo,
                        'materiaPrima_id' => $request->ingredientes,
                        'cantidad'        =>  $cantidadIngrediente,
                        'prioridad' => $prioridad
                    );

                    //si no crea es porque hay agun atributo que no permite null que esta vacio
                    $receta = Receta::create($form_data);
                    $agregar = true;
                    $mensaje = array_merge($mensaje, ['success' => 'Relacion agregada correctamente.', 'agregar' => $agregar, 'receta' => $receta, 'hijoModelo' => null, 'hijoMateriaPrima' => $receta->materiaPrima]);
                    return response()->json($mensaje);

                    //queda aca
                } else {
                    if ($request->has('cambiarIngrediente')) {
                        foreach ($modelo->recetaPadre as $key => $receta) {
                            if ($receta->materiaPrima != null) {
                                if ($receta->materiaPrima->id == $request->ingredientes) {
                                    return response()->json(['errors' => ['La materia prima seleccionada se encuentra  relacionada']]);
                                }
                            }
                        }
                        //liso
                    } else {
                        foreach ($modelo->recetaPadre as $key => $receta) {
                            if ($receta->modeloHijo != null) {
                                if ($receta->modeloHijo->id == $request->ingredientes) {
                                    return response()->json(['errors' => ['El modelo seleccionado se encuentra  relacionado ']]);
                                }
                            }
                        }
                        //verificarmos si el modelo a agregar no esta relacionado de manera profunda
                        $modeloPadre = Modelo::find($request->hidden_id_modelo);
                        $modeloHijo = Modelo::find($request->ingredientes);
                        if (($modeloPadre->id == $modeloHijo->id)) {
                            return response()->json(['errors' => ['No puede seleccionar el mismo modelo como ingrediente ']]);
                        }

                        if ($this->verificarSiEsRecursivo($modeloPadre, $modeloHijo)) {
                            return response()->json(['errors' => ['El modelo seleccionado no esta permitido  para recursion ']]);
                        }
                    }
                    //listo
                    $medida = $this->asignarMedidaAlModelo($modelo, $modelo->medida);

                    if ($medida->id != $modelo->medida->id) {
                        $mensaje = array_merge($mensaje, ['warning' => 'La unidad de medida seleccionada se cambio a ' . $medida->nombre . ' porque algunos de sus hijos tienen unidades de medidas diferentes']);
                        $modelo->update();
                    }
                    //si el check esta seleccionado quiere decir que trajo una materia prima
                    $cantidadIngrediente = 1;
                    $prioridad = 0;
                    if ($request->hidden_modelo_base == 0) {
                        $cantidadIngrediente = $request->cantidad;
                        $prioridad = $request->prioridad;
                    }
                    if ($request->has('cambiarIngrediente')) {


                        $form_data = array(
                            'modeloPadre_id' => $request->hidden_id_modelo,
                            'materiaPrima_id' => $request->ingredientes,
                            'cantidad'        =>  $cantidadIngrediente,
                            'prioridad' => $prioridad
                        );

                        //si no crea es porque hay agun atributo que no permite null que esta vacio
                        $receta = Receta::create($form_data);
                        $agregar = true;
                        $mensaje = array_merge($mensaje, ['success' => 'Relacion agregada correctamente.', 'agregar' => $agregar, 'receta' => $receta, 'hijoModelo' => null, 'hijoMateriaPrima' => $receta->materiaPrima]);
                        return response()->json($mensaje);
                    } else {
                        //si el check no esta seleccionado significa que trajo una relacion de modelo

                        //si llego hasta este punto se puede agregar la relacion de modelo a modelo

                        $form_data = array(
                            'modeloPadre_id' => $request->hidden_id_modelo,
                            'modeloHijo_id' => $request->ingredientes,
                            'cantidad'        =>  $cantidadIngrediente,
                            'prioridad' => $prioridad
                        );

                        // return response()->json(['success' => 'Modelo creado con exito!.', 'request' => $form_data]);
                        //si no crea es porque hay agun atributo que no permite null que esta vacio
                        $receta = Receta::create($form_data);
                        $agregar = true;
                        $mensaje = array_merge($mensaje, ['success' => 'Relacion agregada correctamente.', 'agregar' => $agregar, 'receta' => $receta, 'hijoModelo' => $receta->modeloHijo, 'hijoMateriaPrima' => null]);
                        return response()->json($mensaje);
                    }
                }








                // $modelo->$modelo->modelos()->sync($request->input('modelos', []));


            }

            return response()->json(['errors' => ['El modelo que quiere sincronizar no existe']]);
        }
    }
    //Verifica mientras se agrega un nuevo modelo o materia prima si son de la misma unidad de medida.
    //Si se agrega un modelo o materia prima con otra unidad de medida se le asigna UNIDAD como unidad por defecto para evitar
    //problemas de calculos.
    //si un hijo tiene la unidad de medida UNIDAD al padre tambien se le asigna esa.
    private function asignarMedidaAlModelo($modelo, $medida)
    {

        if ($modelo != null) {
            if (!$modelo->hijosModelos->isEmpty()) {
                //modelo auxiliar se usa para verificar si sus hermanos tienen la misma unidad de medida
                $modeloAuxiliar = $modelo->hijosModelos->first();
                foreach ($modelo->hijosModelos as $key => $modeloHijo) {
                    # code...
                    if ($modeloAuxiliar->medida->id != $modeloHijo->medida->id) {
                        //si encuentro un modelo que tiene una medida diferente le asigan UNIDAD
                        $unidad = Medida::where('nombre', 'UNIDAD')->first();
                        if ($unidad != null) {
                            $medida = $unidad;
                            $modelo->medida_id = $unidad->id;
                        }
                        break;
                    }
                }
            } elseif (!$modelo->materiasPrimas->isEmpty()) {
                # code...
                $materiaAuxiliar = $modelo->materiasPrimas->first();
                foreach ($modelo->materiasPrimas as $key => $materiaHijo) {
                    # code...
                    if ($materiaAuxiliar->medida->id != $materiaHijo->medida->id) {
                        //si encuentro un modelo que tiene una medida diferente le asigan UNIDAD
                        $unidad = Medida::where('nombre', 'UNIDAD')->first();
                        if ($unidad != null) {

                            $medida = $unidad;
                        }
                        break;
                    }
                }
            }
        }
        return $medida;
    }

    public function arbolDelModeloConRecetaSeleccionadas($detallePedido)
    {
        // $htmlFinal='<div class="container" style="margin-top:30px;">'
        // +'<div class="row">'
        // +'<div class="col">'
        // +' <ul id="tree3">'
        // +'<li><a href="#">TECH</a>';
        $modelo = $detallePedido->pedido->producto->modelo;
        $htmlFinal = '<li><a href="#">' . $modelo->nombre . '</a>';
        if ($modelo->hijosModelos->isEmpty() && $modelo->materiasPrimas->isEmpty()) {
            $htmlFinal += '</li>';
        } else {
            $htmlFinal += '<ul>';

            if (!$modelo->hijosModelos->isEmpty()) {
                $htmlFinal += '<ul>';
                foreach ($modelo->recetaPadre as $key => $receta) {
                    $htmlHijo = $this->arbolDelModeloConRecetaSeleccionadas($modelo);
                    $htmlFinal += $htmlHijo;
                }
            }
            if (!$modelo->materiasPrimas->isEmpty()) {
                foreach ($modelo->recetaPadre as $key => $receta) {
                    if (!is_null($receta->materiaPrima)) {

                        $htmlFinal += '<li>' . $receta->materiaPrima->nombre . '</li>';
                    }
                }
            }
            $htmlFinal += '</li>';
        }





        // <div class="container" style="margin-top:30px;">
        //                 <div class="row">
        //                     <div class="col">

        //                         <ul id="tree3">
        //                             <li><a href="#">TECH</a>

        //                                 <ul>
        //                                     <li>Company Maintenance</li>
        //                                     <li>Employees
        //                                         <ul>
        //                                             <li>Reports
        //                                                 <ul>
        //                                                     <li>Report1</li>
        //                                                     <li>Report2</li>
        //                                                     <li>Report3</li>
        //                                                 </ul>
        //                                             </li>
        //                                             <li>Employee Maint.</li>
        //                                         </ul>
        //                                     </li>
        //                                     <li>Human Resources</li>
        //                                 </ul>
        //                             </li>
        //                             <li>XRP
        //                                 <ul>
        //                                     <li>Company Maintenance</li>
        //                                     <li>Employees
        //                                         <ul>
        //                                             <li>Reports
        //                                                 <ul>
        //                                                     <li>Report1</li>
        //                                                     <li>Report2</li>
        //                                                     <li>Report3</li>
        //                                                 </ul>
        //                                             </li>
        //                                             <li>Employee Maint.</li>
        //                                         </ul>
        //                                     </li>
        //                                     <li>Human Resources</li>
        //                                 </ul>
        //                             </li>
        //                         </ul>
        //                     </div>
        //                 </div>
        //             </div>
    }
    private function verificarSiContieneMateriasPrimas(Modelo $modelo)
    {
        if (!$modelo->materiasPrimas->isEmpty()) {
            return true;
        }
        if ($modelo->hijosModelos->isEmpty() && $modelo->materiasPrimas->isEmpty()) {
            return false;
        }
        foreach ($modelo->hijosModelos as $key => $modeloHijo) {
            # code...
            if ($modeloHijo != null) {
                if ($this->verificarSiContieneMateriasPrimas($modeloHijo)) {
                    return true;
                }
            }
        }
        return false;
    }

    //los modelos no pueden contener recetas que se autoreferencien en todos sus recectas hijos
    private function verificarSiEsRecursivo($modeloPadre, $modelo_para_agregar)
    {
        if ($modelo_para_agregar->hijosModelos->isEmpty()) {
            //si entra es imposible que sea recursivo si no tiene hijos  a que referenciar
            return false;
        }

        foreach ($modelo_para_agregar->hijosModelos as $key => $hijoModelo) {
            if ($hijoModelo->id == $modeloPadre->id) {
                return true;
            }
        }
        foreach ($modelo_para_agregar->hijosModelos as $key => $hijoModelo) {
            if ($this->verificarSiEsRecursivo($modeloPadre, $hijoModelo)) {
                return true;
            }
        }
        //si no tiene hijos pero ninguno de ellos contienen al modelo padre que le quiere agregar, entonces no es recursivo
        return false;
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
            'imagenPrincipal'     =>  'mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
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
        $base = 0;
        if ($request->hidden_modelo_base == 1) {
            $base = 1;
        }
        if ($modelo == null) {
            return response()->json(['errors' => ['El modelo  no existe']]);
        }
        // return response()->json(['success' => 'Modelo Actualizado Exitosamente!', 'modelo' => new Modelo()]);
        $venta = 0;
        //El modelo va a estar disponibles para la venta

        $mensaje = [];
        if ($request->has('venta')) {


            if ($this->verificarSiContieneMateriasPrimas($modelo)) {
                $venta = 1;
            }

            if ($venta == 0) {
                $mensaje = array_merge($mensaje, ['warning' => 'No se puede habilitar para la venta porque el  modelo o ninguno de sus hijos tiene materias primas asociadas']);
            }
        }

        $imagen = null;
        $medida = Medida::find($request->medida_id);
        $idMedida = null;

        if ($medida != null) {

            $medida = $this->asignarMedidaAlModelo($modelo, $medida);
            $idMedida = $medida->id;
            if ($idMedida != $request->medida_id) {
                $mensaje = array_merge($mensaje, ['warning2' => 'La unidad de medida seleccionada se cambio a ' . $medida->nombre . ' porque algunos de sus hijos tienen unidades de medidas diferentes']);
            }
        }


        if ($request->hasFile('imagenPrincipal')) {
            $file = $request->file('imagenPrincipal');
            $hoy = Carbon::now();
            $imagen =  $hoy->format('dmYHi') . '' . time() . '.' . $request->file('imagenPrincipal')->getClientOriginalExtension();
            $file->move(public_path('/imagenes/modelos/'), $imagen);
            $form_data = array(
                'nombre'        =>  $request->nombre,
                'imagenPrincipal'        =>  $imagen,
                'detalle'         =>  $request->detalle,
                'precioUnitario'         =>  $request->precioUnitario,
                'medida_id' => $idMedida,
                'base' => $base,
                'cantidadDiasProducidos' => 0,
                'venta' => $venta
            );
            //creamos el camino de la imagen vieja
            if (!is_null($modelo->imagenPrincipal)) {

                $file_path = public_path() . '/imagenes/modelos/' . $modelo->imagenPrincipal;
                if (file_exists($file_path)) {
                    //borramos la imagen vieja
                    unlink($file_path);
                }
            }
        } else {
            $form_data = array(
                'nombre'        =>  $request->nombre,
                'detalle'         =>  $request->detalle,
                'precioUnitario'         =>  $request->precioUnitario,
                'venta' => $venta,
                'base' => $base,
                'cantidadDiasProducidos' => 0,
                'medida_id' => $idMedida
            );
        }


        //revive a la materia prima borrada anteriormente.
        $modelo->restore();
        //Actualizamos
        // $modelo->fill($request->all());
        $modelo->update($form_data);
        $mensaje = array_merge($mensaje, ['success' => 'Modelo Actualizado Exitosamente!', 'modelo' => $modelo]);


        return response()->json($mensaje);
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
