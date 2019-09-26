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

Route::middleware(['auth'])->group(function(){
    Route::get('/admin', function () {
        return view('admin_panel.index');
    });
//users
Route::get('users','UserController@index')->name('usuarios.index')->middleware('permission:usuarios_index');
Route::get('users','UserController@show')->name('usuarios.show')->middleware('permission:usuarios_show');
Route::get('users/create','UserController@create')->name('usuarios.create')->middleware('permission:usuarios_create');
Route::get('users/{usuario}/edit','UserController@edit')->name('usuarios.edit')->middleware('permission:usuarios_edit');
Route::get('users','UserController@delete')->name('usuarios.delete')->middleware('permission:usuarios_delete');

//    Route::resource('/usuarios','UserController');
});
 Route::resource('/usuarios','UserController');

//Categoria
Route::get('materiaPrima','ControllerMateriaPrima@index')->name('materiaPrima.index')->middleware('permission:materiaPrima_index');
Route::get('materiaPrima/{materiaPrima}/show','ControllerMateriaPrima@show')->name('materiaPrima.show')->middleware('permission:materiaPrima_show');
Route::get('materiaPrima/create','ControllerMateriaPrima@create')->name('materiaPrima.create')->middleware('permission:materiaPrima_create');
Route::post('materiaPrima','ControllerMateriaPrima@store')->name('materiaPrima.store')->middleware('permission:materiaPrima_store');
Route::get('materiaPrima/{id}/edit','ControllerMateriaPrima@edit')->name('materiaPrima.edit')->middleware('permission:materiaPrima_edit');
Route::post('materiaPrima/update','ControllerMateriaPrima@update')->name('materiaPrima.update')->middleware('permission:materiaPrima_update');
Route::get('materiaPrima/destroy/{id}','ControllerMateriaPrima@destroy')->name('materiaPrima.destroy')->middleware('permission:materiaPrima_delete');
//  Route::resource('materiaPrima','materiaPrimaController');


//Item
Route::get('item','ItemController@index')->name('item.index')->middleware('permission:item_index');
Route::get('item/{item}/show','ItemController@show')->name('item.show')->middleware('permission:item_show');
Route::get('item/create','ItemController@create')->name('item.create')->middleware('permission:item_create');
Route::post('item','ItemController@store')->name('item.store')->middleware('permission:item_store');
Route::get('item/{item}/edit','ItemController@edit')->name('item.edit')->middleware('permission:item_edit');
Route::put('item/{item}','ItemController@update')->name('item.update')->middleware('permission:item_update');
Route::get('item/{item}','ItemController@destroy')->name('item.destroy')->middleware('permission:item_delete');

//Categoria
Route::get('categoria','CategoriaController@index')->name('categoria.index')->middleware('permission:categoria_index');
Route::get('categoria/{categoria}/show','CategoriaController@show')->name('categoria.show')->middleware('permission:categoria_show');
Route::get('categoria/create','CategoriaController@create')->name('categoria.create')->middleware('permission:categoria_create');
Route::post('categoria','CategoriaController@store')->name('categoria.store')->middleware('permission:categoria_store');
Route::get('categoria/{id}/edit','CategoriaController@edit')->name('categoria.edit')->middleware('permission:categoria_edit');
Route::post('categoria/update','CategoriaController@update')->name('categoria.update')->middleware('permission:categoria_update');
Route::get('categoria/destroy/{id}','CategoriaController@destroy')->name('categoria.destroy')->middleware('permission:categoria_delete');
//  Route::resource('categoria','categoriaController');

//Tipo Item
Route::get('tipoItem','TipoItemController@index')->name('tipoItem.index')->middleware('permission:tipoItem_index');
Route::get('tipoItem/{tipoItem}/show','TipoItemController@show')->name('tipoItem.show')->middleware('permission:tipoItem_show');
Route::get('tipoItem/create','TipoItemController@create')->name('tipoItem.create')->middleware('permission:tipoItem_create');
Route::post('tipoItem','TipoItemController@store')->name('tipoItem.store')->middleware('permission:tipoItem_store');
Route::get('tipoItem/{id}/edit','TipoItemController@edit')->name('tipoItem.edit')->middleware('permission:tipoItem_edit');
Route::post('tipoItem/update','TipoItemController@update')->name('tipoItem.update')->middleware('permission:tipoItem_update');
Route::get('tipoItem/destroy/{id}','TipoItemController@destroy')->name('tipoItem.destroy')->middleware('permission:tipoItem_delete');
//  Route::resource('categoria','categoriaController');

//Proveedor
Route::get('proveedor','ProveedorController@index')->name('proveedor.index')->middleware('permission:proveedor_index');
Route::get('proveedor/{proveedor}/show','ProveedorController@show')->name('proveedor.show')->middleware('permission:proveedor_show');
Route::get('proveedor/create','ProveedorController@create')->name('proveedor.create')->middleware('permission:proveedor_create');
Route::post('proveedor','ProveedorController@store')->name('proveedor.store')->middleware('permission:proveedor_store');
Route::get('proveedor/{id}/edit','ProveedorController@edit')->name('proveedor.edit')->middleware('permission:proveedor_edit');
Route::post('proveedor/update','ProveedorController@update')->name('proveedor.update')->middleware('permission:proveedor_update');
Route::get('proveedor/destroy/{id}','ProveedorController@destroy')->name('proveedor.destroy')->middleware('permission:proveedor_delete');
//  Route::resource('categoria','categoriaController');


//pdf
Route::get('pdf/MateriPrima','PdfController@materiPrima')->name('materiaPrima.pdf');


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
