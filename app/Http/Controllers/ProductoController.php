<?php

namespace App\Http\Controllers;

use App\Modelo;
use App\Producto;
use App\Sublimacion;
use App\TipoImagen;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tipoImagenes = TipoImagen::all();
        $modelo = Modelo::find(1);

        $array = collect();
        $hijoModelosConMateriaPrimas = $this->obtenerTodoslosModelosConMateriaPrimas($modelo, $array);
        $cantidadModelos = 0;
        return view('producto.create', compact('modelo', 'tipoImagenes', 'hijoModelosConMateriaPrimas', 'cantidadModelos'));
    }

    public function obtenerTodoslosModelosConMateriaPrimas($modelo, $array)
    {

        //codicion de corte
        if ($modelo->hijosModelos->isEmpty() && $modelo->materiasPrimas->isEmpty()) {
            return $array;
        }
        //coleccionar modelos con materias primas en sus recetas
        if (!$modelo->materiasPrimas->isEmpty()) {
            $array->add($modelo);
        }


        foreach ($modelo->hijosModelos as $key => $modeloHijo) {
            $array2 = $this->obtenerTodoslosModelosConMateriaPrimas($modeloHijo, $array);
            if ($array2->isNotEmpty()) {
                $array->merge($array2);
            }
        }

        return $array;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $request;
        $modelosSeleccionados = collect();
        $imagenesSeleccionadas = collect();
        $rule2 = [];
        $mensaje2 = [];

        for ($i = 1; $i < $request->cantidadImagenes; $i++) {

            $imagenesSeleccionadas = $imagenesSeleccionadas->add($request->input('file_' . $i));
            $rule2 = array_merge($rule2, ['file_' . $i => 'required|mimes:jpeg,png,jpg,gif,svg,webp|max:2048']);
            $mensaje2 = array_merge($mensaje2, [
                'file_' . $i . '.required'     => 'La imagen es obligatoria',
                'file_' . $i . '.mimes'     => 'El tipo de la imagen debe ser cualquiera de los siguientes tipos peg,png,jpg,gif,svg',
                'file_' . $i . '.max'     => 'La resolucion maxima de la imagen es 2048',
            ]);
        }
        //creamos el array para el sync de productos a materias primas
        for ($i = 0; $i < $request->cantidadModelos; $i++) {

            $modelosSeleccionados = $modelosSeleccionados->add($request->input('modelo_' . $i));
            $rule2 = array_merge($rule2, ['modelo_' . $i => 'required']);
            $mensaje2 = array_merge($mensaje2, ['modelo_' . $i . '.required' => 'El modelo no fue seleccionado']);
        }
        $rules = [
            'imagenNueva'     =>  'mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            // 'imagenPrincipal'     =>  'required|imagenPrincipal|mimes:jpeg,png,jpg,gif,svg',
            'posX'     =>  'required|numeric',
            'posY'     =>  'required|numeric',
            'modelo_id' => 'required'
        ];
        //transformamos la mascara de precio unitario a un valor double normal
        // $tr = str_replace([',', '$', ' '], '', $request->precioUnitario);

        // $request->precioUnitario = $tr;
        $messages = [
            // 'posX.required' => 'El objeto debe tener una posicion X.',
            // 'posY.required' => 'El objeto debe tener una posicion Y.',
            // 'nombre.unique' => 'El nombre de la materia prima debe ser unico.',

            // 'precioUnitario.numeric' => 'El precio debe ser un valor numerico',
            // 'posX.numeric' => 'La posicion x debe ser un numero',
            // 'posY.numeric' => 'La posicion x debe ser un numero',

            'modelo_id.required' => 'El modelo no esta seleccionado',
            'modelo_id.integer' => 'El id del modelo debe ser un numero entero',

        ];

        // return $modelosSeleccionados;
        $messages = array_merge($messages, $mensaje2);
        $rules = array_merge($rules, $rule2);
        $this->validate($request, $rules, $messages);


        $imagen = null;
        for ($i = 1; $i < $request->cantidadImagenes; $i++) {

            if ($request->hasFile('file_' . $i)) {
                $file = $request->file('file_' . $i);
                $hoy = Carbon::now();
                $imagen =  $hoy->format('dmYHi') . '' . time() . '.' . $request->file('file_' . $i)->getClientOriginalExtension();
                $file->move(public_path('/imagenes/sublimaciones/'), $imagen);
            }
        }

        $form_data = array(
            'final'        =>  0,
            'imagenPrincipal'        =>  $imagen,
            'modelo_id'         =>  $request->modelo_id,
            'user_id' => auth()->user()->id
        );

        //si no crea es porque hay agun atributo que no permite null que esta vacio

        $producto = Producto::create($form_data);

        $sublimacion = Sublimacion::create([
            'nuevaImagen' => $imagen,
            'posX' => $request->posX,
            'posY' => $request->posY,
            'alto' => $request->alto,
            'ancho' => $request->ancho,
            'componente_id' => null,
            'producto_id' => $producto->id,
            'imagen_id' => null

        ]);
        $modelo = Modelo::find($request->modelo_id);

        if ($modelo != null) {
            foreach ($modelo->materiasPrimas as $key => $mate) {
                $modelosSeleccionados->add($mate->id);
            }
        }
        $producto->materiasPrimas()->sync($modelosSeleccionados);

        return redirect()->back()->with('success', 'Producto Creado Con Exito!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function show(Producto $producto)
    {
        //
    }
    public function preshow($id)
    {
        $producto = Producto::find($id);
        return view('producto.preShow', compact('producto'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function edit(Producto $producto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Producto $producto)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function destroy(Producto $producto)
    {
        //
    }
}
