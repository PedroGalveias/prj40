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
Auth::routes(['verify' => true, 'register' => false]);

Route::get('/', function () {
    return view('welcome');
});
Route::get('/home', 'HomeController@index')->name('home');
Route::resource('socios', 'UserController')->except(['show']);
Route::resource('movimentos', 'MovimentoController')->except(['show']);
Route::resource('aeronaves', 'AeronaveController')->parameters(['aeronaves'=>'aeronave'])->except(['show']);

//change pass
Route::get('/password','UserController@showChangePasswordForm');
Route::post('/password','UserController@changePassword')->name('changePassword');

//email
Route::post('/socios/{socio}/send_reactivate_mail','UserController@sendReActivationEmail')->name('sendReActivationEmail');

//quotas
Route::patch('/socios/{socio}/quota','UserController@quota')->name('quota');
Route::patch('/socios/desativar_sem_quotas','UserController@desativar_sem_quotas')->name('desativar_sem_quotas');

//certificados
Route::get('/pilotos/{piloto}/certificado', 'UserController@certificado')->name('certificado');
Route::get('/pilotos/{piloto}/licenca', 'UserController@licenca')->name('licenca');

//socios ativos
Route::patch('/socios/{socio}/ativo','UserController@ativarSocio')->name('ativarSocio');

// Preço/Hora de uma Aeronave
Route::get('/aeronaves/{aeronaves}/precos_tempos', 'AeronaveController@priceTime')->name('priceTime');


