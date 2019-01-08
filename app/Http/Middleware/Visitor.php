<?php

namespace App\Http\Middleware;

use Closure;
use App\User;

class Visitor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (auth()->check() && auth()->user()->is_admin === User::ROLE_VISITOR) {
            return $next($request);
        }

        return redirect()->route('login');
    }
}
