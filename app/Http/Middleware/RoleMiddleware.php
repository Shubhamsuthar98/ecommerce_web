<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // var_dump($request->user()->role);
        // var_dump($role);
        // die;

        if (!Auth::check()) {
            return redirect('login');
        }

        $userRole = Auth::user()->role;

        if ($userRole !== $role) {

            // dd($userRole === 'admin' && $request->route()->getName() === 'dashboard');

            if ($userRole === 'admin') {
                return redirect('/admin/dashboard');
            }

            // if ($userRole !== 'admin' && $request->route()->getName() === 'admin/dashboard') {
            return redirect('/dashboard');
            // }
        }
        return $next($request);
    }
}
