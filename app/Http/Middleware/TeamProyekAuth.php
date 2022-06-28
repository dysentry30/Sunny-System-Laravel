<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class TeamProyekAuth
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
            if(auth()->user() ) {
                return $next($request);
            }
            return response()->json([
                "status" => "Login terlebih dahulu",
            ]);
        }

        if(auth()->user()->check_team_proyek ) {
            return $next($request);
        }
        Alert::error('Error', 'Tidak bisa mengakses halaman ' . $request->path());

        return redirect()->back();
        // return app(UserSalesAuth::class)->handle($request, $next);

    }
}
