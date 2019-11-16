<?php

namespace App\Http\Controllers;

use App\FlujoTrabajo;
use App\Imagen;
use App\Modelo;
use App\Pedido;
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
    public function create($id)
    {
        $tipoImagenes = TipoImagen::all();
        $modelo = Modelo::find($id);

        $array = collect();
        $hijoModelosConMateriaPrimas = $this->obtenerTodoslosModelosConMateriaPrimas($modelo, $array);

        $cantidadModelos = 0;
        return view('producto.create', compact('modelo', 'tipoImagenes', 'hijoModelosConMateriaPrimas', 'cantidadModelos'));
    }
    public function tienda()
    {
        $productos = Producto::where('final', '<>', 0)->where('final', '<>', null)->get();
        $imagenes = Imagen::all();
        $tipoImagenes = TipoImagen::all();
        //modelos para la venta
        $modelosVentas = Modelo::where('venta', '<>', 0)->where('venta', '<>', null)->get();

        return view('producto.tienda', compact('productos', 'tipoImagenes', 'modelosVentas', 'imagenes', 'modelosSinPadres'));
    }
    public function obtenerTodoslosModelosConMateriaPrimas($modelo, $array)
    {
        if ($modelo != null) {

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
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //No controlo los id de las imagenes del sistema
        // return $request;
        $materiaPrimaSeleccionada = collect();
        $rule2 = [];
        $mensaje2 = [];

        $modelo = Modelo::find($request->modelo_id);
        // dd($modelo->componentes);
        if ($modelo == null) {
            return redirect()->back()->with('errors', ['El modelo para crear el producto no existe']);
        }
        //cargar por cada componente sus imagenes y verificar si cumplen con los requerimiento de imagenes
        foreach ($modelo->componentes as $key => $componente) {
            $cantidadImagenes = $request->input('cantidadImagenes_' . $componente->id);

            for ($i = 1; $i <= $cantidadImagenes; $i++) {

                $rule2 = array_merge($rule2, [
                    'file_' . $i . '_componente_' . $componente->id => 'mimes:jpeg,png,jpg,gif,svg,webp|max:2048',

                ]);
                $mensaje2 = array_merge($mensaje2, [
                    'file_' . $i . '_componente_' . $componente->id . '.required'     => 'La imagen es obligatoria',
                    'file_' . $i . '_componente_' . $componente->id . '.mimes'     => 'El tipo de la imagen debe ser cualquiera de los siguientes tipos peg,png,jpg,gif,svg',
                    'file_' . $i . '_componente_' . $componente->id . '.max'     => 'La resolucion maxima de la imagen es 2048',
                ]);
            }
        }

        foreach ($modelo->componentes as $key => $componente) {
            $cantidadImagenes = $request->input('cantidadImagenes_sistema_' . $componente->id);

            for ($i = 1; $i <= $cantidadImagenes; $i++) {

                $rule2 = array_merge($rule2, [
                    'imagen_sistema_' . $i . '_componente_' . $componente->id . '_id' . $componente->id => 'integer',

                ]);
                $mensaje2 = array_merge($mensaje2, [
                    'imagen_sistema_' . $i . '_componente_' . $componente->id . '_id' . $componente->id . '.required'     => 'La imagen es obligatoria',
                    'imagen_sistema_' . $i . '_componente_' . $componente->id . '_id' . $componente->id . '.integer'     => 'La imagen seleccionada no existe',
                ]);
            }
        }


        //creamos el array para el sync de productos a materias primas
        for ($i = 0; $i < $request->cantidadModelos; $i++) {
            //guardamos el id de las materia prima seleccionada del modelo
            $materiaPrimaSeleccionada = $materiaPrimaSeleccionada->add($request->input('modelo_' . $i));
            $rule2 = array_merge($rule2, ['modelo_' . $i => 'required']);
            $mensaje2 = array_merge($mensaje2, ['modelo_' . $i . '.required' => 'El modelo no fue seleccionado']);
        }

        $rules = [];

        $messages = [];

        // return $materiaPrimaSeleccionada;
        $messages = array_merge($messages, $mensaje2);
        $rules = array_merge($rules, $rule2);
        $this->validate($request, $rules, $messages);

        //creamos el producto
        $form_data = array(
            'final'        =>  0,
            'imagenPrincipal'        =>  null,
            'modelo_id'         =>  $request->modelo_id,
            'user_id' => auth()->user()->id
        );

        //si no crea es porque hay agun atributo que no permite null que esta vacio

        $producto = Producto::create($form_data);

        foreach ($modelo->componentes as $key => $componente) {
            # code...

            $imagen = null;
            $sublimaciones = collect();
            $cantidadImagenes = $request->input('cantidadImagenes_' . $componente->id);
            $cantidadImagenesSistema = $request->input('cantidadImagenes_sistema_' . $componente->id);
            $sublimacion = null;
            for ($i = 1; $i <= $cantidadImagenes; $i++) {

                $nombreArchivo = 'file_' . $i . '_componente_' . $componente->id;
                if ($request->hasFile($nombreArchivo)) {
                    $file = $request->file($nombreArchivo);
                    $hoy = Carbon::now();
                    $imagen =  $hoy->format('YmdHi') . '' . time() . '.' . $request->file($nombreArchivo)->getClientOriginalExtension();
                    //si existe el archivo creo la sublimacion 

                    //asd
                    $sublimacion = Sublimacion::create([
                        'nuevaImagen' =>  $imagen,

                        'posX' => $request->input('imagen_' . $i . '_componente_' . $componente->id . '_posX'),
                        'posY' => $request->input('imagen_' . $i . '_componente_' . $componente->id . '_posY'),
                        'alto' => $request->input('imagen_' . $i . '_componente_' . $componente->id . '_alto'),
                        'ancho' => $request->input('imagen_' . $i . '_componente_' . $componente->id . '_ancho'),
                        'forma' => $request->input('imagen_' . $i . '_componente_' . $componente->id . '_forma'),
                        'componente_id' => $componente->id,
                        'producto_id' => $producto->id,
                        'imagen_id' => null

                    ]);
                    $imagen = $sublimacion->id . $imagen;
                    $sublimacion->update(['nuevaImagen' =>  $imagen]);
                    $file->move(public_path('/imagenes/sublimaciones/sinProcesar/'), $imagen);
                }
            }
            for ($i = 1; $i <= $cantidadImagenesSistema; $i++) {
                if ($request->has('imagen_sistema_' . $i . '_componente_' . $componente->id . '_id')) {

                    $sublimacion = Sublimacion::create([
                        'nuevaImagen' =>  null,
                        'posX' => $request->input('imagen_sistema_' . $i . '_componente_' . $componente->id . '_posX'),
                        'posY' => $request->input('imagen_sistema_' . $i . '_componente_' . $componente->id . '_posY'),
                        'alto' => $request->input('imagen_sistema_' . $i . '_componente_' . $componente->id . '_alto'),
                        'ancho' => $request->input('imagen_sistema_' . $i . '_componente_' . $componente->id . '_ancho'),
                        'forma' => $request->input('imagen_sistema_' . $i . '_componente_' . $componente->id . '_forma'),
                        'componente_id' => $componente->id,
                        'producto_id' => $producto->id,
                        'imagen_id' =>  $request->input('imagen_sistema_' . $i . '_componente_' . $componente->id . '_id')

                    ]);
                }
            }
        }


        //Agregamos la materias primas del modelo
        foreach ($modelo->materiasPrimas as $key => $mate) {
            $materiaPrimaSeleccionada->add($mate->id);
        }

        $producto->materiasPrimas()->sync($materiaPrimaSeleccionada);
        //creamos el pedido y asociamos el producto a un detalle de pedido
        $flujoTrabajo = FlujoTrabajo::find(1);

        if (auth()->user()->pedidoAPagar() == null) {
            $pedido = Pedido::create([
                'precio' => $producto->modelo->precioUnitario,
                //termiando null cuando el pedido se creo y no se pago
                //terminado 0 cuando el pedido se pago y no se verifico
                //terminado 1 cuando se finalizo la venta
                'terminado' => null,
                'flujoTrabajo_id' => 1,
                'estado_id' => $flujoTrabajo->getEstadoInicial()->id,
                'user_id' => auth()->user()->id
            ]);
        }
        //ya existe un pedido creado para el carrito
        $control = new PedidoController();
        $control->agregarCarrito($producto, 1, auth()->user());


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
        $tipoImagenes = TipoImagen::all();
        return view('producto.preShow', compact('producto', 'tipoImagenes'));
    }
    //hace lo mismo que preshow pero verifica que el usuario este accediendo a un producto que el creo
    public function miProducto($id)
    {

        $producto = Producto::find($id);
        if ($producto != null) {
            $producto = Producto::where('id', $id)->where('user_id', auth()->user()->id)->first();
        }
        $tipoImagenes = TipoImagen::all();

        return view('producto.preShow', compact('producto', 'tipoImagenes'));
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
