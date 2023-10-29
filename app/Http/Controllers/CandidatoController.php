<?php

namespace App\Http\Controllers;

use App\Http\Requests\CandidatoCreateRequest;
use App\Http\Resources\CandidatoCollection;
use App\Http\Resources\MetaFalseResource;
use App\Http\Resources\MetaTrueResource;
use App\Models\Candidato;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Validation\ValidationException;

define('MSG_403', 'User has not privilege');

class CandidatoController extends Controller
{
  /**
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    try {
      $idUsuario = JWTController::getUserID();
      $hasPermissionTo = RoleController::hasPermissionTo('api.leads.index');
      if (!$hasPermissionTo) {
        return response()->json(MetaFalseResource::make((object) ['errors' => MSG_403]), 403);
      }
      $segundosExpiracion = 30;
      if (!Redis::get('candidatos_' . $idUsuario)) {
        $hasRoleManager = RoleController::hasRoleManager();
        if ($hasRoleManager) {
          $candidatos = Candidato::all();
        } else {
          $candidatos = Candidato::where('owner', $idUsuario)->get();
        }
        Redis::setex('candidatos_' . $idUsuario, $segundosExpiracion, serialize($candidatos));
      }
      return CandidatoCollection::make(unserialize(Redis::get('candidatos_' . $idUsuario)));
    } catch (\Exception $e) {
      throw ValidationException::withMessages([$e->getMessage()]);
    }
  }

  /**
   * @param \Illuminate\Http\Request $request
   * @param \App\Models\Candidato $candidato
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    try {
      $idUsuario = JWTController::getUserID();
      $hasPermissionTo = RoleController::hasPermissionTo('api.lead.show');
      if (!$hasPermissionTo) {
        return response()->json(MetaFalseResource::make((object) ['errors' => MSG_403]), 403);
      }
      $hasRoleManager = RoleController::hasRoleManager();
      if ($hasRoleManager) {
        $candidato = Candidato::where('id', $id);
        $errorMessage = 'No lead found';
      } else {
        $candidato = Candidato::where('id', $id)->where('owner', $idUsuario);
        $errorMessage = 'No lead found by owner';
      }
      if (!$candidato->first()) {
        return response()->json(MetaFalseResource::make((object) ['errors' => $errorMessage]), 404);
      }
      $dataCandidato = $candidato->first()->makeHidden(['updated_at']);
      return response()->json(MetaTrueResource::make((object) ['data' => $dataCandidato]), 200);
    } catch (\Exception $e) {
      throw ValidationException::withMessages([$e->getMessage()]);
    }
  }

  /**
   * @param \App\Http\Requests\CandidatoCreateRequest $request
   * @return \Illuminate\Http\Response
   */
  public function create(CandidatoCreateRequest $request)
  {
    try {
      $idUsuario = JWTController::getUserID();
      $hasPermissionTo = RoleController::hasPermissionTo('api.lead.create');
      if (!$hasPermissionTo) {
        return response()->json(MetaFalseResource::make((object) ['errors' => MSG_403]), 403);
      }
      $name = $request->input('name');
      $source = $request->input('source');
      $owner = $request->input('owner');
      $usuario = Usuario::where('id', $owner)->first();
      if (!$usuario) {
        throw ValidationException::withMessages(['Owner not found']);
      }
      $data = [
        'name' => $name,
        'source' => $source,
        'owner' => $owner,
        'created_by' => $idUsuario
      ];
      $nuevoCandidato = Candidato::create($data);
      if ($nuevoCandidato) {
        $dataCandidato = Candidato::find($nuevoCandidato->id)->makeHidden(['updated_at']);
        return response()->json(MetaTrueResource::make((object) ['data' => $dataCandidato]), 201);
      } else {
        return response()->json(MetaFalseResource::make((object) ['errors' => 'Record not created']), 404);
      }
    } catch (\Exception $e) {
      throw ValidationException::withMessages([$e->getMessage()]);
    }
  }
}
