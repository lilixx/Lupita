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
})->middleware('auth');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');

//User
Route::group(['middleware' => 'auth'], function() {
    Route::resource('/users', 'UserController')->middleware('auth');
});
Route::get('/users/{user_id}/show', 'UserController@show')->middleware('auth');
Route::get('/users/{user_id}/edit', 'UserController@edit')->middleware('auth');
Route::get('/users/{user_id}/editprofile', 'UserController@editprofile')->middleware('auth');
Route::put('/users/{user_id}/updateprofile', 'UserController@updateprofile')->name('users.updateprofile')->middleware('auth');
Route::put('/users/{user_id}/out', 'UserController@out')->name('users.out')->middleware('auth');
Route::group(['middleware' => 'auth'], function() {
    Route::resource('/useradd', 'UserController')->middleware('auth');
});

//Ahorro Tasa
Route::group(['middleware' => 'auth'], function() {
    Route::resource('/ahorrotasas', 'AhorrotasaController')->middleware('auth');
});
Route::post('/ahorrotasadd', array('as' => 'ahorrotasadd',
    'uses' => 'AhorrotasaController@store'))->middleware('auth');

//Plazo fijo Tasa
Route::group(['middleware' => 'auth'], function() {
    Route::resource('/plazofijotasas', 'PlazofijotasaController')->middleware('auth');
});
Route::post('/plazofijotasadd', array('as' => 'plazofijotasadd',
   'uses' => 'PlazofijotasaController@store'))->middleware('auth');


//Empresas
Route::group(['middleware' => 'auth'], function() {
    Route::resource('/empresas', 'EmpresaController')->middleware('auth');
});
Route::group(['middleware' => 'auth'], function() {
    Route::resource('/empresaadd', 'EmpresaController')->middleware('auth');
});
Route::get('/empresas/{empresa_id}/deuda', 'EmpresaController@deuda')->middleware('auth');
Route::get('/empresas/{cartera_id}/deudadetalle', 'EmpresaController@deudadetalle')->middleware('auth');
Route::get('/empresas/{empresa_id}/movimiento', 'EmpresaController@movimiento')->middleware('auth');
Route::get('/empresas/{empresa_id}/pago', 'EmpresaController@pago')->middleware('auth');
Route::post('/pagoadd', array('as' => 'pagoadd',
    'uses' => 'EmpresaController@pagoadd'))->middleware('auth');
Route::get('/empresas/{empresa_id}/proyplanilla', 'DeudaempresaController@proyplanilla')->name('empresas.proyplanilla')->middleware('auth');

//Socios
Route::group(['middleware' => 'auth'], function() {
    Route::resource('/socios', 'SocioController')->middleware('auth');
});
Route::get('/searchsocio', 'SocioController@search')->middleware('auth');
Route::put('consultsocio',array('as'=>'consultsocio','uses'=>'SocioController@consultsocio'))->middleware('auth');
Route::group(['middleware' => 'auth'], function() {
    Route::resource('/sociosadd', 'SocioController')->middleware('auth');
});

//Catalogo Afiliación
Route::group(['middleware' => 'auth'], function() {
    Route::resource('/afiliacioncat', 'AfiliacioncatalogoController')->middleware('auth');
});
Route::group(['middleware' => 'auth'], function() {
    Route::resource('/afiliacioncatadd', 'AfiliacioncatalogoController')->middleware('auth');
});

//quitarlo afiliacion
Route::group(['middleware' => 'auth'], function() {
    Route::resource('/afiliacion', 'AfiliacionController')->middleware('auth');
});
Route::group(['middleware' => 'auth'], function() {
    Route::resource('/pdet', 'PlazofijodetalleController')->middleware('auth');
});
Route::group(['middleware' => 'auth'], function() {
    Route::resource('/deuda', 'DeudaempresaController')->middleware('auth');
});

//Reportes
Route::get('/reportes', 'SocioController@reportes')->name('reportes')->middleware('auth');
Route::get('/carteraemp', 'PrestamoController@carteraemp')->name('carteraemp')->middleware('auth');
Route::put('carteraempcon',array('as'=>'carteraempcon','uses'=>'PrestamoController@carteraempcon'))->middleware('auth');
Route::get('/repcartera', 'PrestamoController@repcartera')->name('repcartera')->middleware('auth');

//Prestamos
Route::group(['middleware' => 'auth'], function() {
    Route::resource('/prestamos', 'PrestamoController')->middleware('auth');
});
Route::get('/prestamos/{prestamo_id}/pausa', 'PrestamoController@pausa')->middleware('auth');
Route::put('/prestamos/{prestamo_id}/pausar', 'PrestamoController@pausar')->name('prestamos.pausar')->middleware('auth');
Route::put('/prestamos/{prestamo_id}/continuar', 'PrestamoController@continuar')->name('prestamos.continuar')->middleware('auth');
Route::group(['middleware' => 'auth'], function() {
    Route::resource('/prestamosadd', 'PrestamoController')->middleware('auth');
});
Route::put('/prestamos/{prestamo_id}/planpago', 'PrestamoController@planpago')->name('prestamos.planpago')->middleware('auth');
Route::get('/prestamos/{prestamo_id}/movimiento', 'PrestamoController@movimiento')->name('prestamos.movimiento')->middleware('auth');
Route::put('/prestamos/{prestamo_id}/resume', 'PrestamoController@resume')->name('prestamos.resume')->middleware('auth');
Route::put('/prestamos/{prestamo_id}/contractof', 'PrestamoController@contractof')->name('prestamos.contractof')->middleware('auth');
Route::put('/prestamos/{prestamo_id}/repprestamo', 'PrestamoController@repprestamo')->name('prestamos.repprestamo')->middleware('auth');


//Tasa de Cambio
Route::group(['middleware' => 'auth'], function() {
    Route::resource('/tasacambios', 'TasacambioController')->middleware('auth');
});
Route::group(['middleware' => 'auth'], function() {
    Route::resource('/tasacambioadd', 'TasacambioController')->middleware('auth');
});
Route::get('/tasas', 'TasacambioController@tasas')->name('tasas')->middleware('auth');

//Comision
Route::group(['middleware' => 'auth'], function() {
    Route::resource('/comisiones', 'ComisionController')->middleware('auth');
});
Route::group(['middleware' => 'auth'], function() {
    Route::resource('/comisionadd', 'ComisionController')->middleware('auth');
});

//Miembros del Consejo
Route::group(['middleware' => 'auth'], function() {
    Route::resource('/mconsejo', 'CooperativaController')->middleware('auth');
});

//Ahorro
Route::group(['middleware' => 'auth'], function() {
    Route::resource('/ahorros', 'AhorroController')->middleware('auth');
});
Route::group(['middleware' => 'auth'], function() {
    Route::resource('/ahorroadd', 'AhorroController')->middleware('auth');
});
Route::get('/ahorros/{ahorro_id}/movimiento', 'AhorroController@movimiento')->middleware('auth');
Route::group(['middleware' => 'auth'], function() {
    Route::resource('/movimientoadd', 'AhorrodetalleController')->middleware('auth');
});
Route::get('/ahorrocreatespecial', 'AhorroController@createspecial')->name('ahorros.createspecial')->middleware('auth');
Route::get('/ahorrocreateadelanto', 'AhorroController@createadelanto')->name('ahorros.createadelanto')->middleware('auth');
Route::put('/ahorros/{ahorro_id}/pausar', 'AhorroController@pausar')->name('ahorros.pausar')->middleware('auth');
Route::put('/ahorros/{ahorro_id}/continuar', 'AhorroController@continuar')->name('ahorros.continuar')->middleware('auth');
Route::get('/ahorros/{ahorro_id}/show', 'AhorroController@show')->middleware('auth');
Route::put('/ahorros/{ahorro_id}/repch', 'AhorroController@repch')->name('ahorros.repch')->middleware('auth');

//Plazo fijos
Route::group(['middleware' => 'auth'], function() {
    Route::resource('/plazofijo', 'PlazofijoController')->middleware('auth');
});
Route::group(['middleware' => 'auth'], function() {
    Route::resource('/plazofijoadd', 'PlazofijoController')->middleware('auth');
});
Route::put('/plazofijo/{plazofijo_id}/repplazofijo', 'PlazofijoController@repplazofijo')->name('plazofijo.repplazofijo')->middleware('auth');
Route::get('/plazofijo/{plazofijo_id}/finalizebefore', 'PlazofijoController@finalizebefore')->name('plazofijo.finalizebefore')->middleware('auth');
Route::get('/plazoinactivo', 'PlazofijoController@inactivo')->name('plazofijo.inactivo')->middleware('auth');
Route::get('/plazofijo/{plazofijodet_id}/payck', 'PlazofijoController@payck')->name('plazofijo.payck')->middleware('auth');
Route::put('/plazofijo/{plazofijodet_id}/savepayck', 'PlazofijoController@savepayck')->name('plazofijo.savepayck')->middleware('auth');

//carteras
Route::group(['middleware' => 'auth'], function() {
    Route::resource('/cartera', 'CarteraController')->middleware('auth');
});

//PDF
Route::put('/prestamos/{prestamo_id}/prestamopdf', 'PrestamoController@prestamopdf')->name('prestamos.prestamopdf')->middleware('auth');
Route::put('/plazofijo/{plazofijo_id}/certificado', 'PlazofijoController@certificadopdf')->name('plazofijo.certificadopdf')->middleware('auth');

//autocomplete
Route::get('autocomplete',array('as'=>'autocomplete','uses'=>'BeneficiarioController@autocomplete'))->middleware('auth');
Route::get('socioautocomplete',array('as'=>'socioautocomplete','uses'=>'SocioController@socioautocomplete'))->middleware('auth');
