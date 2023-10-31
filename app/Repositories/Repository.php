<?php

namespace App\Repositories;

use App\Models\Candidato;
use App\Models\Usuario;
use App\Interfaces\RepositoryInterface;

class Repository implements RepositoryInterface
{
  public static function getUsuarioByUserID($id)
  {
    return Usuario::find($id);
  }

  public static function getUsuarioByUserName($username)
  {
    return Usuario::where('username', $username)->first();
  }

  public static function setLastLoginByUserID($id, $data)
  {
    $usuario = Usuario::find($id);
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

  public static function getAllCandidatos()
  {
    return Candidato::all();
  }

  public static function getCandidatosByOwner($id)
  {
    return Candidato::where('owner', $id)->get();
  }

  public static function getCandidatosByID($id)
  {
    return Candidato::find($id);
  }

  public static function getCandidatosOwnerByID($id, $idUsuario)
  {
    return Candidato::where('id', $id)->where('owner', $idUsuario)->first();
  }

  public static function createCandidato($data)
  {
    return Candidato::create($data);
  }
}
