<?php


namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;

class CheckForAdminUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, $next)
    {
        return Auth::user()->isAdmin() ?
            $next($request) : response(['error' => 'Access denied.']);
    }
}
