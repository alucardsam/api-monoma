<?php

namespace App\Http\Middleware;

use App\Http\Controllers\RoleController;
use App\Http\Resources\MetaFalseResource;
use Closure;
use Illuminate\Http\Request;

class CheckRole
{
  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
   * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
   */
  public function handle(Request $request, Closure $next, $role)
  {
    $roles = is_array($role) ? $role : explode('|', $role);
    $hasAnyRole = RoleController::hasAnyRole($roles);
    if (!$hasAnyRole) {
      return response()->json(MetaFalseResource::make((object) ['errors' => 'User has not privilege']), 403);
    }
    return $next($request);
  }
}
