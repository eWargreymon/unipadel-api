<?php

use App\Http\Controllers\TorneoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
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
Route::post('createTorneo', [TorneoController::class, 'store']);
Route::get('getTorneo/{id?}', [TorneoController::class, 'getTorneo']);
Route::get('getTorneosOrganizador/{organizador}', [TorneoController::class, 'getTorneosOrganizador']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
