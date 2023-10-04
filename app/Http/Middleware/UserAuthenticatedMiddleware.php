<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UserAuthenticatedMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(str_contains($request->url(), "api")) {
            if (auth()->user() != null) {
                return $next($request);
            }
            $resp = [
                "status_code" => 401,
                "msg" => "Tidak terautentikasi"
            ];
            return response()->json($resp, 401);
        }

        if (auth()->user() != null) {
            return $next($request);
        }
        return redirect("/");
    }
}
