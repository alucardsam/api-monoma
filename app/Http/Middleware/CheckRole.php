<?php

namespace App\Http\Middleware;

use App\Http\Controllers\JWTController;
use App\Http\Resources\MetaFalseResource;
use App\Interfaces\RepositoryInterface;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CheckRole
{
  private static $repository;

  public function __construct(RepositoryInterface $repository)
  {
    self::$repository = $repository;
  }

  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
   * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
   */
  public function handle(Request $request, Closure $next, $role)
  {
    try {
      $roles = is_array($role) ? $role : explode('|', $role);
      $id = JWTController::getUserID();
      $hasAnyRole = self::$repository::getAnyRoleByUserID($id, $roles);
      if (!$hasAnyRole) {
        return response()->json(MetaFalseResource::make((object) ['errors' => 'User has not privilege']), 403);
      }
      return $next($request);
    } catch (\Exception $e) {
      throw ValidationException::withMessages([$e->getMessage()]);
    }
  }
}
