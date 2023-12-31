<?php

namespace App\Http\Controllers;

use App\Http\Requests\CandidatoCreateRequest;
use App\Http\Resources\CandidatoCollection;
use App\Http\Resources\MetaFalseResource;
use App\Http\Resources\MetaTrueResource;
use App\Interfaces\RepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Validation\ValidationException;

define('MSG_403', 'User has not privilege');

class CandidatoController extends Controller
{
  private static $repository;

  public function __construct(RepositoryInterface $repository)
  {
    self::$repository = $repository;
  }

  public function index(Request $request)
  {
    try {
      $idUsuario = JWTController::getUserID();
      $hasPermissionTo = self::$repository::getPermissionToByUserID($idUsuario, 'api.leads.index');
      if (!$hasPermissionTo) {
        return response()->json(MetaFalseResource::make((object) ['errors' => MSG_403]), 403);
      }
      $segundosExpiracion = 30;
      if (!Redis::get('candidatos_' . $idUsuario)) {
        $hasRoleManager = self::$repository::getRoleByUserID($idUsuario, 'manager');
        if ($hasRoleManager) {
          $candidatos = self::$repository::getAllCandidatos();
        } else {
          $candidatos = self::$repository::getCandidatosByOwner($idUsuario);
        }
        Redis::setex('candidatos_' . $idUsuario, $segundosExpiracion, serialize($candidatos));
      }
      return CandidatoCollection::make(unserialize(Redis::get('candidatos_' . $idUsuario)));
    } catch (\Exception $e) {
      throw ValidationException::withMessages([$e->getMessage()]);
    }
  }

  public function show($id)
  {
    try {
      $idUsuario = JWTController::getUserID();
      $hasPermissionTo = self::$repository::getPermissionToByUserID($idUsuario, 'api.lead.show');
      if (!$hasPermissionTo) {
        return response()->json(MetaFalseResource::make((object) ['errors' => MSG_403]), 403);
      }
      $hasRoleManager = self::$repository::getRoleByUserID($idUsuario, 'manager');
      if ($hasRoleManager) {
        $candidato = self::$repository::getCandidatosByID($id);
        $errorMessage = 'No lead found';
      } else {
        $candidato = self::$repository::getCandidatosOwnerByID($id, $idUsuario);
        $errorMessage = 'No lead found by owner';
      }
      if (!$candidato) {
        return response()->json(MetaFalseResource::make((object) ['errors' => $errorMessage]), 404);
      }
      return response()->json(MetaTrueResource::make((object) ['data' => $candidato]), 200);
    } catch (\Exception $e) {
      throw ValidationException::withMessages([$e->getMessage()]);
    }
  }

  public function create(CandidatoCreateRequest $request)
  {
    try {
      $idUsuario = JWTController::getUserID();
      $hasPermissionTo = self::$repository::getPermissionToByUserID($idUsuario, 'api.lead.create');
      if (!$hasPermissionTo) {
        return response()->json(MetaFalseResource::make((object) ['errors' => MSG_403]), 403);
      }
      $name = $request->input('name');
      $source = $request->input('source');
      $owner = $request->input('owner');
      $usuario = self::$repository::getUsuarioByUserID($owner);
      if (!$usuario) {
        throw ValidationException::withMessages(['Owner not found']);
      }
      $data = [
        'name' => $name,
        'source' => $source,
        'owner' => $owner,
        'created_by' => $idUsuario
      ];
      $nuevoCandidato = self::$repository::createCandidato($data);
      if ($nuevoCandidato) {
        $dataCandidato = self::$repository::getCandidatosByID($nuevoCandidato->id);
        return response()->json(MetaTrueResource::make((object) ['data' => $dataCandidato]), 201);
      } else {
        return response()->json(MetaFalseResource::make((object) ['errors' => 'Record not created']), 404);
      }
    } catch (\Exception $e) {
      throw ValidationException::withMessages([$e->getMessage()]);
    }
  }
}
