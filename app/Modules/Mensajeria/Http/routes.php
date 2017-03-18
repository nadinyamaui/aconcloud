<?php

/*
|--------------------------------------------------------------------------
| Module Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for the module.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::resource('mensajes', 'MensajesController');
Route::get('mensajes/iframe/{id}', 'MensajesController@iframe');

Route::post('mensajes/borrar', 'MensajesController@borrar');
Route::post('mensajes/papelera', 'MensajesController@papelera');
