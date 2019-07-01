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
	//return Twitter::postTweet(['status' => 'Mi primer tweet desde Laravel', 'format' => 'json']);
    return view('welcome');
});

Route::get('/prueba', function () {
	return Usuario::getAlistamiento();
});

Route::get('/tweet', function () {
	$data = Twitter::getTweet("1145667645242523652",['format' => 'array']);
	return $data;
});

Route::get('/tweets', function () {
	$data = Twitter::getMentionsTimeline(["screen_name" => "totanawarbot",'format' => 'array']);
	return $data;
});

