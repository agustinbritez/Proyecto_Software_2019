<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Route;
// Route::get('estadistica', 'EstadisticaController@productosMasVendidos');

Route::group(['middleware' => ['guest']], function () {
    Route::get('/', 'Auth\LoginController@showLoginForm');
    Route::post('/login', 'Auth\LoginController@login')->name('login');
});
//todos pueden ver

Route::get('producto/tienda', 'ProductoController@tienda')->name('producto.tienda');
Route::get('proveedor/obtenerPrecios/{id}', 'ProveedorController@obtenerPrecios')->name('proveedor.obtenerPrecios');
Route::get('producto/create/{id}', 'ProductoController@create')->name('producto.create');
Route::get('proveedor/consultarPrecios/{id}', 'ProveedorController@consultarPrecios')->name('proveedor.consultarPrecios');


Route::middleware(['auth'])->group(function () {
    Route::get('/admin', function () {
        return view('admin_panel.index');
    });



    //todos los usuarios logeados  pueden acceder 
    // Route::resource('/usuario', 'UserController');
    // Route::resource('/usuario', 'UserController');


    Route::get('usuario/editMiPerfil', 'UserController@editMiPerfil')->name('usuario.editMiPerfil');
    Route::post('usuario/modificar', 'UserController@modificar')->name('usuario.modificar');
    Route::post('usuario/crearDireccion', 'UserController@crearDireccion')->name('usuario.crearDireccion');
    Route::post('usuario/cambiarPassword', 'UserController@cambiarPassword')->name('usuario.cambiarPassword');
    Route::get('usuario/direccionEnvioPredeterminada/{id}', 'UserController@direccionEnvioPredeterminada')->name('usuario.direccionEnvioPredeterminada');

    Route::get('materiaPrima/verificarStock', 'ControllerMateriaPrima@verificarStock')->name('materiaPrima.verificarStock');
    Route::get('materiaPrima/stockMinimo', 'ControllerMateriaPrima@stockMinimo')->name('materiaPrima.stockMinimo');
    Route::get('pedido/confirmarPedido/{id}', 'PedidoController@confirmarPedido')->name('pedido.confirmarPedido');
    Route::get('pedido/pagarPedido/{id}', 'PedidoController@pagarPedido')->name('pedido.pagarPedido');
    Route::get('producto/{id}/miProducto', 'ProductoController@miProducto')->name('producto.miProducto');
    Route::get('producto/{id}/preshow', 'ProductoController@preshow')->name('producto.preshow');

    //materia Prima


    Route::middleware(['role:cliente'] || ['role:admin'])->group(function () {
        Route::post('producto', 'ProductoController@store')->name('producto.store');
        Route::get('pedido/agregarProductoFinal/{id}', 'PedidoController@agregarProductoFinal')->name('pedido.agregarProductoFinal');
        Route::get('tipoImagen/obtenerImagenes/{id}', 'TipoImagenController@obtenerImagenes')->name('tipoImagen.obtenerImagenes');
        Route::get('pedido/misPedidos', 'PedidoController@misPedidos')->name('pedido.misPedidos');
        Route::get('pedido/filtrarMisPedidos', 'PedidoController@filtrarMisPedidos')->name('pedido.filtrarMisPedidos');
        Route::get('producto/{id}/editMiProducto', 'ProductoController@editMiProducto')->name('producto.editMiProducto');
        Route::get('detallePedido/{id}/edit', 'DetallePedidoController@edit')->name('detallePedido.edit');
        Route::delete('detallePedido/destroy/{id}', 'DetallePedidoController@destroy')->name('detallePedido.destroy');
        Route::delete('pedido/destroy/{id}', 'PedidoController@destroy')->name('pedido.destroy');
        Route::post('producto/update/{id}', 'ProductoController@update')->name('producto.update');
        Route::post('detallePedido/update/{id}', 'DetallePedidoController@update')->name('detallePedido.update');
    });



    Route::middleware(['role:empleado'] || ['role:admin'] || ['role:gerente'])->group(function () {
        //pdf
        Route::get('pdf/MateriaPrima', 'PdfController@materiaPrima')->name('pdf.materiaPrima');
        Route::get('pdf/Proveedor', 'PdfController@proveedor')->name('pdf.proveedor');
        Route::get('pdf/Movimiento', 'PdfController@movimiento')->name('pdf.movimiento');
        Route::get('pdf/Modelo/{base}', 'PdfController@modelo')->name('pdf.modelo');
        Route::get('pdf/Auditoria', 'PdfController@auditoria')->name('pdf.auditoria');
        Route::get('pdf/auditoriaUnObjeto/{id}', 'PdfController@auditoriaUnObjeto')->name('pdf.auditoriaUnObjeto');
        Route::get('pdf/Pedido', 'PdfController@pedido')->name('pdf.pedido');

        //propuesta materia prima proveedor
        Route::get('materiaPrima/propuesta/{id}', 'ControllerMateriaPrima@propuesta')->name('materiaPrima.propuesta');
    });
    Route::middleware(['role:admin'] || ['role:gerente'])->group(function () {

        //estadistica

        Route::get('estadistica', 'EstadisticaController@index')->name('estadistica.index');
        Route::get('estadistica/productosMasVendidos', 'EstadisticaController@productosMasVendidos')->name('estadistica.productosMasVendidos');
        Route::get('estadistica/materiaPrimasMasConsumidas', 'EstadisticaController@materiaPrimasMasConsumidas')->name('estadistica.materiaPrimasMasConsumidas');
    });



    Route::middleware(['role:auditor'] || ['role:admin'])->group(function () {

        //auditoria
        Route::get('auditoria', 'AuditoriaController@index')->name('auditoria.index');
        Route::get('auditoria/show/{id}', 'AuditoriaController@show')->name('auditoria.show');
        Route::get('auditoria/historial/{id}', 'AuditoriaController@historial')->name('auditoria.historial');
    });

    Route::middleware(['role:empleado'] || ['role:admin'])->group(function () {
        //usuario
        Route::get('usuario', 'UserController@index')->name('usuario.index');
        Route::post('usuario/store', 'UserController@store')->name('usuario.store');
        Route::post('usuario/update', 'UserController@update')->name('usuario.update');
        Route::get('usuario/{id}/edit', 'UserController@edit')->name('usuario.edit');
        Route::delete('usuario/destroy', 'UserController@destroy')->name('usuario.destroy');

        //pedido
        Route::get('pedido/filtrarTrabajo', 'PedidoController@filtrarTrabajo')->name('pedido.filtrarTrabajo');

        //materia Prima
        Route::get('materiaPrima', 'ControllerMateriaPrima@index')->name('materiaPrima.index');
        Route::get('materiaPrima/{materiaPrima}/show', 'ControllerMateriaPrima@show')->name('materiaPrima.show');
        Route::get('materiaPrima/create', 'ControllerMateriaPrima@create')->name('materiaPrima.create');
        Route::post('materiaPrima', 'ControllerMateriaPrima@store')->name('materiaPrima.store');
        Route::get('materiaPrima/{id}/edit', 'ControllerMateriaPrima@edit')->name('materiaPrima.edit');
        Route::get('materiaPrima/parametros', 'ControllerMateriaPrima@obtenerParametros')->name('materiaPrima.parametros');
        Route::post('materiaPrima/update', 'ControllerMateriaPrima@update')->name('materiaPrima.update');
        Route::delete('materiaPrima/destroy', 'ControllerMateriaPrima@destroy')->name('materiaPrima.destroy');

        //receta
        Route::delete('receta/destroy/{id}', 'RecetaController@destroy')->name('receta.destroy');

        //componente
        Route::delete('componente/destroy/{id}', 'ComponenteController@destroy')->name('componente.destroy');

        //Movimientos
        Route::get('movimiento', 'MovimientoController@index')->name('movimiento.index');
        Route::get('movimiento/{movimiento}/show', 'MovimientoController@show')->name('movimiento.show');
        Route::get('movimiento/create', 'MovimientoController@create')->name('movimiento.create');
        Route::post('movimiento', 'MovimientoController@store')->name('movimiento.store');
        Route::get('movimiento/{id}/edit', 'MovimientoController@edit')->name('movimiento.edit');
        Route::post('movimiento/update', 'MovimientoController@update')->name('movimiento.update');
        Route::delete('movimiento/destroy', 'MovimientoController@destroy')->name('movimiento.destroy');

        //Modelos
        Route::get('modelo', 'ModeloController@index')->name('modelo.index');
        Route::get('modelo/indexBase', 'ModeloController@indexBase')->name('modelo.indexBase');
        Route::get('modelo/{modelo}/show', 'ModeloController@show')->name('modelo.show');
        Route::get('modelo/create', 'ModeloController@create')->name('modelo.create');
        Route::get('modelo/baseCreate', 'ModeloController@baseCreate')->name('modelo.baseCreate');
        Route::get('modelo/baseModificar/{id}', 'ModeloController@baseModificar')->name('modelo.baseModificar');
        Route::post('modelo', 'ModeloController@store')->name('modelo.store');
        Route::get('modelo/{id}/edit', 'ModeloController@edit')->name('modelo.edit');
        Route::post('modelo/update', 'ModeloController@update')->name('modelo.update');
        Route::delete('modelo/destroy/{id}', 'ModeloController@destroy')->name('modelo.destroy');
        Route::get('modelo/{variable}', 'ModeloController@cargarListaIngrediente')->name('modelo.cargarListaIngrediente');
        Route::post('modelo/relation', 'ModeloController@addRelation')->name('modelo.addRelation');
        Route::get('modelo/modificar/{id}', 'ModeloController@modificar')->name('modelo.modificar');
        Route::post('modelo/componente', 'ModeloController@addComponente')->name('modelo.addComponente');
        Route::get('modelo/getMedidaMateriaPrima/{id}', 'ModeloController@getMedidaMateriaPrima')->name('modelo.getMedidaMateriaPrima');
        Route::get('modelo/getMedidaModelo/{id}', 'ModeloController@getMedidaModelo')->name('modelo.getMedidaModelo');

        //producto
        Route::post('producto/confirmarProducto/{id}', 'ProductoController@confirmarProducto')->name('producto.confirmarProducto');

        // Pedidos
        Route::get('pedido', 'PedidoController@index')->name('pedido.index');
        Route::get('pedido/{pedido}/show', 'PedidoController@show')->name('pedido.show');
        Route::get('pedido/{id}/preshow', 'PedidoController@preshow')->name('pedido.preshow');
        Route::get('pedido/create/{id}', 'PedidoController@create')->name('pedido.create');
        Route::post('pedido', 'PedidoController@store')->name('pedido.store');
        Route::get('pedido/{id}/edit', 'PedidoController@edit')->name('pedido.edit');
        Route::post('pedido/update', 'PedidoController@update')->name('pedido.update');
        Route::post('pedido/terminarPedido/{id}', 'PedidoController@terminarPedido')->name('pedido.terminarPedido');
        Route::get('pedido/trabajo', 'PedidoController@trabajo')->name('pedido.trabajo');
        Route::get('pedido/ordenamientoInteligente', 'PedidoController@ordenamientoInteligente')->name('pedido.ordenamientoInteligente');

        // detalle de pedido
        Route::get('detallePedido/{id}', 'DetallePedidoController@index')->name('detallePedido.index');
        Route::get('detallePedido/{detallePedido}/show', 'DetallePedidoController@show')->name('detallePedido.show');
        Route::get('detallePedido/show/{id}', 'DetallePedidoController@show')->name('detallePedido.show');
        Route::get('detallePedido/create/{id}', 'DetallePedidoController@create')->name('detallePedido.create');
        Route::post('detallePedido', 'DetallePedidoController@store')->name('detallePedido.store');
        Route::get('detallePedido/verificarDetalle/{id}', 'DetallePedidoController@verificarDetalle')->name('detallePedido.verificarDetalle');
        Route::get('detallePedido/rechazarDetalle/{id}', 'DetallePedidoController@rechazarDetalle')->name('detallePedido.rechazarDetalle');
        Route::get('detallePedido/estadoSiguiente/{id}', 'DetallePedidoController@estadoSiguiente')->name('detallePedido.estadoSiguiente');
        Route::get('detallePedido/estadoAnterior/{id}', 'DetallePedidoController@estadoAnterior')->name('detallePedido.estadoAnterior');


        // Sublimacion
        Route::get('sublimacion', 'SublimacionController@index')->name('sublimacion.index');
        Route::get('sublimacion/{sublimacion}/show', 'SublimacionController@show')->name('sublimacion.show');
        Route::get('sublimacion/{id}/preshow', 'SublimacionController@preshow')->name('sublimacion.preshow');
        Route::get('sublimacion/create/{id}', 'SublimacionController@create')->name('sublimacion.create');
        Route::post('sublimacion', 'SublimacionController@store')->name('sublimacion.store');
        Route::get('sublimacion/{id}/edit', 'SublimacionController@edit')->name('sublimacion.edit');
        Route::post('sublimacion/update/{id}', 'SublimacionController@update')->name('sublimacion.update');
        Route::delete('sublimacion/destroy/{id}', 'SublimacionController@destroy')->name('sublimacion.destroy');

        // Flujo de trabajos
        Route::get('flujoTrabajo', 'flujoTrabajoController@index')->name('flujoTrabajo.index');
        Route::get('flujoTrabajo/{flujoTrabajo}/show', 'flujoTrabajoController@show')->name('flujoTrabajo.show');
        Route::get('flujoTrabajo/create/{id}', 'flujoTrabajoController@create')->name('flujoTrabajo.create');
        Route::post('flujoTrabajo', 'flujoTrabajoController@store')->name('flujoTrabajo.store');
        Route::get('flujoTrabajo/{id}/edit', 'flujoTrabajoController@edit')->name('flujoTrabajo.edit');
        Route::get('flujoTrabajo/agregarEstado/{idFlujo}-{idEstado}', 'flujoTrabajoController@agregarEstado')->name('flujoTrabajo.agregarEstado');
        Route::get('flujoTrabajo/quitarEstado/{id}', 'flujoTrabajoController@quitarEstado')->name('flujoTrabajo.quitarEstado');
        Route::post('flujoTrabajo/update/{id}', 'flujoTrabajoController@update')->name('flujoTrabajo.update');
        Route::delete('flujoTrabajo/destroy/{id}', 'flujoTrabajoController@destroy')->name('flujoTrabajo.destroy');

        // Estados
        Route::get('estado', 'estadoController@index')->name('estado.index');
        Route::get('estado/{estado}/show', 'estadoController@show')->name('estado.show');
        Route::get('estado/create/{id}', 'estadoController@create')->name('estado.create');
        Route::post('estado', 'estadoController@store')->name('estado.store');
        Route::get('estado/{id}/edit', 'estadoController@edit')->name('estado.edit');
        Route::post('estado/update/{id}', 'estadoController@update')->name('estado.update');
        Route::delete('estado/destroy/{id}', 'estadoController@destroy')->name('estado.destroy');
        //Tipo Movimiento
        Route::get('tipoMovimiento', 'tipoMovimientoController@index')->name('tipoMovimiento.index');
        Route::get('tipoMovimiento/{tipoMovimiento}/show', 'tipoMovimientoController@show')->name('tipoMovimiento.show');
        Route::get('tipoMovimiento/create', 'tipoMovimientoController@create')->name('tipoMovimiento.create');
        Route::post('tipoMovimiento', 'tipoMovimientoController@store')->name('tipoMovimiento.store');
        Route::get('tipoMovimiento/{id}/edit', 'tipoMovimientoController@edit')->name('tipoMovimiento.edit');
        Route::post('tipoMovimiento/update', 'tipoMovimientoController@update')->name('tipoMovimiento.update');
        Route::delete('tipoMovimiento/destroy', 'tipoMovimientoController@destroy')->name('tipoMovimiento.destroy');
        //  Route::resource('tipoMovimiento','tipoMovimientoController');

        //imagen
        Route::get('imagen', 'imagenController@index')->name('imagen.index');
        Route::get('imagen/{imagen}/show', 'imagenController@show')->name('imagen.show');
        Route::get('imagen/create', 'imagenController@create')->name('imagen.create');
        Route::post('imagen', 'imagenController@store')->name('imagen.store');
        Route::get('imagen/{id}/edit', 'imagenController@edit')->name('imagen.edit');
        Route::post('imagen/update', 'imagenController@update')->name('imagen.update');
        Route::delete('imagen/destroy/{id}', 'imagenController@destroy')->name('imagen.destroy');

        //tipo imagen
        Route::get('tipoImagen', 'TipoImagenController@index')->name('tipoImagen.index');
        Route::get('tipoImagen/{tipoImagen}/show', 'TipoImagenController@show')->name('tipoImagen.show');
        Route::get('tipoImagen/create', 'TipoImagenController@create')->name('tipoImagen.create');
        Route::post('tipoImagen', 'TipoImagenController@store')->name('tipoImagen.store');
        Route::get('tipoImagen/{id}/edit', 'TipoImagenController@edit')->name('tipoImagen.edit');
        Route::post('tipoImagen/update', 'TipoImagenController@update')->name('tipoImagen.update');
        Route::delete('tipoImagen/destroy', 'TipoImagenController@destroy')->name('tipoImagen.destroy');


        //Pais
        Route::get('pais', 'PaisController@index')->name('pais.index');
        Route::get('pais/{pais}/show', 'PaisController@show')->name('pais.show');
        Route::get('pais/create', 'PaisController@create')->name('pais.create');
        Route::post('pais', 'PaisController@store')->name('pais.store');
        Route::get('pais/{id}/edit', 'PaisController@edit')->name('pais.edit');
        Route::post('pais/update', 'PaisController@update')->name('pais.update');
        Route::delete('pais/destroy', 'PaisController@destroy')->name('pais.destroy');

        //Provincia
        Route::get('provincia', 'ProvinciaController@index')->name('provincia.index');
        Route::get('provincia/{provincia}/show', 'ProvinciaController@show')->name('provincia.show');
        Route::get('provincia/create', 'ProvinciaController@create')->name('provincia.create');
        Route::post('provincia', 'ProvinciaController@store')->name('provincia.store');
        Route::get('provincia/{id}/edit', 'ProvinciaController@edit')->name('provincia.edit');
        Route::post('provincia/update', 'ProvinciaController@update')->name('provincia.update');
        Route::delete('provincia/destroy', 'ProvinciaController@destroy')->name('provincia.destroy');

        //localidad
        Route::get('localidad', 'LocalidadController@index')->name('localidad.index');
        Route::get('localidad/{localidad}/show', 'LocalidadController@show')->name('localidad.show');
        Route::get('localidad/create', 'LocalidadController@create')->name('localidad.create');
        Route::post('localidad', 'LocalidadController@store')->name('localidad.store');
        Route::get('localidad/{id}/edit', 'LocalidadController@edit')->name('localidad.edit');
        Route::post('localidad/update', 'LocalidadController@update')->name('localidad.update');
        Route::delete('localidad/destroy', 'LocalidadController@destroy')->name('localidad.destroy');

        //calle
        Route::get('calle', 'CalleController@index')->name('calle.index');
        Route::get('calle/{calle}/show', 'CalleController@show')->name('calle.show');
        Route::get('calle/create', 'CalleController@create')->name('calle.create');
        Route::post('calle', 'CalleController@store')->name('calle.store');
        Route::get('calle/{id}/edit', 'CalleController@edit')->name('calle.edit');
        Route::post('calle/update', 'CalleController@update')->name('calle.update');
        Route::delete('calle/destroy', 'CalleController@destroy')->name('calle.destroy');


        //Medidas
        Route::get('medida', 'medidaController@index')->name('medida.index');
        Route::get('medida/{medida}/show', 'medidaController@show')->name('medida.show');
        Route::get('medida/create', 'medidaController@create')->name('medida.create');
        Route::post('medida', 'medidaController@store')->name('medida.store');
        Route::get('medida/{id}/edit', 'medidaController@edit')->name('medida.edit');
        Route::post('medida/update', 'medidaController@update')->name('medida.update');
        Route::delete('medida/destroy', 'medidaController@destroy')->name('medida.destroy');
        //  Route::resource('medida','medidaController');

        //Direccion
        Route::get('direccion', 'direccionController@index')->name('direccion.index');
        Route::get('direccion/{direccion}/show', 'direccionController@show')->name('direccion.show');
        Route::get('direccion/create', 'direccionController@create')->name('direccion.create');
        Route::post('direccion', 'direccionController@store')->name('direccion.store');
        Route::get('direccion/{id}/edit', 'direccionController@edit')->name('direccion.edit');
        Route::post('direccion/update', 'direccionController@update')->name('direccion.update');
        Route::delete('direccion/destroy', 'direccionController@destroy')->name('direccion.destroy');
        //  Route::resource('direccion','direccionController');

        //Documento
        Route::get('documento', 'documentoController@index')->name('documento.index');
        Route::get('documento/{documento}/show', 'documentoController@show')->name('documento.show');
        Route::get('documento/create', 'documentoController@create')->name('documento.create');
        Route::post('documento', 'documentoController@store')->name('documento.store');
        Route::get('documento/{id}/edit', 'documentoController@edit')->name('documento.edit');
        Route::post('documento/update', 'documentoController@update')->name('documento.update');
        Route::delete('documento/destroy', 'documentoController@destroy')->name('documento.destroy');
        //  Route::resource('documento','documentoController');
        //Proveedor
        Route::get('proveedor', 'ProveedorController@index')->name('proveedor.index');
        Route::get('proveedor/{proveedor}/show', 'ProveedorController@show')->name('proveedor.show');
        Route::get('proveedor/create', 'ProveedorController@create')->name('proveedor.create');
        Route::post('proveedor', 'ProveedorController@store')->name('proveedor.store');
        Route::get('proveedor/{id}/edit', 'ProveedorController@edit')->name('proveedor.edit');
        Route::post('proveedor/update', 'ProveedorController@update')->name('proveedor.update');
        Route::delete('proveedor/destroy', 'ProveedorController@destroy')->name('proveedor.destroy');
    });
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::fallback(function () {
    return view('errors.404');
});
