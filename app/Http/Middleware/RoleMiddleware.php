<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  mixed  ...$roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$role)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();

        if (!in_array($user->role_id, $role)) {
            return redirect()->back()->with('error', 'Anda tidak punya akses ke halaman ini.');
        }

        return $next($request);
    }
}