<?php
/*DB::listen(function($query){
    echo "<pre>{$query->sql}</pre>";
});*/
//colocar de la siguiente manera System/recurso

Route::get('/', function () {
    return redirect('/login');
});

//Global
Route::get('logout', 'Auth\LoginController@logout');
Auth::routes();

Route::auth();

Route::get('/home', 'HomeController@index')->name('home');
Route::post('/home', 'HomeController@index')->name('home');
Route::post('/home/filtros', ['as' => 'home.filtros', 'uses' => 'HomeController@filtros']);
Route::resource('roles', 'RolesController');
Route::resource('permisos', 'PermissionsController');
Route::resource('bitacora', 'LogController');
Route::match(['get', 'post'], '/usuarios/busqueda', ['as' => 'usuarios.search', 'uses' => 'UserController@search']);
Route::resource('usuarios', 'UserController')->except(['show']);
