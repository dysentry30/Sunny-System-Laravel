<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class UserNotAuthenticatedMiddleware
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
            if(auth()->user() != null) {
                return response()->json([
                    "status" => "Terautentikasi",
                ]);
            }
            return $next($request);
        }

        if (auth()->user() == null) {
            return $next($request);
        }

        if (Gate::allows("poc")) {
            return redirect("/rab-proyek");
        }

        if (Gate::allows("crm")) {
            return redirect("/dashboard");
        } elseif (Gate::allows("ccm")) {
            return redirect("/dashboard-ccm/perolehan-kontrak");
        } elseif (Gate::allows("csi")) {
            return redirect("/csi");
        } elseif (Gate::allows("ska-skt")) {
            return redirect("/ska-skt");
        }
    }
}
