<?php

//use Twitter;

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

use App\Models\Usuario;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/muertes', 'MuertesController@index')->name('muertes');

Route::resource("tipoTweet", "TipoTweetController");

Route::get('/pruebas', function () {
    return Twitter::getTweet("1142472066001756160", ["format" => "array"]);
});

Route::get('/usuarios/verificar/{idUsuario}', 'UsuariosController@valida')->name('verificar');
