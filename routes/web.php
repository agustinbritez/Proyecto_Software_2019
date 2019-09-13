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
Route::get('users/create','UserController@create')->name('usuarios.crate')->middleware('permission:usuarios_create');
Route::get('users/{usuario}/edit','UserController@edit')->name('usuarios.edit')->middleware('permission:usuarios_edit');
Route::get('users','UserController@delete')->name('usuarios.delete')->middleware('permission:usuarios_delete');

//    Route::resource('/usuarios','UserController');
});
 Route::resource('/usuarios','UserController');
// Route::resource('/roles','UserController');
// Route::resource('/usuarios','UserController');

Route::resource('/materiaPrima','controllerMateriaPrima');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
