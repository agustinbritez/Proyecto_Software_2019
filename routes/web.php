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

Route::middleware(['auth'])->group(function () {
    Route::get('/admin', function () {
        return view('admin_panel.index');
    });
    //users
    Route::get('users', 'UserController@index')->name('usuarios.index')->middleware('permission:usuarios_index');
    Route::get('users', 'UserController@show')->name('usuarios.show')->middleware('permission:usuarios_show');
    Route::get('users/create', 'UserController@create')->name('usuarios.create')->middleware('permission:usuarios_create');
    Route::get('users/{usuario}/edit', 'UserController@edit')->name('usuarios.edit')->middleware('permission:usuarios_edit');
    Route::get('users', 'UserController@delete')->name('usuarios.delete')->middleware('permission:usuarios_delete');
    //pdf
    Route::get('pdf/MateriaPrima', 'PdfController@materiaPrima')->name('pdf.materiaPrima');
    Route::get('pdf/Proveedor', 'PdfController@proveedor')->name('pdf.proveedor');
    Route::get('pdf/Movimiento', 'PdfController@movimiento')->name('pdf.movimiento');
    Route::get('pdf/Modelos', 'PdfController@modelo')->name('pdf.modelo');

    //    Route::resource('/usuarios','UserController');
});
Route::resource('/usuarios', 'UserController');

//receta
Route::delete('receta/destroy/{id}', 'RecetaController@destroy')->name('receta.destroy')->middleware('permission:receta_delete');


//materia Prima
Route::get('materiaPrima', 'ControllerMateriaPrima@index')->name('materiaPrima.index')->middleware('permission:materiaPrima_index');
Route::get('materiaPrima/{materiaPrima}/show', 'ControllerMateriaPrima@show')->name('materiaPrima.show')->middleware('permission:materiaPrima_show');
Route::get('materiaPrima/create', 'ControllerMateriaPrima@create')->name('materiaPrima.create')->middleware('permission:materiaPrima_create');
Route::post('materiaPrima', 'ControllerMateriaPrima@store')->name('materiaPrima.store')->middleware('permission:materiaPrima_store');
Route::get('materiaPrima/{id}/edit', 'ControllerMateriaPrima@edit')->name('materiaPrima.edit')->middleware('permission:materiaPrima_edit');
Route::get('materiaPrima/parametros', 'ControllerMateriaPrima@obtenerParametros')->name('materiaPrima.parametros')->middleware('permission:materiaPrima_edit');
Route::post('materiaPrima/update', 'ControllerMateriaPrima@update')->name('materiaPrima.update')->middleware('permission:materiaPrima_update');
Route::delete('materiaPrima/destroy', 'ControllerMateriaPrima@destroy')->name('materiaPrima.destroy')->middleware('permission:materiaPrima_delete');
//  Route::resource('materiaPrima','materiaPrimaController');

//auditoria
Route::get('auditoria', 'AuditoriaController@index')->name('auditoria.index')->middleware('permission:auditoria_index');

//Movimientos
Route::get('movimiento', 'MovimientoController@index')->name('movimiento.index')->middleware('permission:movimiento_index');
Route::get('movimiento/{movimiento}/show', 'MovimientoController@show')->name('movimiento.show')->middleware('permission:movimiento_show');
Route::get('movimiento/create', 'MovimientoController@create')->name('movimiento.create')->middleware('permission:movimiento_create');
Route::post('movimiento', 'MovimientoController@store')->name('movimiento.store')->middleware('permission:movimiento_store');
Route::get('movimiento/{id}/edit', 'MovimientoController@edit')->name('movimiento.edit')->middleware('permission:movimiento_edit');
Route::post('movimiento/update', 'MovimientoController@update')->name('movimiento.update')->middleware('permission:movimiento_update');
Route::delete('movimiento/destroy', 'MovimientoController@destroy')->name('movimiento.destroy')->middleware('permission:movimiento_delete');
//  Route::resource('movimiento','movimientoController');

//Modelos
Route::get('modelo', 'ModeloController@index')->name('modelo.index')->middleware('permission:modelo_index');
Route::get('modelo/{modelo}/show', 'ModeloController@show')->name('modelo.show')->middleware('permission:modelo_show');
Route::get('modelo/create', 'ModeloController@create')->name('modelo.create')->middleware('permission:modelo_create');
Route::post('modelo', 'ModeloController@store')->name('modelo.store')->middleware('permission:modelo_store');
Route::get('modelo/{id}/edit', 'ModeloController@edit')->name('modelo.edit')->middleware('permission:modelo_edit');
Route::post('modelo/update', 'ModeloController@update')->name('modelo.update')->middleware('permission:modelo_update');
Route::delete('modelo/destroy/{id}', 'ModeloController@destroy')->name('modelo.destroy')->middleware('permission:modelo_delete');
Route::get('modelo/{variable}', 'ModeloController@cargarListaIngrediente')->name('modelo.cargarListaIngrediente');
Route::post('modelo/relation', 'ModeloController@addRelation')->name('modelo.addRelation')->middleware('permission:modelo_addRelation');
Route::get('modelo/modificar/{id}', 'ModeloController@modificar')->name('modelo.modificar')->middleware('permission:modelo_modificar');
Route::get('modelo/getMedidaMateriaPrima/{id}', 'ModeloController@getMedidaMateriaPrima')->name('modelo.getMedidaMateriaPrima')->middleware('permission:modelo_getMedidaMateriaPrima');
Route::get('modelo/getMedidaModelo/{id}', 'ModeloController@getMedidaModelo')->name('modelo.getMedidaModelo')->middleware('permission:modelo_getMedidaModelo');
//  Route::resource('modelo','modeloController');

//Tipo Movimiento
Route::get('tipoMovimiento', 'tipoMovimientoController@index')->name('tipoMovimiento.index')->middleware('permission:tipoMovimiento_index');
Route::get('tipoMovimiento/{tipoMovimiento}/show', 'tipoMovimientoController@show')->name('tipoMovimiento.show')->middleware('permission:tipoMovimiento_show');
Route::get('tipoMovimiento/create', 'tipoMovimientoController@create')->name('tipoMovimiento.create')->middleware('permission:tipoMovimiento_create');
Route::post('tipoMovimiento', 'tipoMovimientoController@store')->name('tipoMovimiento.store')->middleware('permission:tipoMovimiento_store');
Route::get('tipoMovimiento/{id}/edit', 'tipoMovimientoController@edit')->name('tipoMovimiento.edit')->middleware('permission:tipoMovimiento_edit');
Route::post('tipoMovimiento/update', 'tipoMovimientoController@update')->name('tipoMovimiento.update')->middleware('permission:tipoMovimiento_update');
Route::delete('tipoMovimiento/destroy', 'tipoMovimientoController@destroy')->name('tipoMovimiento.destroy')->middleware('permission:tipoMovimiento_delete');
//  Route::resource('tipoMovimiento','tipoMovimientoController');

//Pais
Route::get('pais', 'PaisController@index')->name('pais.index')->middleware('permission:pais_index');
Route::get('pais/{pais}/show', 'PaisController@show')->name('pais.show')->middleware('permission:pais_show');
Route::get('pais/create', 'PaisController@create')->name('pais.create')->middleware('permission:pais_create');
Route::post('pais', 'PaisController@store')->name('pais.store')->middleware('permission:pais_store');
Route::get('pais/{id}/edit', 'PaisController@edit')->name('pais.edit')->middleware('permission:pais_edit');
Route::post('pais/update', 'PaisController@update')->name('pais.update')->middleware('permission:pais_update');
Route::delete('pais/destroy', 'PaisController@destroy')->name('pais.destroy')->middleware('permission:pais_delete');

//Provincia
Route::get('provincia', 'ProvinciaController@index')->name('provincia.index')->middleware('permission:provincia_index');
Route::get('provincia/{provincia}/show', 'ProvinciaController@show')->name('provincia.show')->middleware('permission:provincia_show');
Route::get('provincia/create', 'ProvinciaController@create')->name('provincia.create')->middleware('permission:provincia_create');
Route::post('provincia', 'ProvinciaController@store')->name('provincia.store')->middleware('permission:provincia_store');
Route::get('provincia/{id}/edit', 'ProvinciaController@edit')->name('provincia.edit')->middleware('permission:provincia_edit');
Route::post('provincia/update', 'ProvinciaController@update')->name('provincia.update')->middleware('permission:provincia_update');
Route::delete('provincia/destroy', 'ProvinciaController@destroy')->name('provincia.destroy')->middleware('permission:provincia_delete');

//localidad
Route::get('localidad', 'LocalidadController@index')->name('localidad.index')->middleware('permission:localidad_index');
Route::get('localidad/{localidad}/show', 'LocalidadController@show')->name('localidad.show')->middleware('permission:localidad_show');
Route::get('localidad/create', 'LocalidadController@create')->name('localidad.create')->middleware('permission:localidad_create');
Route::post('localidad', 'LocalidadController@store')->name('localidad.store')->middleware('permission:localidad_store');
Route::get('localidad/{id}/edit', 'LocalidadController@edit')->name('localidad.edit')->middleware('permission:localidad_edit');
Route::post('localidad/update', 'LocalidadController@update')->name('localidad.update')->middleware('permission:localidad_update');
Route::delete('localidad/destroy', 'LocalidadController@destroy')->name('localidad.destroy')->middleware('permission:localidad_delete');

//calle
Route::get('calle', 'CalleController@index')->name('calle.index')->middleware('permission:calle_index');
Route::get('calle/{calle}/show', 'CalleController@show')->name('calle.show')->middleware('permission:calle_show');
Route::get('calle/create', 'CalleController@create')->name('calle.create')->middleware('permission:calle_create');
Route::post('calle', 'CalleController@store')->name('calle.store')->middleware('permission:calle_store');
Route::get('calle/{id}/edit', 'CalleController@edit')->name('calle.edit')->middleware('permission:calle_edit');
Route::post('calle/update', 'CalleController@update')->name('calle.update')->middleware('permission:calle_update');
Route::delete('calle/destroy', 'CalleController@destroy')->name('calle.destroy')->middleware('permission:calle_delete');


//Medidas
Route::get('medida', 'medidaController@index')->name('medida.index')->middleware('permission:medida_index');
Route::get('medida/{medida}/show', 'medidaController@show')->name('medida.show')->middleware('permission:medida_show');
Route::get('medida/create', 'medidaController@create')->name('medida.create')->middleware('permission:medida_create');
Route::post('medida', 'medidaController@store')->name('medida.store')->middleware('permission:medida_store');
Route::get('medida/{id}/edit', 'medidaController@edit')->name('medida.edit')->middleware('permission:medida_edit');
Route::post('medida/update', 'medidaController@update')->name('medida.update')->middleware('permission:medida_update');
Route::delete('medida/destroy', 'medidaController@destroy')->name('medida.destroy')->middleware('permission:medida_delete');
//  Route::resource('medida','medidaController');

//Direccion
Route::get('direccion', 'direccionController@index')->name('direccion.index')->middleware('permission:direccion_index');
Route::get('direccion/{direccion}/show', 'direccionController@show')->name('direccion.show')->middleware('permission:direccion_show');
Route::get('direccion/create', 'direccionController@create')->name('direccion.create')->middleware('permission:direccion_create');
Route::post('direccion', 'direccionController@store')->name('direccion.store')->middleware('permission:direccion_store');
Route::get('direccion/{id}/edit', 'direccionController@edit')->name('direccion.edit')->middleware('permission:direccion_edit');
Route::post('direccion/update', 'direccionController@update')->name('direccion.update')->middleware('permission:direccion_update');
Route::delete('direccion/destroy', 'direccionController@destroy')->name('direccion.destroy')->middleware('permission:direccion_delete');
//  Route::resource('direccion','direccionController');

//Documento
Route::get('documento', 'documentoController@index')->name('documento.index')->middleware('permission:documento_index');
Route::get('documento/{documento}/show', 'documentoController@show')->name('documento.show')->middleware('permission:documento_show');
Route::get('documento/create', 'documentoController@create')->name('documento.create')->middleware('permission:documento_create');
Route::post('documento', 'documentoController@store')->name('documento.store')->middleware('permission:documento_store');
Route::get('documento/{id}/edit', 'documentoController@edit')->name('documento.edit')->middleware('permission:documento_edit');
Route::post('documento/update', 'documentoController@update')->name('documento.update')->middleware('permission:documento_update');
Route::delete('documento/destroy', 'documentoController@destroy')->name('documento.destroy')->middleware('permission:documento_delete');
//  Route::resource('documento','documentoController');

//Item
Route::get('item', 'ItemController@index')->name('item.index')->middleware('permission:item_index');
Route::get('item/{item}/show', 'ItemController@show')->name('item.show')->middleware('permission:item_show');
Route::get('item/create', 'ItemController@create')->name('item.create')->middleware('permission:item_create');
Route::post('item', 'ItemController@store')->name('item.store')->middleware('permission:item_store');
Route::get('item/{item}/edit', 'ItemController@edit')->name('item.edit')->middleware('permission:item_edit');
Route::put('item/{item}', 'ItemController@update')->name('item.update')->middleware('permission:item_update');
Route::get('item/{item}', 'ItemController@destroy')->name('item.destroy')->middleware('permission:item_delete');

//Categoria
Route::get('categoria', 'CategoriaController@index')->name('categoria.index')->middleware('permission:categoria_index');
Route::get('categoria/{categoria}/show', 'CategoriaController@show')->name('categoria.show')->middleware('permission:categoria_show');
Route::get('categoria/create', 'CategoriaController@create')->name('categoria.create')->middleware('permission:categoria_create');
Route::post('categoria', 'CategoriaController@store')->name('categoria.store')->middleware('permission:categoria_store');
Route::get('categoria/{id}/edit', 'CategoriaController@edit')->name('categoria.edit')->middleware('permission:categoria_edit');
Route::post('categoria/update', 'CategoriaController@update')->name('categoria.update')->middleware('permission:categoria_update');
Route::get('categoria/destroy/{id}', 'CategoriaController@destroy')->name('categoria.destroy')->middleware('permission:categoria_delete');
//  Route::resource('categoria','categoriaController');

//Tipo Item
Route::get('tipoItem', 'TipoItemController@index')->name('tipoItem.index')->middleware('permission:tipoItem_index');
Route::get('tipoItem/{tipoItem}/show', 'TipoItemController@show')->name('tipoItem.show')->middleware('permission:tipoItem_show');
Route::get('tipoItem/create', 'TipoItemController@create')->name('tipoItem.create')->middleware('permission:tipoItem_create');
Route::post('tipoItem', 'TipoItemController@store')->name('tipoItem.store')->middleware('permission:tipoItem_store');
Route::get('tipoItem/{id}/edit', 'TipoItemController@edit')->name('tipoItem.edit')->middleware('permission:tipoItem_edit');
Route::post('tipoItem/update', 'TipoItemController@update')->name('tipoItem.update')->middleware('permission:tipoItem_update');
Route::get('tipoItem/destroy/{id}', 'TipoItemController@destroy')->name('tipoItem.destroy')->middleware('permission:tipoItem_delete');
//  Route::resource('categoria','categoriaController');

//Proveedor
Route::get('proveedor', 'ProveedorController@index')->name('proveedor.index')->middleware('permission:proveedor_index');
Route::get('proveedor/{proveedor}/show', 'ProveedorController@show')->name('proveedor.show')->middleware('permission:proveedor_show');
Route::get('proveedor/create', 'ProveedorController@create')->name('proveedor.create')->middleware('permission:proveedor_create');
Route::post('proveedor', 'ProveedorController@store')->name('proveedor.store')->middleware('permission:proveedor_store');
Route::get('proveedor/{id}/edit', 'ProveedorController@edit')->name('proveedor.edit')->middleware('permission:proveedor_edit');
Route::post('proveedor/update', 'ProveedorController@update')->name('proveedor.update')->middleware('permission:proveedor_update');
Route::delete('proveedor/destroy', 'ProveedorController@destroy')->name('proveedor.destroy')->middleware('permission:proveedor_delete');
//  Route::resource('proveedor','ProveedorController');




//prueba
Route::resource('ajax-crud', 'AjaxCrudController');

Route::post('ajax-crud/update', 'AjaxCrudController@update')->name('ajax-crud.update');

Route::get('ajax-crud/destroy/{id}', 'AjaxCrudController@destroy');

//Route::get('materiaPrima/{id}/destroy','ControllerMateriaPrima@destroy')->name('materiaPrima.destroy')->middleware('permission:usuarios_delete');

// Route::resource('/roles','UserController');
// Route::resource('/usuarios','UserController');

// Route::resource('/materiaPrima','ControllerMateriaPrima');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
