<?php

namespace App\Http\Middleware;

use Closure;
use AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;

class IsKordinator
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    public function handle(Request $request, Closure $next)
    {
        if (auth()->user()->level == "Kordinator Kabupaten") {
            return $next($request);
        }

        return redirect('/petugas/dashboard');
    }
}
