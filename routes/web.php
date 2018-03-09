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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//Empresas
Route::group(['middleware' => 'auth'], function() {
    Route::resource('/empresas', 'EmpresaController');
});
Route::group(['middleware' => 'auth'], function() {
    Route::resource('/empresaadd', 'EmpresaController');
});

//Fiador (luego borrar)
Route::group(['middleware' => 'auth'], function() {
    Route::resource('/fiador', 'FiadorController');
});


//Socios
Route::group(['middleware' => 'auth'], function() {
    Route::resource('/socios', 'SocioController');
});
Route::group(['middleware' => 'auth'], function() {
    Route::resource('/sociosadd', 'SocioController');
});

//Catalogo Afiliación
Route::group(['middleware' => 'auth'], function() {
    Route::resource('/afiliacioncat', 'AfiliacioncatalogoController');
});
Route::group(['middleware' => 'auth'], function() {
    Route::resource('/afiliacioncatadd', 'AfiliacioncatalogoController');
});

//quitarlo afiliacion
Route::group(['middleware' => 'auth'], function() {
    Route::resource('/afiliacion', 'AfiliacionController');
});

//Prestamos
Route::group(['middleware' => 'auth'], function() {
    Route::resource('/prestamos', 'PrestamoController');
});
Route::group(['middleware' => 'auth'], function() {
    Route::resource('/prestamosadd', 'PrestamoController');
});
Route::put('/prestamos/{prestamo_id}/planpago', 'PrestamoController@planpago')->name('prestamos.planpago');
Route::put('/prestamos/{prestamo_id}/resume', 'PrestamoController@resume')->name('prestamos.resume');
Route::put('/prestamos/{prestamo_id}/contractof', 'PrestamoController@contractof')->name('prestamos.contractof');


//Tasa de Cambio
Route::group(['middleware' => 'auth'], function() {
    Route::resource('/tasacambios', 'TasacambioController');
});
Route::group(['middleware' => 'auth'], function() {
    Route::resource('/tasacambioadd', 'TasacambioController');
});

//Comision
Route::group(['middleware' => 'auth'], function() {
    Route::resource('/comisiones', 'ComisionController');
});
Route::group(['middleware' => 'auth'], function() {
    Route::resource('/comisionadd', 'ComisionController');
});

//Miembros del Consejo
Route::group(['middleware' => 'auth'], function() {
    Route::resource('/mconsejo', 'CooperativaController');
});

//Ahorro
Route::group(['middleware' => 'auth'], function() {
    Route::resource('/ahorros', 'AhorroController');
});
Route::group(['middleware' => 'auth'], function() {
    Route::resource('/ahorroadd', 'AhorroController');
});
Route::get('/ahorros/{ahorro_id}/movimiento', 'AhorroController@movimiento')->middleware('auth');
Route::group(['middleware' => 'auth'], function() {
    Route::resource('/movimientoadd', 'AhorrodetalleController');
});
Route::put('/ahorros/{ahorro_id}/pausar', 'AhorroController@pausar')->name('ahorros.pausar');
Route::put('/ahorros/{ahorro_id}/continuar', 'AhorroController@continuar')->name('ahorros.continuar');
Route::get('/ahorros/{ahorro_id}/show', 'AhorroController@show')->middleware('auth');
Route::put('/ahorros/{ahorro_id}/repch', 'AhorroController@repch')->name('ahorros.repch');

//Plazo fijos
Route::group(['middleware' => 'auth'], function() {
    Route::resource('/plazofijo', 'PlazofijoController');
});
Route::group(['middleware' => 'auth'], function() {
    Route::resource('/plazofijoadd', 'PlazofijoController');
});

//carteras
Route::group(['middleware' => 'auth'], function() {
    Route::resource('/cartera', 'CarteraController');
});

//PDF
Route::put('/prestamos/{prestamo_id}/prestamopdf', 'PrestamoController@prestamopdf')->name('prestamos.prestamopdf');
Route::put('/plazofijo/{plazofijo_id}/certificado', 'PlazofijoController@certificadopdf')->name('plazofijo.certificadopdf');

//autocomplete
Route::get('autocomplete',array('as'=>'autocomplete','uses'=>'BeneficiarioController@autocomplete'));
Route::get('socioautocomplete',array('as'=>'socioautocomplete','uses'=>'SocioController@socioautocomplete'));
