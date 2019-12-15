<?php

namespace App\Http\Controllers;

use App\FlujoTrabajo;
use App\Imagen;
use App\MateriaPrimaSeleccionada;
use App\Modelo;
use App\Pedido;
use App\Producto;
use App\Receta;
use App\Sublimacion;
use App\TipoImagen;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
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
        $recetasPadres  = $this->obtenerRecetas($modelo, $array);
        $array2 = collect();

        $modeloConMateriaPrimaEstatica = $this->obtenerModelosConMateriasPrimasEstaticas($modelo, $array2);
        $cantidadModelos = 0;
        return view('producto.create', compact('modelo', 'tipoImagenes', 'recetasPadres', 'cantidadModelos', 'modeloConMateriaPrimaEstatica'));
    }
    public function tienda()
    {
        $productos = Producto::where('final', true)
            ->where('mostrar', true)
            ->join('modelos', 'modelos.id', '=', 'productos.modelo_id')
            ->where('modelos.venta', true)
            ->select('productos.*')
            ->get();

        $imagenes = Imagen::all();
        $tipoImagenes = TipoImagen::all();
        //modelos para la venta
        $modelosVentas = Modelo::where('venta', '<>', 0)->where('venta', '<>', null)->get();
        $vuelto = new Request();
        return view('producto.tienda', compact('productos', 'tipoImagenes', 'modelosVentas', 'imagenes', 'vuelto'));
    }

    public function filtrarTienda(Request $request)
    {
        # code...
        $modelos = DB::table('modelos')->where('modelos.deleted_at', null)
            ->where('venta', true);

        if ($request->has('modelos') && ($request->modelos > 0)) {
            $modelos = $modelos
                ->where('modelos.id', $request->modelos);
        }
        if ($request->has('tipoImagen') && ($request->tipoImagen > 0)) {
            $modelos = $modelos
                ->join('componentes', 'componentes.modelo_id', '=', 'modelos.id')
                ->join('sublimacions', 'componentes.id', '=', 'sublimacions.componente_id')
                ->join('imagens', 'imagens.id', '=', 'sublimacions.imagen_id')
                ->where('imagens.tipoImagen_id', $request->tipoImagen);
            if ($request->has('imagenSeleccionada') && ($request->imagenSeleccionada > 0)) {
                $modelos = $modelos
                    ->where('imagens.id', $request->imagenSeleccionada);
            }
        }
        if (($request->filtro_precioUnitarioMin != '') && ($request->filtro_precioUnitarioMax != '') && ($request->filtro_precioUnitarioMin != null) && ($request->filtro_precioUnitarioMax != null) && ((floatval($request->filtro_precioUnitarioMin) != 0.0) && (floatval($request->filtro_precioUnitarioMax) != 0.0))) {
            $modelos = $modelos
                ->where('precioUnitario', '>=', $request->filtro_precioUnitarioMin)
                ->where('precioUnitario', '<=', $request->filtro_precioUnitarioMax);
        } else if (($request->filtro_precioUnitarioMin != '') && ($request->filtro_precioUnitarioMin != null)) {
            $modelos = $modelos
                ->where('precioUnitario', '>=', $request->filtro_precioUnitarioMin);
        } else if (($request->filtro_precioUnitarioMax != '') && ($request->filtro_precioUnitarioMax != null)) {
            $modelos = $modelos
                ->where('precioUnitario', '<=', $request->filtro_precioUnitarioMax);
        }
        // if ($request->has('ventas') && ($request->ventas >= 0)) {
        //     $modelos = $modelos ->join('productos','modelos.id','=','productos.modelo_id')
        //     ->join('detalle_pedidos','detalle_pedidos.producto_id','=','productos.id')
        //     ->select('modelos.*',DB::raw('count(productos.id) * detalle_pedidos.cantidad  as cantidadVendida'))
        //     // ->select('modelos.*')
        //     ->groupBy('modelos.id');
        //     if (($request->ventas == 0)) {

        //         $modelos = $modelos
        //         ->orderBy('cantidadVendida','asc');
        //     }else if($request->ventas == 1){
        //         $modelos = $modelos
        //         ->orderBy('cantidadVendida','desc');
        //     }
        // }


        $modelos = $modelos
            ->select('modelos.*')
            ->get();
        $productos = Producto::where('productos.deleted_at', null)
            ->join('modelos', 'modelos.id', '=', 'productos.modelo_id')
            ->select('productos.*');
        $modelosEncontrador = collect();
        foreach ($modelos as $key => $modelo) {
            $modelosEncontrador->add($modelo->id);
        }
        $productos = $productos->whereIn('productos.modelo_id', $modelosEncontrador);

        // if ($request->has('precios') && ($request->precios >= 0)) {
        //     if (($request->precios == 0)) {

        //         $productos = $productos
        //         ->orderBy('modelos.precioUnitario','asc');
        //     }else if($request->precios == 1){
        //         $productos = $productos
        //         ->orderBy('modelos.precioUnitario','desc');
        //     }
        // }

        $productos = $productos
            ->where('mostrar', true)
            ->where('final', true)
            ->groupBy('productos.id')
            ->get();
        $imagenes = Imagen::all();
        $tipoImagenes = TipoImagen::all();
        //modelos para la venta
        $modelosVentas = Modelo::where('venta', '<>', 0)->where('venta', '<>', null)->get();
        $vuelto = $request;
        return view('producto.tienda', compact('productos', 'tipoImagenes', 'modelosVentas', 'imagenes', 'vuelto'));
    }



    // Obtengo las recetas del modelo que tengan hijos modelos que tenga materia prima
    // receta -> hijoMoldeo-> materias primas
    public function obtenerRecetas($modelo, $array)
    {
        if ($modelo != null) {

            //codicion de corte
            if ($modelo->hijosModelos->isEmpty() && $modelo->materiasPrimas->isEmpty()) {
                return $array;
            }
            // //coleccionar modelos con materias primas en sus recetas
            // if (!$modelo->materiasPrimas->isEmpty()) {
            //     $array->add($modelo);
            // }
            foreach ($modelo->hijosModelos as $key => $modeloHijo) {
                $array2 = $this->obtenerRecetas($modeloHijo, $array);
                if ($array2->isNotEmpty()) {
                    $array->merge($array2);
                }
            }

            //agregamos los modelos hijos que tiene la siguiente estructura modelo -> modelo ->materia prima
            if (!$modelo->hijosModelos->isEmpty()) {
                foreach ($modelo->recetaPadre as $key => $receta) {
                    # code...
                    if ($receta->modeloHijo != null) {
                        //si el modelo hijo no tiene modelo y si tiene materiaprimas
                        if (!$receta->modeloHijo->materiasPrimas->isEmpty() && $receta->modeloHijo->hijosModelos->isEmpty()) {
                            $array->add($receta);
                        }
                    }
                }
            }
        }
        return $array;
    }
    public function obtenerModelosConMateriasPrimasEstaticas($modelo, $array)
    {
        if ($modelo != null) {

            //codicion de corte
            if ($modelo->hijosModelos->isEmpty() && $modelo->materiasPrimas->isEmpty()) {
                return $array;
            }
            // //coleccionar modelos con materias primas en sus recetas
            if ((!$modelo->materiasPrimas->isEmpty()) && (!$modelo->hijosModelos->isEmpty())) {
                $array->add($modelo);
            }
            foreach ($modelo->hijosModelos as $key => $modeloHijo) {
                $array2 = $this->obtenerModelosConMateriasPrimasEstaticas($modeloHijo, $array);
                if ($array2->isNotEmpty()) {
                    $array->merge($array2);
                }
            }
        }
        return $array;
    }

    public function confirmarProducto(Request $request, $id)
    {


        $rules = [

            'imagenProducto'     =>  'required|mimes:jpeg,png,jpg,gif,svg,webp|max:2048'

        ];


        $messages = [

            'imagenProducto.required'     => 'La imagen es obligatoria.',
            'imagenProducto.mimes'     => 'La imagen debe ser cualquiera de los siguientes tipos jpeg,png,jpg,gif,svg,webp.',
            'imagenProducto.max'     => 'La resolucion maxima de la imagen es 2048.'
        ];

        $this->validate($request, $rules, $messages);
        $producto = Producto::find($id);

        if ($producto != null) {
            $imagen = null;
            if ($request->hasFile('imagenProducto')) {
                $file = $request->file('imagenProducto');
                $hoy = Carbon::now();
                $imagen =  $producto->id . $hoy->format('dmYHi') . '' . time() . '.' . $request->file('imagenProducto')->getClientOriginalExtension();
                if (!is_null($producto->imagenPrincipal)) {
                    //creamos el camino de la imagen vieja
                    $file_path = public_path('/imagenes/productos/')   . $producto->imagenPrincipal;
                    //borramos la imagen vieja
                    unlink($file_path);
                }
                $file->move(public_path('/imagenes/productos/'), $imagen);
                $producto->imagenPrincipal = $imagen;
                $producto->final = 1;
                $producto->update();
                return redirect()->back()->with('success', 'Producto confirmado como finalizado');
            }
            return redirect()->back()->withErrors('No existe una imagen para el producto');
        }

        return redirect()->back()->withErrors('El producto  para confirmar no existe o se encuentra eliminado');
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
        $recetaConMateriasPrimasSeleccionadas = collect();
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
            //son las recectas seleccionadas de un modelo en especial, el modelo es el padre de la receta
            if ($request->input('recetaPadre_' . $i)) {
                $recetaConMateriasPrimasSeleccionadas->add([$request->input('recetaPadre_' . $i), $request->input('recetaHijo_' . $i)]);
                //  $recetaConMateriasPrimasSeleccionadas = array_merge($recetaConMateriasPrimasSeleccionadas, [[$request->input('recetaPadre_' . $i)], [$request->input('recetaHijo_' . $i)]]);
                // $recetaConMateriasPrimasSeleccionadas = $recetaConMateriasPrimasSeleccionadas->add($request->input('recetaPadre_' . $i));
                $rule2 = array_merge($rule2, ['recetaPadre_' . $i => 'required', 'recetaHijo_' . $i => 'required',]);
                $mensaje2 = array_merge($mensaje2, ['recetaPadre_' . $i . '.required' => 'La receta no fue seleccionada', 'recetaHijo_' . $i . '.required' => 'La receta no fue seleccionado']);
            }
        }
        $rules = [];

        $messages = [];

        // return $recetaConMateriasPrimasSeleccionadas;
        $messages = array_merge($messages, $mensaje2);
        $rules = array_merge($rules, $rule2);
        $this->validate($request, $rules, $messages);

        $mostrar = 0;
        if ($request->has('mostrar')) {
            $mostrar = 1;
        }
        //creamos el producto
        $form_data = array(
            'final'        =>  0,
            'imagenPrincipal'        =>  null,
            'modelo_id'         =>  $request->modelo_id,
            'mostrar'         =>  $mostrar,
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
                    $posx = $request->input('imagen_' . $i . '_componente_' . $componente->id . '_posX');
                    if (is_null($posx)) {
                        $posx = 0;
                    }
                    $posy =  $request->input('imagen_' . $i . '_componente_' . $componente->id . '_posY');
                    if (is_null($posy)) {
                        $posy = 0;
                    }
                    $alto = $request->input('imagen_' . $i . '_componente_' . $componente->id . '_alto');
                    if (is_null($alto)) {
                        $alto = 50;
                    }
                    $ancho = $request->input('imagen_' . $i . '_componente_' . $componente->id . '_ancho');
                    if (is_null($ancho)) {
                        $ancho = 120;
                    }
                    $forma = $request->input('imagen_' . $i . '_componente_' . $componente->id . '_forma');
                    if (is_null($forma)) {
                        $forma = 0;
                    }
                    $sublimacion = Sublimacion::create([
                        'nuevaImagen' =>  $imagen,

                        'posX' => $posx,
                        'posY' => $posy,
                        'alto' => $alto,
                        'ancho' => $ancho,
                        'forma' => $forma,
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

                    $posxSistema = $request->input('imagen_sistema_' . $i . '_componente_' . $componente->id . '_posX');
                    if (is_null($posxSistema)) {
                        $posxSistema = 0;
                    }
                    $posySistema =  $request->input('imagen_sistema_' . $i . '_componente_' . $componente->id . '_posY');
                    if (is_null($posySistema)) {
                        $posySistema = 0;
                    }
                    $altoSistema = $request->input('imagen_sistema_' . $i . '_componente_' . $componente->id . '_alto');
                    if (is_null($altoSistema)) {
                        $altoSistema = 50;
                    }
                    $anchoSistema = $request->input('imagen_sistema_' . $i . '_componente_' . $componente->id . '_ancho');
                    if (is_null($anchoSistema)) {
                        $anchoSistema = 120;
                    }
                    $formaSistema = $request->input('imagen_sistema_' . $i . '_componente_' . $componente->id . '_forma');
                    if (is_null($formaSistema)) {
                        $formaSistema = 0;
                    }
                    $sublimacion = Sublimacion::create([
                        'nuevaImagen' =>  null,
                        'posX' => $posxSistema,
                        'posY' => $posySistema,
                        'alto' => $altoSistema,
                        'ancho' => $anchoSistema,
                        'forma' => $formaSistema,
                        'componente_id' => $componente->id,
                        'producto_id' => $producto->id,
                        'imagen_id' =>  $request->input('imagen_sistema_' . $i . '_componente_' . $componente->id . '_id')

                    ]);
                }
            }
        }


        //Agregamos la materias primas del modelo
        // foreach ($modelo->materiasPrimas as $key => $mate) {
        //     $recetaConMateriasPrimasSeleccionadas->add($mate->id);
        // }

        // $producto->recetas()->sync($recetaConMateriasPrimasSeleccionadas);
        //creamos el pedido y asociamos el producto a un detalle de pedido
        $flujoTrabajo = FlujoTrabajo::where('nombre', 'FLUJO PEDIDOS')->first();

        if (auth()->user()->pedidoAPagar() == null) {
            $pedido = Pedido::create([
                'precio' => 0,
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

        $control->agregarCarrito($producto, 1, auth()->user(), $recetaConMateriasPrimasSeleccionadas);


        return redirect()->back()->with('success', 'Se agrego a "Mis pedido" con exito');
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


        if ($producto == null) {
            return redirect()->back()->withErrors('El producto no existe');
        }

        $tipoImagenes = TipoImagen::all();
        return view('producto.preShow', compact('producto', 'tipoImagenes'));
    }
    //hace lo mismo que preshow pero verifica que el usuario este accediendo a un producto que el creo
    public function miProducto($id)
    {

        $producto = Producto::find($id);
        $array = collect();
        $modelo = new Modelo();
        if ($producto != null) {
            $producto = Producto::where('id', $id)->where('user_id', auth()->user()->id)->first();
            $hijoModelosConMateriaPrimas = $this->obtenerRecetas($producto->modelo, $array);
            $modelo = $producto->modelo;
        }

        $tipoImagenes = TipoImagen::all();


        // return view('producto.preShow', compact('producto', 'tipoImagenes'));
        return view('producto.preShow', compact('producto', 'tipoImagenes', 'hijoModelosConMateriaPrimas', 'modelo'));
    }
    public function editMiProducto($id)
    {
        $producto = Producto::find($id);

        if ($producto != null) {
            if (auth()->user()->id != $producto->user->id) {
                return redirect()->back()->withErrors('No puede modificar este producto porque usted no lo creo');
            }
            if ($producto->final) {
                return redirect()->back()->withErrors('No puede modificar este producto porque es un producto finalizado');
            }
            $tipoImagenes = TipoImagen::all();


            $array = collect();
            $recetasPadres  = $this->obtenerRecetas($producto->modelo, $array);
            $array2 = collect();

            $modeloConMateriaPrimaEstatica = $this->obtenerModelosConMateriasPrimasEstaticas($producto->modelo, $array2);
            $cantidadModelos = 0;
        }

        return view('producto.editMiProducto', compact('producto', 'tipoImagenes', 'recetasPadres',  'modeloConMateriaPrimaEstatica'));
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
    public function update(Request $request, $id)
    {
        // return $request;
        $producto = Producto::find($id);
        if (is_null($producto)) {
            return redirect()->back()->withErrors('El producto no existe');
        }
        //No controlo los id de las imagenes del sistema
        // return $request;
        $recetaConMateriasPrimasSeleccionadas = collect();
        $rule2 = [];
        $mensaje2 = [];

        //cargar por cada componente sus imagenes y verificar si cumplen con los requerimiento de imagenes
        foreach ($producto->modelo->componentes as $key => $componente) {
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

        foreach ($producto->modelo->componentes as $key => $componente) {
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
            //son las recectas seleccionadas de un modelo en especial, el modelo es el padre de la receta
            if ($request->input('recetaPadre_' . $i)) {
                $recetaConMateriasPrimasSeleccionadas->add([$request->input('recetaPadre_' . $i), $request->input('recetaHijo_' . $i), $request->input('materiaId_' . $i)]);
                //  $recetaConMateriasPrimasSeleccionadas = array_merge($recetaConMateriasPrimasSeleccionadas, [[$request->input('recetaPadre_' . $i)], [$request->input('recetaHijo_' . $i)]]);
                // $recetaConMateriasPrimasSeleccionadas = $recetaConMateriasPrimasSeleccionadas->add($request->input('recetaPadre_' . $i));
                $rule2 = array_merge($rule2, ['recetaPadre_' . $i => 'required', 'recetaHijo_' . $i => 'required',]);
                $mensaje2 = array_merge($mensaje2, ['recetaPadre_' . $i . '.required' => 'La receta no fue seleccionada', 'recetaHijo_' . $i . '.required' => 'La receta no fue seleccionado']);
            }
        }
        $rules = [];

        $messages = [];

        // return $recetaConMateriasPrimasSeleccionadas;
        $messages = array_merge($messages, $mensaje2);
        $rules = array_merge($rules, $rule2);
        $this->validate($request, $rules, $messages);




        foreach ($producto->modelo->componentes as $key => $componente) {
            # code...

            $imagen = null;
            $sublimaciones = collect();
            $cantidadImagenes = $request->input('cantidadImagenes_' . $componente->id);
            $cantidadImagenesSistema = $request->input('cantidadImagenes_sistema_' . $componente->id);
            $sublimacion = null;
            $actualizar = [];
            for ($i = 0; $i < $cantidadImagenes; $i++) {
                $actualizar = [];
                $nombreArchivo = 'file_' . $i . '_componente_' . $componente->id;
                $sublimacion_id = $request->input('imagen_' . $i . '_componente_' . $componente->id . '_sublimacion');
                $sublimacion = Sublimacion::find($sublimacion_id);
                if (is_null($sublimacion)) {
                    return redirect()->back()->withErrors('No se pudo actualizar porque modifico el codigo fuente');
                } elseif ($sublimacion->componente->id != $componente->id) {
                    return redirect()->back()->withErrors('La imagen a sublimar no pertenece al componente');
                }
                if ($request->hasFile($nombreArchivo)) {
                    $file = $request->file($nombreArchivo);
                    $hoy = Carbon::now();
                    $imagen =  $sublimacion->id . $hoy->format('YmdHi') . '' . time() . '.' . $request->file($nombreArchivo)->getClientOriginalExtension();
                    //si existe el archivo creo la sublimacion 
                    $file->move(public_path('/imagenes/sublimaciones/sinProcesar/'), $imagen);
                    $actualizar = array_merge($actualizar, ['nuevaImagen' => $imagen]);
                }

                //asd

                $posx = $request->input('imagen_' . $i . '_componente_' . $componente->id . '_posX');
                if (!is_null($posx)) {
                    $actualizar = array_merge($actualizar, ['posX' => $posx]);
                }
                $posy =  $request->input('imagen_' . $i . '_componente_' . $componente->id . '_posY');
                if (!is_null($posy)) {
                    $actualizar = array_merge($actualizar, ['posY' => $posy]);
                }
                $alto = $request->input('imagen_' . $i . '_componente_' . $componente->id . '_alto');
                if (!is_null($alto)) {
                    $actualizar = array_merge($actualizar, ['alto' => $alto]);
                }
                $ancho = $request->input('imagen_' . $i . '_componente_' . $componente->id . '_ancho');
                if (!is_null($ancho)) {
                    $actualizar = array_merge($actualizar, ['ancho' => $ancho]);
                }
                $forma = $request->input('imagen_' . $i . '_componente_' . $componente->id . '_forma');
                if (!is_null($forma)) {
                    $actualizar = array_merge($actualizar, ['forma' => $forma]);
                }
                $sublimacion->update($actualizar);
            }
            for ($i = 0; $i < $cantidadImagenesSistema; $i++) {
                $actualizar = [];
                $sublimacion_id = $request->input('imagen_sistema_' . $i . '_componente_' . $componente->id . '_sublimacion');
                $sublimacion = Sublimacion::find($sublimacion_id);
                if (is_null($sublimacion)) {
                    return redirect()->back()->withErrors('No se pudo actualizar porque modifico el codigo fuente');
                } elseif ($sublimacion->componente->id != $componente->id) {
                    return redirect()->back()->withErrors('La imagen a sublimar no pertenece al componente');
                }
                if ($request->has('imagen_sistema_' . $i . '_componente_' . $componente->id . '_id')) {
                    $imagen_id = $request->input('imagen_sistema_' . $i . '_componente_' . $componente->id . '_id');
                    if (!is_null($imagen_id)) {
                        # code...
                        $actualizar = array_merge($actualizar, ['imagen_id' => $imagen_id]);
                    }
                }

                $posxSistema = $request->input('imagen_sistema_' . $i . '_componente_' . $componente->id . '_posX');
                if (!is_null($posxSistema)) {
                    $actualizar = array_merge($actualizar, ['posX' => $posxSistema]);
                }
                $posySistema =  $request->input('imagen_sistema_' . $i . '_componente_' . $componente->id . '_posY');
                if (!is_null($posySistema)) {
                    $actualizar = array_merge($actualizar, ['posY' => $posySistema]);
                }
                $altoSistema = $request->input('imagen_sistema_' . $i . '_componente_' . $componente->id . '_alto');
                if (!is_null($altoSistema)) {
                    $actualizar = array_merge($actualizar, ['alto' => $altoSistema]);
                }
                $anchoSistema = $request->input('imagen_sistema_' . $i . '_componente_' . $componente->id . '_ancho');
                if (!is_null($anchoSistema)) {
                    $actualizar = array_merge($actualizar, ['ancho' => $anchoSistema]);
                }
                $formaSistema = $request->input('imagen_sistema_' . $i . '_componente_' . $componente->id . '_forma');
                if (!is_null($formaSistema)) {
                    $actualizar = array_merge($actualizar, ['forma' => $formaSistema]);
                }
                $sublimacion->update($actualizar);
            }
        }

        foreach ($producto->materiaPrimaSeleccionadas as $key => $materia) {
            # code...
            foreach ($recetaConMateriasPrimasSeleccionadas as $key => $padreEHijo) {
                # code...
                // return $padreEHijo;
                if ($materia->id == $padreEHijo[2]) {

                    $materia->update([
                        'recetaPadre_id' => $padreEHijo[0],
                        'recetaHijo_id' => $padreEHijo[1],
                        'producto_id' => $producto->id
                    ]);
                }
            }
        }

        return redirect()->back()->with('success', 'Producto Atualizado Con Exito!');
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



    /**
     * Array quickSort($arreglo, $campo) ordena un $arreglo en funcion de un $campo
     *
     * @param tipo $arreglo a ordenar, en funcion de un $campo, desde $inicio asta $final
     * @return $regresa el mismo arreglo pero ordenado
     * @access public
     * @link: http://es.wikipedia.org/wiki/Quicksort
     * -----------------------------Estado pendiente, muy pendiente!!!...----------------------------
     */
    function quickSort($arreglo, $campo, $inicio = 0, $final = 0)
    {
        $p = $final; //posicion del pivote sera la final
        $i = $inicio; //posicion inicial a ordenar
        if ($p == 0) //caso inicial ';¬)
            $p = count($arreglo) - 1;
        if ($p - $i > 0) { //si observamos el arreglo mas pequeño que puede recibir es de 2 donde $j==$i
            $j = $p - 1;
            for (; $i < $j; $i++) {
                if ($arreglo[$i][$campo] <= $arreglo[$p][$campo])
                    continue;
                if ($arreglo[$j][$campo] >= $arreglo[$p][$campo]) {
                    --$i;
                    --$j;
                    continue;
                }
                $aux = $arreglo[$i];
                $arreglo[$i] = $arreglo[$j];
                $arreglo[$j] = $aux;
            }
            //el elemento p debe de ir en la posicion $i
            $valor_pivote = $arreglo[$p];
            for (; $i < $p; $i++)
                $arreglo[$i + 1] = $arreglo[$i];
            //finalmente en $j donde todavia esta el valor de i ponemos el valor del pivote
            $arreglo[$j] = $valor_pivote;
            //chicharronera recursiva mandamos ordenar tanto la parte alta y la baja
            $arreglo = $this->quickSort($arreglo, $campo, $inicio, $j - 1);
            $arreglo = $this->quickSort($arreglo, $campo, $j + 1, $p);
        }
        return $arreglo;
    }
}
