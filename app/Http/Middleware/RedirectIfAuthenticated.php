<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::user();

                // Redirect based on user role
                if ($user->role === 'super_admin') {
                    return redirect()->route('superadmin.dashboard');
                } elseif ($user->role === 'agency_admin') {
                    return redirect()->route('admin.dashboard');
                } elseif ($user->role === 'check_in_staff') {
                    return redirect()->route('admin.checkin');
                } else {
                    return redirect()->route('dashboard'); // Regular passengers
                }
            }
        }

        return $next($request);
    }
}
