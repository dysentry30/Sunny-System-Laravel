<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class AdminAuth
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
        if (str_contains($request->url(), "api")) {
            if (auth()->user()) {
                return $next($request);
            }
            return response()->json([
                "status" => "Login terlebih dahulu",
            ]);
        }
        $allowed_url_admin_kontrak = join(" ", ["dashboard", "customer", "forecast", "proyek", "knowledge-base", "company", "sumber-dana", "dop", "pasal", "user", "team-proyek", "sbu", "unit-kerja", "document", "contract-management", "review-contract", "draft-contract", "issue-project", "question", "input-risk", "laporan-bulanan", "serah-terima", "claim", "claim-management", "approval-claim", "detail-claim", "kpi", "change-request", "kriteria-pasar", "addendum-contract", "mom-meeting", "perjanjian-kso", "dokumen-pendukung", "kontrak-tanda-tangan", "klarifikasi-negosiasi", "stage"]);
        $allowed_url_user_sales = join(" ", ["dashboard", "customer", "forecast", "proyek", "knowledge-base", "company", "sumber-dana", "pasal", "team-proyek", "dop", "sbu", "unit-kerja", "kriteria-pasar", "get-kabupaten", "get-kabupaten-coordinate"]);
        $allowed_url_team_proyek = join(" ", ["dashboard", "proyek", "contract-management", "review-contract", "draft-contract", "issue-project", "question", "input-risk", "laporan-bulanan", "serah-terima", "claim-management", "approval-claim", "detail-claim", "claim", "document", "user"]);
        $concat_allowed_url = "";

        if (auth()->user()->check_administrator) {
            return $next($request);
        }
        if (auth()->user()->check_admin_kontrak) {
            $concat_allowed_url .= $allowed_url_admin_kontrak;
        }
        if (auth()->user()->check_user_sales) {
            $concat_allowed_url .= $allowed_url_user_sales;

        }
        if (auth()->user()->check_team_proyek) {
            $concat_allowed_url .= $allowed_url_team_proyek;
        }
        $path = explode(" ", str_replace("-", " ", $request->path()));
        if (count($path) > 1) {
            foreach($path as $i => $p) {
                $path[$i] = ucfirst($p);
                
            }
            $path = join(" ", $path);
        } else {
            $path = ucfirst($path[0]);
        }
        if (str_contains($concat_allowed_url, $request->segment(1))) {
            return $next($request);
        }


        Alert::error('Error', 'Tidak bisa mengakses halaman ' . $path);

        return redirect("/proyek");
        // return app(AdminKontrakAuth::class)->handle($request, $next);

    }
}
