<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KultureController;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\GoogleController;
use App\Models\Candidato;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\CandidatoController;
use App\Http\Controllers\EncuestaController;
use App\Http\Controllers\SatisfaccionController;
use App\Http\Controllers\FactoresController;
use App\Http\Controllers\BournoutController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\ProductividadController;
use App\Http\Controllers\TableroController;
use App\Http\Controllers\Emp_UsuariosController;
use App\Http\Controllers\EmpresasController;
use App\Models\Empresas;
use App\Models\Emp_Usuarios;
use App\Models\Provincia;
use App\Models\Localidad;
use App\Http\Controllers\ProvinciaController;
use App\Http\Controllers\EmpresaImportController;
use App\Http\Controllers\ParticipantesController;




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

// rutas principales

Route::get('/',[KultureController::class, 'index'])->name('candidatos.inicio');
Route::get('/candidatos/inicio',[KultureController::class, 'index'])->name('candidatos.inicio');

Route::get('/usuarios/registro',[UsuariosController::class, 'registro'])->name('usuarios.registro');
Route::post('/usuarios/store',[UsuariosController::class, 'store'])->name('usuarios.store');
Route::get('/dashboard', function () {
    return view('candidatos.dashboard'); // Especifica la ruta completa
})->name('candidatos.dashboard');


Route::get('/candidatos/home', [KultureController::class, 'home'])->name('candidatos.home');

Route::get('/usuarios/login',[UsuariosController::class, 'login'])->name('usuarios.login');
Route::post('/usuarios/authenticate',[UsuariosController::class, 'authenticate'])->name('usuarios.authenticate');

Route::get('/usuarios/logout',[KultureController::class, 'logout'])->name('usuarios.logout');

Route::post('/logout', [KultureController::class, 'logout'])->name('logout');

Route::get('/google/login',[GoogleController::class, 'login'])->name('google.login');
Route::get('/google/callback',[GoogleController::class, 'callback'])->name('google.callback');


Route::get('/candidatos/plantilla_datos_adicionales', [CandidatoController::class, 'plantillaDatosAdicionales'])->name('candidatos.plantilla_datos_adicionales');

Route::put('candidatos/{id}/actualizar', [CandidatoController::class, 'actualizarDatos'])->name('candidatos.actualizarDatos');



Route::get('/instrucciones', [CandidatoController::class, 'instrucciones'])->name('candidatos.instrucciones');
Route::get('/datos-personales', [CandidatoController::class, 'datosPersonales'])->name('candidatos.datosPersonales');
Route::get('/analisis-cultural', [CandidatoController::class, 'analisisCultural'])->name('candidatos.analisisCultural');
Route::get('/satisfaccion-laboral', [CandidatoController::class, 'satisfaccionLaboral'])->name('candidatos.satisfaccionLaboral');
Route::get('/factores-sociales', [CandidatoController::class, 'factoresSociales'])->name('candidatos.factoresSociales');
Route::get('/burnout', [CandidatoController::class, 'burnout'])->name('candidatos.burnout');
Route::get('/feedback', [CandidatoController::class, 'feedback'])->name('candidatos.feedback');

Route::get('/tablero', [CandidatoController::class, 'tablero'])->name('candidatos.plantilla_tablero');



Route::get('/candidatos/edit/{idcandidato}',[CandidatoController::class, 'edit'])->name('candidatos.edit');
Route::put('/candidatos/update/{idcandidato}',[CandidatoController::class, 'update'])->name('candidatos.update');



Route::get('/localidades/{idprovincia}', [CandidatoController::class, 'getLocalidades'])->name('localidades.get');
Route::get('/candidatos/localidades/{idprovincia}', [CandidatoController::class, 'getLocalidades']);


// routes/web.php


// analisis cultural

Route::get('/encuestas/{encuestaId}/{preguntaNumero?}', [EncuestaController::class, 'show'])->name('encuesta.show');
Route::post('/encuestas/guardar-directa/{preguntaId}', [EncuestaController::class, 'guardarOrden'])->name('encuesta.guardarOrden');
Route::post('/encuestas/finalizar/{preguntaId}/{idCandidato}', [EncuestaController::class, 'finalizarEncuesta'])->name('encuesta.finalizarEncuesta');
Route::post('/encuestas/guardar-respuesta-directa/{preguntaId}', [EncuestaController::class, 'guardarRespuestaDirecta'])->name('encuesta.guardarRespuestaDirecta');
Route::get('/encuestas/satisfaccion/{encuestaId}/{preguntaNumero?}', [EncuestaController::class, 'showSatisfaccion'])
    ->name('encuesta.showsatisfaccion');

// satisfaccion laboral

 Route::get('/encuestas/satisfaccion/{encuestaId}/{preguntaNumero?}', [SatisfaccionController::class, 'showsatisfaccion'])->name('encuesta.showsatisfaccion');
Route::post('/encuestas/satisfaccion/guardar-directa/{preguntaId}', [SatisfaccionController::class, 'guardarRespuestaDirecta'])->name('encuesta.guardarRespuestaDirecta');
 Route::post('/encuestas/satisfaccion/finalizar/{preguntaId}/{idCandidato}', [SatisfaccionController::class, 'finalizarSatisfaccion'])->name('encuesta.finalizarSatisfaccion');
 Route::post('/encuestas/satisfaccion/guardar-respuesta-directa/{preguntaId}', [SatisfaccionController::class, 'guardarRespuestaDirecta'])->name('encuesta.guardarRespuestaDirecta');
Route::get('/encuestas/factoressociales/{encuestaId}/{preguntaNumero?}', [SatisfaccionController::class, 'showFactoressociales'])->name('encuesta.showfactoressociales');

// factores sociales

 Route::get('/encuestas/factoressociales/{encuestaId}/{preguntaNumero?}', [FactoresController::class, 'showfactores'])->name('encuesta.showfactoressociales');
Route::post('/encuestas/factoressociales/guardar-directa/{preguntaId}', [FactoresController::class, 'guardarRespuestaDirecta'])->name('encuesta.guardarRespuestaDirecta');
Route::post('/encuestas/factoressociales/finalizar/{preguntaId}/{idCandidato}', [FactoresController::class, 'finalizarFactoressociales'])->name('encuesta.finalizarFactoressociales');
Route::post('/encuestas/factoressociales/guardar-respuesta-directa/{preguntaId}', [FactoresController::class, 'guardarRespuestaDirecta'])->name('encuesta.guardarRespuestaDirecta');
Route::get('/encuestas/bournout/{encuestaId}/{preguntaNumero?}', [FactoresController::class, 'showBournout'])->name('encuesta.showbournout');


// burnout

 Route::get('/encuestas/bournout/{encuestaId}/{preguntaNumero?}', [BournoutController::class, 'showbournout'])->name('encuesta.showbournout');
Route::post('/encuestas/bournout/guardar-directa/{preguntaId}', [BournoutController::class, 'guardarRespuestaDirecta'])->name('encuesta.guardarRespuestaDirecta');
Route::post('/encuestas/bournout/finalizar/{preguntaId}/{idCandidato}', [BournoutController::class, 'finalizarBournout'])->name('encuesta.finalizarBournout');
Route::post('/encuestas/bournout/guardar-respuesta-directa/{preguntaId}', [BournoutController::class, 'guardarRespuestaDirecta'])->name('encuesta.guardarRespuestaDirecta');



//Route::get('/encuestas/bournout', function () {
  //  return view('encuestas.bournout'); // Asegúrate de que la vista exista en resources/views/encuestas/bournout.blade.php
//})->name('encuestas.bournout');


    Route::get('/candidatos/home', [CandidatoController::class, 'homee'])->name('candidatos.home');
  

  Route::get('/encuestas/satisfaccionlaboral', [CandidatoController::class, 'satisfaccionLaboral'])->name('encuestas.showsatisfaccion');
    Route::get('/encuestas/factoressociales', [CandidatoController::class, 'factoresSociales'])->name('encuestas.showfactoressociales');


    //feedback
// Ruta para mostrar el formulario

    Route::get('/candidatos/feedback', [FeedbackController::class, 'vista'])->name('candidatos.feedback');
    
// Ruta para enviar el feedback
Route::post('/candidatos/feedback', [FeedbackController::class, 'store'])->name('feedback.store');

Route::get('/tablero', [TableroController::class, 'index'])->name('tablero.index');
Route::post('/productividad', [ProductividadController::class, 'store'])->name('productividad.store');
Route::post('/productividad/mover', [ProductividadController::class, 'mover'])->name('productividad.mover');
Route::get('/productividad/{tipo}', [ProductividadController::class, 'getDatos'])->name('productividad.getDatos');


// Recuperar contraseña rutas
Route::get('usuarios/password/forgot', [UsuariosController::class, 'showForgotPasswordForm'])->name('usuarios.password.forgot');
Route::post('usuarios/password/forgot', [UsuariosController::class, 'sendResetLink'])->name('usuarios.password.email');
Route::get('usuarios/password/reset/{token}', [UsuariosController::class, 'showResetPasswordForm'])->name('usuarios.password.reset');
Route::post('usuarios/password/reset', [UsuariosController::class, 'resetPassword'])->name('usuarios.password.update');


// Rutas de EMPRESA APARTADO 2

Route::get('/empresas/login',[Emp_UsuariosController::class, 'login'])->name('empresas.login');
Route::post('/empresas/authenticate',[Emp_UsuariosController::class, 'authenticate'])->name('empresas.authenticate');

Route::get('/usuarios/logout',[KultureController::class, 'logout'])->name('usuarios.logout');

Route::post('/logout', [KultureController::class, 'logout'])->name('logout');



// Ruta para la página de registro de empresas
Route::get('/empresas/registro', [Emp_UsuariosController::class, 'create'])->name('empresas.registro');

// Ruta para manejar el formulario de registro
Route::post('/empresas/registro', [Emp_UsuariosController::class, 'store'])->name('empresas.store');



Route::get('/empresas/login',[Emp_UsuariosController::class, 'login'])->name('empresas.login');
Route::post('/empresas/authenticate',[Emp_UsuariosController::class, 'authenticate'])->name('empresas.authenticate');



Route::get('empresas/password/forgot', [Emp_UsuariosController::class, 'showForgotPasswordFormEmp'])->name('empresas.password.forgot');
Route::post('empresas/password/forgot', [Emp_UsuariosController::class, 'sendResetLinkEmp'])->name('empresas.password.email');
Route::get('empresas/password/reset/{token}', [Emp_UsuariosController::class, 'showResetPasswordFormEmp'])->name('empresas.password.reset');
Route::post('empresas/password/reset', [Emp_UsuariosController::class, 'resetPasswordEmp'])->name('empresas.password.update');


Route::middleware(['auth:emp_usuarios'])->group(function () {
    Route::get('/dashboardemp', function () {
        return view('empresas.dashboard');
    })->name('empresas.dashboard');

    Route::get('/empresas/home', [EmpresasController::class, 'homee'])->name('empresas.home');
    Route::get('/empresas/datos', [EmpresasController::class, 'datos'])->name('empresas.datos');
    Route::get('/empresas/importar', [EmpresasController::class, 'importar'])->name('empresas.importar');
    Route::post('/empresas/importar', [EmpresaImportController::class, 'importar'])->name('empresas.importar');
    Route::get('/empresas/panel', [EmpresasController::class, 'panel'])->name('empresas.panel');
    Route::get('/configuracion', [EmpresasController::class, 'configuracion'])->name('empresas.configuracion');
    Route::get('/empresas/edit/{idempresa}', [EmpresasController::class, 'edit'])->name('empresas.datos');
    Route::put('/empresas/update/{idempresa}', [EmpresasController::class, 'update'])->name('empresas.update');
    Route::get('/localidades/{idprovincia}', [ProvinciaController::class, 'getLocalidades'])->name('localidades.get');
Route::get('/participantes/data', [ParticipantesController::class, 'getData'])->name('participantes.data');
Route::get('/departamentos/list', [ParticipantesController::class, 'listDepartments'])->name('departamentos.list');
});
