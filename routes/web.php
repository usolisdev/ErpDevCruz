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
Route::post('empresas/crear-actualizar-empresa', [
    'as'	=> 'crear-actualizar-empresa',
    'uses'	=> 'EmpresaController@GuardarActualizarEmpresa'
])->middleware('auth');
// Route::post('empresas/actualizar-empresa', [
//     'as'	=> 'actualizar-empresa',
//     'uses'	=> 'EmpresaController@EditarEmpresa'
// ])->middleware('auth');
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

/***************CRM*******************/
	/***************Personas*******************/
		/***************
		 * *******************/
        Route::get('usuarios/{idempresa?}', [
            'as'	=> 'usuarios',
            'uses'	=> 'UsuariosController@lusuarios'
        ])->middleware('auth');
        Route::get('usuarios/{idempresa}/{idusuario}', [
            'as'	=> 'profile',
            'uses'	=> 'UsuariosController@profile'
        ])->middleware('auth');
        Route::post('usuarios/listarusuarios', [
            'as'	=> 'listar-usuarios',
            'uses'	=> 'UsuariosController@listarusuarios'
        ])->middleware('auth');
        Route::post('usuarios/TraerUsuario', [
            'as'	=> 'Traer-usuario',
            'uses'	=> 'UsuariosController@TraerUsuario'
        ])->middleware('auth');
        Route::post('usuarios/crear-usuario', [
            'as'	=> 'crear-usuario',
            'uses'	=> 'UsuariosController@GuardarUsuario'
        ])->middleware('auth');
        // Route::post('usuarios/actualizar-usuario', [
        //     'as'	=> 'actualizar-usuario',
        //     'uses'	=> 'UsuariosController@EditarUsuario'
        // ])->middleware('auth');
        Route::post('usuarios/actualizar-datoscuenta', [
            'as'	=> 'actualizar-datoscuenta',
            'uses'	=> 'UsuariosController@ActualizarDatosCuenta'
        ])->middleware('auth');
        Route::post('usuarios/actualizar-datospersonales', [
            'as'	=> 'actualizar-datospersonales',
            'uses'	=> 'UsuariosController@ActualizarDatosPersonales'
        ])->middleware('auth');
        Route::post('usuarios/actualizar-iniciosesion-correo', [
            'as'	=> 'actualizar-iniciosesion-correo',
            'uses'	=> 'UsuariosController@ActualizarInicioSesionCorreo'
        ])->middleware('auth');
        Route::post('usuarios/actualizar-iniciosesion-contra', [
            'as'	=> 'actualizar-iniciosesion-contra',
            'uses'	=> 'UsuariosController@ActualizarInicioSesionContra'
        ])->middleware('auth');

        Route::post('usuarios/actualizar-permisos-usuario', [
            'as'	=> 'actualizar-permisos-usuario',
            'uses'	=> 'UsuariosController@actualizarpermisos'
        ])->middleware('auth');
        Route::post('usuarios/editarcontrasenia', [
            'as'	=> 'EditarContrasenia',
            'uses'	=> 'UsuariosController@EditarContrasenia'
        ])->middleware('auth');
        Route::post('usuarios/eliminar-usuario', [
            'as'	=> 'eliminar-usuario',
            'uses'	=> 'UsuariosController@EliminarUsuario'
        ])->middleware('auth');
        Route::get('usuariosrep/repus/{idempresa?}', [
            'as'	=> 'usuario-reporte',
            'uses'	=> 'UsuariosController@reporteUsers'
        ])->middleware('auth');
        Route::get('usuariosrep/repusexcel/{idempresa?}', [
            'as'	=> 'usuario-reporteexcel',
            'uses'	=> 'UsuariosController@downloadExcelusuarios'
        ])->middleware('auth');
    /***************clientes*******************/
        Route::post('clientes/listadeclientes', [
            'as'	=> 'listadeclientes',
            'uses'	=> 'PersonaController@listadeclientes'
        ])->middleware('auth');
        Route::post('clientes/TraerCliente', [
            'as'	=> 'Traer-Cliente',
            'uses'	=> 'PersonaController@TraerCliente'
        ])->middleware('auth');
        Route::get('clientes/listadeclientes/{idempresa}', [
            'as'	=> 'listar-clientes',
            'uses'	=> 'PersonaController@lclientes'
        ])->middleware('auth');
        Route::post('clientes/crear-cliente', [
            'as'	=> 'crear-cliente',
            'uses'	=> 'PersonaController@Guardarcliente'
        ])->middleware('auth');
        Route::post('clientes/actualizar-cliente', [
            'as'	=> 'actualizar-cliente',
            'uses'	=> 'PersonaController@Editarcliente'
        ])->middleware('auth');
        Route::post('clientes/eliminar-cliente', [
            'as'	=> 'eliminar-cliente',
            'uses'	=> 'PersonaController@Eliminarcliente'
        ])->middleware('auth');
        Route::post('clientes/atributos', [
            'as'	=> 'cliente-atributos',
            'uses'	=> 'PersonaController@listattrtree'
        ])->middleware('auth');
        Route::post('clientes/guardaratributos', [
            'as'	=> 'guardar-defgrupatributos',
            'uses'	=> 'PersonaController@guardardetattrclientes'
        ])->middleware('auth');
        Route::get('clientes/repcli/{idempresa}', [
            'as'	=> 'clientes-reporte',
            'uses'	=> 'PersonaController@reporteCliente'
        ])->middleware('auth');
        Route::get('clientes/repcliexcel/{idempresa}', [
            'as'	=> 'clientes-repcliexcel',
            'uses'	=> 'PersonaController@downloadExcelCliente'
        ])->middleware('auth');
    /***************proveedores*******************/
        Route::post('proveedores/listadeproveedores', [
            'as'	=> 'listadeproveedores',
            'uses'	=> 'PersonaController@listadeproveedores'
        ])->middleware('auth');
        Route::post('proveedores/TraerProveedor', [
            'as'	=> 'Traer-Proveedor',
            'uses'	=> 'PersonaController@TraerProveedor'
        ])->middleware('auth');
        Route::get('proveedores/listadeproveedores/{idempresa}', [
            'as'	=> 'listar-proveedores',
            'uses'	=> 'PersonaController@lproveedores'
        ])->middleware('auth');
        Route::post('proveedores/crear-proveedor', [
            'as'	=> 'crear-proveedor',
            'uses'	=> 'PersonaController@GuardarProveedor'
        ])->middleware('auth');
        Route::post('proveedores/actualizar-proveedor', [
            'as'	=> 'actualizar-proveedor',
            'uses'	=> 'PersonaController@EditarProveedor'
        ])->middleware('auth');
        Route::post('proveedores/eliminar-proveedor', [
            'as'	=> 'eliminar-proveedor',
            'uses'	=> 'PersonaController@EliminarProveedor'
        ])->middleware('auth');
        Route::post('proveedores/atributos', [
            'as'	=> 'proveedores-atributos',
            'uses'	=> 'PersonaController@listattrtreepro'
        ])->middleware('auth');
        Route::post('proveedores/guardaratributos', [
            'as'	=> 'guardar-defgrupatributos',
            'uses'	=> 'PersonaController@guardardetattrproveedores'
        ])->middleware('auth');
        Route::get('proveedores/repprovee/{idempresa}', [
            'as'	=> 'proveedores-reporte',
            'uses'	=> 'PersonaController@reporteProveedor'
        ])->middleware('auth');
        Route::get('proveedores/repproveexcel/{idempresa}', [
            'as'	=> 'proveedores-repproveexcel',
            'uses'	=> 'PersonaController@downloadExcelProveedor'
        ])->middleware('auth');
    /***************Vendedores*******************/
        Route::post('vendedores/listadevendedores', [
            'as'	=> 'listadevendedores',
            'uses'	=> 'PersonaController@listadevendedores'
        ])->middleware('auth');
        Route::post('vendedores/Traervendedor', [
            'as'	=> 'Traer-vendedor',
            'uses'	=> 'PersonaController@Traervendedor'
        ])->middleware('auth');
        Route::get('vendedorprofile/{idempresa}/{idatributo}', [
            'as'	=> 'profile-vendedor',
            'uses'	=> 'PersonaController@profilevendedor'
        ])->middleware('auth');
        Route::get('vendedores/listadevendedores/{idempresa}', [
            'as'	=> 'listar-vendedores',
            'uses'	=> 'PersonaController@lvendedores'
        ])->middleware('auth');
        Route::post('vendedores/crear-vendedor', [
            'as'	=> 'crear-vendedor',
            'uses'	=> 'PersonaController@Guardarvendedor'
        ])->middleware('auth');
        Route::post('vendedores/actualizar-vendedor', [
            'as'	=> 'actualizar-vendedor',
            'uses'	=> 'PersonaController@Editarvendedor'
        ])->middleware('auth');
        Route::post('vendedores/eliminar-vendedor', [
            'as'	=> 'eliminar-vendedor',
            'uses'	=> 'PersonaController@Eliminarvendedor'
        ])->middleware('auth');
        Route::get('vendedores/repvende/{idempresa}', [
            'as'	=> 'vendedores-reporte',
            'uses'	=> 'PersonaController@reporteVendedor'
        ])->middleware('auth');
        Route::get('vendedores/repvendeexcel/{idempresa}', [
            'as'	=> 'vendedores-repvendeexcel',
            'uses'	=> 'PersonaController@downloadExcelVendedores'
        ])->middleware('auth');
    /***************Personas*******************/
        Route::post('personas/Traerpersona', [
            'as'	=> 'Traer-persona',
            'uses'	=> 'PersonaController@Traerpersona'
        ])->middleware('auth');
    /***************Empresas*******************/
        Route::post('personas/TraerEmpresa', [
            'as'	=> 'Traer-empresa',
            'uses'	=> 'PersonaController@TraerEmpresa'
        ])->middleware('auth');


/*******Menu dashboard Empresa********/
Route::get('/menu/{idempresa}',[
    'as'	=> 'gotomenu',
    'uses'	=> 'HomeController@menu'
])->middleware('auth');

