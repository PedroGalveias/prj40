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

Route::patch('/socios/desativar_sem_quotas','UserController@desativarSemQuotas')->name('desativarSemQuotas');
Route::patch('/socios/reset_quotas','UserController@resetQuota')->name('resetQuota');

Route::get('/home', 'HomeController@index')->name('home');
Route::resource('socios', 'UserController')->except(['show','desativarSemQuotas']);
Route::resource('movimentos', 'MovimentoController')->except(['show']);
Route::resource('aeronaves', 'AeronaveController')->parameters(['aeronaves'=>'aeronave'])->except(['show']);

//change pass
Route::get('/password','UserController@showChangePasswordForm');
Route::post('/password','UserController@changePassword')->name('changePassword');

//email
Route::post('/socios/{socio}/send_reactivate_mail','UserController@sendReActivationEmail')->name('sendReActivationEmail');

//quotas

Route::patch('/socios/{socio}/quota','UserController@quota')->name('quota');

//lista pilotos
Route::get('/aeronaves/{aeronave}/pilotos', 'AeronaveController@listaPilotosAutorizados')->name('listaAutorizados');
Route::post('/aeronaves/{aeronave}/pilotos/{piloto}', 'AeronaveController@acrescentaPiloto');
Route::delete('/aeronaves/{aeronave}/pilotos/{piloto}', 'AeronaveController@removePiloto');


//certificados
Route::get('/pilotos/{piloto}/certificado', 'UserController@certificado')->name('certificado');
Route::get('/pilotos/{piloto}/licenca', 'UserController@licenca')->name('licenca');

//socios ativos

Route::patch('/socios/{socio}/ativo','UserController@ativarSocio')->name('ativarSocio');
Route::get('/aeronaves/{aeronave}/precos_tempos', 'AeronaveController@precoTempos')->name('precos_tempos');

// Preço/Hora - Rota que devolve um JSON
Route::get('/aeronaves/{aeronave}/precos_tempos', 'AeronaveController@precoTempos')->name('precos_tempos');

// Estatisticas
Route::get('/movimentos/estatisticas', 'MovimentoController@estatisticas')->name('estatisticas');

// Pendentes
Route::get('/pendentes', 'PendentesController@index')->name('pendentes');


