<?php

namespace App\Repositories;

use App\Interfaces\UsuarioRepositoryInterface;
use App\Models\Usuario;

class UsuarioRepository implements UsuarioRepositoryInterface
{

  public static function getUsuarioByUserName($username)
  {
    return Usuario::where('username', $username)->first()->makeVisible(['password']);
  }

  public static function setLastLoginByUserID($id, $data)
  {
    $usuario = Usuario::where('id', $id)->first();
    $usuario->last_login = $data['last_login'];
    $usuario->save();
  }

  public static function getAnyRoleByUserID($id, $roles)
  {
    return Usuario::find($id)->hasAnyRole($roles);
  }

  public static function getRoleByUserID($id, $role)
  {
    return Usuario::find($id)->hasRole($role);
  }

  public static function getPermissionToByUserID($id, $permission)
  {
    return Usuario::find($id)->hasPermissionTo($permission);
  }
}
