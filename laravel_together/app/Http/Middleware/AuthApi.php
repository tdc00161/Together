<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthApi
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
        if ($request->header('Accept') == 'application/json' || $request->is('api/*')) { // 주소 시작이 /api/ 인지
            return $next($request);
        } else {
            return abort(403, 'Unauthorized'); // HTTP 통신 중단 후 값 반환?
        }
    }
}
