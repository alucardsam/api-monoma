<?php

#use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\CandidatoController;
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

/* Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
}); */

Route::post('auth', [UsuarioController::class, 'login'])->name('api.auth.login');
Route::middleware('checkJWT')->group(function() {
  Route::middleware(['CheckRole:manager|agent'])->get('leads', [CandidatoController::class, 'index'])->name('api.leads.index');
  Route::middleware(['CheckRole:manager|agent'])->get('lead/{id}', [CandidatoController::class, 'show'])->name('api.lead.show');
  Route::middleware(['CheckRole:manager'])->post('lead', [CandidatoController::class, 'create'])->name('api.lead.create');
});
