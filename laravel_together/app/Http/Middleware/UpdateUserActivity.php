<?php

namespace App\Http\Middleware;

use App\Events\OnOffline;
use Closure;
use Illuminate\Http\Request;

class UpdateUserActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        if (auth()->check()) {
            auth()->user()->update([
                'last_activity' => now(),
            ]);
            $OnOffline = new OnOffline(auth()->user());
            $OnOffline->whoOnline();     
        }

        return $next($request);
    }
}
