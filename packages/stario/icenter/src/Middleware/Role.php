<?php

namespace Star\Icenter\Middleware;

use Closure;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role, $permission = null)
    {
        if (!$request->user()->hasRole($role)) {
            return response()->json([
                'result' => '您没有访问权限'
            ], 403);
        }

        if (! $request->user()->can($permission)) {
            return response()->json([
                'result' => '您没有访问权限'
            ], 403);
         }
        return $next($request);
    }
}
