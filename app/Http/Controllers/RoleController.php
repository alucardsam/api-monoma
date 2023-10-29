<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class RoleController extends Controller
{
  public static function hasAnyRole($roles)
  {
    try {
      return Usuario::find(JWTController::getUserID())->hasAnyRole($roles);
    } catch (\Exception $e) {
      throw ValidationException::withMessages([$e->getMessage()]);
    }
  }

  public static function hasRoleManager()
  {
    try {
      return Usuario::find(JWTController::getUserID())->hasRole('manager');
    } catch (\Exception $e) {
      throw ValidationException::withMessages([$e->getMessage()]);
    }
  }

  public static function hasPermissionTo($permission)
  {
    try {
      return Usuario::find(JWTController::getUserID())->hasPermissionTo($permission);
    } catch (\Exception $e) {
      throw ValidationException::withMessages([$e->getMessage()]);
    }
  }
}
