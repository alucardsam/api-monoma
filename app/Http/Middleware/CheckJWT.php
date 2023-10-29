<?php

namespace App\Http\Middleware;

use App\Http\Controllers\JWTController;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CheckJWT
{
  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
   * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
   */
  public function handle(Request $request, Closure $next)
  {
    try {
      $getUserData = JWTController::getUserData();
      if (empty($getUserData)) {
        throw ValidationException::withMessages(['JWT data no exist']);
      }
      return $next($request);
    } catch (\Exception $e) {
      throw ValidationException::withMessages([$e->getMessage()]);
    }
  }
}
