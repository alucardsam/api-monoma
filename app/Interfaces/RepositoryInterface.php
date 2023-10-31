<?php

namespace App\Interfaces;

interface RepositoryInterface
{
  public static function getUsuarioByUserID($id);
  public static function getUsuarioByUserName($username);
  public static function setLastLoginByUserID($id, $data);
  public static function getAnyRoleByUserID($id, $roles);
  public static function getRoleByUserID($id, $role);
  public static function getPermissionToByUserID($id, $permission);
  public static function getAllCandidatos();
  public static function getCandidatosByOwner($id);
  public static function getCandidatosByID($id);
  public static function getCandidatosOwnerByID($id, $idUsuario);
  public static function createCandidato($data);
}
