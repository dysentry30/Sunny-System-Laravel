<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ContractApproval;
use App\Models\PerubahanKontrak;
use App\Models\ProyekPISNew;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use stdClass;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ScheduleOtorisasiContract extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schedule:contract';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scheduller for Automatically Otorisasi Contract every first date of month';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            DB::beginTransaction();

            $dateStart = Carbon::now()->translatedFormat("d F Y H:i:s");
            sendNotifEmail("andias@wikamail.id", "RUNNING JOB OTORISASI CONTRACT", "Otorisasi otomatis sedang dijalankan pada hari : $dateStart", true, false);
            sendNotifEmail("fathur.rohman2353@gmail.com", "RUNNING JOB OTORISASI CONTRACT", "Otorisasi otomatis sedang dijalankan pada hari : $dateStart", true, false);

            $bulan_pelaporan = (int) date('m') != 1 ? (int) date("m") - 1 : 12;
            $tahun_pelaporan = $bulan_pelaporan == 1 ? date('Y') - 1 : date('Y');

            $claims = PerubahanKontrak::select([
                'id_perubahan_kontrak',
                'kode_proyek',
                'id_contract',
                'jenis_perubahan',
                'tanggal_perubahan',
                'uraian_perubahan',
                'proposal_klaim',
                'tanggal_pengajuan',
                'biaya_pengajuan',
                'nilai_disetujui',
                'waktu_pengajuan',
                'waktu_disetujui',
                'stage',
                'perubahan_kontrak.profit_center',
                'nilai_negatif',
                'kd_divisi'
            ])->join('proyek_pis_new', 'perubahan_kontrak.profit_center', '=', 'proyek_pis_new.profit_center')->get();
    
            if ($claims->isNotEmpty()) {

                $isExistContractApproval = ContractApproval::where("periode_laporan", $bulan_pelaporan)->where("tahun", $tahun_pelaporan)->where("is_approved", true)->get()?->groupBy("profit_center");

                if ($isExistContractApproval->isEmpty()) {
                    $approval = new ContractApproval();
                    $data_approval = $claims->map(function ($claim) use ($bulan_pelaporan, $tahun_pelaporan) {
                        $claim['id'] = Str::uuid()->toString();
                        $claim['periode_laporan'] = $bulan_pelaporan;
                        $claim['tahun'] = $tahun_pelaporan;
                        $claim['unit_kerja'] = $claim->ProyekPISNew->kd_divisi;
                        $claim['is_locked'] = true;
                        $claim['is_approved'] = true;
                        $claim->nilai_negatif = $claim->nilai_negatif ?: false;
                        $claim->makeHidden(['ProyekPISNew', 'id_perubahan_kontrak']); //Untuk menghilangkan relasi agar tidak masuk ke array
                        return $claim;
                    });

                    $is_success = $approval->insert($data_approval->toArray());
                } else {
                    $claims = $claims->groupBy("profit_center");
                    $data_approval = collect([]);
                    $approval = new ContractApproval();

                    $claimsExist = $isExistContractApproval->keys()->toArray();
                    $claims->sortKeys()->each(function ($item, $key) use ($claimsExist, $data_approval, $bulan_pelaporan, $tahun_pelaporan) {
                        if (!in_array($key, $claimsExist)) {
                            $data = $item->map(function ($claim) use ($bulan_pelaporan, $tahun_pelaporan) {
                                $claim['id'] = Str::uuid()->toString();
                                $claim['periode_laporan'] = $bulan_pelaporan;
                                $claim['tahun'] = $tahun_pelaporan;
                                $claim['unit_kerja'] = $claim->ProyekPISNew->kd_divisi;
                                $claim['is_locked'] = true;
                                $claim['is_approved'] = true;
                                $claim->nilai_negatif = $claim->nilai_negatif ?: false;
                                $claim->makeHidden(['ProyekPISNew', 'id_perubahan_kontrak']); //Untuk menghilangkan relasi agar tidak masuk ke array
                                return $claim;
                            });

                            $data_approval->push($data);
                        }
                    });

                    if ($data_approval->isNotEmpty()) {
                        $is_success = $approval->insert($data_approval->toArray());
                    }
                }
            }

            DB::commit();

            $contractApprovalData = ContractApproval::where("periode_laporan", $bulan_pelaporan)->where("tahun", $tahun_pelaporan)->where("is_approved", true)->get()->groupBy("profit_center");
            setLogging('Scheduller/ErrorApprovalCCM', "APPROVAL CCM => ", [
                "DATA" => $contractApprovalData->toArray() ?? [],
                "STATUS" => "SUCCESS"
            ]);
            if ($contractApprovalData->isNotEmpty()) {
                $contractApprovalData->each(function ($data, $profit_center) use ($bulan_pelaporan, $tahun_pelaporan) {
                    $isSuccessSendSAP = self::sendDataSAP($profit_center, $bulan_pelaporan, $tahun_pelaporan);
                    sleep(10);

                    $dateFinish = Carbon::now()->translatedFormat("d F Y H:i:s");
                    // sendNotifEmail("andias@wikamail.id", "FINISH RUNNING JOB OTORISASI CONTRACT $profit_center", "Otorisasi otomatis proyek $profit_center berhasil dijalankan pada hari : $dateFinish", true, false);
                    // sendNotifEmail("fathur.rohman2353@gmail.com", "FINISH RUNNING JOB OTORISASI CONTRACT $profit_center", "Otorisasi otomatis proyek $profit_center berhasil dijalankan pada hari : $dateFinish", true, false);
                    if ($isSuccessSendSAP) {

                        $data->each(function ($item) {
                            $newClaim = new PerubahanKontrak();
                            $newClaim->profit_center = $item->profit_center;
                            $newClaim->id_contract = $item->id_contract ?? null;
                            $newClaim->jenis_perubahan = $item->jenis_perubahan;
                            $newClaim->tanggal_perubahan = $item->tanggal_perubahan;
                            $newClaim->uraian_perubahan = $item->uraian_perubahan;
                            $newClaim->keterangan = $item->keterangan;
                            $newClaim->proposal_klaim = $item->proposal_klaim;
                            $newClaim->tanggal_pengajuan = $item->tanggal_pengajuan;
                            $newClaim->biaya_pengajuan = !empty($item->biaya_pengajuan) ? str_replace(".", "", $item->biaya_pengajuan) : null;
                            // $newClaim->waktu_pengajuan = !empty($data["biaya-pengajuan"]) ? $data["waktu-pengajuan"] : null;
                            $newClaim->nilai_negatif = $item->nilai_negatif;
                            $newClaim->waktu_pengajuan_new = $item->waktu_pengajuan_new;
                            $newClaim->periode_laporan = $item->periode_laporan != 12 ? $item->periode_laporan + 1 : 1;
                            $newClaim->tahun = $item->tahun;
                            $newClaim->stage = $item->stage;

                            $newClaim->save();
                        });

                        $namaProyek = $data->first()->proyek_name;
                        $dateFinish = Carbon::now()->translatedFormat("d F Y H:i:s");
                        // sendNotifEmail("andias@wikamail.id", "FINISH RUNNING JOB OTORISASI CONTRACT", "Otorisasi otomatis proyek $profit_center berhasil dijalankan pada hari : $dateFinish", true, false);
                        // sendNotifEmail("fathur.rohman2353@gmail.com", "FINISH RUNNING JOB OTORISASI CONTRACT", "Otorisasi otomatis proyek $profit_center berhasil dijalankan pada hari : $dateFinish", true, false);
                    } else {
                        $namaProyek = $data->first()->proyek_name;
                        $dateFinish = Carbon::now()->translatedFormat("d F Y H:i:s");
                        sendNotifEmail("andias@wikamail.id", "FAILED RUNNING JOB OTORISASI CONTRACT", "Otorisasi otomatis proyek $profit_center gagal dijalankan pada hari : $dateFinish", true, false);
                        sendNotifEmail("fathur.rohman2353@gmail.com", "FAILED RUNNING JOB OTORISASI CONTRACT", "Otorisasi otomatis proyek $profit_center gagal dijalankan pada hari : $dateFinish", true, false);
                    }
                });
            } else {
                $dateFinish = Carbon::now()->translatedFormat("d F Y H:i:s");
                // sendNotifEmail("andias@wikamail.id", "FAILED RUNNING JOB OTORISASI CONTRACT", "Otorisasi otomatis gagal dijalankan pada hari : $dateFinish . Karena tidak ada proyek", true, false);
                sendNotifEmail("fathur.rohman2353@gmail.com", "FAILED RUNNING JOB OTORISASI CONTRACT", "Otorisasi otomatis gagal dijalankan pada hari : $dateFinish . Karena tidak ada proyek", true, false);
            }
            
            return Command::SUCCESS;
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th->getMessage());
            sendNotifEmail("fathur.rohman2353@gmail.com", "RUNNING JOB OTORISASI CONTRACT FAIL", $th->getMessage(), true, false);
            return Command::FAILURE;
        }
    }

    private function sendDataSAP($profit_center, $periode_laporan, $tahun_laporan)
    {
        $claims_all = ContractApproval::whereIn("jenis_perubahan", ["VO", "Klaim"])
            ->whereIn("stage", [1, 2, 4, 5])
            ->where('profit_center', $profit_center)
            ->where('periode_laporan', '=', $periode_laporan)
            ->where('tahun', '=', $tahun_laporan)
            ->get();

        if ($claims_all->isEmpty()) {
            return true;
        }

        $tanggalLaporan = (int) (date("Y") . sprintf('%02d', $periode_laporan) . $tahun_laporan);

        $data_claims_potential = $claims_all->map(function ($item, $key) use ($claims_all, $tanggalLaporan) {

            $item_claim = $claims_all->groupBy("jenis_perubahan")->filter(function ($i, $key) use ($item) {
                return $key == $item->jenis_perubahan;
                // return $i->stage == 1;
            })->flatten();

            $claim_val = $item_claim->filter(function ($ic) use ($item) {
                if ($item->stage >= 1) {
                    return (int) $ic->stage >= 1;
                }
            })->count();

            // $claim_val = $item_claim->filter(function($ic) use($item){
            //     if ($item->stage == 4) {
            //         return (int) $ic->stage == 4;
            //     }elseif($item->stage == 5){
            //         return (int) $ic->stage == 5;
            //     } elseif ($item->stage >= 2) {
            //         return (int) $ic->stage >= 2;
            //     } elseif ($item->stage >= 1) {
            //         return (int) $ic->stage >= 1;
            //     }
            // })->count();

            // $claim_val = $item_claim->filter(function($ic) use($item){
            //     if($item->stage == 1 ){
            //         return $ic->stage == 1;
            //     }elseif($item->stage == 2){
            //         return $ic->stage == 2;
            //     }elseif($item->stage == 5){
            //         return $ic->stage == 5;
            //     }
            // })->count();

            $uraian_formatted = substr(preg_replace('/\s+/', ' ', str_replace('"', '', $item->uraian_perubahan)), 0, 255);
            $uraian_formatted = substr(preg_replace('/[\x{200B}-\x{200D}\x{FEFF}]/u', ' ', $uraian_formatted), 0, 255);
            $isProposalDuplicate = $claims_all->where("proposal_klaim", $item->proposal_klaim)->count() > 1;
            // $profit_center = $item->Proyeks->profit_center;
            $profit_center = $item->profit_center;
            $newClass = new stdClass();

            $newClass->NO_PROPOSAL_CLAIM = $item->proposal_klaim;
            $newClass->TANGGAL = $tanggalLaporan;
            $newClass->PROFIT_CTR = "$profit_center";
            $newClass->PROJECT_DEF = "$profit_center";
            $newClass->COMP_CODE = "A000";
            $newClass->ITEM_CLAIM = "$uraian_formatted";

            if ($item->stage >= 1) {
                $newClass->CLAIM_CAT = "ITEM POTENTIAL";
            };

            // if ($item->stage == 4) {
            //     $newClass->CLAIM_CAT = "ITEM NEGOTIATION";
            // }elseif($item->stage == 5){
            //     $newClass->CLAIM_CAT = "ITEM APPROVED";
            // } elseif ($item->stage >= 2) {
            //     $newClass->CLAIM_CAT = "ITEM SUBMISSION";
            // } elseif ($item->stage >= 1) {
            //     $newClass->CLAIM_CAT = "ITEM POTENTIAL";
            // };

            // if($item->stage == 2){
            //     $newClass->CLAIM_CAT = "ITEM DIAJUKAN";
            // }elseif($item->stage == 1){
            //     $newClass->CLAIM_CAT = "ITEM TARGET";
            // }elseif($item->stage == 5){
            //     $newClass->CLAIM_CAT = "ITEM DISETUJUI";
            // } elseif ($item->stage == 4) {
            //     $newClass->CLAIM_CAT = "ITEM NEGOSIASI";
            // };

            $newClass->CLAIM_VAL = $claim_val;

            if ($item->stage == 5) {
                if ($item->jenis_perubahan == "VO") {
                    if ($isProposalDuplicate) {
                        $sumClaimAmount = $claims_all->where("proposal_klaim", $item->proposal_klaim)->sum(function ($change) {
                            if ($change->nilai_negatif) {
                                return 0 - (int)$change->nilai_disetujui;
                            } else {
                                return $change->nilai_disetujui;
                            }
                        });

                        $newClass->CLAIM_AMOUNT = $sumClaimAmount;
                    } else {
                        if ($item->nilai_negatif) {
                            $newClass->CLAIM_AMOUNT = 0 - (int)$item->nilai_disetujui;
                        } else {
                            $newClass->CLAIM_AMOUNT = (int)$item->nilai_disetujui;
                        }
                    }
                } else {
                    if ($isProposalDuplicate) {
                        $sumClaimAmount = $claims_all->where("proposal_klaim", $item->proposal_klaim)->sum(function ($change) {
                            return $change->nilai_disetujui;
                        });

                        $newClass->CLAIM_AMOUNT = $sumClaimAmount;
                    } else {
                        $newClass->CLAIM_AMOUNT = (int)$item->nilai_disetujui;
                    }
                }
            } else {
                if ($item->jenis_perubahan == "VO") {
                    if ($isProposalDuplicate) {
                        $sumClaimAmount = $claims_all->where("proposal_klaim", $item->proposal_klaim)->sum(function ($change) {
                            if ($change->nilai_negatif) {
                                return 0 - (int)$change->biaya_pengajuan;
                            } else {
                                return $change->biaya_pengajuan;
                            }
                        });

                        $newClass->CLAIM_AMOUNT = $sumClaimAmount;
                    } else {
                        if ($item->nilai_negatif) {
                            $newClass->CLAIM_AMOUNT = 0 - (int)$item->biaya_pengajuan;
                        } else {
                            $newClass->CLAIM_AMOUNT = (int)$item->biaya_pengajuan;
                        }
                    }
                } else {
                    if ($isProposalDuplicate) {
                        $sumClaimAmount = $claims_all->where("proposal_klaim", $item->proposal_klaim)->sum(function ($change) {
                            return $change->nilai_disetujui;
                        });

                        $newClass->CLAIM_AMOUNT = $sumClaimAmount;
                    } else {
                        $newClass->CLAIM_AMOUNT = (int)$item->biaya_pengajuan;
                    }
                }
            }

            // $newClass->CLAIM_AMOUNT = (int)$item_claim->sum("biaya_pengajuan");

            // $newClass->CLAIM_VAL = $claims_all->groupBy("jenis_perubahan")->map(function($i, $key) use($item){
            //     return $key = $i->count();
            // })->get($item->jenis_perubahan);

            if ($item->jenis_perubahan == "Klaim") {
                $newClass->CATEGORY = "CLAIM";
            } else {
                $newClass->CATEGORY = "$item->jenis_perubahan";
            }

            return $newClass;
        })->values();

        $data_claims_submission = $claims_all->filter(function ($item) {
            return $item->stage >= 2;
        })->map(function ($item, $key) use ($claims_all, $tanggalLaporan) {

            $item_claim = $claims_all->groupBy("jenis_perubahan")->filter(function ($i, $key) use ($item) {
                return $key == $item->jenis_perubahan;
                // return $i->stage == 1;
            })->flatten();

            $claim_val = $item_claim->filter(function ($ic) use ($item) {
                if ($item->stage >= 2) {
                    return (int) $ic->stage >= 2;
                }
            })->count();

            // $claim_val = $item_claim->filter(function($ic) use($item){
            //     if($item->stage == 1 ){
            //         return $ic->stage == 1;
            //     }elseif($item->stage == 2){
            //         return $ic->stage == 2;
            //     }elseif($item->stage == 5){
            //         return $ic->stage == 5;
            //     }
            // })->count();

            $uraian_formatted = substr(preg_replace('/\s+/', ' ', str_replace('"', '', $item->uraian_perubahan)), 0, 255);
            $uraian_formatted = substr(preg_replace('/[\x{200B}-\x{200D}\x{FEFF}]/u', ' ', $uraian_formatted), 0, 255);
            $isProposalDuplicate = $claims_all->where("proposal_klaim", $item->proposal_klaim)->count() > 1;
            // $profit_center = $item->Proyeks->profit_center;
            $profit_center = $item->profit_center;
            $newClass = new stdClass();

            $newClass->NO_PROPOSAL_CLAIM = $item->proposal_klaim;
            $newClass->TANGGAL = $tanggalLaporan;
            $newClass->PROFIT_CTR = "$profit_center";
            $newClass->PROJECT_DEF = "$profit_center";
            $newClass->COMP_CODE = "A000";
            $newClass->ITEM_CLAIM = "$uraian_formatted";

            if ($item->stage >= 2) {
                $newClass->CLAIM_CAT = "ITEM SUBMISSION";
            }

            // if($item->stage == 2){
            //     $newClass->CLAIM_CAT = "ITEM DIAJUKAN";
            // }elseif($item->stage == 1){
            //     $newClass->CLAIM_CAT = "ITEM TARGET";
            // }elseif($item->stage == 5){
            //     $newClass->CLAIM_CAT = "ITEM DISETUJUI";
            // } elseif ($item->stage == 4) {
            //     $newClass->CLAIM_CAT = "ITEM NEGOSIASI";
            // };

            $newClass->CLAIM_VAL = $claim_val;

            if ($item->stage == 5) {
                if ($item->jenis_perubahan == "VO") {
                    if ($isProposalDuplicate) {
                        $sumClaimAmount = $claims_all->where("proposal_klaim", $item->proposal_klaim)->sum(function ($change) {
                            if ($change->nilai_negatif) {
                                return 0 - (int)$change->nilai_disetujui;
                            } else {
                                return $change->nilai_disetujui;
                            }
                        });

                        $newClass->CLAIM_AMOUNT = $sumClaimAmount;
                    } else {
                        if ($item->nilai_negatif) {
                            $newClass->CLAIM_AMOUNT = 0 - (int)$item->nilai_disetujui;
                        } else {
                            $newClass->CLAIM_AMOUNT = (int)$item->nilai_disetujui;
                        }
                    }
                } else {
                    if ($isProposalDuplicate) {
                        $sumClaimAmount = $claims_all->where("proposal_klaim", $item->proposal_klaim)->sum(function ($change) {
                            return $change->nilai_disetujui;
                        });

                        $newClass->CLAIM_AMOUNT = $sumClaimAmount;
                    } else {
                        $newClass->CLAIM_AMOUNT = (int)$item->nilai_disetujui;
                    }
                }
            } else {
                if ($item->jenis_perubahan == "VO") {
                    if ($isProposalDuplicate) {
                        $sumClaimAmount = $claims_all->where("proposal_klaim", $item->proposal_klaim)->sum(function ($change) {
                            if ($change->nilai_negatif) {
                                return 0 - (int)$change->biaya_pengajuan;
                            } else {
                                return $change->biaya_pengajuan;
                            }
                        });

                        $newClass->CLAIM_AMOUNT = $sumClaimAmount;
                    } else {
                        if ($item->nilai_negatif) {
                            $newClass->CLAIM_AMOUNT = 0 - (int)$item->biaya_pengajuan;
                        } else {
                            $newClass->CLAIM_AMOUNT = (int)$item->biaya_pengajuan;
                        }
                    }
                } else {
                    if ($isProposalDuplicate) {
                        $sumClaimAmount = $claims_all->where("proposal_klaim", $item->proposal_klaim)->sum(function ($change) {
                            return $change->nilai_disetujui;
                        });

                        $newClass->CLAIM_AMOUNT = $sumClaimAmount;
                    } else {
                        $newClass->CLAIM_AMOUNT = (int)$item->biaya_pengajuan;
                    }
                }
            }

            // $newClass->CLAIM_AMOUNT = (int)$item_claim->sum("biaya_pengajuan");

            // $newClass->CLAIM_VAL = $claims_all->groupBy("jenis_perubahan")->map(function($i, $key) use($item){
            //     return $key = $i->count();
            // })->get($item->jenis_perubahan);

            if ($item->jenis_perubahan == "Klaim") {
                $newClass->CATEGORY = "CLAIM";
            } else {
                $newClass->CATEGORY = "$item->jenis_perubahan";
            }

            return $newClass;
        })->values();

        $data_claims_filter = $claims_all->filter(function ($item) {
            return $item->stage == 4 || $item->stage == 5;
        })->map(function ($item, $key) use ($claims_all, $tanggalLaporan) {

            $item_claim = $claims_all->groupBy("jenis_perubahan")->filter(function ($i, $key) use ($item) {
                return $key == $item->jenis_perubahan;
                // return $i->stage == 1;
            })->flatten();

            $claim_val = $item_claim->filter(function ($ic) use ($item) {
                if ($item->stage == 4) {
                    return (int) $ic->stage == 4;
                } elseif ($item->stage == 5) {
                    return (int) $ic->stage == 5;
                }
            })->count();

            // $claim_val = $item_claim->filter(function($ic) use($item){
            //     if($item->stage == 1 ){
            //         return $ic->stage == 1;
            //     }elseif($item->stage == 2){
            //         return $ic->stage == 2;
            //     }elseif($item->stage == 5){
            //         return $ic->stage == 5;
            //     }
            // })->count();

            $uraian_formatted = substr(preg_replace('/\s+/', ' ', str_replace('"', '', $item->uraian_perubahan)), 0, 255);
            $uraian_formatted = substr(preg_replace('/[\x{200B}-\x{200D}\x{FEFF}]/u', ' ', $uraian_formatted), 0, 255);
            $isProposalDuplicate = $claims_all->where("proposal_klaim", $item->proposal_klaim)->count() > 1;
            // $profit_center = $item->Proyeks->profit_center;
            $profit_center = $item->profit_center;
            $newClass = new stdClass();

            $newClass->NO_PROPOSAL_CLAIM = $item->proposal_klaim;
            $newClass->TANGGAL = $tanggalLaporan;
            $newClass->PROFIT_CTR = "$profit_center";
            $newClass->PROJECT_DEF = "$profit_center";
            $newClass->COMP_CODE = "A000";
            $newClass->ITEM_CLAIM = "$uraian_formatted";

            if ($item->stage == 4) {
                $newClass->CLAIM_CAT = "ITEM NEGOTIATION";
            } elseif ($item->stage == 5) {
                $newClass->CLAIM_CAT = "ITEM APPROVED";
            }

            // if($item->stage == 2){
            //     $newClass->CLAIM_CAT = "ITEM DIAJUKAN";
            // }elseif($item->stage == 1){
            //     $newClass->CLAIM_CAT = "ITEM TARGET";
            // }elseif($item->stage == 5){
            //     $newClass->CLAIM_CAT = "ITEM DISETUJUI";
            // } elseif ($item->stage == 4) {
            //     $newClass->CLAIM_CAT = "ITEM NEGOSIASI";
            // };

            $newClass->CLAIM_VAL = $claim_val;

            if ($item->stage == 5) {
                if ($item->jenis_perubahan == "VO") {
                    if ($isProposalDuplicate) {
                        $sumClaimAmount = $claims_all->where("proposal_klaim", $item->proposal_klaim)->sum(function ($change) {
                            if ($change->nilai_negatif) {
                                return 0 - (int)$change->nilai_disetujui;
                            } else {
                                return $change->nilai_disetujui;
                            }
                        });

                        $newClass->CLAIM_AMOUNT = $sumClaimAmount;
                    } else {
                        if ($item->nilai_negatif) {
                            $newClass->CLAIM_AMOUNT = 0 - (int)$item->nilai_disetujui;
                        } else {
                            $newClass->CLAIM_AMOUNT = (int)$item->nilai_disetujui;
                        }
                    }
                } else {
                    if ($isProposalDuplicate) {
                        $sumClaimAmount = $claims_all->where("proposal_klaim", $item->proposal_klaim)->sum(function ($change) {
                            return $change->nilai_disetujui;
                        });

                        $newClass->CLAIM_AMOUNT = $sumClaimAmount;
                    } else {
                        $newClass->CLAIM_AMOUNT = (int)$item->nilai_disetujui;
                    }
                }
            } else {
                if ($item->jenis_perubahan == "VO") {
                    if ($isProposalDuplicate) {
                        $sumClaimAmount = $claims_all->where("proposal_klaim", $item->proposal_klaim)->sum(function ($change) {
                            if ($change->nilai_negatif) {
                                return 0 - (int)$change->biaya_pengajuan;
                            } else {
                                return $change->biaya_pengajuan;
                            }
                        });

                        $newClass->CLAIM_AMOUNT = $sumClaimAmount;
                    } else {
                        if ($item->nilai_negatif) {
                            $newClass->CLAIM_AMOUNT = 0 - (int)$item->biaya_pengajuan;
                        } else {
                            $newClass->CLAIM_AMOUNT = (int)$item->biaya_pengajuan;
                        }
                    }
                } else {
                    if ($isProposalDuplicate) {
                        $sumClaimAmount = $claims_all->where("proposal_klaim", $item->proposal_klaim)->sum(function ($change) {
                            return $change->nilai_disetujui;
                        });

                        $newClass->CLAIM_AMOUNT = $sumClaimAmount;
                    } else {
                        $newClass->CLAIM_AMOUNT = (int)$item->biaya_pengajuan;
                    }
                }
            }

            // $newClass->CLAIM_AMOUNT = (int)$item_claim->sum("biaya_pengajuan");

            // $newClass->CLAIM_VAL = $claims_all->groupBy("jenis_perubahan")->map(function($i, $key) use($item){
            //     return $key = $i->count();
            // })->get($item->jenis_perubahan);

            if ($item->jenis_perubahan == "Klaim") {
                $newClass->CATEGORY = "CLAIM";
            } else {
                $newClass->CATEGORY = "$item->jenis_perubahan";
            }

            return $newClass;
        })->values();

        $data_claims = $data_claims_potential->merge($data_claims_submission)->merge($data_claims_filter);

        // return response()->json($data_claims->toArray(), 200);
        // dump(
        //     $data_claims->toArray()
        // );

        // SAP DEV
        // // FIRST STEP SEND DATA TO BW
        // $csrf_token = "";
        // $content_location = "";
        // // $response = getAPI("https://wtappbw-qas.wika.co.id:44350/sap/bw4/v1/push/dataStores/yodaltes4/requests", [], [], false);
        // // $http = Http::withBasicAuth("WIKA_API", "WikaWika2022");
        // $get_token = Http::withBasicAuth("WIKA_API", "WikaWika2022")->withHeaders(["x-csrf-token" => "Fetch"])->get("https://wtappbw-dev.wika.co.id:44340/sap/bw4/v1/push/dataStores/zosbi006/requests");
        // $csrf_token = $get_token->header("x-csrf-token");
        // $cookie = "";
        // collect($get_token->cookies()->toArray())->each(function($c) use(&$cookie) {
        //     $cookie .= $c["Name"] . "=" . $c["Value"] . ";"; 
        // });

        // // SECOND STEP SEND DATA TO BW
        // $get_content_location = Http::withBasicAuth("WIKA_API", "WikaWika2022")->withHeaders(["x-csrf-token" => $csrf_token, "Cookie" => $cookie])->post("https://wtappbw-dev.wika.co.id:44340/sap/bw4/v1/push/dataStores/zosbi006/requests");
        // $content_location = $get_content_location->header("content-location");


        // // THIRD STEP SEND DATA TO BW
        // // dd($new_class->toJson());
        // $fill_data = Http::withBasicAuth("WIKA_API", "WikaWika2022")->withHeaders(["x-csrf-token" => $csrf_token, "Cookie" => $cookie, "content-type" => "application/json"])->post("https://wtappbw-dev.wika.co.id:44340/sap/bw4/v1/push/dataStores/zosbi006/dataSend?request=$content_location&datapid=1", $data_claims->toArray());

        // // FOURTH STEP SEND DATA TO BW
        // $closed_request = Http::withBasicAuth("WIKA_API", "WikaWika2022")->withHeaders(["x-csrf-token" => $csrf_token, "Cookie" => $cookie])->post("https://wtappbw-dev.wika.co.id:44340/sap/bw4/v1/push/dataStores/zosbi006/requests/$content_location/close");
        // // dd($closed_request, $data_claims, $fill_data);

        //-------------------------------------------------------------------------------------//


        //SAP PRODUCTION

        // FIRST STEP SEND DATA TO BW
        if (env("APP_ENV") == "production") {
            $results_response = collect();
            $csrf_token = "";
            $content_location = "";
            // $response = getAPI("https://wtappbw-qas.wika.co.id:44350/sap/bw4/v1/push/dataStores/yodaltes4/requests", [], [], false);
            // $http = Http::withBasicAuth("WIKA_API", "WikaWika2022");
            $get_token = Http::withBasicAuth("WIKA_API", "WikaWikaWika2022")->withHeaders(["x-csrf-token" => "Fetch"])->get("https://wtappbw-prd.wika.co.id:44360/sap/bw4/v1/push/dataStores/zosbi006/requests");
            $csrf_token = $get_token->header("x-csrf-token");
            $cookie = "";
            collect($get_token->cookies()->toArray())->each(function ($c) use (&$cookie) {
                $cookie .= $c["Name"] . "=" . $c["Value"] . ";";
            });

            // SECOND STEP SEND DATA TO BW
            $get_content_location = Http::withBasicAuth("WIKA_API", "WikaWikaWika2022")->withHeaders(["x-csrf-token" => $csrf_token, "Cookie" => $cookie])->post("https://wtappbw-prd.wika.co.id:44360/sap/bw4/v1/push/dataStores/zosbi006/requests");
            $content_location = $get_content_location->header("content-location");


            // THIRD STEP SEND DATA TO BW
            // dd($new_class->toJson());
            $fill_data = Http::withBasicAuth("WIKA_API", "WikaWikaWika2022")->withHeaders(["x-csrf-token" => $csrf_token, "Cookie" => $cookie, "content-type" => "application/json"])->post("https://wtappbw-prd.wika.co.id:44360/sap/bw4/v1/push/dataStores/zosbi006/dataSend?request=$content_location&datapid=1", $data_claims->toArray());
            $results_response->push($fill_data->body());

            // FOURTH STEP SEND DATA TO BW
            $closed_request = Http::withBasicAuth("WIKA_API", "WikaWikaWika2022")->withHeaders(["x-csrf-token" => $csrf_token, "Cookie" => $cookie])->post("https://wtappbw-prd.wika.co.id:44360/sap/bw4/v1/push/dataStores/zosbi006/requests/$content_location/close");
            $results_response->push($closed_request->body());
            // dd($closed_request, $data_claims, $fill_data);
            // integrationLog("OTORISASI CLAIMS", $data_claims->toJson(), json_encode(["x-csrf-token" => $csrf_token, "Cookie" => $cookie, "content-type" => "application/json"]), $fill_data->status(), $fill_data->body(), null, null);

            if ($fill_data->successful() && $closed_request->successful()) {
                $data_claims_array = $data_claims->toArray() ?? [];
                $data_claims_array["PERIODE"] = $tanggalLaporan;
                setLogging('Scheduller/ApprovalCCM', "APPROVAL CCM => ", [
                    "KODE_PROYEK" => $claims_all->first()?->profit_center,
                    "DATA" => $data_claims_array,
                    "STATUS" => "SUCCESS",
                    "RESPONSE SAP" => $results_response->toArray()
                ]);

                return true;
            } else {
                $data_claims_array = $data_claims->toArray() ?? [];
                $data_claims_array["PERIODE"] = $tanggalLaporan;
                setLogging('Scheduller/ErrorApprovalCCM', "APPROVAL CCM => ", [
                    "KODE_PROYEK" => $claims_all->first()?->profit_center,
                    "DATA" => $data_claims_array,
                    "STATUS" => "FAILED",
                    "RESPONSE SAP" => $results_response->toArray()
                ]);

                return false;
            }
        }

        return true;
    }
}
