<?php

namespace App\Interfaces;

interface UsuarioRepositoryInterface
{
  public static function getUsuarioByUserName($username);
  public static function setLastLoginByUserID($id, $data);
  public static function getAnyRoleByUserID($id, $roles);
  public static function getRoleByUserID($id, $role);
  public static function getPermissionToByUserID($id, $permission);
}
