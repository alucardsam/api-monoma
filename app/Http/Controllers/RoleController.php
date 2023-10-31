<?php

namespace App\Http\Controllers;

use App\Interfaces\UsuarioRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class RoleController extends Controller
{
  private static $usuarioRepository;

  public function __construct(UsuarioRepositoryInterface $usuarioRepository)
  {
    self::$usuarioRepository = $usuarioRepository;
  }

  public static function hasAnyRole($roles)
  {
    try {
      $id = JWTController::getUserID();
      return self::$usuarioRepository::getAnyRoleByUserID($id, $roles);
    } catch (\Exception $e) {
      throw ValidationException::withMessages([$e->getMessage()]);
    }
  }

  public static function hasRoleManager()
  {
    try {
      $id = JWTController::getUserID();
      $role = 'manager';
      return self::$usuarioRepository::getRoleByUserID($id, $role);
    } catch (\Exception $e) {
      throw ValidationException::withMessages([$e->getMessage()]);
    }
  }

  public static function hasPermissionTo($permission)
  {
    try {
      $id = JWTController::getUserID();
      return self::$usuarioRepository::getPermissionToByUserID($id, $permission);
    } catch (\Exception $e) {
      throw ValidationException::withMessages([$e->getMessage()]);
    }
  }
}
