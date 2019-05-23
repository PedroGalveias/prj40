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

Route::get('/', function () {
    return view('welcome');
});

 Auth::routes(['verify' => true, 'register' => false]);

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('socios', 'UserController')->only(['update'])->middleware('can:edit-perfil,user');
Route::resource('socios', 'UserController')->except(['show','edit','update']);

Route::resource('socios', 'UserController')->only(['edit'])->middleware('can:edit-perfil,user');


Route::resource('movimentos', 'MovementController')->except(['show']);

Route::resource('/aeronaves', 'AeronaveController')->parameters(['aeronaves'=>'aeronave'])->except(['show']);

//Route::get('/alterarPerfil/{id}', 'UserController@alterarPerfil')->name('alterarPerfil');


Route::get('/password','UserController@showChangePasswordForm');
Route::post('/password','UserController@changePassword')->name('changePassword');
Route::get('/profile', 'UserController@profile');
Route::get('/pilotos/{piloto}/certificado', 'UserController@certificado')->name('certificado');
Route::get('/pilotos/{piloto}/licenca', 'UserController@licenca')->name('licenca');