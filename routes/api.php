<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TorneoController;
use App\Http\Controllers\PartidosController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('createUser', [UserController::class, 'store']);
Route::get('getUser/{email?}', [UserController::class, 'getUser']);
Route::get('getJugadores/{nombre?}', [UserController::class, 'getJugadores']);
Route::post('createPareja', [UserController::class, 'createPareja']);
Route::get('getParejas/{email}', [UserController::class, 'getParejas']);

Route::post('createTorneo', [TorneoController::class, 'store']);
Route::post('createInscripcion', [TorneoController::class, 'inscripcion']);
Route::get('getTorneo/{id?}', [TorneoController::class, 'getTorneo']);

Route::get('getHorariosTorneo/{id}/{isTorneo}', [TorneoController::class, 'getHorariosTorneo']);
Route::get('getHorariosDisponibles/{id}', [TorneoController::class, 'getHorariosDisponibles']);
Route::delete('deleteHorario/{horario}', [TorneoController::class, 'deleteHorario']);

Route::get('getCanchaTorneo/{torneo}', [TorneoController::class, 'getCancha']);
Route::get('getTorneosOrganizador/{organizador}/{estado?}', [TorneoController::class, 'getTorneosOrganizador']);
Route::get('getTorneosJugador/{jugador}', [TorneoController::class, 'getTorneosJugador']);
Route::get('getInscripciones/{torneo}', [TorneoController::class, 'getInscripciones']);
Route::post('validatePareja', [TorneoController::class, 'validatePareja']);

Route::post('createRecurso', [TorneoController::class, 'createRecurso']);
Route::post('generateCalendario', [TorneoController::class, 'generateCalendario']);
Route::post('setHorarios', [TorneoController::class, 'setHorariosJornada']);

Route::get('getPartido/{id}/{torneo?}', [PartidosController::class, 'getPartido']);
Route::post('getPartidos', [PartidosController::class, 'getPartidos']);
Route::get('getJornadasTorneo/{torneo}', [PartidosController::class, 'getJornadasTorneo']);
Route::post('getPartidosTorneo', [PartidosController::class, 'getPartidosTorneo']);
Route::post('getPartidosTorneoPlayer', [PartidosController::class, 'getPartidosTorneoPlayer']);
Route::post('setHorarioPartido', [PartidosController::class, 'setHorarioPartido']);
Route::post('proponerHorarioPartido', [PartidosController::class, 'proponerHorarioPartido']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
