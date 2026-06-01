<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AsistenciaAdminController;
use App\Http\Controllers\AsistenciaController;
use App\Http\Controllers\GastoController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\ReservaAdminController;
use App\Http\Controllers\ReservaClaseController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


/*
|--------------------------------------------------------------------------
| RESERVAS PÚBLICAS
|--------------------------------------------------------------------------
*/
Route::get('/reservar', [ReservaClaseController::class, 'index'])->name('reservas.index');
Route::post('/reservar/buscar', [ReservaClaseController::class, 'buscar'])->name('reservas.buscar');
Route::post('/reservar/guardar', [ReservaClaseController::class, 'guardar'])->name('reservas.guardar');
Route::get('/reservar/exito', [ReservaClaseController::class, 'success'])->name('reservas.success');

/*
|--------------------------------------------------------------------------
| ASISTENCIA PÚBLICA
|--------------------------------------------------------------------------
*/

Route::get('/registrar-asistencia', [AsistenciaController::class, 'index'])->name('asistencia.index');
Route::post('/registrar-asistencia/buscar', [AsistenciaController::class, 'buscar'])->name('asistencia.buscar');
Route::post('/registrar-asistencia/guardar', [AsistenciaController::class, 'guardar'])->name('asistencia.guardar');
Route::get('/registrar-asistencia/exito', [AsistenciaController::class, 'success'])->name('asistencia.success');



/******************************************* ADMIN *******************************************/
Route::get('admin', [AdminController::class, 'index']);

/******************************************* ADMIN ASISTENCIAS  *******************************************/
Route::get('admin/asistencias', [AsistenciaAdminController::class, 'index'])->name('admin.asistencias.index');
Route::post('admin/asistencias/cerrar-dia', [AsistenciaAdminController::class, 'cerrarDia'])->name('admin.asistencias.cerrarDia');

/******************************************* ADMIN RESERVAS  *******************************************/

Route::get('admin/reservas', [ReservaAdminController::class, 'index'])->name('admin.reservas.index');
Route::post('admin/reservas/cancelar/{idReservaClase}', [ReservaAdminController::class, 'cancelar'])->name('admin.reservas.cancelar');


/******************************************* ADMIN USUARIO *******************************************/

Route::get('admin/usuarios', [UsuarioController::class, 'index']);

Route::get('admin/usuarios/create', [UsuarioController::class, 'create']);
Route::post('admin/usuarios', [UsuarioController::class, 'store']);

Route::get('admin/usuarios/export', [UsuarioController::class, 'export']);

Route::get('admin/usuarios/{idUsuario}', [UsuarioController::class, 'show']);

Route::get('admin/usuarios/{idUsuario}/edit', [UsuarioController::class, 'edit']);
Route::patch('admin/usuarios/{idUsuario}', [UsuarioController::class, 'update']);

Route::get('admin/usuarios/{idUsuario}/edit_password', [UsuarioController::class, 'edit_password']);
Route::patch('admin/usuarios/{idUsuario}/update_password', [UsuarioController::class, 'update_password']);

Route::get('admin/usuarios/{idUsuario}/create_pago', [UsuarioController::class, 'create_pago']);
Route::patch('admin/usuarios/{idUsuario}/store_pago', [UsuarioController::class, 'store_pago']);
Route::delete('admin/usuarios/{idUsuario}/pago/{idPago}/delete', [UsuarioController::class, 'delete_pago']);

Route::get('admin/usuarios/send_password/{idUsuario}', [UsuarioController::class, 'send_password_by_email']);

Route::delete('admin/usuarios/{idUsuario}', [UsuarioController::class, 'delete']);

/******************************************* ADMIN GASTOS *******************************************/

Route::get('admin/gastos', [GastoController::class, 'index']);

Route::get('admin/gastos/create', [GastoController::class, 'create']);
Route::post('admin/gastos', [GastoController::class, 'store']);

Route::get('admin/gastos/{idGasto}/edit', [GastoController::class, 'edit']);
Route::patch('admin/gastos/{idGasto}', [GastoController::class, 'update']);

Route::delete('admin/gastos/{idGasto}', [GastoController::class, 'destroy']);


/******************************************* ADMIN PROGRAMACION *******************************************/
Route::get('admin/programacion', [ProgramacionController::class, 'index']);

Route::get('admin/programacion/create', [ProgramacionController::class, 'create']);
Route::post('admin/programacion', [ProgramacionController::class, 'store']);

Route::get('admin/programacion/show', [ProgramacionController::class, 'show']);
Route::get('admin/programacion/edit', [ProgramacionController::class, 'edit']);
Route::patch('admin/programacion/{idProgramacion}', [ProgramacionController::class, 'update']);

Route::patch('admin/programacion/{idProgramacion}', [ProgramacionController::class, 'destroy']);

/******************************************* ADMIN EJERCICIO *******************************************/
Route::get('admin/ejercicios', [EjercicioController::class, 'index']);

Route::get('admin/ejercicios/create', [EjercicioController::class, 'create']);
Route::post('admin/ejercicios', [EjercicioController::class, 'store']);

Route::get('admin/ejercicios/show', [EjercicioController::class, 'show']);
Route::get('admin/ejercicios/edit', [EjercicioController::class, 'edit']);
Route::patch('admin/ejercicios/{idEjercicio}', [EjercicioController::class, 'update']);

Route::delete('admin/ejercicios/{idEjercicio}', [EjercicioController::class, 'destroy']);


/******************************************* ADMIN REPORTES *******************************************/


Route::get('admin/reportes/corte_caja', [ReporteController::class, 'corte_caja']);
Route::get('admin/reportes/corte_caja/export', [ReporteController::class, 'corte_caja_export']);

Route::get('admin/reportes/concentrado_pagos_por_mes', [ReporteController::class, 'concentrado_pagos_por_mes']);
Route::get('admin/reportes/concentrado_pagos_por_mes/export', [ReporteController::class, 'concentrado_pagos_por_mes_export']);

Route::get('admin/reportes/pagos_pendientes', [ReporteController::class, 'pagos_pendientes'])->name('admin.reportes.pagos_pendientes');
Route::get('admin/reportes/pagos_pendientes/exportar', [ReporteController::class, 'pagos_pendientes_exportar'])->name('admin.reportes.pagos_pendientes.exportar');

require __DIR__.'/auth.php';
