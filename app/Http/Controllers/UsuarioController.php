<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsuarioLoginRequest;
use App\Http\Resources\MetaTrueResource;
use App\Interfaces\RepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UsuarioController extends Controller
{
  private static $Repository;

  public function __construct(RepositoryInterface $Repository)
  {
    self::$Repository = $Repository;
  }

  public function login(UsuarioLoginRequest $request)
  {
    try {
      $username = $request->input('username');
      $pwd = $request->input('password');
      $usuario = self::$Repository::getUsuarioByUserName($username);
      if (!$usuario) {
        throw ValidationException::withMessages(['Username or Password incorrect']);
      }
      $checkPassword = Hash::check($pwd, $usuario->makeVisible(['password'])->password);
      if (!$checkPassword) {
        throw ValidationException::withMessages(['Password incorrect for: ' . $username]);
      }
      $dataJWT = [
        'iss' => env('APP_URL'),
        'aud' => env('APP_URL'),
        'iat' => time(),
        'nbf' => time(),
        'sub' => env('APP_NAME'),
        'data' => [
          'UserID' => $usuario->id,
          'UserName' => $usuario->username,
          'Role' => $usuario->role,
        ],
      ];
      $token = JWTController::createToken($dataJWT);
      $dataLastLogin = [
        'last_login' => date("Y-m-d H:i:s")
      ];
      self::$Repository::setLastLoginByUserID($usuario->id, $dataLastLogin);
      $data = [
        'token' => $token,
        'minutes_to_expire' => JWTController::getTTLtoMinutes()
      ];
      return response()->json(MetaTrueResource::make((object) ['data' => $data]), 200);
    } catch (\Exception $e) {
      throw ValidationException::withMessages([$e->getMessage()]);
    }
  }
}
