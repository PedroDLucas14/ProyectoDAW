<?php

use App\Http\Controllers\AccesorioController;
use App\Http\Controllers\GestionController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JuegoController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MercadoController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\NavesController;
use App\Http\Controllers\PilotosController;
use App\Http\Controllers\UsuariosAccesorioController;
use App\Http\Controllers\UsuariosNaveController;
use App\Http\Controllers\UsuariosPilotoController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Aquí es donde puede registrar rutas web para su aplicación. Estos
| Las rutas son cargadas por RouteServiceProvider y todas ellas
| asignarse al grupo de middleware "web".
|
*/

//Ruta Inicial
Route::controller(HomeController::class)->group(function () {
    Route::get('/', 'index')->name('home');
    Route::get('sobreNosotros', 'nosotros')->name('sobreNosotros');
});

//Rutas de los cruds

//------Gestión------//
Route::controller(GestionController::class)->group(function () {
    Route::get('/gestion', 'gestion')->name('gestion')->middleware('admin');
    Route::post('/gestion', 'gestion')->name('gestion')->middleware('admin');
    Route::get('/gestion/inventario', 'gestionInvetario')->name('gestionInventarios')->middleware('admin');
    Route::post('/gestion/inventario', 'gestionInvetario')->name('gestionInventarios')->middleware('admin');
});

//------Usuarios-----//
Route::controller(UsuariosController::class)->group(function () {
    Route::get('/gestion/usuarios', 'index')->name('listaUsuarios');
    Route::post('/gestion/usuarios', 'index')->name('listaUsuarios');
    Route::get('/gestion/usuarios/{usuario}/ver', 'show')->name('verUsuario');
    Route::get('/gestion/usuarios/crearUsuario', 'create')->name('añadirUsuario');
    Route::post('/gestion/usuarios/crearUsuario', 'store')->name('crearUsuario');
    Route::put('/gestion/usuarios/{usuario}/modificar', 'update')->name('modificarUsuario');
    Route::post('/gestion/usuarios/{usuario}/delete', 'destroy')->name('borrarUsuario');
});
//-----Naves--------
Route::controller(NavesController::class)->group(function () {
    Route::get('/gestion/naves', 'index')->name('listaNaves');
    Route::post('/gestion/naves', 'index')->name('listaNaves');
    Route::get('/gestion/naves/{nave}/ver', 'show')->name('verNave');
    Route::get('/gestion/naves/crearNave', 'create')->name('añadirNave');
    Route::post('/gestion/naves/crearNave', 'store')->name('crearNave');
    Route::put('/gestion/naves/{nave}/modificar', 'update')->name('modificarNave');
    Route::post('/gestion/naves/{nave}/delete', 'destroy')->name('borrarNave');
});
//----Pilotos-------
Route::controller(PilotosController::class)->group(function () {
    Route::get('/gestion/pilotos', 'index')->name('listaPilotos');
    Route::post('/gestion/pilotos', 'index')->name('listaPilotos');
    Route::get('/gestion/pilotos/{piloto}/ver', 'show')->name('verPiloto');
    Route::get('/gestion/pilotos/crearPiloto', 'create')->name('añadirPiloto');
    Route::post('/gestion/pilotos/crearPiloto', 'store')->name('crearPiloto');
    Route::put('/gestion/pilotos/{piloto}/modificar', 'update')->name('modificarPiloto');
    Route::post('/gestion/pilotos/{piloto}/delete', 'destroy')->name('borrarPiloto');
});
//Rutas de registro
Route::view('registro', 'registro.registro')->name('registro');
Route::post('/registro', [LoginController::class, 'registrar']);
Route::controller(LoginController::class)->group(function () {
    Route::view('/login', 'registro.login')->name('login');
    Route::get('/logout', 'logout')->name('salir');
    Route::post('login', 'login')->name('IniciarSesion');
});
//Rutas de accesorios
Route::controller(AccesorioController::class)->group(function () {
    Route::get('/gestion/accesorios', 'index')->name('listaAccesorios')->middleware('admin');
    Route::post('/gestion/accesorios', 'index')->name('listaAccesorios')->middleware('admin');
    Route::get('/gestion/accesorios/{accesorio}/ver', 'show')->name('verAccesorio')->middleware('admin');
    Route::get('/gestion/accesorios/crearAccesorio', 'create')->name('añadirAccesorio')->middleware('admin');
    Route::post('/gestion/accesorios/crearAccesorio', 'store')->name('crearAccesorio')->middleware('admin');
    Route::put('/gestion/accesorios/{accesorio}/modificar', 'update')->name('modificarAccesorio')->middleware('admin');
    Route::post('/gestion/accesorios/{accesorio}/delete', 'destroy')->name('borrarAccesorio')->middleware('admin');
});
//Rutas de inventario
//------Usuarios naves----------//
Route::controller(UsuariosNaveController::class)->group(function () {
    Route::get('/gestion/inventario/{usuario}/naves', 'index')->name('listaNavesUsuario')->middleware('admin');
    Route::get('/gestion/inventario/{usuario}/ver/naves/{usuariosNave}', 'show')->name('verUsuarioNave')->middleware('admin');
    Route::get('/gestion/inventario/crearUsuarioNave', 'create')->name('añadirUsuarioNave')->middleware('admin');
    Route::post('/gestion/inventario/crearUsuarioNave', 'store')->name('crearUsuarioNave')->middleware('admin');
    Route::put('/gestion/inventario/{usuarioNave}/modificar', 'update')->name('modificarUsuarioNave')->middleware('admin');
    Route::post('/gestion/invenario/{usuarioNave}/delete', 'destroy')->name('borrarUsuarioNave')->middleware('admin');
});
//------Usuarios pilotos----------//
Route::controller(UsuariosPilotoController::class)->group(function () {
    Route::get('/gestion/inventario/{usuario}/pilotos', 'index')->name('listaPilotosUsuario')->middleware('admin');
    Route::get('/gestion/inventario/{usuario}/ver/pilotos/{usuarioPiloto}', 'show')->name('verUsuarioPiloto')->middleware('admin');
    Route::get('/gestion/inventario/crearUsuarioPiloto', 'create')->name('añadirUsuarioPilto')->middleware('admin');
    Route::post('/gestion/inventario/crearUsuarioPiloto', 'store')->name('crearUsuarioPiloto')->middleware('admin');
    Route::put('/gestion/inventario/{usuarioPiloto}/modificar', 'update')->name('modificarUsuarioPiloto')->middleware('admin');
    Route::post('/gestion/inventario/{usuarioPiloto}/delete', 'destroy')->name('borrarUsuarioPiloto')->middleware('admin');
});

//-------Usuarios accesorio---------//
Route::controller(UsuariosAccesorioController::class)->group(function () {
    Route::get('/gestion/inventario/{usuario}/accesorios', 'index')->name('listaAccUsuario')->middleware('admin');
    Route::get('/gestion/inventario/{usuario}/ver/accesorios/{usuarioAccesorio}', 'show')->name('verAccUsuario')->middleware('admin');
    Route::get('/gestion/inventario/crearUsuarioAccesorio', 'create')->name('añadirAccUsuario')->middleware('admin');
    Route::post('/gestion/inventario/crearUsuarioAccesorio', 'store')->name('crearAccUsuario')->middleware('admin');
    Route::put('/gestion/inventario/{usuarioAccesorio}/modificar','update')->name('modificarAccUsuario')->middleware('admin');
    Route::post('/gestion/inventario/{usuarioAccesorio}/delete','destroy')->name('borrarAccUsuario')->middleware('admin');
});

//Rutas del juego
Route::controller(JuegoController::class)->group(function () {
    Route::get('/juego', 'lista')->name('jugar')->middleware('jugador');
    Route::post('/juego/iniciar', 'crearPartida')->name('iniciar');
    Route::post('/juego/batalla', 'iniciarBatalla')->name('batalla');
    Route::post('/juego/hacer', 'procedimientoJuego');
    Route::post('/juego/muestra', 'muestraBatalla');
    Route::get('/juego/recargar', 'recargar');
    Route::get('/clasificación', 'verClasificacion')->name('index.clasificacion');
    Route::post('/clasificación', 'verClasificacion');
});

//Rutas del perfil
Route::controller(PerfilController::class)->group(function () {
    Route::get('/perfil', 'verPerfil')->name('perfil.index');
    Route::post('/perfil', 'verPerfil')->name('perfil.update');
    Route::get('/perfil/inventario', 'inventario')->name('perfil.inventario');
    Route::post('/perfil/inventario', 'inventario')->name('perfil.inventario');
    Route::get('/perfil/historial', 'historial')->name('perfil.historial');
    Route::post("/perfil/inventario/compruebaSubida", 'compruebaSubida');
    Route::post('/perfil/inventario/subidaNivel', 'subirNiveles')->name('subirNivel');
    Route::get('/perfil/historial/ver/{cod_batalla}','verPartida')->name('verPartida');
    Route::post("/perfil/historial/ver/datosPartida",'datosPartida');
});


//Rutas del mercado
Route::controller(MercadoController::class)->group(function () {
    Route::get('/mercado', 'market')->name('mercado.ver');
    Route::post('/mercado', 'market')->name('mercado.ver');
    Route::get('/mercado/comprarPiloto/{piloto}', 'comprarPiloto')->name('comprar.piloto');
    Route::get('/mercado/comprarNave/{nave}', 'comprarNaves')->name('comprar.nave');
    Route::get('/mercado/comprarAccesorio/{accesorio}', 'comprarAccesorio')->name('comprar.accesorio');
});

//Rutas de errores
Route::view('/error', 'errores.error')->name('error');
