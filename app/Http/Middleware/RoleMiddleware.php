<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $role)
    {
        $userRoles = auth()->user()->roles;

        $needCheckRoles = explode('|', $role);

        info('userRoles:', $userRoles->toArray());
        info('needCheckRoles:',$needCheckRoles);

        foreach ($needCheckRoles as $needCheckRole) {
            if ($userRoles->where('name', $needCheckRole)->count() > 0) {
                return $next($request);
            }
        }


        return response()->json([
            'message' => "Unauthorized",
        ], 401);
                
    }
}
