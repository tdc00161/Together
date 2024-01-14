<?php

namespace App\Http\Middleware;

use App\Events\OnOffline;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

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
            $userId = Auth::id();
            $value = Cache::get('online-'.$userId);
            Log::debug('$value '.$value);
            Log::debug('내 아이디 명으로 된 캐시: '.$userId);
            if (!$value) {
                OnOffline::dispatch(Auth::user());
                $OnOffline = new OnOffline(auth()->user());
                $OnOffline->whoOnline();
                Log::debug('처리');
                Cache::put('online-'.$userId, 'online request', 180);
            }
        }

        return $next($request);
    }
}
