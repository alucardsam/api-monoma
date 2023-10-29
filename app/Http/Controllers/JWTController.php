<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Validation\ValidationException;

class JWTController extends Controller
{
  public static function createToken($payload)
  {
    try {
      return JWT::encode($payload, env('JWT_SECRET'), env('JWT_ALGORITHM'));
    } catch (\Exception $e) {
      throw ValidationException::withMessages([$e->getMessage()]);
    }
  }

  private static function existToken()
  {
    try {
      $request = request();
      if (!$request->hasHeader(env('JWT_HEADER')) && !empty(env('JWT_HEADER'))) {
        throw ValidationException::withMessages(['Token missing or invalid']);
      }
      return $request->bearerToken();
    } catch (\Exception $e) {
      throw ValidationException::withMessages([$e->getMessage()]);
    }
  }

  private static function validateToken($tokenDecoded)
  {
    try {
      $checkTokenDecoded = (!empty($tokenDecoded) && is_object($tokenDecoded));
      if (!$checkTokenDecoded) {
        throw ValidationException::withMessages(['Token invalid']);
      }
      $checkUserIDExistKey = (!isset($tokenDecoded->data->UserID));
      $checkUserID = (empty($tokenDecoded->data->UserID) || !is_numeric($tokenDecoded->data->UserID));
      if ($checkUserIDExistKey || $checkUserID) {
        throw ValidationException::withMessages(['UserID missing or invalid']);
      }
      $checkIATExistKey = (!isset($tokenDecoded->iat));
      $checkIAT = (empty($tokenDecoded->iat) || !is_numeric($tokenDecoded->iat));
      if ($checkIATExistKey || $checkIAT) {
        throw ValidationException::withMessages(['Emit time missing']);
      }
      $timeDifference = time() - ($tokenDecoded->iat + env('JWT_TTL'));
      if ($timeDifference >= env('JWT_TTL')) {
        throw ValidationException::withMessages(['Token expired, please try the request again']);
      }
      return $tokenDecoded->data;
    } catch (\Exception $e) {
      throw ValidationException::withMessages([$e->getMessage()]);
    }
  }

  public static function getUserData()
  {
    try {
      $existToken = self::existToken();
      JWT::$leeway = 30;
      $tokenDecoded = JWT::decode($existToken, new Key(env('JWT_SECRET'), env('JWT_ALGORITHM')));
      return self::validateToken($tokenDecoded);
    } catch (\Exception $e) {
      throw ValidationException::withMessages([$e->getMessage()]);
    }
  }

  public static function getUserID()
  {
    try {
      $userData = self::getUserData();
      return $userData->UserID;
    } catch (\Exception $e) {
      throw ValidationException::withMessages([$e->getMessage()]);
    }
  }

  public static function getTTLtoMinutes()
  {
    return env('JWT_TTL') / 60;
  }
}
