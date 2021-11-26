<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

//Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/',[
	'as'	=> 'root',
	'uses'	=> 'HomeController@index'
]);

/***************Empresas*******************/
Route::get('empresas/listarempresas', [
    'as'	=> 'listar-empresas',
    'uses'	=> 'EmpresaController@listarempresas'
])->middleware('auth');
Route::post('empresas/TraerEmpresa', [
    'as'	=> 'Traer-empresa',
    'uses'	=> 'EmpresaController@TraerEmpresa'
])->middleware('auth');
Route::post('empresas/crear-empresa', [
    'as'	=> 'crear-empresa',
    'uses'	=> 'EmpresaController@GuardarEmpresa'
])->middleware('auth');
Route::post('empresas/actualizar-empresa', [
    'as'	=> 'actualizar-empresa',
    'uses'	=> 'EmpresaController@EditarEmpresa'
])->middleware('auth');
Route::post('empresas/eliminar-empresa', [
    'as'	=> 'eliminar-empresa',
    'uses'	=> 'EmpresaController@EliminarEmpresa'
])->middleware('auth');
Route::get('empresas/repemp', [
    'as'	=> 'empresas-reporte',
    'uses'	=> 'EmpresaController@reporteEmpresa'
])->middleware('auth');
Route::get('empresas/repempexcel', [
    'as'	=> 'empresas-reporteexcel',
    'uses'	=> 'EmpresaController@downloadExcelempresas'
])->middleware('auth');
/***************Agenda*******************/
    Route::get('empresas/agendaadministrador/{idempresa}', [
        'as'	=> 'Agendaadmin',
        'uses'	=> 'EmpresaController@lagendaadmin'
    ])->middleware('auth');
    Route::get('empresas/agenda/idempresa', [
        'as'	=> 'Agenda',
        'uses'	=> 'EmpresaController@lagenda'
    ])->middleware('auth');
    Route::post('empresas/TraerAgenda', [
        'as'	=> 'Traer-agenda',
        'uses'	=> 'EmpresaController@TraerAgenda'
    ])->middleware('auth');
    Route::post('empresas/guardaragenda', [
        'as'	=> 'guardar-agenda',
        'uses'	=> 'EmpresaController@GuardarAgenda'
    ])->middleware('auth');

