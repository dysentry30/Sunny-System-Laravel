<?php

namespace App\Http\Middleware;

use App\Models\RoleManagements;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
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
        // if (Auth::user() instanceof RoleManagements) {
        //     Auth::setUser(Auth::user()->User);
        // }
        // dd(Auth::user());
        if (str_contains($request->url(), "api")) {
            if (auth()->user()) {
                return $next($request);
            }
            return response()->json([
                "status" => "Login terlebih dahulu",
            ]);
        }
        $allowed_url_admin_kontrak = join(" ", [
            "dashboard-ccm",
            "check-current-password",
            "user",
            "dashboard",
            "customer",
            "proyek",
            "knowledge-base",
            "company",
            "sumber-dana",
            "dop",
            "pasal",
            "user",
            "team-proyek",
            "sbu",
            "unit-kerja",
            "document",
            "contract-management",
            "review-contract",
            "draft-contract",
            "issue-project",
            "question",
            "input-risk",
            "laporan-bulanan",
            "serah-terima",
            "claim",
            "claim-management",
            "approval-claim",
            "detail-claim",
            "kpi",
            "change-request",
            "kriteria-pasar",
            "addendum-contract",
            "mom-meeting",
            "perjanjian-kso",
            "dokumen-pendukung",
            "kontrak-tanda-tangan",
            "klarifikasi-negosiasi",
            "stage",
            "history-approval",
            "perubahan-kontrak",
            "jenis-dokumen",
            "document-template",
            "dokumen-site-instruction",
            "dokumen-technical-form",
            "dokumen-technical-query",
            "dokumen-field-design-change",
            "dokumen-contract-change-notice",
            "dokumen-contract-change-order",
            "dokumen-contract-change-proposal",
            "perubahan-kontrak",
            "pasal-kontraktual",
            "checklist-manajemen-kontrak",
            "asuransi-pelaksanaan",
            "jaminan-pelaksanaan",
            "get-progress",
        ]);
        $allowed_url_user_sales = join(" ", [
            "rekomendasi",
            "rkap",
            "history-autorisasi",
            "check-current-password",
            "user",
            "tipe-proyek",
            "jenis-proyek",
            "mata-uang",
            "request-approval-history",
            "dashboard",
            "customer",
            "forecast",
            "forecast-kumulatif-eksternal",
            "forecast-kumulatif-eksternal-internal",
            "proyek",
            "knowledge-base",
            "company",
            "sumber-dana",
            "pasal",
            "team-proyek",
            "dop",
            "sbu",
            "unit-kerja",
            "kriteria-pasar",
            "get-kabupaten",
            "get-kabupaten-coordinate",
            "document",
            "forecast-internal",
            "download-pareto",
            "download",
            "proyek-datatables",
            "kriteria-pengguna-jasa",
            "company-profile",
            "laporan-keuangan",
            "green-lane",
            "non-green-lane",
            "AHU",
            "nota-rekomendasi-2"
        ]);
        $allowed_url_team_proyek = join(" ", ["dashboard", "proyek", "contract-management", "review-contract", "draft-contract", "issue-project", "question", "input-risk", "laporan-bulanan", "serah-terima", "claim-management", "approval-claim", "detail-claim", "claim", "document", "user"]);
        $concat_allowed_url = "";
        if (Gate::any(['super-admin', 'admin-crm'])) {
            return $next($request);
        }
        if (Gate::allows('ccm')) {
            $concat_allowed_url .= $allowed_url_admin_kontrak;
        }
        if (Gate::any(['crm', 'csi'])) {
            if (!str_contains(Auth::user()->email, "@wika-customer")) {
                $concat_allowed_url .= $allowed_url_user_sales;
            } else {
                $concat_allowed_url .= join(" ", ["/csi/customer-survey"]);
            }
        }
        if (auth()->user()->check_team_proyek) {
            $concat_allowed_url .= $allowed_url_team_proyek;
        }
        $path = explode(" ", str_replace("-", " ", $request->path()));
        if (count($path) > 1) {
            foreach ($path as $i => $p) {
                $path[$i] = ucfirst($p);
            }
            $path = join(" ", $path);
        } else {
            $path = ucfirst($path[0]);
        }
        if (!auth()->user()->is_active) {
            Auth::logout();
            Alert::error("USER NON ACTIVE", "Hubungi Admin (PIC)");
            // return redirect("/");
            return redirect(env('WZONE_URL'));
        }
        if ($request->segment(1) == "user" && Gate::denies('admin-crm')) {
            if (str_contains($concat_allowed_url, $request->segment(1)) && ($request->segment(2) == "view" || $request->segment(2) == "password" || $request->segment(2) == "update")) {
                return $next($request);
            } else {
                Alert::error('Error', 'Tidak bisa mengakses halaman ' . $path);

                return redirect("/proyek");
            }
        } else {
            if (str_contains($concat_allowed_url, $request->segment(1))) {
                return $next($request);
            }
        }


        Alert::error('Error', 'Tidak bisa mengakses halaman ' . $path);

        return redirect("/proyek");
        // return app(AdminKontrakAuth::class)->handle($request, $next);

    }
}