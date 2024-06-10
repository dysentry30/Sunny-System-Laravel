<?php

// if(!function_exists("url_encode")) {
// }

use App\Models\Customer;
use App\Models\Provinsi;
use App\Models\IndustryOwner;
use PhpOffice\PhpWord\PhpWord;
use Karriere\PdfMerge\PdfMerge;
use Illuminate\Http\UploadedFile;
use App\Models\KriteriaAssessment;
use App\Models\KriteriaPenggunaJasa;
use App\Models\KriteriaPenggunaJasaDetail;
use App\Models\LegalitasPerusahaan;
use App\Models\NotaRekomendasi;
use App\Models\ExceptGreenlane;
use App\Models\IntegrationLog;
use App\Models\PenilaianPenggunaJasa;
use App\Models\Proyek;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use PhpOffice\PhpWord\TemplateProcessor;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

function url_encode($url) {
    return urlencode(urlencode($url));
}

function url_decode($url) {
    return urldecode(urldecode($url));
}

function getPeriode($periode)
{
    return [(int) substr($periode, 0, 4), (int) substr($periode, 4, 2)];
}

function arrayToXML($array, &$xml_data)
{
    foreach ($array as $key => $value) {
        // $xml_data->addAttribute('type', 'application/xml');
        if (is_array($value)) {
            if (is_numeric($key)) {
                $key = 'entry'; //dealing with <0/>..<n/> issues
            }
            // $subnode = $xml_data->addChild("entry");
            if ($key == 'Account') {
                $subnode = $xml_data->addChild("link");
                $subnode->addAttribute('title', $key);
            } else if ($key == 'UsrProvinsi') {
                $subnode = $xml_data->addChild("link");
                $subnode->addAttribute('title', $key);
            } else if ($key == 'UsrNegara') {
                $subnode = $xml_data->addChild("link");
                $subnode->addAttribute('title', $key);
            } else if ($key == 'UsrSistemPembayaran') {
                $subnode = $xml_data->addChild("link");
                $subnode->addAttribute('title', $key);
            } else if ($key == 'UsrMataUang') {
                $subnode = $xml_data->addChild("link");
                $subnode->addAttribute('title', $key);
            } else if ($key == 'UsrJenisKontrak') {
                $subnode = $xml_data->addChild("link");
                $subnode->addAttribute('title', $key);
            } else if ($key == 'UsrSumberDanaL') {
                $subnode = $xml_data->addChild("link");
                $subnode->addAttribute('title', $key);
            } else if ($key == 'UsrSBUL') {
                $subnode = $xml_data->addChild("link");
                $subnode->addAttribute('title', $key);
            } else if ($key == 'UsrJenis') {
                $subnode = $xml_data->addChild("link");
                $subnode->addAttribute('title', $key);
            } else {
                $subnode = $xml_data->addChild($key);
            }
            // $subnode = $xml_data->addChild("content");
            arrayToXML($value, $subnode);
        } else {
            $xml_data->addChild("$key", htmlspecialchars("$value"));
        }
    }
    return $xml_data->asXML();
}

function getApi($url, $payload, $header, $is_post)
{
    $c = curl_init($url);
    // $c = curl_init("http://101.255.171.12/dashboard-api/data/report");
    curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($c, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
    if ($is_post == true) {
        curl_setopt($c, CURLOPT_POSTFIELDS, $payload);
    }
    curl_setopt($c, CURLOPT_HTTPHEADER, $header);
    // dd($c);
    $output = curl_exec($c);
    curl_close($c);
    $output = json_decode($output);
    return $output;
};
function writeDOCXFile($content)
{
    $php_word = new PhpWord();
    $section = $php_word->addSection();
    // $html = "<p>test</p>";
    // $html .= "<b>test</b>";
    \PhpOffice\PhpWord\Shared\Html::addHtml($section, $content, false, false);
    $docx_writer = \PhpOffice\PhpWord\IOFactory::createWriter($php_word);
    return $docx_writer;
}

function moveFileTemp(UploadedFile $file, $file_name)
{
    $path = "words/";
    $file_name =  $file_name . "." . $file->getClientOriginalExtension();
    $result = $file->move(public_path($path), $file_name);

    return $result;
}

function moveFileDocumentTemp(UploadedFile $file, $file_name)
{
    $path = "template/";
    $file_name =  $file_name . "." . $file->getClientOriginalExtension();
    $result = $file->move(public_path($path), $file_name);

    return $result;
}

function moneyFormatToNumber(string $value)
{
    return (int) str_replace(",", "", $value);
}

//Get Kode Tahun sesuai abjad 
function get_year_code($year){
    $a = [];
    $n = 2021;
    foreach (range('A', 'Z') as $k => $v) {
        $a[$n + $k] = $v;
    }
    return $a[$year];
}

// Log Message 
function setLogging($file, $message, $data) {
    Log::build([
        'driver' => 'single',
        'path' => storage_path("logs/$file.log"),
    ])->info("$message", $data);
}

// function checkGreenLine($proyek) {
//     if($proyek instanceof App\Models\Proyek) {
//         if ($proyek->dop != "EA") {
//             $customer = $proyek->proyekBerjalan->Customer ?? null;
//             $results = collect();
//             if (!empty($proyek->sumber_dana)) {
//                 if (!empty($proyek->negara) && ($proyek->negara == 'ID' || $proyek->negara == 'Indonesia')) {
//                     if ($proyek->sumber_dana == "APBD" || $proyek->sumber_dana == "BUMN") {
//                         $results->push(App\Models\KriteriaGreenLine::where("isi", "=", $proyek->sumber_dana)->where("item", "=", "Sumber Dana")->where(function ($query) use ($proyek, $customer) {
//                             $query->where('sub_isi', '=', $proyek->provinsi)
//                                 ->orWhere('sub_isi', '=', $customer->group_tier);
//                         })->count() > 0);
//                     } else {
//                         $results->push(App\Models\KriteriaGreenLine::where("isi", "=", $proyek->sumber_dana)->where("item", "=", "Sumber Dana")->count() > 0);
//                     }
//                 } else {
//                     $results->push(App\Models\KriteriaGreenLine::where("isi", "=", $proyek->sumber_dana)->where("item", "=", "Proyek Luar Negeri")->count() > 0);
//                 }
//             }
//             if (!empty($customer->jenis_instansi)) {
//                 if ((str_contains($customer->jenis_instansi, "BUMN") || str_contains($customer->jenis_instansi, "Kementrian / Pemerintah Pusat") || str_contains($customer->jenis_instansi, "Anak dan Turunan BUMN"))) {
//                     if (!empty($customer->group_tier)) {
//                         $results->push(App\Models\KriteriaGreenLine::where("item", "=", "Instansi")->where("isi", "=", $customer->jenis_instansi)->where("sub_isi", "=", $customer->group_tier)->count() > 0);
//                     } elseif (!empty($customer->nama_holding)) {
//                         $holding = Customer::find($customer->nama_holding);
//                         if ($holding->jenis_instansi == "BUMN" && !empty($holding->group_tier)) {
//                             $results->push(App\Models\KriteriaGreenLine::where("item", "=", "Instansi")->where("isi", "=", $holding->jenis_instansi)->where("sub_isi", "=", $holding->group_tier)->count() > 0);
//                         }
//                     } else {
//                         $results->push(App\Models\KriteriaGreenLine::where("item", "=", "Instansi")->where("isi", "=", $customer->jenis_instansi)->count() > 0);
//                     }
//                 } else {
//                     $results->push(App\Models\KriteriaGreenLine::where("item", "=", "Instansi")->where("isi", "=", $customer->jenis_instansi)->count() > 0);
//                 }
//             } else {
//                 $results->push(false);
//             }
//             // if ($proyek->is_disetujui) {
//             //     return true;
//             // }
//             // return $results->count() > 1 && $results->every(function ($item) {
//             //     return $item === true;
//             // });
//             return $results->contains(true);
//         } else {
//             return true;
//         }
//     }
//     return false;
// }
function checkGreenLine($proyek) {
    if($proyek instanceof App\Models\Proyek) {
        if ($proyek->dop != "EA") {
            $customer = $proyek->proyekBerjalan?->Customer ?? null;
            $exceptGreenlaneAll = ExceptGreenlane::all();
            if (!empty($customer)) {
                if ($exceptGreenlaneAll->count() > 0) {
                    $greenlaneExcept = null;
                    if (!empty($customer->id_customer) || !empty($proyek->sumber_dana)) {
                        $greenlaneExcept = ExceptGreenlane::where(function ($query) use ($proyek, $customer) {
                            $query->where('item', $customer->id_customer)
                                ->orWhere('item', $proyek->sumber_dana);
                        })->first();
                    }

                    if (empty($greenlaneExcept) || !empty($greenlaneExcept->sub_item)) {
                        $results = collect();

                        if (!empty($proyek->sumber_dana)) {
                            if (!empty($proyek->negara) && ($proyek->negara == 'ID' || $proyek->negara == 'Indonesia')) {
                                if ($proyek->sumber_dana == "APBD" || $proyek->sumber_dana == "BUMN") {
                                    //Jika ada Sumber Dana yg di Except Green Lane maka langsung kategori Green Lane
                                    if (!empty($greenlaneExcept->sub_item)) {
                                        if ($proyek->provinsi == $greenlaneExcept->sub_item || $customer->group_tier == $greenlaneExcept->sub_item) {
                                            return true;
                                        }
                                    }

                                    //Jika tidak ada maka dicek di kriteria green lane dahulu untuk sumber dana dan anakannya
                                    $results->push(App\Models\KriteriaGreenLine::where("isi", "=", $proyek->sumber_dana)->where("item", "=", "Sumber Dana")->where(function ($query) use ($proyek, $customer) {
                                        $query->where('sub_isi', '=', $proyek->provinsi)
                                            ->orWhere('sub_isi', '=', $customer->group_tier);
                                    })->count() > 0);
                                } else {
                                    //Jika diluar APBD dan BUMN
                                    $results->push(App\Models\KriteriaGreenLine::where("isi", "=", $proyek->sumber_dana)->where("item", "=", "Sumber Dana")->count() > 0);
                                }
                            } else {
                                //Jika Proyek Luar Negeri
                                $results->push(App\Models\KriteriaGreenLine::where("isi", "=", $proyek->sumber_dana)->where("item", "=", "Proyek Luar Negeri")->count() > 0);
                            }
                        }
                        if (!empty($customer->jenis_instansi)) {
                            if ((str_contains($customer->jenis_instansi, "BUMN") || str_contains($customer->jenis_instansi, "Kementrian / Pemerintah Pusat") || str_contains($customer->jenis_instansi, "Anak dan Turunan BUMN"))) {
                                if (!empty($customer->group_tier)) {
                                    $results->push(App\Models\KriteriaGreenLine::where("item", "=", "Instansi")->where("isi", "=", $customer->jenis_instansi)->where("sub_isi", "=", $customer->group_tier)->count() > 0);
                                } elseif (!empty($customer->nama_holding)) {
                                    $holding = Customer::find($customer->nama_holding);
                                    if ($holding->jenis_instansi == "BUMN" && !empty($holding->group_tier)) {
                                        $results->push(App\Models\KriteriaGreenLine::where("item", "=", "Instansi")->where("isi", "=", $holding->jenis_instansi)->where("sub_isi", "=", $holding->group_tier)->count() > 0);
                                    }
                                } else {
                                    $results->push(App\Models\KriteriaGreenLine::where("item", "=", "Instansi")->where("isi", "=", $customer->jenis_instansi)->count() > 0);
                                }
                            } else {
                                $results->push(App\Models\KriteriaGreenLine::where("item", "=", "Instansi")->where("isi", "=", $customer->jenis_instansi)->count() > 0);
                            }
                        } else {
                            $results->push(false);
                        }
                        // if ($proyek->is_disetujui) {
                        //     return true;
                        // }
                        // dd($results);
                        return $results->count() > 1 && $results->every(function ($item) {
                            return $item === true;
                        });
                        // return $results->contains(true);
                    } else {
                        return true;
                    }
                } else {
                    $results = collect();
                    if (!empty($proyek->sumber_dana)) {
                        if (!empty($proyek->negara) && ($proyek->negara == 'ID' || $proyek->negara == 'Indonesia')) {
                            if ($proyek->sumber_dana == "APBD" || $proyek->sumber_dana == "BUMN") {
                                $results->push(App\Models\KriteriaGreenLine::where("isi", "=", $proyek->sumber_dana)->where("item", "=", "Sumber Dana")->where(function ($query) use ($proyek, $customer) {
                                    if ($proyek->sumber_data == "APBD") {
                                        $query->where('sub_isi', '=', $proyek->provinsi);
                                    } else {
                                        // if(!empty($customer->nama_holding)){
                                        //     $holding = Customer::find($customer->nama_holding);
                                        //     $query->where('sub_isi', '=', $holding->group_tier);
                                        // }else{
                                        //     $query->where('sub_isi', '=', $customer->group_tier);
                                        // }
                                        if (!empty($customer->nama_holding)) {
                                            $tier_bumn = App\Models\MasterGrupTierBUMN::where("id_pelanggan", $customer->nama_holding)->orderBy("updated_at")->first();
                                            if (!empty($tier_bumn)) {
                                                $query->where('sub_isi', '=', $proyek->provinsi)->orWhere('sub_isi', '=', $tier_bumn->kategori);
                                            }
                                        } else {
                                            $tier_bumn = App\Models\MasterGrupTierBUMN::where("id_pelanggan", $customer->id_customer)->orderBy("updated_at")->first();
                                            if (!empty($tier_bumn)) {
                                                $query->where('sub_isi', '=', $proyek->provinsi)->orWhere('sub_isi', '=', $tier_bumn->kategori);
                                            }
                                        }
                                    }
                                })->count() > 0);
                            } else {
                                $results->push(App\Models\KriteriaGreenLine::where("isi", "=", $proyek->sumber_dana)->where("item", "=", "Sumber Dana")->count() > 0);
                            }
                        } else {
                            $results->push(App\Models\KriteriaGreenLine::where("isi", "=", $proyek->sumber_dana)->where("item", "=", "Proyek Luar Negeri")->count() > 0);
                        }
                    }
                    if (!empty($customer->jenis_instansi)) {
                        if ((str_contains($customer->jenis_instansi, "BUMN") || str_contains($customer->jenis_instansi, "Kementrian / Pemerintah Pusat") || str_contains($customer->jenis_instansi, "Anak dan Turunan BUMN"))) {
                            if (!empty($customer->group_tier)) {
                                $results->push(App\Models\KriteriaGreenLine::where("item", "=", "Instansi")->where("isi", "=", $customer->jenis_instansi)->where("sub_isi", "=", $customer->group_tier)->count() > 0);
                            } elseif (!empty($customer->nama_holding)) {
                                $holding = Customer::find($customer->nama_holding);
                                if ($holding->jenis_instansi == "BUMN" && !empty($holding->group_tier)) {
                                    $results->push(App\Models\KriteriaGreenLine::where("item", "=", "Instansi")->where("isi", "=", $holding->jenis_instansi)->where("sub_isi", "=", $holding->group_tier)->count() > 0);
                                }
                            } else {
                                $results->push(App\Models\KriteriaGreenLine::where("item", "=", "Instansi")->where("isi", "=", $customer->jenis_instansi)->count() > 0);
                            }
                        } else {
                            $results->push(App\Models\KriteriaGreenLine::where("item", "=", "Instansi")->where("isi", "=", $customer->jenis_instansi)->count() > 0);
                        }
                    } else {
                        $results->push(false);
                    }
                    return $results->count() > 1 && $results->every(function ($item) {
                        return $item === true;
                    });
                }
            } else {
                return false;
            }
        } else {
            return true;
        }
    }
    return false;
}

function checkNonGreenLaneNota2($proyek)
{
    if ($proyek instanceof App\Models\Proyek) {
        if ($proyek->UnitKerja->dop != 'EA') {
            if ($proyek->stage == 4) {
                if (empty($proyek->jenis_terkontrak) || empty($proyek->sistem_bayar)) {
                    return null;
                }

                if ($proyek->jenis_terkontrak == "Lumpsum" || $proyek->sistem_bayar == "Monthly" || $proyek->is_uang_muka) {
                    return true;
                } else {
                    return false;
                }
            }
            return null;
        } else {
            return null;
        }
    } else {
        return false;
    }
}

function validateInput($data, $rules) {
    $is_validated = Validator::make($data, $rules);
    $errors = $is_validated->errors();
    if($errors->isNotEmpty()) {
        $fields = collect($errors->toArray())->map(function($item, $field) {
            if(str_contains($field, "-")) {
                return ucwords(str_replace("-", " ", $field));
            } elseif (str_contains($field, "_")) {
                return ucwords(str_replace("_", " ", $field));
            }
            return ucwords(str_replace(".", " ", $field));
        })->values();
        $fields = $fields->join(", ", " dan ");
        return $fields;
    }
    return false;
}

function createWordRekomendasi(App\Models\Proyek $proyek, \Illuminate\Support\Collection $hasil_assessment = new \Illuminate\Support\Collection(), $is_proyek_mega) {
    $phpWord = new \PhpOffice\PhpWord\PhpWord();
    $customer = $proyek->proyekBerjalan->customer;
    $target_path = "file-rekomendasi";
    $now = Carbon\Carbon::now();
    $file_name = $now->format("dmYHis") . "_nota-rekomendasi_$proyek->kode_proyek.pdf";
    $notaRekomendasi = NotaRekomendasi::where('kode_proyek', $proyek->kode_proyek)->first();
    // if($customer->proyekBerjalans->where("stage", "=", 8)->count() > 0) {
    //     $internal_score = $hasil_assessment->sum(function($ra) {
    //         if($ra["kategori"] == "Internal") {
    //             return $ra["score"];
    //         }
    //     });
    //     $eksternal_score = $hasil_assessment->sum(function($ra) {
    //         if($ra["kategori"] == "Eksternal") {
    //             return $ra["score"];
    //         }
    //     });
    // } else {
    // }
    
    // $hasil_assessment = $hasil_assessment->where("kategori", "=", "Eksternal");
    $top_100 = $hasil_assessment->where("kriteria_penilaian", "=", "Top 100 Perusahan Besar di Indonesia")->first();
    $rating = $hasil_assessment->where("kriteria_penilaian", "=", "Lembaga Lain yang mengeluarkan rating perusahaan di Indonesia")->first();
    $industry_attractive = $hasil_assessment->where("kriteria_penilaian", "=", "Industry Attractive")->first();
    $key_client = $hasil_assessment->where("kriteria_penilaian", "=", "Key Client")->first();
    $bowheer = $hasil_assessment->where("kriteria_penilaian", "=", "Pemberi Kerja bermasalah")->first();
    $piutang = $hasil_assessment->where("kriteria_penilaian", "=", "Piutang")->first();

    // dd($bowheer);
    // if ($customer->proyekBerjalans->where("stage", "=", 8)->count() > 0) {
    if ($customer->Piutang->where('kategori', '!=', 1)->count() > 0 || $customer->MasalahHukum->count() > 0) {
        if (empty($key_client)) {
            $key_client = collect(["kategori" => "Internal", "kriteria_penilaian" => "Key Client", "score" => 0]);
            $hasil_assessment->push($key_client);
        }
        if (empty($bowheer)) {
            $bowheer = collect(["kategori" => "Internal", "kriteria_penilaian" => "Pemberi Kerja bermasalah", "score" => 10]);
            $hasil_assessment->push($bowheer);
        }
        if (empty($piutang)) {
            $piutang = collect(["kategori" => "Internal", "kriteria_penilaian" => "Piutang", "score" => 10]);
            $hasil_assessment->push($piutang);
        }
    }
    $total_score = $hasil_assessment->sum(function($ra) {
        return $ra["score"];
    });
    // return dd($total_score);
    // dd($top_100, $rating, $industry_attractive);

    $section = $phpWord->addSection();
    $footer = $section->addFooter();
    $footer->addText("*Dokumen ini dibuat oleh sistem CRM", ['size' => 10, 'bold' => true], ['align' => 'right']);
    $nama_proyek = str_replace("&", "dan", $proyek->nama_proyek);

    $section->addText("Tabel Kriteria Penilaian Pemberi Kerja", ['size' => 12, "bold" => true], ['align' => "center"]);
    $section->addText(htmlspecialchars($customer->name, ENT_QUOTES), ['size' => 12, "bold" => true], ['align' => "center"]);

    $section->addTextBreak(1);
    $table = $section->addTable('myOwnTableStyle',array('borderSize' => 1, 'borderColor' => '999999', 'afterSpacing' => 0, 'Spacing'=> 0, 'cellMargin'=>0  ));
    $table->addRow(-0.5, array('exactHeight' => -5));

    // $styleCell = array('borderTopSize'=>1 ,'borderTopColor' =>'black','borderLeftSize'=>1,'borderLeftColor' =>'black','borderRightSize'=>1,'borderRightColor'=>'black','borderBottomSize' =>1,'borderBottomColor'=>'black', 'textAlignment' => \PhpOffice\PhpWord\SimpleType\TextAlignment::CENTER);
    // $TstyleCell = array("bgColor" => "F4B083", 'borderTopSize'=>1 ,'borderTopColor' =>'black','borderLeftSize'=>1,'borderLeftColor' =>'black','borderRightSize'=>1,'borderRightColor'=>'black','borderBottomSize' =>1,'borderBottomColor'=>'black' );
    // $TfontStyle = array('bold'=>true, 'italic'=> false, 'size'=>10, 'name' => 'Times New Roman', 'afterSpacing' => 0, 'Spacing'=> 0, 'cellMargin'=>0, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::BOTH);
    // $fontStyle = array('bold'=>false, 'italic'=> false, 'size'=>10, 'name' => 'Times New Roman', 'afterSpacing' => 0, 'Spacing'=> 0, 'cellMargin'=>0, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::BOTH);

    
    $fancyTableStyle = ['borderSize' => 0, 'borderColor' => '999999'];
    $cellRowSpan = ['vMerge' => 'restart', 'valign' => 'center', 'bgColor' => '8496B0'];
    $cellRowContinue = ['vMerge' => 'continue'];
    $cellColSpan = ['gridSpan' => 1, 'valign' => 'center', 'bgColor' => '8496B0'];
    $cellHCentered = ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER, "color" => "FFFFFF"];
    $cellVCentered = ['valign' => 'center'];
    $cellCategoryStyle = ["bgColor" => "D6DCE4"];
    $fontStyleHeader = ["color" => "FFFFFF", "bold" => true];

    $spanTableStyleName = 'Colspan Rowspan';
    $phpWord->addTableStyle($spanTableStyleName, $fancyTableStyle);
    $table = $section->addTable($spanTableStyleName);

    $table->addRow();

    $cell1 = $table->addCell(2000, $cellRowSpan);
    $textrun1 = $cell1->addTextRun($cellHCentered);
    $textrun1->addText('No', $fontStyleHeader);
    
    $cell2 = $table->addCell(4000, $cellRowSpan);
    $textrun2 = $cell2->addTextRun($cellHCentered);
    $textrun2->addText('Kriteria Penilaian', $fontStyleHeader);

    $cell3 = $table->addCell(2000, $cellColSpan);
    $textrun3 = $cell3->addTextRun($cellHCentered);
    $textrun3->addText('Klasifikasi A', $fontStyleHeader);

    $cell3 = $table->addCell(2000, $cellColSpan);
    $textrun3 = $cell3->addTextRun($cellHCentered);
    $textrun3->addText('Klasifikasi B', $fontStyleHeader);

    $cell3 = $table->addCell(2000, $cellColSpan);
    $textrun3 = $cell3->addTextRun($cellHCentered);
    $textrun3->addText('Klasifikasi C', $fontStyleHeader);

    $table->addCell(2000, $cellRowSpan)->addText('Nilai', $fontStyleHeader, $cellHCentered);
    $table->addCell(2000, $cellRowSpan)->addText('Tier', $fontStyleHeader, $cellHCentered);

    // Begin :: Thead
    $table->addRow();
    $table->addCell(null, $cellRowContinue);
    $table->addCell(null, $cellRowContinue);
    $table->addCell(2000, $cellRowSpan)->addText('Nilai 10', $fontStyleHeader, $cellHCentered);
    $table->addCell(2000, $cellRowSpan)->addText('Nilai 7.5', $fontStyleHeader, $cellHCentered);
    $table->addCell(2000, $cellRowSpan)->addText('Nilai 5', $fontStyleHeader, $cellHCentered);
    $table->addCell(null, $cellRowContinue);
    $table->addCell(null, $cellRowContinue);
    // End :: Thead

    // Begin :: Body
    // if($customer->proyekBerjalans->where("stage", "=", 8)->count() > 0) {
    if ($customer->Piutang->where('kategori', '!=', 1)->count() > 0 || $customer->MasalahHukum->count() > 0) {
        $table->addRow(null, $cellCategoryStyle);
        $table->addCell(null, $cellCategoryStyle);
        $table->addCell(4000, $cellCategoryStyle)->addText("Internal", ["bold" => true]);
        $table->addCell(null, $cellCategoryStyle);
        $table->addCell(null, $cellCategoryStyle);
        $table->addCell(null, $cellCategoryStyle);
        $table->addCell(null, $cellCategoryStyle);
        $table->addCell(null, $cellCategoryStyle);
        
        $table->addRow();
        $table->addCell(2000)->addText("1");
        $table->addCell(4000)->addText("Piutang");
        $table->addCell(2000, ['bgColor' => $piutang['score'] == 10 ? 'FFB77D' : ''])->addText("Tidak Ada Piutang");
        $table->addCell(2000, ['bgColor' => $piutang['score'] == 7.5 ? 'FFB77D' : ''])->addText(htmlspecialchars("Piutang < 3 Bulan"));
        $table->addCell(2000, ['bgColor' => $piutang['score'] == 5 ? 'FFB77D' : ''])->addText("Piutang > 3 Bulan");
        $table->addCell(2000)->addText($piutang["score"] ?? 10);
        $table->addCell(2000)->addText("-");
        
        $table->addRow();
        $table->addCell(2000)->addText("2");
        $table->addCell(4000)->addText("Pemberi Kerja bermasalah");
        $table->addCell(2000, ["bgColor" => $bowheer["score"] == 10 ? 'FFB77D' : ''])->addText("Tak berperkara dengan Wika");
        $table->addCell(2000, ["bgColor" => $bowheer["score"] == 7.5 ? 'FFB77D' : ''])->addText("Ada perkara, Wika Menang");
        $table->addCell(2000, ["bgColor" => $bowheer["score"] == 5 ? 'FFB77D' : ''])->addText("Ada Perkara, Wika Kalah");
        $table->addCell(2000)->addText($bowheer["score"] ?? 10);
        $table->addCell(2000)->addText("-");
        
        $table->addRow();
        $table->addCell(2000)->addText("3");
        $table->addCell(4000)->addText("Key Client");
        $table->addCell(2000, ["bgColor" => $key_client['score'] == 10 ? 'FFB77D' : ''])->addText("Perusahan menjadi bagian Key Client");
        $table->addCell(2000, $cellCategoryStyle);
        $table->addCell(2000, $cellCategoryStyle);
        $table->addCell(2000)->addText($key_client["score"] ?? 0);
        $table->addCell(2000)->addText("-");
    }
    $table->addRow(null, $cellCategoryStyle);
    $table->addCell(null, $cellCategoryStyle);
    $table->addCell(4000, $cellCategoryStyle)->addText("Eksternal", ["bold" => true]);
    $table->addCell(null, $cellCategoryStyle);
    $table->addCell(null, $cellCategoryStyle);
    $table->addCell(null, $cellCategoryStyle);
    $table->addCell(null, $cellCategoryStyle);
    $table->addCell(null, $cellCategoryStyle);
    
    $table->addRow();
    $table->addCell(2000)->addText("1");
    $table->addCell(4000)->addText("Industry Attractive
    (Industry Rating untuk melihat industri yang menjadi sasaran)");
    $table->addCell(2000, ["bgColor" => $industry_attractive['score'] == 10 ? 'FFB77D' : ''])->addText("Industri Menarik dan Cenderung Menarik");
    $table->addCell(2000, ["bgColor" => $industry_attractive['score'] == 7.5 ? 'FFB77D' : ''])->addText("Industri Netral dan Cenderung Waspada");
    $table->addCell(2000, ["bgColor" => $industry_attractive['score'] == 5 ? 'FFB77D' : ''])->addText("Industri Waspada");
    $table->addCell(2000)->addText($industry_attractive["score"]);
    $table->addCell(2000)->addText("-");
    
    $table->addRow();
    $table->addCell(2000)->addText("2");
    $table->addCell(4000)->addText("Top 100  Perusahaan terbesar di Indonesia
    (dikeluarkan oleh lembaga terpercaya)");
    $table->addCell(2000, ["bgColor" => $top_100['score'] == 10 ? 'FFB77D' : ''])->addText("Perusahaan berada pada urutan 1 - 50");
    $table->addCell(2000, ["bgColor" => $top_100['score'] == 7.5 ? 'FFB77D' : ''])->addText("Perusahaan berada pada urutan 51 - 100");
    $table->addCell(2000, ["bgColor" => $top_100['score'] == 5 ? 'FFB77D' : ''])->addText("Perusahaan tidak berada pada daftar Top Perusahaan");
    $table->addCell(2000)->addText($top_100["score"]);
    $table->addCell(2000)->addText("-");
    
    $table->addRow();
    $table->addCell(2000)->addText("3");
    $table->addCell(4000)->addText("Lembaga lain yang mengeluarkan rating perusahaan di indonesia
    (misal: LQ45)");
    $table->addCell(2000, ["bgColor" => $rating['score'] == 10 ? 'FFB77D' : ''])->addText("Perusahaan berada pada urutan 1 - 20");
    $table->addCell(2000, ["bgColor" => $rating['score'] == 7.5 ? 'FFB77D' : ''])->addText("Perusahaan berada pada urutan 21 - 45");
    $table->addCell(2000, ["bgColor" => $rating['score'] == 5 ? 'FFB77D' : ''])->addText("Perusahaan tidak berada pada daftar rating Perusahaan");
    $table->addCell(2000)->addText($rating["score"] ?? 0);
    $table->addCell(2000)->addText("-");

    $table->addRow();
    $table->addCell(null, $cellCategoryStyle);
    $table->addCell(4000, $cellCategoryStyle)->addText("Total", ["bold" => true]);
    $table->addCell(null, $cellCategoryStyle);
    $table->addCell(null, $cellCategoryStyle);
    $table->addCell(null, $cellCategoryStyle);
    $table->addCell(2000, $cellCategoryStyle)->addText($total_score, ["bold" => true]);

    $tier = "";
    // if($customer->proyekBerjalans->where("stage", "=", 8)->count() > 0) {
    if ($customer->Piutang->where('kategori', '!=', 1)->count() > 0 || $customer->MasalahHukum->count() > 0) {
        if ($total_score >= 45) {
            $tier = "A";
        } else if($total_score < 45 && $total_score >= 25) {
            $tier = "B";
        } else {
            $tier = "C";
        }
    } else {
        if ($total_score >= 22.5) {
            $tier = "A";
        } else if($total_score < 22.5 && $total_score >= 15) {
            $tier = "B";
        } else {
            $tier = "C";
        }
    }
    $table->addCell(2000, $cellCategoryStyle)->addText($tier, ["bold" => true]);

    $section->addTextBreak(1);

    // End :: Body

    // Begin :: Footer
    // if($customer->proyekBerjalans->where("stage", "=", 8)->count() > 0) {
    if ($customer->Piutang->where('kategori', '!=', 1)->count() > 0 || $customer->MasalahHukum->count() > 0) {
        $section->addText("Rumusan Tier dari Kolom Nilai dengan ketentuan:", ['size'=>10, "bold" => true], ['align' => "left"]);
        $section->addText("A: X >= 45", ['size' => 10, "bold" => true], ['align' => "left"]);
        $section->addText(htmlspecialchars("B: 25 =< X =< 45"), ['size'=>10, "bold" => true], ['align' => "left"]);
        $section->addText(htmlspecialchars("C: 0 =< X < 25"), ['size' => 10, "bold" => true], ['align' => "left"]);
    } else {
        $section->addText("Rumusan Tier dari Kolom Nilai dengan ketentuan:", ['size'=>10, "bold" => true], ['align' => "left"]);
        $section->addText("A: X >= 22.5", ['size' => 10, "bold" => true], ['align' => "left"]);
        $section->addText(htmlspecialchars("B: 15 =< X =< 22.5"), ['size'=>10, "bold" => true], ['align' => "left"]);
        $section->addText(htmlspecialchars("C: 0 =< X < 15"), ['size' => 10, "bold" => true], ['align' => "left"]);
    }
    
    // End :: Footer

    $properties = $phpWord->getDocInfo();
    $properties->setTitle($file_name);
    $properties->setDescription('Nota Rekomendasi');

    $rendererName = \PhpOffice\PhpWord\Settings::PDF_RENDERER_DOMPDF;
    $rendererLibraryPath = realpath('../vendor/dompdf/dompdf');
    \PhpOffice\PhpWord\Settings::setPdfRenderer($rendererName, $rendererLibraryPath);

    $xmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'PDF');
    $is_saved = $xmlWriter->save(public_path($target_path. "/". $file_name));
    // dd("saved");
    // $proyek->file_rekomendasi = $file_name;
    // $proyek->hasil_assessment = $hasil_assessment->toJson();
    // $proyek->save();
    $notaRekomendasi->file_rekomendasi = $file_name;
    $notaRekomendasi->hasil_assessment = $hasil_assessment->toJson();
    $notaRekomendasi->save();
}

function createWordPengajuan(App\Models\Proyek $proyek, \Illuminate\Support\Collection $hasil_assessment = new \Illuminate\Support\Collection(), $is_proyek_mega, $hostName)
{
    $phpWord = new \PhpOffice\PhpWord\PhpWord();
    $customer = $proyek->proyekBerjalan->Customer;
    $target_path = "file-pengajuan";
    $now = Carbon\Carbon::now();
    $file_name = $now->format("dmYHis") . "_nota-pengajuan_$proyek->kode_proyek";
    $notaRekomendasi = NotaRekomendasi::where('kode_proyek', $proyek->kode_proyek)->first();

    $qrName = date('dmYHis_') . "pengajuan_" . Auth::user()->nip . "-" . $proyek->kode_proyek . ".png";
    $qrPath = public_path('/file-ttd' . '/' . $qrName);
    $qrUrl = $hostName . "nip=" . Auth::user()->nip . "&redirectTo=/rekomendasi/" . $proyek->kode_proyek . "/view-qr?kategori=pengajuan&nip=" . Auth::user()->nip;

    $generateQRCode = generateQrCode($qrName, $qrPath, $qrUrl);

    if (!$generateQRCode) {
        Alert::error("Error", "QR gagal dibuat, Hubungi Admin!");
        return redirect()->back();
    }

    // $file_name = $now->format("dmYHis") . "_nota-pengajuan_$proyek->kode_proyek.pdf";


    // $styleCell = array('borderTopSize'=>1 ,'borderTopColor' =>'black','borderLeftSize'=>1,'borderLeftColor' =>'black','borderRightSize'=>1,'borderRightColor'=>'black','borderBottomSize' =>1,'borderBottomColor'=>'black', 'textAlignment' => \PhpOffice\PhpWord\SimpleType\TextAlignment::CENTER);
    // $TstyleCell = array("bgColor" => "F4B083", 'borderTopSize'=>1 ,'borderTopColor' =>'black','borderLeftSize'=>1,'borderLeftColor' =>'black','borderRightSize'=>1,'borderRightColor'=>'black','borderBottomSize' =>1,'borderBottomColor'=>'black' );
    // $TfontStyle = array('bold'=>true, 'italic'=> false, 'size'=>10, 'name' => 'Times New Roman', 'afterSpacing' => 0, 'Spacing'=> 0, 'cellMargin'=>0, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::BOTH);
    // $fontStyle = array('bold'=>false, 'italic'=> false, 'size'=>10, 'name' => 'Times New Roman', 'afterSpacing' => 0, 'Spacing'=> 0, 'cellMargin'=>0, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::BOTH);
    $section = $phpWord->addSection();
    $footer = $section->addFooter();
    $footer->addText("*Dokumen ini dibuat oleh sistem CRM", ['size' => 10, 'bold' => true], ['align' => 'right']);
    $section->addText("NOTA REKOMENDASI TAHAP I", ['size' => 12, "bold" => true], ['align' => "center"]);
    $section->addText("Seleksi Pengguna Jasa Non Green Lane", ['size' => 12, "bold" => true], ['align' => "center"]);

    $section->addText($proyek->klasifikasi_pasdin, ['size' => 12, "bold" => true], ['align' => "center"]);
    // if ($is_proyek_mega) {
    //     $section->addText("Proyek Mega", ['size' => 12, "bold" => true], ['align' => "center"]);
    // } else {
    //     $section->addText("Proyek Kecil / Proyek Menengah", ['size' => 12, "bold" => true], ['align' => "center"]);
    // }

    $section->addTextBreak(1);
    $table = $section->addTable('myOwnTableStyle', array('borderSize' => 1, 'borderColor' => '999999', 'afterSpacing' => 0, 'Spacing' => 0, 'cellMargin' => 0));
    $table->addRow(-0.5, array('exactHeight' => -5));

    $styleCell = array('borderTopSize' => 1, 'borderTopColor' => 'black', 'borderLeftSize' => 1, 'borderLeftColor' => 'black', 'borderRightSize' => 1, 'borderRightColor' => 'black', 'borderBottomSize' => 1, 'borderBottomColor' => 'black', 'textAlignment' => \PhpOffice\PhpWord\SimpleType\TextAlignment::CENTER);
    $TstyleCell = array("bgColor" => "F4B083", 'borderTopSize' => 1, 'borderTopColor' => 'black', 'borderLeftSize' => 1, 'borderLeftColor' => 'black', 'borderRightSize' => 1, 'borderRightColor' => 'black', 'borderBottomSize' => 1, 'borderBottomColor' => 'black');
    $TfontStyle = array('bold' => true, 'italic' => false, 'size' => 10, 'name' => 'Times New Roman', 'afterSpacing' => 0, 'Spacing' => 0, 'cellMargin' => 0, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::BOTH);
    $fontStyle = array('bold' => false, 'italic' => false, 'size' => 10, 'name' => 'Times New Roman', 'afterSpacing' => 0, 'Spacing' => 0, 'cellMargin' => 0, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::BOTH);


    $table->addCell(500, $TstyleCell)->addText('No', $TfontStyle);
    $table->addCell(2500, $TstyleCell)->addText("Item", $TfontStyle);
    $table->addCell(6000, $TstyleCell)->addText('Uraian', $TfontStyle);

    $nama_proyek = str_replace("&", "dan", $proyek->nama_proyek);
    $table->addRow();
    $table->addCell(500, $styleCell)->addText('1', $fontStyle);
    $table->addCell(2500, $styleCell)->addText("Nama Proyek", $fontStyle);
    $table->addCell(6000, $styleCell)->addText($nama_proyek, $fontStyle);
    $table->addRow();
    $table->addCell(500, $styleCell)->addText('2', $fontStyle);
    $table->addCell(2500, $styleCell)->addText("Lokasi Proyek", $fontStyle);
    $table->addCell(6000, $styleCell)->addText(Provinsi::find($proyek->provinsi)->province_name ?? "-", $fontStyle);
    $table->addRow();
    $table->addCell(500, $styleCell)->addText('3', $fontStyle);
    $table->addCell(2500, $styleCell)->addText("Nama Pengguna Jasa", $fontStyle);
    $table->addCell(6000, $styleCell)->addText($proyek->proyekBerjalan->name_customer, $fontStyle);
    $table->addRow();
    $table->addCell(500, $styleCell)->addText('4', $fontStyle);
    $table->addCell(2500, $styleCell)->addText("Instansi Pengguna Jasa", $fontStyle);
    $table->addCell(6000, $styleCell)->addText($proyek->proyekBerjalan->Customer->jenis_instansi, $fontStyle);
    $table->addRow();
    $table->addCell(500, $styleCell)->addText('5', $fontStyle);
    $table->addCell(2500, $styleCell)->addText("Sumber Pendanaan Proyek", $fontStyle);
    $table->addCell(6000, $styleCell)->addText($proyek->sumber_dana, $fontStyle);
    $table->addRow();
    $table->addCell(500, $styleCell)->addText('6', $fontStyle);
    $table->addCell(2500, $styleCell)->addText("Perkiraan Nilai Proyek", $fontStyle);
    $table->addCell(6000, $styleCell)->addText(number_format($proyek->nilaiok_awal, 0, ".", "."), $fontStyle);
    $table->addRow();
    $table->addCell(500, $styleCell)->addText('7', $fontStyle);
    $table->addCell(2500, $styleCell)->addText("Kategori Proyek", $fontStyle);
    $table->addCell(6000, $styleCell)->addText($proyek->klasifikasi_pasdin ?? "-", $fontStyle);

    $section->addText("Berdasarkan informasi di atas, mengajukan untuk mengikuti aktifitas Perolehan Kontrak (tender) tersebut di atas.");

    // $section->addTextBreak();

    // $cell_2_ttd->addText($now->translatedFormat("l, d F Y"), ["bold" => true], ["align" => "center"]);
    $section->addTextBreak(3);
    $section->addText($now->translatedFormat("d F Y"), ["bold" => true], ["align" => "center"]);
    // $section->addTextBreak(1);
    // $section->addTextBreak(1);
    $section->addText("$" . "{tandaTangan}", ["bold" => false], ["align" => "center"]);
    // $section->addTextBreak(1);
    $section->addText("( " . Auth::user()->name . " )", ["bold" => true, "size" => 9], ["align" => "center"]);
    $section->addText(Auth::user()->Pegawai->Jabatan?->nama_jabatan, ["bold" => true], ["align" => "center"]);
    $section->addTextBreak(5);
    $section->addText("Catatan :");
    $section->addText("Dokumen Pemilihan atau dokumen pendukung lainnya harap di upload dalam aplikasi CRM.");
    // End :: Footer

    // Begin :: Add Template docx withoutTTD
    $properties = $phpWord->getDocInfo();
    $properties->setTitle($file_name);
    $properties->setDescription('Nota Pengajuan Rekomendasi');
    $phpWord->save(public_path($target_path . "/" . $file_name . ".docx"));
    // end :: Add Template docx withoutTTD
    
    // Begin :: SIGNED Template docx
    $templateProcessor = new TemplateProcessor($target_path . "/" . $file_name . ".docx");
    //Pake Barcode
    $templateProcessor->setImageValue('tandaTangan', ["path" => public_path('file-ttd/' . $qrName), "height" => 75, "ratio" => false]);

    //Pake TTD
    // $templateProcessor->setImageValue('tandaTangan', ["path" => public_path('file-ttd/ttd.png'), "width" => 10, "ratio" => true]);
    // $templateProcessor->setValue('tandaTangan', '<img src="' . public_path('\qr-code' . '\\' . $proyek->kode_proyek . '.svg') . '" width="300" height="300" />');
    $ttdFileName = $now->format("dmYHis") . "_signed-nota-pengajuan_$proyek->kode_proyek";
    $templateProcessor->saveAs(public_path($target_path . "/" . $ttdFileName . ".docx"));
    // end :: SIGNED Template docx
    
    File::delete(public_path($target_path . "/" . $file_name . ".docx"));
    // dd($files);
    
    // Begin :: CONVERT Template docx to PDF
    
    $templatePhpWord = \PhpOffice\PhpWord\IOFactory::load(public_path($target_path . "/" . $ttdFileName . ".docx"));
    $rendererName = \PhpOffice\PhpWord\Settings::PDF_RENDERER_DOMPDF;
    $rendererLibraryPath = realpath('../vendor/dompdf/dompdf');
    \PhpOffice\PhpWord\Settings::setPdfRenderer($rendererName, $rendererLibraryPath);
    $xmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($templatePhpWord, 'PDF');
    $xmlWriter->save(public_path($target_path . "/" . $file_name . ".pdf"));
    // end :: CONVERT Template docx to PDF

    File::delete(public_path($target_path . "/" . $ttdFileName . ".docx"));

    // dd("saved");
    // $proyek->file_pengajuan = $file_name . ".pdf";
    // $proyek->hasil_assessment = $hasil_assessment->toJson();
    // $proyek->save();
    $notaRekomendasi->file_pengajuan = $file_name . ".pdf";
    $notaRekomendasi->hasil_assessment = $hasil_assessment->toJson();
    $notaRekomendasi->save();
}

function createWordProfileRisiko($kode_proyek)
{
    $target_path = "file-profile-risiko";
    $proyek = Proyek::select('kode_proyek', 'nama_proyek')->where('kode_proyek', $kode_proyek)->first();
    $customer = $proyek->proyekBerjalan?->customer?->name;
    $notaRekomendasi = NotaRekomendasi::where('kode_proyek', $proyek->kode_proyek)->first();
    // dd($customer);
    $now = Carbon\Carbon::now();
    $file_name = $now->format("dmYHis") . "_profile-risiko_" . $proyek->kode_proyek . ".docx";
    $kriteriaPenggunaJasaDetail = KriteriaPenggunaJasaDetail::where('kode_proyek', $kode_proyek)->get();

    $cellRowContinue = ['vMerge' => 'continue', 'bgColor' => '8496B0', 'borderSize' => 3, 'borderColor' => '000000', 'afterSpacing' => 0];
    $cellColSpanKriteria = ['gridSpan' => 4, 'valign' => 'center', 'bgColor' => '8496B0', 'borderSize' => 3, 'borderColor' => '000000', 'afterSpacing' => 0];
    $cellHCentered = ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER, "color" => "FFFFFF", 'spaceAfter' => 0];
    $fontStyleHeader = ["color" => "FFFFFF", "bold" => true, 'size' => 5];
    $cellRowSpan = ['vMerge' => 'restart', 'valign' => 'center', 'bgColor' => '8496B0', 'borderSize' => 3, 'borderColor' => '000000', 'afterSpacing' => 0];

    $phpWord = new PhpWord();
    $section = $phpWord->addSection(['orientation' => 'landscape', 'marginLeft' => 300, 'marginRight' => 300, 'marginTop' => 300, 'marginBottom' => 300]);

    $section->addText(htmlspecialchars("Pengembangan Kriteria Untuk Pemilihan Pengguna Jasa" . " - " . $customer, ENT_QUOTES), ['size' => 8, "bold" => true], ['align' => "center", 'spaceAfter' => 0]);
    // $section->addText("Testing", ['size' => 12, "bold" => true], ['align' => "center", 'spaceAfter' => 0]);

    $section->addTextBreak(1);
    // $table = $section->addTable('myOwnTableStyle', array('borderSize' => 1, 'borderColor' => '999999', 'afterSpacing' => 0, 'Spacing' => 0, 'cellMargin' => 0));
    // $table->addRow(-0.5, array('exactHeight' => -5));

    $table = $section->addTable('myOwnTableStyle', array('borderSize' => 5, 'borderColor' => '000000', 'afterSpacing' => 0, 'Spacing' => 0, 'cellMargin' => 0, 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0)));

    $table->addRow();

    $cell1 = $table->addCell(300, $cellRowSpan);
    $textrun1 = $cell1->addTextRun($cellHCentered);
    $textrun1->addText('No', $fontStyleHeader);

    $cell2 = $table->addCell(3000, $cellRowSpan);
    $textrun2 = $cell2->addTextRun($cellHCentered);
    $textrun2->addText('Parameter', $fontStyleHeader);

    $cell3 = $table->addCell(800, $cellRowSpan);
    $textrun3 = $cell3->addTextRun($cellHCentered);
    $textrun3->addText('Weight (%)', $fontStyleHeader);

    $cell4 = $table->addCell(5000, $cellColSpanKriteria);
    $textrun4 = $cell4->addTextRun($cellHCentered);
    $textrun4->addText('Kriteria', $fontStyleHeader);

    $cell5 = $table->addCell(500, $cellRowSpan);
    $textrun5 = $cell5->addTextRun($cellHCentered);
    $textrun5->addText('Nilai', $fontStyleHeader);

    $cell6 = $table->addCell(1000, $cellRowSpan);
    $textrun6 = $cell6->addTextRun($cellHCentered);
    $textrun6->addText('Score', $fontStyleHeader);

    $cell7 = $table->addCell(2000, $cellRowSpan);
    $textrun7 = $cell7->addTextRun($cellHCentered);
    $textrun7->addText('Keterangan', $fontStyleHeader);

    // Begin :: Thead
    $table->addRow();
    $table->addCell(null, $cellRowContinue);
    $table->addCell(null, $cellRowContinue);
    $table->addCell(null, $cellRowContinue);
    $table->addCell(2000, ['bgColor' => '8496B0', 'borderSize' => 3, 'borderColor' => '000000', 'afterSpacing' => 0])->addText('1', $fontStyleHeader, $cellHCentered);
    $table->addCell(2000, ['bgColor' => '8496B0', 'borderSize' => 3, 'borderColor' => '000000', 'afterSpacing' => 0])->addText('2', $fontStyleHeader, $cellHCentered);
    $table->addCell(2000, ['bgColor' => '8496B0', 'borderSize' => 3, 'borderColor' => '000000', 'afterSpacing' => 0])->addText('3', $fontStyleHeader, $cellHCentered);
    $table->addCell(3000, ['bgColor' => '8496B0', 'borderSize' => 3, 'borderColor' => '000000', 'afterSpacing' => 0])->addText('4', $fontStyleHeader, $cellHCentered);
    $table->addCell(null, $cellRowContinue);
    $table->addCell(null, $cellRowContinue);
    $table->addCell(null, $cellRowContinue);

    $table->addRow();
    $table->addCell(null, $cellRowContinue);
    $table->addCell(3000, ['bgColor' => '8496B0', 'borderSize' => 3, 'borderColor' => '000000', 'afterSpacing' => 0])->addText('(1)', $fontStyleHeader, $cellHCentered);
    $table->addCell(800, ['bgColor' => '8496B0', 'borderSize' => 3, 'borderColor' => '000000', 'afterSpacing' => 0])->addText('(2)', $fontStyleHeader, $cellHCentered);
    $table->addCell(5000, $cellColSpanKriteria)->addText('(3)', $fontStyleHeader, $cellHCentered);
    $table->addCell(500, ['bgColor' => '8496B0', 'borderSize' => 3, 'borderColor' => '000000', 'afterSpacing' => 0])->addText('(4)', $fontStyleHeader, $cellHCentered);
    $table->addCell(1000, ['bgColor' => '8496B0', 'borderSize' => 3, 'borderColor' => '000000', 'afterSpacing' => 0])->addText('(5) = (2) * (4)', $fontStyleHeader, $cellHCentered);
    $table->addCell(2000, ['bgColor' => '8496B0', 'borderSize' => 3, 'borderColor' => '000000', 'afterSpacing' => 0])->addText('(6)', $fontStyleHeader, $cellHCentered);


    //Begin::Body
    //Begin::Legalitas Perusahaan
    $table->addRow();
    $table->addCell(null, ['borderSize' => 2, 'borderColor' => '000000', 'bgColor' => 'FFFEA8'])->addTextRun(['spaceAfter' => 0]);
    $table->addCell(2000, ['gridSpan' => 9, 'borderSize' => 2, 'borderColor' => '000000', 'bgColor' => 'FFFEA8', 'afterSpacing' => 0])->addText('LEGALITAS PERUSAHAAN (area yang harus seluruhnya terpenuhi, setelah itu akan dilakukan scoring)', ['size' => 5, 'bold' => true], ['spaceAfter' => 0]);


    $legalitasMasterData = LegalitasPerusahaan::where('nota_rekomendasi', '=', 'Nota Rekomendasi 1')->get()->sortBy('created_at')->each(function ($lp, $key) use ($table, $cellHCentered, $kriteriaPenggunaJasaDetail) {
        if ($key == 0) {
            $merge = 'restart';
        } else {
            $merge = 'continue';
        }

        $kriteriaIndex0 = $kriteriaPenggunaJasaDetail->where('index', 0)->first();

        if ($kriteriaIndex0->kriteria == $key + 1) {
            $selectColor = 'FFB77D';
        } else {
            $selectColor = '';
        }

        $table->addRow();

        if ($key == 0) {
            $table->addCell(300, ['vMerge' => $merge, 'valign' => 'center', 'borderSize' => 2, 'borderColor' => '000000'])->addText('1', ['size' => 5]);
            $table->addCell(3000, ['vMerge' => $merge, 'valign' => 'center', 'borderSize' => 2, 'borderColor' => '000000'])->addText('Legalitas institusi / perusahaan', ['size' => 5]);
        } else {
            $table->addCell(1000, ['vMerge' => $merge, 'valign' => 'center', 'borderSize' => 2, 'borderColor' => '000000'])->addTextRun(['spaceAfter' => 0]);
            $table->addCell(3000, ['vMerge' => $merge, 'valign' => 'center', 'borderSize' => 2, 'borderColor' => '000000'])->addTextRun(['spaceAfter' => 0]);
        }

        $table->addCell(800, ['vMerge' => $merge, 'valign' => 'center', 'borderSize' => 2, 'borderColor' => '000000']);
        $table->addCell(2000, ['vMerge' => $merge, 'valign' => 'center', 'borderSize' => 2, 'borderColor' => '000000', 'bgColor' => 'CFCFCF']);
        $table->addCell(2000, ['vMerge' => $merge, 'valign' => 'center', 'borderSize' => 2, 'borderColor' => '000000', 'bgColor' => 'CFCFCF']);
        $table->addCell(2000, ['vMerge' => $merge, 'valign' => 'center', 'borderSize' => 2, 'borderColor' => '000000', 'bgColor' => 'CFCFCF']);

        $cellKriteria = $table->addCell(3000, ['borderSize' => 2, 'borderColor' => '000000', 'bgColor' => $selectColor]);
        $addTextRun = $cellKriteria->addTextRun(['spaceAfter' => 0]);
        $text = nl2br(htmlspecialchars($lp->item, ENT_QUOTES));
        $textExplode = explode('<br />', $text);
        $addTextRun->addText(array_shift($textExplode), ['size' => 5]);
        if (count($textExplode) > 1) {
            foreach ($textExplode as $line) {
                $addTextRun->addTextBreak();
                $addTextRun->addText($line, ['size' => 5]);
            }
        }

        $table->addCell(500, ['vMerge' => $merge, 'valign' => 'center', 'borderSize' => 2, 'borderColor' => '000000']);
        $table->addCell(1000, ['vMerge' => $merge, 'valign' => 'center', 'borderSize' => 2, 'borderColor' => '000000']);

        if (!empty($kriteriaIndex0->keterangan) && $kriteriaIndex0->kriteria == $key + 1) {
            $cellKeterangan0 = $table->addCell(1000, ['valign' => 'center', 'borderSize' => 2, 'borderColor' => '000000']);
            $addTextRunKeterangan0 = $cellKeterangan0->addTextRun(['spaceAfter' => 0]);
            $textKeterangan0 = nl2br(htmlspecialchars($kriteriaIndex0->keterangan, ENT_QUOTES));
            $textExplodeKeterangan0 = explode('<br />', $textKeterangan0);
            $addTextRunKeterangan0->addText(array_shift($textExplodeKeterangan0), ['size' => 5]);
            if (count($textExplodeKeterangan0) > 1) {
                foreach ($textExplodeKeterangan0 as $line) {
                    $addTextRunKeterangan0->addTextBreak();
                    $addTextRunKeterangan0->addText($line, ['size' => 5]);
                }
            }
        } else {
            $table->addCell(1000, ['valign' => 'center', 'borderSize' => 2, 'borderColor' => '000000']);
        }
    });
    //End::Legalitas Perusahaan


    //Begin::Kriteria Pengguna Jasa

    $kriteriaMasterData = KriteriaPenggunaJasa::where('nota_rekomendasi', '=', 'Nota Rekomendasi 1')->get()->sortBy('created_at')->each(function ($lp, $key) use ($table, $cellHCentered, $kriteriaPenggunaJasaDetail) {

        if ($key == 0 && $lp->kategori != 'Financial') {
            $table->addRow();
            $table->addCell(null, ['borderSize' => 2, 'borderColor' => '000000', 'bgColor' => 'FFFEA8'])->addTextRun(['spaceAfter' => 0]);
            $table->addCell(2000, ['gridSpan' => 9, 'borderSize' => 2, 'borderColor' => '000000', 'bgColor' => 'FFFEA8', 'afterSpacing' => 0])->addText('REPUTASI PEMBERI KERJA', ['size' => 5, 'bold' => true], ['spaceAfter' => 0]);
        } else {
            if ($key == 1) {
                $table->addRow();
                $table->addCell(null, ['borderSize' => 2, 'borderColor' => '000000', 'bgColor' => 'FFFEA8'])->addTextRun(['spaceAfter' => 0]);
                $table->addCell(2000, ['gridSpan' => 9, 'borderSize' => 2, 'borderColor' => '000000', 'bgColor' => 'FFFEA8', 'afterSpacing' => 0])->addText('FINANCIAL', ['size' => 5, 'bold' => true], ['spaceAfter' => 0]);
            }
        }

        $kriteriaIndex = $kriteriaPenggunaJasaDetail->where('index', $key + 1)->first();

        $table->addRow();

        if ($key == 0 && $lp->kategori != 'Financial') {
            $table->addCell(300, ['valign' => 'center', 'borderSize' => 2, 'borderColor' => '000000'])->addText('1', ['size' => 5]);
            $table->addCell(3000, ['borderSize' => 2, 'borderColor' => '000000'])->addText($lp->item, ['size' => 5]);
        } else {
            $table->addCell(300, ['valign' => 'center', 'borderSize' => 2, 'borderColor' => '000000'])->addText($key, ['size' => 5]);
            $table->addCell(3000, ['borderSize' => 2, 'borderColor' => '000000'])->addText($lp->item, ['size' => 5]);
        }

        $table->addCell(800, ['valign' => 'center', 'borderSize' => 2, 'borderColor' => '000000'])->addTextRun($cellHCentered)->addText($lp->bobot, ['size' => 5]);

        if (!empty($lp->kriteria_1)) {
            $cellKriteria1 = $table->addCell(2000, ['borderSize' => 2, 'borderColor' => '000000', 'bgColor' => $kriteriaIndex->kriteria == 1 ? 'FFB77D' : '']);
            $addTextRun1 = $cellKriteria1->addTextRun(['spaceAfter' => 0]);
            $text1 = nl2br(htmlspecialchars($lp->kriteria_1, ENT_QUOTES));
            $textExplode1 = explode('<br />', $text1);
            $addTextRun1->addText(array_shift($textExplode1), ['size' => 5]);
            if (count($textExplode1) > 1) {
                foreach ($textExplode1 as $line) {
                    $addTextRun1->addTextBreak();
                    $addTextRun1->addText($line, ['size' => 5]);
                }
            }
        } else {
            $table->addCell(2000, ['borderSize' => 2, 'borderColor' => '000000', 'bgColor' => 'CFCFCF'])->addTextRun(['spaceAfter' => 0]);
        }

        if (!empty($lp->kriteria_2)) {
            $cellKriteria2 = $table->addCell(2000, ['borderSize' => 2, 'borderColor' => '000000', 'bgColor' => $kriteriaIndex->kriteria == 2 ? 'FFB77D' : '']);
            $addTextRun2 = $cellKriteria2->addTextRun(['spaceAfter' => 0]);
            $text2 = nl2br(htmlspecialchars($lp->kriteria_2, ENT_QUOTES));
            $textExplode2 = explode('<br />', $text2);
            $addTextRun2->addText(array_shift($textExplode2), ['size' => 5]);
            if (count($textExplode2) > 1) {
                foreach ($textExplode2 as $line) {
                    $addTextRun2->addTextBreak();
                    $addTextRun2->addText($line, ['size' => 5]);
                }
            }
        } else {
            $table->addCell(2000, ['borderSize' => 2, 'borderColor' => '000000', 'bgColor' => 'CFCFCF'])->addTextRun(['spaceAfter' => 0]);
        }

        if (!empty($lp->kriteria_3)) {
            $cellKriteria3 = $table->addCell(2000, ['borderSize' => 2, 'borderColor' => '000000', 'bgColor' => $kriteriaIndex->kriteria == 3 ? 'FFB77D' : '']);
            $addTextRun3 = $cellKriteria3->addTextRun(['spaceAfter' => 0]);
            $text3 = nl2br(htmlspecialchars($lp->kriteria_3, ENT_QUOTES));
            $textExplode3 = explode('<br />', $text3);
            $addTextRun3->addText(array_shift($textExplode3), ['size' => 5]);
            if (count($textExplode3) > 1) {
                foreach ($textExplode3 as $line) {
                    $addTextRun3->addTextBreak();
                    $addTextRun3->addText($line, ['size' => 5]);
                }
            }
        } else {
            $table->addCell(2000, ['borderSize' => 2, 'borderColor' => '000000', 'bgColor' => 'CFCFCF'])->addTextRun(['spaceAfter' => 0]);
        }

        if (!empty($lp->kriteria_4)) {
            $cellKriteria4 = $table->addCell(3000, ['borderSize' => 2, 'borderColor' => '000000', 'bgColor' => $kriteriaIndex->kriteria == 4 ? 'FFB77D' : '']);
            $addTextRun4 = $cellKriteria4->addTextRun(['spaceAfter' => 0]);
            $text4 = nl2br(htmlspecialchars($lp->kriteria_4, ENT_QUOTES));
            $textExplode4 = explode('<br />', $text4);
            $addTextRun4->addText(array_shift($textExplode4), ['size' => 5]);
            if (count($textExplode4) > 1) {
                foreach ($textExplode4 as $line) {
                    $addTextRun4->addTextBreak();
                    $addTextRun4->addText($line, ['size' => 5]);
                }
            }
        } else {
            $table->addCell(2000, ['borderSize' => 2, 'borderColor' => '000000', 'bgColor' => 'CFCFCF'])->addTextRun(['spaceAfter' => 0]);
        }
        // $table->addCell(2000, ['borderSize' => 2, 'borderColor' => '000000', 'bgColor' => 'CFCFCF'])->addText('<');

        $table->addCell(500, ['valign' => 'center', 'borderSize' => 2, 'borderColor' => '000000'])->addTextRun($cellHCentered)->addText($kriteriaIndex->kriteria, ['size' => 5]);
        $table->addCell(1000, ['valign' => 'center', 'borderSize' => 2, 'borderColor' => '000000'])->addTextRun($cellHCentered)->addText($kriteriaIndex->nilai, ['size' => 5]);

        if (!empty($kriteriaIndex->keterangan)) {
            $cellKeterangan = $table->addCell(1000, ['borderSize' => 2, 'borderColor' => '000000']);
            $addTextRunKeterangan = $cellKeterangan->addTextRun(['spaceAfter' => 0]);
            $textKeterangan = nl2br(htmlspecialchars($kriteriaIndex->keterangan, ENT_QUOTES));
            $textExplodeKeterangan = explode('<br />', $textKeterangan);
            $addTextRunKeterangan->addText(array_shift($textExplodeKeterangan), ['size' => 5]);
            if (count($textExplodeKeterangan) > 1) {
                foreach ($textExplodeKeterangan as $line) {
                    $addTextRunKeterangan->addTextBreak();
                    $addTextRunKeterangan->addText($line, ['size' => 5]);
                }
            }
        } else {
            $table->addCell(1000, ['valign' => 'center', 'borderSize' => 2, 'borderColor' => '000000'])->addTextRun(['spaceAfter' => 0]);
        }
    });
    //End::Kriteria Pengguna Jasa

    //Begin::Total
    $totalBobot = KriteriaPenggunaJasa::all()->sum('bobot');
    $totalScore = $kriteriaPenggunaJasaDetail->sum('nilai') ?? 0;
    $kriteriaFinal = PenilaianPenggunaJasa::all()->filter(function ($item) use ($totalScore) {
        return $item->dari_nilai <= $totalScore && $item->sampai_nilai >= $totalScore;
    })->first()->nama ?? '-';

    $table->addRow();
    $table->addCell(300, ['valign' => 'center', 'bgColor' => '8496B0', 'borderSize' => 3, 'borderColor' => '000000', 'afterSpacing' => 0])->addTextRun(['spaceAfter' => 0]);
    $table->addCell(3000, ['valign' => 'center', 'bgColor' => '8496B0', 'borderSize' => 3, 'borderColor' => '000000', 'afterSpacing' => 0])->addTextRun($cellHCentered)->addText('TOTAL', ['size' => 5, 'bold' => true, 'color' => 'FFFFFF']);
    $table->addCell(800, ['valign' => 'center', 'bgColor' => '8496B0', 'borderSize' => 3, 'borderColor' => '000000', 'afterSpacing' => 0])->addTextRun($cellHCentered)->addText($totalBobot, ['size' => 5, 'bold' => true, 'color' => 'FFFFFF']);
    $table->addCell(5000, ['gridSpan' => 4, 'valign' => 'center', 'bgColor' => '8496B0', 'borderSize' => 3, 'borderColor' => '000000', 'afterSpacing' => 0])->addTextRun(['spaceAfter' => 0]);
    $table->addCell(500, ['valign' => 'center', 'bgColor' => '8496B0', 'borderSize' => 3, 'borderColor' => '000000', 'afterSpacing' => 0])->addTextRun(['spaceAfter' => 0]);
    $table->addCell(1000, ['valign' => 'center', 'bgColor' => '8496B0', 'borderSize' => 3, 'borderColor' => '000000', 'afterSpacing' => 0])->addTextRun($cellHCentered)->addText($totalScore, ['size' => 5, 'bold' => true, 'color' => 'FFFFFF']);
    $table->addCell(2000, ['valign' => 'center', 'bgColor' => '8496B0', 'borderSize' => 3, 'borderColor' => '000000', 'afterSpacing' => 0])->addTextRun($cellHCentered)->addText($kriteriaFinal, ['size' => 5, 'bold' => true, 'color' => 'FFFFFF']);

    //End::Total

    //Begin::Rumus
    $section->addTextBreak(1);
    $section->addText("Catatan untuk skoring :", ['size' => 6, 'bold' => true], ['align' => 'left']);
    $section->addTextRun(['spaceAfter' => 0])->addText(htmlspecialchars("340 <= X <= 400         : Risiko Rendah"), ['size' => 6, 'bgColor' => $kriteriaFinal == "Risiko Rendah" ? 'FFB77D' : ''], ['align' => 'left']);
    $section->addTextRun(['spaceAfter' => 0])->addText(htmlspecialchars("260 <= X <= 240         : Risiko Moderat"), ['size' => 6, 'bgColor' => $kriteriaFinal == "Risiko Moderat" ? 'FFB77D' : ''], ['align' => 'left']);
    $section->addTextRun(['spaceAfter' => 0])->addText(htmlspecialchars("180 <= X <= 260         : Risiko Tinggi"), ['size' => 6, 'bgColor' => $kriteriaFinal == "Risiko Tinggi" ? 'FFB77D' : ''], ['align' => 'left']);
    $section->addTextRun(['spaceAfter' => 0])->addText(htmlspecialchars("100 <= X <= 180         : Risiko Ekstrim"), ['size' => 6, 'bgColor' => $kriteriaFinal == "Risiko Ekstrim" ? 'FFB77D' : ''], ['align' => 'left']);
    //End::Rumus

    //End::Body
    $filePath = public_path('/file-profile-risiko//' . $file_name);
    // $rendererName = \PhpOffice\PhpWord\Settings::PDF_RENDERER_DOMPDF;
    // $rendererLibraryPath = realpath('../vendor/dompdf/dompdf');
    // \PhpOffice\PhpWord\Settings::setPdfRenderer($rendererName, $rendererLibraryPath);

    $phpWord->save($filePath);
    // $proyek->file_penilaian_risiko = $file_name;
    // $proyek->save();
    $notaRekomendasi->file_penilaian_risiko = $file_name;
    $notaRekomendasi->save();
}

function createWordProfileRisikoNew($kode_proyek)
{
    $target_path = "file-profile-risiko";
    $proyek = Proyek::select('kode_proyek', 'nama_proyek')->where('kode_proyek', $kode_proyek)->first();
    $customer = $proyek->proyekBerjalan?->customer?->name;
    $notaRekomendasi = NotaRekomendasi::where('kode_proyek', $proyek->kode_proyek)->first();
    // dd($customer);
    $now = Carbon\Carbon::now();
    $file_name = $now->format("dmYHis") . "_profile-risiko_" . $proyek->kode_proyek;
    $kriteriaPenggunaJasaDetail = KriteriaPenggunaJasaDetail::where('kode_proyek', $kode_proyek)->orderBy('index')->get();

    $cellRowContinue = ['vMerge' => 'continue', 'bgColor' => '8496B0', 'borderSize' => 3, 'borderColor' => '000000', 'afterSpacing' => 0];
    $cellColSpanKriteria = ['gridSpan' => 4, 'valign' => 'center', 'bgColor' => '8496B0', 'borderSize' => 3, 'borderColor' => '000000', 'afterSpacing' => 0];
    $cellHCentered = ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER, "color" => "FFFFFF", 'spaceAfter' => 0, 'spaceBefore' => 0];
    $fontStyleHeader = ["color" => "FFFFFF", "bold" => true, 'size' => 8];
    $cellRowSpan = ['vMerge' => 'restart', 'valign' => 'center', 'bgColor' => '8496B0', 'borderSize' => 3, 'borderColor' => '000000', 'afterSpacing' => 0];

    $phpWord = new PhpWord();
    $section = $phpWord->addSection(['marginLeft' => 800, 'marginRight' => 800, 'marginTop' => 800, 'marginBottom' => 800]);
    // $footer = $section->createFooter();
    // $footer->addText("*Dokumen ini dibuat oleh sistem CRM", ['size' => 6, 'bold' => true], ['align' => 'right']);

    $section->addText("Pengembangan Kriteria Untuk Pemilihan Pengguna Jasa", ['size' => 8, "bold" => true], ['align' => "center", 'spaceAfter' => 0]);
    $section->addText(htmlspecialchars($customer, ENT_QUOTES), ['size' => 12, "bold" => true], ['align' => "center", 'spaceAfter' => 0]);
    $section->addTextBreak();

    // $section->addTextBreak(1);
    // $table = $section->addTable('myOwnTableStyle', array('borderSize' => 1, 'borderColor' => '999999', 'afterSpacing' => 0, 'Spacing' => 0, 'cellMargin' => 0));
    // $table->addRow(-0.5, array('exactHeight' => -5));

    $table = $section->addTable('myOwnTableStyle', array('borderSize' => 5, 'borderColor' => '000000', 'afterSpacing' => 0, 'Spacing' => 0, 'cellMargin' => 0, 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0)));

    $table->addRow();

    $cell1 = $table->addCell(1000, $cellRowSpan);
    $textrun1 = $cell1->addTextRun($cellHCentered);
    $textrun1->addText('No', $fontStyleHeader, ["align" => "center", "spacing" => 0, "spaceBefore" => 1, "spaceAfter" => 1]);

    $cell2 = $table->addCell(1000, $cellRowSpan);
    $textrun2 = $cell2->addTextRun($cellHCentered);
    $textrun2->addText('Parameter', $fontStyleHeader, ["align" => "center", "spacing" => 0, "spaceBefore" => 1, "spaceAfter" => 1]);

    $cell3 = $table->addCell(1000, $cellRowSpan);
    $textrun3 = $cell3->addTextRun($cellHCentered);
    $textrun3->addText('Weight (%)', $fontStyleHeader, ["align" => "center", "spacing" => 0, "spaceBefore" => 1, "spaceAfter" => 1]);

    $cell4 = $table->addCell(1000, $cellRowSpan);
    $textrun4 = $cell4->addTextRun($cellHCentered);
    $textrun4->addText('Kriteria', $fontStyleHeader, ["align" => "center", "spacing" => 0, "spaceBefore" => 1, "spaceAfter" => 1]);

    $cell5 = $table->addCell(1000, $cellRowSpan);
    $textrun5 = $cell5->addTextRun($cellHCentered);
    $textrun5->addText('Nilai', $fontStyleHeader, ["align" => "center", "spacing" => 0, "spaceBefore" => 1, "spaceAfter" => 1]);

    $cell6 = $table->addCell(1000, $cellRowSpan);
    $textrun6 = $cell6->addTextRun($cellHCentered);
    $textrun6->addText('Score', $fontStyleHeader, ["align" => "center", "spacing" => 0, "spaceBefore" => 1, "spaceAfter" => 1]);

    $cell7 = $table->addCell(2000, $cellRowSpan);
    $textrun7 = $cell7->addTextRun($cellHCentered);
    $textrun7->addText('Keterangan', $fontStyleHeader, ["align" => "center", "spacing" => 0, "spaceBefore" => 1, "spaceAfter" => 1]);

    // Begin :: Thead
    // $table->addRow();
    // $table->addCell(null, $cellRowContinue);
    // $table->addCell(null, $cellRowContinue);
    // $table->addCell(null, $cellRowContinue);
    // // $table->addCell(2000, ['bgColor' => '8496B0', 'borderSize' => 3, 'borderColor' => '000000', 'afterSpacing' => 0])->addText('1', $fontStyleHeader, $cellHCentered);
    // // $table->addCell(2000, ['bgColor' => '8496B0', 'borderSize' => 3, 'borderColor' => '000000', 'afterSpacing' => 0])->addText('2', $fontStyleHeader, $cellHCentered);
    // // $table->addCell(2000, ['bgColor' => '8496B0', 'borderSize' => 3, 'borderColor' => '000000', 'afterSpacing' => 0])->addText('3', $fontStyleHeader, $cellHCentered);
    // // $table->addCell(3000, ['bgColor' => '8496B0', 'borderSize' => 3, 'borderColor' => '000000', 'afterSpacing' => 0])->addText('4', $fontStyleHeader, $cellHCentered);
    // $table->addCell(null, $cellRowContinue);
    // $table->addCell(null, $cellRowContinue);
    // $table->addCell(null, $cellRowContinue);

    $table->addRow();
    $table->addCell(1000, $cellRowContinue);
    $table->addCell(1000, ['bgColor' => '8496B0', 'borderSize' => 3, 'borderColor' => '000000', 'afterSpacing' => 0])->addText('(1)', $fontStyleHeader, $cellHCentered);
    $table->addCell(1000, ['bgColor' => '8496B0', 'borderSize' => 3, 'borderColor' => '000000', 'afterSpacing' => 0])->addText('(2)', $fontStyleHeader, $cellHCentered);
    // $table->addCell(1000, $cellColSpanKriteria)->addText('(3)', $fontStyleHeader, $cellHCentered);
    $table->addCell(1000, ['bgColor' => '8496B0', 'borderSize' => 3, 'borderColor' => '000000', 'afterSpacing' => 0])->addText('(3)', $fontStyleHeader, $cellHCentered);
    $table->addCell(1000, ['bgColor' => '8496B0', 'borderSize' => 3, 'borderColor' => '000000', 'afterSpacing' => 0])->addText('(4)', $fontStyleHeader, $cellHCentered);
    $table->addCell(1000, ['bgColor' => '8496B0', 'borderSize' => 3, 'borderColor' => '000000', 'afterSpacing' => 0])->addText('(5) = (2) * (4)', $fontStyleHeader, $cellHCentered);
    $table->addCell(2000, ['bgColor' => '8496B0', 'borderSize' => 3, 'borderColor' => '000000', 'afterSpacing' => 0])->addText('(6)', $fontStyleHeader, $cellHCentered);


    //Begin::Body
    //Begin::Legalitas Perusahaan
    $table->addRow();
    $table->addCell(1000, ['borderSize' => 2, 'borderColor' => '000000', 'bgColor' => 'FFFEA8'])->addTextRun(['spaceAfter' => 0]);
    $table->addCell(1000, ['gridSpan' => 6, 'borderSize' => 2, 'borderColor' => '000000', 'bgColor' => 'FFFEA8', 'afterSpacing' => 0])->addText('LEGALITAS PERUSAHAAN (area yang harus seluruhnya terpenuhi, setelah itu akan dilakukan scoring)', ['size' => 8, 'bold' => true], ["align" => "left", "spacing" => 0, "spaceBefore" => 1, "spaceAfter" => 1]);

    //Begin::Legalitas Old
    // $legalitasMasterData = LegalitasPerusahaan::where('nota_rekomendasi', '=', 'Nota Rekomendasi 1')->get()->sortBy('created_at')->each(function ($lp, $key) use ($table, $cellHCentered, $kriteriaPenggunaJasaDetail) {
    //     if ($key == 0) {
    //         $merge = 'restart';
    //     } else {
    //         $merge = 'continue';
    //     }

    //     $kriteriaIndex0 = $kriteriaPenggunaJasaDetail->where('index', 0)->first();

    //     if ($kriteriaIndex0->kriteria == $key + 1) {
    //         $selectColor = 'FFB77D';
    //     } else {
    //         $selectColor = '';
    //     }

    //     $table->addRow();

    //     if ($key == 0) {
    //         $table->addCell(300, ['vMerge' => $merge, 'valign' => 'center', 'borderSize' => 2, 'borderColor' => '000000'])->addText('1', ['size' => 5]);
    //         $table->addCell(3000, ['vMerge' => $merge, 'valign' => 'center', 'borderSize' => 2, 'borderColor' => '000000'])->addText('Legalitas institusi / perusahaan', ['size' => 5]);
    //     } else {
    //         $table->addCell(1000, ['vMerge' => $merge, 'valign' => 'center', 'borderSize' => 2, 'borderColor' => '000000'])->addTextRun(['spaceAfter' => 0]);
    //         $table->addCell(3000, ['vMerge' => $merge, 'valign' => 'center', 'borderSize' => 2, 'borderColor' => '000000'])->addTextRun(['spaceAfter' => 0]);
    //     }

    //     $table->addCell(800, ['vMerge' => $merge, 'valign' => 'center', 'borderSize' => 2, 'borderColor' => '000000']);
    //     $table->addCell(2000, ['vMerge' => $merge, 'valign' => 'center', 'borderSize' => 2, 'borderColor' => '000000', 'bgColor' => 'CFCFCF']);
    //     $table->addCell(2000, ['vMerge' => $merge, 'valign' => 'center', 'borderSize' => 2, 'borderColor' => '000000', 'bgColor' => 'CFCFCF']);
    //     $table->addCell(2000, ['vMerge' => $merge, 'valign' => 'center', 'borderSize' => 2, 'borderColor' => '000000', 'bgColor' => 'CFCFCF']);

    //     $cellKriteria = $table->addCell(3000, ['borderSize' => 2, 'borderColor' => '000000', 'bgColor' => $selectColor]);
    //     $addTextRun = $cellKriteria->addTextRun(['spaceAfter' => 0]);
    //     $text = nl2br(htmlspecialchars($lp->item, ENT_QUOTES));
    //     $textExplode = explode('<br />', $text);
    //     $addTextRun->addText(array_shift($textExplode), ['size' => 5]);
    //     if (count($textExplode) > 1) {
    //         foreach ($textExplode as $line) {
    //             $addTextRun->addTextBreak();
    //             $addTextRun->addText($line, ['size' => 5]);
    //         }
    //     }

    //     $table->addCell(500, ['vMerge' => $merge, 'valign' => 'center', 'borderSize' => 2, 'borderColor' => '000000']);
    //     $table->addCell(1000, ['vMerge' => $merge, 'valign' => 'center', 'borderSize' => 2, 'borderColor' => '000000']);

    //     if (!empty($kriteriaIndex0->keterangan) && $kriteriaIndex0->kriteria == $key + 1) {
    //         $cellKeterangan0 = $table->addCell(1000, ['valign' => 'center', 'borderSize' => 2, 'borderColor' => '000000']);
    //         $addTextRunKeterangan0 = $cellKeterangan0->addTextRun(['spaceAfter' => 0]);
    //         $textKeterangan0 = nl2br(htmlspecialchars($kriteriaIndex0->keterangan, ENT_QUOTES));
    //         $textExplodeKeterangan0 = explode('<br />', $textKeterangan0);
    //         $addTextRunKeterangan0->addText(array_shift($textExplodeKeterangan0), ['size' => 5]);
    //         if (count($textExplodeKeterangan0) > 1) {
    //             foreach ($textExplodeKeterangan0 as $line) {
    //                 $addTextRunKeterangan0->addTextBreak();
    //                 $addTextRunKeterangan0->addText($line, ['size' => 5]);
    //             }
    //         }
    //     } else {
    //         $table->addCell(1000, ['valign' => 'center', 'borderSize' => 2, 'borderColor' => '000000']);
    //     }
    // });
    //End::Legalitas Old

    //Begin::Legalitas New
    $table->addRow();
    $count = 0;
    $legalitasMasterSelect = LegalitasPerusahaan::where('nota_rekomendasi', '=', 'Nota Rekomendasi 1')->get()->sortBy('created_at')->each(function ($lp, $key) use ($table, $cellHCentered, $kriteriaPenggunaJasaDetail, &$count) {
        $kriteriaIndex0 = $kriteriaPenggunaJasaDetail->where('index', 0)->first();
        
        if (!empty($kriteriaIndex0) && $kriteriaIndex0->kriteria == $key + 1) {
            $count++;
            $table->addCell(1000, ['valign' => 'center', 'borderSize' => 2, 'borderColor' => '000000'])->addText('1', ['size' => 8], ["align" => "left", "spacing" => 0, "spaceBefore" => 1, "spaceAfter" => 1]); // Nomor
            $table->addCell(1000, ['valign' => 'center', 'borderSize' => 2, 'borderColor' => '000000'])->addText('Legalitas institusi / perusahaan', ['size' => 8], ["align" => "left", "spacing" => 0, "spaceBefore" => 1, "spaceAfter" => 1]); // Parameter
            $table->addCell(1000, ['valign' => 'center', 'borderSize' => 2, 'borderColor' => '000000']); // Weight
            //Begin::Kriteria Selection
            $cellKriteria = $table->addCell(1000, ['borderSize' => 2, 'borderColor' => '000000']);
            // $addTextRun = $cellKriteria->addTextRun(['spaceAfter' => 0]);
            // $text = nl2br(htmlspecialchars($lp->item, ENT_QUOTES));
            // $textExplode = explode('<br />', $text);
            // $addTextRun->addText(array_shift($textExplode), ['size' => 8]);
            // if (count($textExplode) > 1) {
            //     foreach ($textExplode as $line) {
            //         $addTextRun->addTextBreak();
            //         $addTextRun->addText($line, ['size' => 8]);
            //     }
            // }
            $cellKriteria->addText(str_replace("\r\n", '</w:t><w:br/><w:t>', htmlspecialchars(!empty($lp->item) ? $lp->item : "Tidak Ada", ENT_QUOTES)), ["bold" => false, 'size' => 8], ["align" => "left", "spacing" => 0, "spaceBefore" => 1, "spaceAfter" => 1]);
            // $kriteriaIndex0ListOpsi = preg_split("/\n|\r\n?/", htmlspecialchars(!empty($lp->item) ? $lp->item : "Tidak Ada", ENT_QUOTES));
            // foreach ($kriteriaIndex0ListOpsi as $key => $text) {
            //     $cellKriteria->addText($text, ["bold" => false, 'size' => 8], ["align" => "left"]);
            //     if ($text == "") {
            //         $cellKriteria->addTextBreak(1, ['size' => 5], ['afterSpacing' => 0, 'spacing' => 10]);
            //     }
            // }
            //End::Kriteria Selection
            $table->addCell(1000, ['valign' => 'center', 'borderSize' => 2, 'borderColor' => '000000']); //Nilai
            $table->addCell(1000, ['valign' => 'center', 'borderSize' => 2, 'borderColor' => '000000']); //Score
            //Begin::Keterangan Selection
            if (!empty($kriteriaIndex0->keterangan)) {
                $cellKeterangan0 = $table->addCell(2000, ['valign' => 'center', 'borderSize' => 2, 'borderColor' => '000000']);
                // $addTextRunKeterangan0 = $cellKeterangan0->addTextRun(['spaceAfter' => 0]);
                // $textKeterangan0 = nl2br(htmlspecialchars($kriteriaIndex0->keterangan, ENT_QUOTES));
                // $textExplodeKeterangan0 = explode('<br />', $textKeterangan0);
                // $addTextRunKeterangan0->addText(array_shift($textExplodeKeterangan0), ['size' => 8]);
                // if (count($textExplodeKeterangan0) > 1) {
                //     foreach ($textExplodeKeterangan0 as $line) {
                //         $addTextRunKeterangan0->addTextBreak();
                //         $addTextRunKeterangan0->addText($line, ['size' => 8]);
                //     }
                // }
                $cellKeterangan0->addText(str_replace("\r\n", '</w:t><w:br/><w:t>', htmlspecialchars($kriteriaIndex0->keterangan, ENT_QUOTES)), ["bold" => false, 'size' => 8], ["align" => "left", "spacing" => 0, "spaceBefore" => 1, "spaceAfter" => 1]);
                // $kriteriaIndex0ListKeterangan = preg_split("/\n|\r\n?/", htmlspecialchars($kriteriaIndex0->keterangan, ENT_QUOTES));
                // foreach ($kriteriaIndex0ListKeterangan as $key => $text) {
                //     $cellKeterangan0->addText($text, ["bold" => false, 'size' => 8], ["align" => "left"]);
                //     if ($text == "") {
                //         $cellKeterangan0->addTextBreak(1, ['size' => 5], ['afterSpacing' => 0, 'spacing' => 10]);
                //     }
                // }
            } else {
                $table->addCell(2000, ['valign' => 'center', 'borderSize' => 2, 'borderColor' => '000000']);
            }
            //EndBegin::Keterangan Selection

        }
    });
    //End::Legalitas New

    //End::Legalitas Perusahaan


    //Begin::Kriteria Pengguna Jasa

    // $kriteriaMasterData = KriteriaPenggunaJasa::where('nota_rekomendasi', '=', 'Nota Rekomendasi 1')->get()->sortBy('created_at')->each(function ($lp, $key) use ($table, $cellHCentered, $kriteriaPenggunaJasaDetail) {

    //     if ($key == 0 && $lp->kategori != 'Financial') {
    //         $table->addRow();
    //         $table->addCell(null, ['borderSize' => 2, 'borderColor' => '000000', 'bgColor' => 'FFFEA8'])->addTextRun(['spaceAfter' => 0]);
    //         $table->addCell(2000, ['gridSpan' => 9, 'borderSize' => 2, 'borderColor' => '000000', 'bgColor' => 'FFFEA8', 'afterSpacing' => 0])->addText('REPUTASI PEMBERI KERJA', ['size' => 5, 'bold' => true], ['spaceAfter' => 0]);
    //     } else {
    //         if ($key == 1) {
    //             $table->addRow();
    //             $table->addCell(null, ['borderSize' => 2, 'borderColor' => '000000', 'bgColor' => 'FFFEA8'])->addTextRun(['spaceAfter' => 0]);
    //             $table->addCell(2000, ['gridSpan' => 9, 'borderSize' => 2, 'borderColor' => '000000', 'bgColor' => 'FFFEA8', 'afterSpacing' => 0])->addText('FINANCIAL', ['size' => 5, 'bold' => true], ['spaceAfter' => 0]);
    //         }
    //     }

    //     $kriteriaIndex = $kriteriaPenggunaJasaDetail->where('index', $key + 1)->first();

    //     $table->addRow();

    //     if ($key == 0 && $lp->kategori != 'Financial') {
    //         $table->addCell(300, ['valign' => 'center', 'borderSize' => 2, 'borderColor' => '000000'])->addText('1', ['size' => 5]);
    //         $table->addCell(3000, ['borderSize' => 2, 'borderColor' => '000000'])->addText($lp->item, ['size' => 5]);
    //     } else {
    //         $table->addCell(300, ['valign' => 'center', 'borderSize' => 2, 'borderColor' => '000000'])->addText($key, ['size' => 5]);
    //         $table->addCell(3000, ['borderSize' => 2, 'borderColor' => '000000'])->addText($lp->item, ['size' => 5]);
    //     }

    //     $table->addCell(800, ['valign' => 'center', 'borderSize' => 2, 'borderColor' => '000000'])->addTextRun($cellHCentered)->addText($lp->bobot, ['size' => 5]);

    //     if (!empty($lp->kriteria_1)) {
    //         $cellKriteria1 = $table->addCell(2000, ['borderSize' => 2, 'borderColor' => '000000', 'bgColor' => $kriteriaIndex->kriteria == 1 ? 'FFB77D' : '']);
    //         $addTextRun1 = $cellKriteria1->addTextRun(['spaceAfter' => 0]);
    //         $text1 = nl2br(htmlspecialchars($lp->kriteria_1, ENT_QUOTES));
    //         $textExplode1 = explode('<br />', $text1);
    //         $addTextRun1->addText(array_shift($textExplode1), ['size' => 5]);
    //         if (count($textExplode1) > 1) {
    //             foreach ($textExplode1 as $line) {
    //                 $addTextRun1->addTextBreak();
    //                 $addTextRun1->addText($line, ['size' => 5]);
    //             }
    //         }
    //     } else {
    //         $table->addCell(2000, ['borderSize' => 2, 'borderColor' => '000000', 'bgColor' => 'CFCFCF'])->addTextRun(['spaceAfter' => 0]);
    //     }

    //     if (!empty($lp->kriteria_2)) {
    //         $cellKriteria2 = $table->addCell(2000, ['borderSize' => 2, 'borderColor' => '000000', 'bgColor' => $kriteriaIndex->kriteria == 2 ? 'FFB77D' : '']);
    //         $addTextRun2 = $cellKriteria2->addTextRun(['spaceAfter' => 0]);
    //         $text2 = nl2br(htmlspecialchars($lp->kriteria_2, ENT_QUOTES));
    //         $textExplode2 = explode('<br />', $text2);
    //         $addTextRun2->addText(array_shift($textExplode2), ['size' => 5]);
    //         if (count($textExplode2) > 1) {
    //             foreach ($textExplode2 as $line) {
    //                 $addTextRun2->addTextBreak();
    //                 $addTextRun2->addText($line, ['size' => 5]);
    //             }
    //         }
    //     } else {
    //         $table->addCell(2000, ['borderSize' => 2, 'borderColor' => '000000', 'bgColor' => 'CFCFCF'])->addTextRun(['spaceAfter' => 0]);
    //     }

    //     if (!empty($lp->kriteria_3)) {
    //         $cellKriteria3 = $table->addCell(2000, ['borderSize' => 2, 'borderColor' => '000000', 'bgColor' => $kriteriaIndex->kriteria == 3 ? 'FFB77D' : '']);
    //         $addTextRun3 = $cellKriteria3->addTextRun(['spaceAfter' => 0]);
    //         $text3 = nl2br(htmlspecialchars($lp->kriteria_3, ENT_QUOTES));
    //         $textExplode3 = explode('<br />', $text3);
    //         $addTextRun3->addText(array_shift($textExplode3), ['size' => 5]);
    //         if (count($textExplode3) > 1) {
    //             foreach ($textExplode3 as $line) {
    //                 $addTextRun3->addTextBreak();
    //                 $addTextRun3->addText($line, ['size' => 5]);
    //             }
    //         }
    //     } else {
    //         $table->addCell(2000, ['borderSize' => 2, 'borderColor' => '000000', 'bgColor' => 'CFCFCF'])->addTextRun(['spaceAfter' => 0]);
    //     }

    //     if (!empty($lp->kriteria_4)) {
    //         $cellKriteria4 = $table->addCell(3000, ['borderSize' => 2, 'borderColor' => '000000', 'bgColor' => $kriteriaIndex->kriteria == 4 ? 'FFB77D' : '']);
    //         $addTextRun4 = $cellKriteria4->addTextRun(['spaceAfter' => 0]);
    //         $text4 = nl2br(htmlspecialchars($lp->kriteria_4, ENT_QUOTES));
    //         $textExplode4 = explode('<br />', $text4);
    //         $addTextRun4->addText(array_shift($textExplode4), ['size' => 5]);
    //         if (count($textExplode4) > 1) {
    //             foreach ($textExplode4 as $line) {
    //                 $addTextRun4->addTextBreak();
    //                 $addTextRun4->addText($line, ['size' => 5]);
    //             }
    //         }
    //     } else {
    //         $table->addCell(2000, ['borderSize' => 2, 'borderColor' => '000000', 'bgColor' => 'CFCFCF'])->addTextRun(['spaceAfter' => 0]);
    //     }
    //     // $table->addCell(2000, ['borderSize' => 2, 'borderColor' => '000000', 'bgColor' => 'CFCFCF'])->addText('<');

    //     $table->addCell(500, ['valign' => 'center', 'borderSize' => 2, 'borderColor' => '000000'])->addTextRun($cellHCentered)->addText($kriteriaIndex->kriteria, ['size' => 5]);
    //     $table->addCell(1000, ['valign' => 'center', 'borderSize' => 2, 'borderColor' => '000000'])->addTextRun($cellHCentered)->addText($kriteriaIndex->nilai, ['size' => 5]);

    //     if (!empty($kriteriaIndex->keterangan)) {
    //         $cellKeterangan = $table->addCell(1000, ['borderSize' => 2, 'borderColor' => '000000']);
    //         $addTextRunKeterangan = $cellKeterangan->addTextRun(['spaceAfter' => 0]);
    //         $textKeterangan = nl2br(htmlspecialchars($kriteriaIndex->keterangan, ENT_QUOTES));
    //         $textExplodeKeterangan = explode('<br />', $textKeterangan);
    //         $addTextRunKeterangan->addText(array_shift($textExplodeKeterangan), ['size' => 5]);
    //         if (count($textExplodeKeterangan) > 1) {
    //             foreach ($textExplodeKeterangan as $line) {
    //                 $addTextRunKeterangan->addTextBreak();
    //                 $addTextRunKeterangan->addText($line, ['size' => 5]);
    //             }
    //         }
    //     } else {
    //         $table->addCell(1000, ['valign' => 'center', 'borderSize' => 2, 'borderColor' => '000000'])->addTextRun(['spaceAfter' => 0]);
    //     }
    // });

    $kriteriaMasterData = KriteriaPenggunaJasa::where('nota_rekomendasi', '=', 'Nota Rekomendasi 1')->get()->sortBy('created_at')->groupBy('kategori')->each(function ($lp, $key) use ($table, $cellHCentered, $kriteriaPenggunaJasaDetail, &$count) {
        if ($key != "Financial") {
            //REPUTASI PEMBERI KERJA
            $table->addRow();
            $table->addCell(1000, ['borderSize' => 2, 'borderColor' => '000000', 'bgColor' => 'FFFEA8'])->addTextRun(['spaceAfter' => 0]);
            $table->addCell(1000, [
                'gridSpan' => 6, 'borderSize' => 2, 'borderColor' => '000000', 'bgColor' => 'FFFEA8'
            ])->addText('REPUTASI PEMBERI KERJA', ['size' => 8, 'bold' => true], ["align" => "left", "spacing" => 0, "spaceBefore" => 1, "spaceAfter" => 1]);

            $kriteriaSelect = $lp->each(function ($ks, $k) use ($table, $cellHCentered, $kriteriaPenggunaJasaDetail, &$count) {
                $table->addRow();

                $kriteriaIndex = $kriteriaPenggunaJasaDetail->where('index', $count)->first();
                $table->addCell(1000, ['valign' => 'center', 'borderSize' => 2, 'borderColor' => '000000'])->addText('1', ['size' => 8], ["align" => "left", "spacing" => 0, "spaceBefore" => 1, "spaceAfter" => 1]);
                $table->addCell(1000, ['borderSize' => 2, 'borderColor' => '000000'])->addText($ks->item, ['size' => 8], ["align" => "left", "spacing" => 0, "spaceBefore" => 1, "spaceAfter" => 1]);
                $table->addCell(1000, ['valign' => 'center', 'borderSize' => 2, 'borderColor' => '000000'])->addTextRun($cellHCentered)->addText($ks->bobot, ['size' => 8], ["align" => "left", "spacing" => 0, "spaceBefore" => 1, "spaceAfter" => 1]);

                switch ($kriteriaIndex->kriteria) {
                    case 1:
                        $selectedKriteria = $ks->kriteria_1;
                        break;
                    case 2:
                        $selectedKriteria = $ks->kriteria_2;
                        break;
                    case 3:
                        $selectedKriteria = $ks->kriteria_3;
                        break;
                    case 4:
                        $selectedKriteria = $ks->kriteria_4;
                        break;

                    default:
                        $selectedKriteria = "Tidak Ada";
                        break;
                }
                //Begin::Kriteria Selection
                $cellKriteria1 = $table->addCell(1000, ['borderSize' => 2, 'borderColor' => '000000']);
                // $addTextRun1 = $cellKriteria1->addTextRun(['spaceAfter' => 0]);
                // $text1 = nl2br(htmlspecialchars($selectedKriteria, ENT_QUOTES));
                // $textExplode1 = explode('<br />', $text1);
                // $addTextRun1->addText(array_shift($textExplode1), ['size' => 8]);
                // if (count($textExplode1) > 1) {
                //     foreach ($textExplode1 as $line) {
                //         $addTextRun1->addTextBreak();
                //         $addTextRun1->addText($line, ['size' => 8]);
                //     }
                // }
                $cellKriteria1->addText(str_replace("\r\n", '</w:t><w:br/><w:t>', htmlspecialchars($selectedKriteria, ENT_QUOTES)), ["bold" => false, 'size' => 8], ["align" => "left", "spacing" => 0, "spaceBefore" => 1, "spaceAfter" => 1]);
                // $kriteriaIndex1List = preg_split("/\n|\r\n?/", htmlspecialchars($selectedKriteria, ENT_QUOTES));
                // foreach ($kriteriaIndex1List as $key => $text) {
                //     $cellKriteria1->addText($text, ["bold" => false, 'size' => 8], ["align" => "left"]);
                //     if ($text == "") {
                //         $cellKriteria1->addTextBreak(1, ['size' => 5], ['afterSpacing' => 0, 'spacing' => 10]);
                //     }
                // }
                //End::Kriteria Selection

                $table->addCell(1000, ['valign' => 'center', 'borderSize' => 2, 'borderColor' => '000000'])->addTextRun($cellHCentered)->addText($kriteriaIndex->kriteria ?? 0, ['size' => 8]);
                $table->addCell(1000, ['valign' => 'center', 'borderSize' => 2, 'borderColor' => '000000'])->addTextRun($cellHCentered)->addText($kriteriaIndex->nilai ?? 0, ['size' => 8]);

                //Begin::Keterangan Selection

                if (!empty($kriteriaIndex->keterangan)) {
                    $cellKeterangan = $table->addCell(2000, ['borderSize' => 2, 'borderColor' => '000000']);
                    // $addTextRunKeterangan = $cellKeterangan->addTextRun(['spaceAfter' => 0]);
                    // $textKeterangan = nl2br(htmlspecialchars($kriteriaIndex->keterangan, ENT_QUOTES));
                    // $textExplodeKeterangan = explode('<br />', $textKeterangan);
                    // $addTextRunKeterangan->addText(array_shift($textExplodeKeterangan), ['size' => 8]);
                    // if (count($textExplodeKeterangan) > 1) {
                    //     foreach ($textExplodeKeterangan as $line) {
                    //         $addTextRunKeterangan->addTextBreak();
                    //         $addTextRunKeterangan->addText($line, ['size' => 8]);
                    //     }
                    // }
                    $cellKeterangan->addText(str_replace("\r\n", '</w:t><w:br/><w:t>', htmlspecialchars($kriteriaIndex->keterangan, ENT_QUOTES)), ["bold" => false, 'size' => 8], ["align" => "left", "spacing" => 0, "spaceBefore" => 1, "spaceAfter" => 1]);
                    // $kriteriaIndex1ListKeterangan = preg_split("/\n|\r\n?/", htmlspecialchars($kriteriaIndex->keterangan, ENT_QUOTES));
                    // foreach ($kriteriaIndex1ListKeterangan as $key => $text) {
                    //     $cellKeterangan->addText($text, ["bold" => false, 'size' => 8], ["align" => "left"]);
                    //     if ($text == "") {
                    //         $cellKeterangan->addTextBreak(1, ['size' => 5], ['afterSpacing' => 0, 'spacing' => 10]);
                    //     }
                    // }
                } else {
                    $table->addCell(2000, ['valign' => 'center', 'borderSize' => 2, 'borderColor' => '000000'])->addTextRun(['spaceAfter' => 0]);
                }
                $count++;
                //End::Keterangan Selection
            });
        } else {
            //FINANCIAL
            $table->addRow();
            $table->addCell(1000, ['borderSize' => 2, 'borderColor' => '000000', 'bgColor' => 'FFFEA8'])->addTextRun(['spaceAfter' => 0]);
            $table->addCell(1000, ['gridSpan' => 6, 'borderSize' => 2, 'borderColor' => '000000', 'bgColor' => 'FFFEA8'])->addText('FINANCIAL', ['size' => 8, 'bold' => true], ["align" => "left", "spacing" => 0, "spaceBefore" => 1, "spaceAfter" => 1]);

            $kriteriaSelect = $lp->each(function ($ks, $k) use ($table, $cellHCentered, $kriteriaPenggunaJasaDetail, &$count) {
                $table->addRow();

                $kriteriaIndex = $kriteriaPenggunaJasaDetail->where('index', $count)->first();
                if ($ks->item == "Kepatuhan Pembayaran Pajak") {
                    $kriteriaIndex = $kriteriaPenggunaJasaDetail->where('index', $count)->first();
                }

                $table->addCell(1000, ['valign' => 'center', 'borderSize' => 2, 'borderColor' => '000000'])->addText($count, ['size' => 8], ["align" => "left", "spacing" => 0, "spaceBefore" => 1, "spaceAfter" => 1]);
                $table->addCell(1000, ['borderSize' => 2, 'borderColor' => '000000'])->addText($ks->item, ['size' => 8], ["align" => "left", "spacing" => 0, "spaceBefore" => 1, "spaceAfter" => 1]);
                $table->addCell(1000, ['valign' => 'center', 'borderSize' => 2, 'borderColor' => '000000'])->addTextRun($cellHCentered)->addText($ks->bobot, ['size' => 8], ["align" => "left", "spacing" => 0, "spaceBefore" => 1, "spaceAfter" => 1]);

                switch ($kriteriaIndex->kriteria) {
                    case 1:
                        $selectedKriteria = $ks->kriteria_1;
                        break;
                    case 2:
                        $selectedKriteria = $ks->kriteria_2;
                        break;
                    case 3:
                        $selectedKriteria = $ks->kriteria_3;
                        break;
                    case 4:
                        $selectedKriteria = $ks->kriteria_4;
                        break;

                    default:
                        $selectedKriteria = "Tidak Ada";
                        break;
                }

                //Begin::Kriteria Selection
                $cellKriteria1 = $table->addCell(1000, ['borderSize' => 2, 'borderColor' => '000000']);
                // $addTextRun1 = $cellKriteria1->addTextRun(['spaceAfter' => 0]);
                // $text1 = nl2br(htmlspecialchars($selectedKriteria, ENT_QUOTES));
                // $textExplode1 = explode('<br />', $text1);
                // $addTextRun1->addText(array_shift($textExplode1), ['size' => 8]);
                // if (count($textExplode1) > 1) {
                //     foreach ($textExplode1 as $line) {
                //         $addTextRun1->addTextBreak();
                //         $addTextRun1->addText($line, ['size' => 8]);
                //     }
                // }
                $cellKriteria1->addText(str_replace("\r\n", '</w:t><w:br/><w:t>', htmlspecialchars($selectedKriteria, ENT_QUOTES)), ["bold" => false, 'size' => 8], ["align" => "left", "spacing" => 0, "spaceBefore" => 1, "spaceAfter" => 1]);
                // $kriteriaIndex1List = preg_split("/\n|\r\n?/", htmlspecialchars($selectedKriteria, ENT_QUOTES));
                // foreach ($kriteriaIndex1List as $key => $text) {
                //     $cellKriteria1->addText($text, ["bold" => false, 'size' => 8], ["align" => "left"]);
                //     if ($text == "") {
                //         $cellKriteria1->addTextBreak(1, ['size' => 5], ['afterSpacing' => 0, 'spacing' => 10]);
                //     }
                // }
                //End::Kriteria Selection

                $table->addCell(1000, ['valign' => 'center', 'borderSize' => 2, 'borderColor' => '000000'])->addTextRun($cellHCentered)->addText($kriteriaIndex->kriteria ?? 0, ['size' => 8]);
                $table->addCell(1000, ['valign' => 'center', 'borderSize' => 2, 'borderColor' => '000000'])->addTextRun($cellHCentered)->addText($kriteriaIndex->nilai ?? 0, ['size' => 8]);

                //Begin::Keterangan Selection

                if (!empty($kriteriaIndex->keterangan)) {
                    $cellKeterangan = $table->addCell(2000, ['borderSize' => 2, 'borderColor' => '000000']);
                    // $addTextRunKeterangan = $cellKeterangan->addTextRun(['spaceAfter' => 0]);
                    // $textKeterangan = nl2br(htmlspecialchars($kriteriaIndex->keterangan, ENT_QUOTES));
                    // $textExplodeKeterangan = explode('<br />', $textKeterangan);
                    // $addTextRunKeterangan->addText(array_shift($textExplodeKeterangan), ['size' => 8]);
                    // if (count($textExplodeKeterangan) > 1) {
                    //     foreach ($textExplodeKeterangan as $line) {
                    //         $addTextRunKeterangan->addTextBreak();
                    //         $addTextRunKeterangan->addText($line, ['size' => 8]);
                    //     }
                    // }
                    $cellKeterangan->addText(str_replace("\r\n", '</w:t><w:br/><w:t>', htmlspecialchars($kriteriaIndex->keterangan, ENT_QUOTES)), ["bold" => false, 'size' => 8], ["align" => "left", "spacing" => 0, "spaceBefore" => 1, "spaceAfter" => 1]);
                    // $kriteriaIndex1ListKeterangan = preg_split("/\n|\r\n?/", htmlspecialchars($kriteriaIndex->keterangan, ENT_QUOTES));
                    // foreach ($kriteriaIndex1ListKeterangan as $key => $text) {
                    //     $cellKeterangan->addText($text, ["bold" => false, 'size' => 8], ["align" => "left"]);
                    //     if ($text == "") {
                    //         $cellKeterangan->addTextBreak(1, ['size' => 5], ['afterSpacing' => 0, 'spacing' => 10]);
                    //     }
                    // }
                } else {
                    $table->addCell(2000, ['valign' => 'center', 'borderSize' => 2, 'borderColor' => '000000'])->addTextRun(['spaceAfter' => 0]);
                }
                $count++;
                //End::Keterangan Selection
            });
        }
        

    });

    //End::Kriteria Pengguna Jasa

    //Begin::Total
    $totalBobot = KriteriaPenggunaJasa::all()->sum('bobot');
    $totalScore = $kriteriaPenggunaJasaDetail->sum('nilai') ?? 0;
    $kriteriaFinal = PenilaianPenggunaJasa::all()->filter(function ($item) use ($totalScore) {
        return $item->dari_nilai <= $totalScore && $item->sampai_nilai >= $totalScore;
    })->first()->nama ?? '-';

    $table->addRow();
    $table->addCell(1000, ['valign' => 'center', 'bgColor' => '8496B0', 'borderSize' => 3, 'borderColor' => '000000', 'afterSpacing' => 0])->addTextRun(['spaceAfter' => 0]);
    $table->addCell(1000, ['valign' => 'center', 'bgColor' => '8496B0', 'borderSize' => 3, 'borderColor' => '000000', 'afterSpacing' => 0])->addTextRun($cellHCentered)->addText('TOTAL', ['size' => 8, 'bold' => true, 'color' => 'FFFFFF'], ["align" => "left", "spacing" => 0, "spaceBefore" => 1, "spaceAfter" => 1]);
    $table->addCell(1000, ['valign' => 'center', 'bgColor' => '8496B0', 'borderSize' => 3, 'borderColor' => '000000', 'afterSpacing' => 0])->addTextRun($cellHCentered)->addText($totalBobot, ['size' => 8, 'bold' => true, 'color' => 'FFFFFF'], ["align" => "left", "spacing" => 0, "spaceBefore" => 1, "spaceAfter" => 1]);
    // $table->addCell(1000, ['gridSpan' => 4, 'valign' => 'center', 'bgColor' => '8496B0', 'borderSize' => 3, 'borderColor' => '000000', 'afterSpacing' => 0])->addTextRun(['spaceAfter' => 0]);
    $table->addCell(1000, ['valign' => 'center', 'bgColor' => '8496B0', 'borderSize' => 3, 'borderColor' => '000000', 'afterSpacing' => 0])->addTextRun(['spaceAfter' => 0]);
    $table->addCell(1000, ['valign' => 'center', 'bgColor' => '8496B0', 'borderSize' => 3, 'borderColor' => '000000', 'afterSpacing' => 0])->addTextRun(['spaceAfter' => 0]);
    $table->addCell(1000, ['valign' => 'center', 'bgColor' => '8496B0', 'borderSize' => 3, 'borderColor' => '000000', 'afterSpacing' => 0])->addTextRun($cellHCentered)->addText($totalScore, ['size' => 8, 'bold' => true, 'color' => 'FFFFFF'], ["align" => "left", "spacing" => 0, "spaceBefore" => 1, "spaceAfter" => 1]);
    $table->addCell(2000, ['valign' => 'center', 'bgColor' => '8496B0', 'borderSize' => 3, 'borderColor' => '000000', 'afterSpacing' => 0])->addTextRun($cellHCentered)->addText($kriteriaFinal, ['size' => 8, 'bold' => true, 'color' => 'FFFFFF'], ["align" => "left", "spacing" => 0, "spaceBefore" => 1, "spaceAfter" => 1]);

    //End::Total

    //Begin::Rumus
    // $section->addTextBreak(1);
    $section->addText("Catatan untuk skoring :", ['size' => 8, 'bold' => true], ['align' => 'left']);
    $section->addTextRun(['spaceAfter' => 0])->addText(htmlspecialchars("340 <= X <= 400         : Risiko Rendah"), ['size' => 8, 'bgColor' => $kriteriaFinal == "Risiko Rendah" ? 'FFB77D' : ''], ['align' => 'left']);
    $section->addTextRun(['spaceAfter' => 0])->addText(htmlspecialchars("260 <= X <= 240         : Risiko Moderat"), ['size' => 8, 'bgColor' => $kriteriaFinal == "Risiko Moderat" ? 'FFB77D' : ''], ['align' => 'left']);
    $section->addTextRun(['spaceAfter' => 0])->addText(htmlspecialchars("180 <= X <= 260         : Risiko Tinggi"), ['size' => 8, 'bgColor' => $kriteriaFinal == "Risiko Tinggi" ? 'FFB77D' : ''], ['align' => 'left']);
    $section->addTextRun(['spaceAfter' => 0])->addText(htmlspecialchars("100 <= X <= 180         : Risiko Ekstrim"), ['size' => 8, 'bgColor' => $kriteriaFinal == "Risiko Ekstrim" ? 'FFB77D' : ''], ['align' => 'left']);
    //End::Rumus

    // $section2 = $phpWord->addSection();
    // $section2->addText("lorem ipsum");

    //End::Body
    $filePath = public_path('/file-profile-risiko//' . $file_name . '.docx');
    // $rendererName = \PhpOffice\PhpWord\Settings::PDF_RENDERER_DOMPDF;
    // $rendererLibraryPath = realpath('../vendor/dompdf/dompdf');
    // \PhpOffice\PhpWord\Settings::setPdfRenderer($rendererName, $rendererLibraryPath);

    $phpWord->save($filePath);
    // dd("Tes");

    // Begin :: CONVERT Template docx to PDF

    $templatePhpWord = \PhpOffice\PhpWord\IOFactory::load(public_path('/file-profile-risiko//' . $file_name . ".docx"));
    $rendererName = \PhpOffice\PhpWord\Settings::PDF_RENDERER_DOMPDF;
    $rendererLibraryPath = realpath('../vendor/dompdf/dompdf');
    \PhpOffice\PhpWord\Settings::setPdfRenderer($rendererName, $rendererLibraryPath);
    $xmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($templatePhpWord, 'PDF');
    $xmlWriter->save(public_path('/file-profile-risiko//' . $file_name . ".pdf"));

    // \PhpOffice\PhpWord\Settings::setPdfRendererName(\PhpOffice\PhpWord\Settings::PDF_RENDERER_TCPDF);
    // // Path to directory with tcpdf.php file.
    // // Rigth now `TCPDF` writer is depreacted. Consider to use `DomPDF` or `MPDF` instead.
    // \PhpOffice\PhpWord\Settings::setPdfRendererPath('../vendor/tecnickcom/tcpdf');

    // $xmlWriter = \PhpOffice\PhpWord\IOFactory::load(public_path('/file-profile-risiko//' . $file_name . ".docx"));
    // $xmlWriter->save(public_path('/file-profile-risiko//' . $file_name . ".pdf"), 'PDF');
    // end :: CONVERT Template docx to PDF

    File::delete(public_path('/file-profile-risiko//' . $file_name . ".docx"));
    return $file_name . ".pdf";
    // $proyek->file_penilaian_risiko = $file_name . '.pdf';
    // return $proyek->save();
}

function createWordPersetujuanOld(App\Models\Proyek $proyek, \Illuminate\Support\Collection $hasil_assessment = new \Illuminate\Support\Collection(), $is_proyek_besar, $is_proyek_mega, \Illuminate\Http\Request $request)
{
    $phpWord = new \PhpOffice\PhpWord\PhpWord();
    $target_path = "file-persetujuan";
    $now = Carbon\Carbon::now();
    $file_name = $now->format("dmYHis") . "_nota-persetujuan_$proyek->kode_proyek";
    $internal_score = $hasil_assessment->sum(function($ra) {
        if($ra->kategori == "Internal") {
            return $ra->score;
        }
    });
    $eksternal_score = $hasil_assessment->sum(function($ra) {
        if($ra->kategori == "Eksternal") {
            return $ra->score;
        }
    });

    // $penyusun = collect(json_decode($proyek->approved_penyusun))->values()->toArray();
    $penyusun = collect(json_decode($proyek->approved_verifikasi))->values()->toArray();
    $rekomendator = json_decode($proyek->approved_rekomendasi_final);
    $penyetuju = json_decode($proyek->approved_persetujuan);
    $max_grid_span = collect([!empty($penyusun) ? count($penyusun) : 0, !empty($rekomendator) ? count($rekomendator) : 0, !empty($penyetuju) ? count($penyetuju) : 0])->max();
    // dd($penyusun, $rekomendator, $penyetuju, $max_grid_span);

    $section = $phpWord->addSection();
    
    $section->addText("NOTA REKOMENDASI TAHAP I", ['size'=>12, "bold" => true], ['align' => "center"]);
    $section->addText("Seleksi Pengguna Jasa Non Green Lane", ['size'=>12, "bold" => true], ['align' => "center"]);

    if ($is_proyek_mega) {
        $section->addText("Proyek Mega", ['size'=>12, "bold" => true], ['align' => "center"]);
    } else if ($is_proyek_besar) {
        $section->addText("Proyek Besar", ['size'=>12, "bold" => true], ['align' => "center"]);
    } else {
        $section->addText("Proyek Kecil / Proyek Menengah", ['size'=>12, "bold" => true], ['align' => "center"]);
    }

    $section->addTextBreak(1);
    $table = $section->addTable('myOwnTableStyle',array('borderSize' => 1, 'borderColor' => '999999', 'afterSpacing' => 0, 'Spacing'=> 0, 'cellMargin'=>0  ));
    $table->addRow(-0.5, array('exactHeight' => -5));

    $styleCell = array('borderTopSize'=>1 ,'borderTopColor' =>'black','borderLeftSize'=>1,'borderLeftColor' =>'black','borderRightSize'=>1,'borderRightColor'=>'black','borderBottomSize' =>1,'borderBottomColor'=>'black', 'textAlignment' => \PhpOffice\PhpWord\SimpleType\TextAlignment::CENTER);
    $TstyleCell = array("bgColor" => "F4B083", 'borderTopSize'=>1 ,'borderTopColor' =>'black','borderLeftSize'=>1,'borderLeftColor' =>'black','borderRightSize'=>1,'borderRightColor'=>'black','borderBottomSize' =>1,'borderBottomColor'=>'black' );
    $TfontStyle = array('bold'=>true, 'italic'=> false, 'size'=>10, 'name' => 'Times New Roman', 'afterSpacing' => 0, 'Spacing'=> 0, 'cellMargin'=>0, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::BOTH);
    $fontStyle = array('bold'=>false, 'italic'=> false, 'size'=>10, 'name' => 'Times New Roman', 'afterSpacing' => 0, 'Spacing'=> 0, 'cellMargin'=>0, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::BOTH);


    $table->addCell(500,$TstyleCell)->addText('No',$TfontStyle);
    $table->addCell(2500,$TstyleCell)->addText("Item", $TfontStyle);
    $table->addCell(6000,$TstyleCell)->addText('Uraian',$TfontStyle);

    $nama_proyek = str_replace("&", "dan", $proyek->nama_proyek);
    $table->addRow();
    $table->addCell(500,$styleCell)->addText('1', $fontStyle);
    $table->addCell(2500,$styleCell)->addText("Nama Proyek", $fontStyle);
    $table->addCell(6000, $styleCell)->addText($nama_proyek, $fontStyle);
    $table->addRow();
    $table->addCell(500,$styleCell)->addText('2', $fontStyle);
    $table->addCell(2500,$styleCell)->addText("Lokasi Proyek", $fontStyle);
    $table->addCell(6000, $styleCell)->addText(Provinsi::find($proyek->provinsi)->province_name ?? "-", $fontStyle);
    $table->addRow();
    $table->addCell(500,$styleCell)->addText('3', $fontStyle);
    $table->addCell(2500, $styleCell)->addText("Nama Pengguna Jasa", $fontStyle);
    $table->addCell(6000,$styleCell)->addText($proyek->proyekBerjalan->name_customer, $fontStyle);
    $table->addRow();
    $table->addCell(500,$styleCell)->addText('4', $fontStyle);
    $table->addCell(2500, $styleCell)->addText("Instansi Pengguna Jasa", $fontStyle);
    $table->addCell(6000,$styleCell)->addText($proyek->proyekBerjalan->Customer->jenis_instansi, $fontStyle);
    $table->addRow();
    $table->addCell(500,$styleCell)->addText('5', $fontStyle);
    $table->addCell(2500,$styleCell)->addText("Sumber Pendanaan Proyek", $fontStyle);
    $table->addCell(6000,$styleCell)->addText($proyek->sumber_dana, $fontStyle);
    $table->addRow();
    $table->addCell(500,$styleCell)->addText('6', $fontStyle);
    $table->addCell(2500, $styleCell)->addText("Perkiraan Nilai Proyek", $fontStyle);
    $table->addCell(6000,$styleCell)->addText(number_format($proyek->nilaiok_awal, 0, ".", "."), $fontStyle);
    $table->addRow();
    $table->addCell(500,$styleCell)->addText('7', $fontStyle);
    $table->addCell(2500,$styleCell)->addText("Kategori Proyek", $fontStyle);
    $table->addCell(6000,$styleCell)->addText($proyek->klasifikasi_pasdin ?? "-", $fontStyle);
    $table->addRow();
    $table->addCell(500,$styleCell)->addText('8', $fontStyle);
    $table->addCell(2500,$styleCell)->addText("Assessment Eksternal Atas Pengguna Jasa", $fontStyle);
    $table->addCell(6000,$styleCell)->addText($eksternal_score ?? "-", $fontStyle);
    $table->addRow();
    $table->addCell(500,$styleCell)->addText('9', $fontStyle);
    $table->addCell(2500,$styleCell)->addText("Assessment Internal Atas Pengguna Jasa ", $fontStyle);
    $table->addCell(6000,$styleCell)->addText($internal_score ?? "-", $fontStyle);
    $table->addRow();
    $table->addCell(500,$styleCell)->addText('10', $fontStyle);
    $table->addCell(2500,$styleCell)->addText("Catatan", $fontStyle);
    $cell_catatan = $table->addCell(6000, $styleCell);
    $catatan_list = preg_split("/\n|\r\n?/", htmlspecialchars($proyek->catatan_nota_rekomendasi, ENT_QUOTES));
    foreach ($catatan_list as $key => $catatan) {
        $cell_catatan->addText($catatan, ["bold" => false], ["align" => "left"]);
        if ($catatan == "") {
            $cell_catatan->addTextBreak(1, ['size' => 5], ['afterSpacing' => 0, 'spacing' => 10]);
            // $cell_catatan->addText("<w:br/>");
        }
    }

    $section->addText("Berdasarkan informasi di atas, mengajukan untuk mengikuti aktifitas Perolehan Kontrak (tender) tersebut di atas.");

    $section->addTextBreak(5);
    $section2 = $phpWord->addSection();
    // $section2->addPageBreak();

    $table_ttd = $section2->addTable('ttd_table',array('borderSize' => 1, 'borderColor' => '999999', 'afterSpacing' => 0, 'Spacing'=> 0, 'cellMargin'=>0  ));
    // $table_ttd->addRow();
    $table_ttd->addRow();

    $header_cell = $table_ttd->addCell(3000, ["vMerge" => "restart", "gridSpan" => 2, "bgColor" => "F4B083"]);
    $header_cell->addText("Disusun oleh,", ["bold" => true], ["align" => "center"]);
    // $header_cell->addText(null, ["bold" => true]);

    // New TTD Method
    $table_ttd->addRow();
    if (!empty($penyusun)) {
        // dd($penyusun);
        $total_penyusun = count($penyusun);
        foreach ($penyusun as $key => $p) {

            $key++;
            $total_penyusun = count($penyusun);

            if ($total_penyusun == 1) {
                $cell_2_ttd = $table_ttd->addCell(3000, ["vMerge" => "restart", "gridSpan" => 2]);
            } else {
                if ($total_penyusun % 2 == 0) {
                    if ($key % 2 != 0) {
                        $table_ttd->addRow();
                    }
                    $cell_2_ttd = $table_ttd->addCell(3000, ["vMerge" => "restart", "gridSpan" => 1]);
                } else {
                    if ($key == 3 || $key == 5) {
                        $table_ttd->addRow();
                    }
                    if (($total_penyusun == 3 && $key == 3) || ($total_penyusun == 5 && $key == 5)) {
                        $cell_2_ttd = $table_ttd->addCell(3000, ["vMerge" => "restart", "gridSpan" => 2]);
                    } else {
                        $cell_2_ttd = $table_ttd->addCell(3000, ["vMerge" => "restart", "gridSpan" => 1]);
                    }
                }
            }


            $tanggal_ttd = Carbon\Carbon::create($p->tanggal);
            // $cell_2_ttd->addText($now->translatedFormat("l, d F Y"), ["bold" => true], ["align" => "center"]);
            $cell_2_ttd->addTextBreak(1);
            $cell_2_ttd->addText("$" . "{ttdPenyusun$key}", ["bold" => false], ["align" => "center"]);
            $cell_2_ttd->addTextBreak(1);
            $cell_2_ttd->addText(User::find($p->user_id)->name, ["bold" => true], ["align" => "center"]);
            $cell_2_ttd->addText(User::find($p->user_id)->Pegawai->Jabatan?->nama_jabatan, ["bold" => true], ["align" => "center"]);
            $cell_2_ttd->addText("Tanggal: " . $tanggal_ttd->translatedFormat("d F Y"), ["bold" => true, "size" => 7], ["align" => "center"]);
            // if ($p->status == "approved" && empty($p->catatan)) {
            //     $cell_2_ttd->addText("Direkomendasikan", ["bold" => true, "size" => 7], ["align" => "center"]);
            // } elseif ($p->status == "approved" && !empty($p->catatan)) {
            //     $cell_2_ttd->addText("Direkomendasikan dengan catatan", ["bold" => true, "size" => 7], ["align" => "center"]);
            // } else {
            //     $cell_2_ttd->addText("Tidak Direkomendasikan", ["bold" => true, "size" => 7], ["align" => "center"]);
            // }
        }
    }
    
    // $cell_2_ttd = $table_ttd->addCell(500);
    // $cell_2_ttd = $table_ttd->addCell(500);
    // // $cell_2_ttd->addText($now->translatedFormat("l, d F Y"), ["bold" => true], ["align" => "center"]);
    // $cell_2_ttd->addTextBreak(1);
    // $cell_2_ttd->addText("$" . "{ttdPenyusun2}", ["bold" => false], ["align" => "center"]);
    // $cell_2_ttd->addText(User::find($penyusun[0]->user_id)->name, ["bold" => true], ["align" => "center"]);
    // $cell_2_ttd->addText(User::find($penyusun[0]->user_id)->Pegawai->Jabatan?->nama_jabatan, ["bold" => true], ["align" => "center"]);
    // $cell_2_ttd->addText("Tanggal: " . $now->translatedFormat("d F Y"), ["bold" => true, "size" => 7], ["align" => "center"]);

    $table_ttd->addRow();
    $header_cell = $table_ttd->addCell(3000, ["vMerge" => "restart", "gridSpan" => 2, "bgColor" => "F4B083"]);
    $header_cell->addText("Direkomendasi oleh,", ["bold" => true], ["align" => "center"]);
    // $header_cell->addText(null, ["bold" => true]);

    $table_ttd->addRow();
    if (!empty($rekomendator)) {
        foreach ($rekomendator as $key => $p) {
            $key++;
            $total_rekomendator = count($rekomendator);
            if ($total_rekomendator == 1) {
                $cell_3_ttd = $table_ttd->addCell(3000, ["vMerge" => "restart", "gridSpan" => 2]);
            } else {
                if ($total_rekomendator % 2 == 0) {
                    if ($key % 2 != 0) {
                        $table_ttd->addRow();
                    }
                    $cell_3_ttd = $table_ttd->addCell(3000, ["vMerge" => "restart", "gridSpan" => 1]);
                } else {
                    if ($key == 3 || $key == 5) {
                        $table_ttd->addRow();
                    }
                    if (($total_rekomendator == 3 && $key == 3) || ($total_rekomendator == 5 && $key == 5)) {
                        $cell_3_ttd = $table_ttd->addCell(3000, ["vMerge" => "restart", "gridSpan" => 2]);
                    } else {
                        $cell_3_ttd = $table_ttd->addCell(3000, ["vMerge" => "restart", "gridSpan" => 1]);
                    }
                }
            }
            $tanggal_ttd = Carbon\Carbon::create($p->tanggal);
            // $cell_3_ttd->addText($now->translatedFormat("l, d F Y"), ["bold" => true], ["align" => "center"]);
            $cell_3_ttd->addTextBreak(1);
            $cell_3_ttd->addText("$" . "{ttdRekomendasi$key}", ["bold" => false], ["align" => "center"]);
            $cell_3_ttd->addTextBreak(1);
            $cell_3_ttd->addText(User::find($p->user_id)->name, ["bold" => true], ["align" => "center"]);
            $cell_3_ttd->addText(User::find($p->user_id)->Pegawai->Jabatan?->nama_jabatan, ["bold" => true], ["align" => "center"]);
            $cell_3_ttd->addText("Tanggal: " . $tanggal_ttd->translatedFormat("d F Y"), ["bold" => true, "size" => 7], ["align" => "center"]);
            if ($p->status == "approved" && empty($p->catatan)) {
                $cell_3_ttd->addText("Direkomendasikan", ["bold" => true, "size" => 7], ["align" => "center"]);
            } elseif ($p->status == "approved" && !empty($p->catatan)) {
                $cell_3_ttd->addText("Direkomendasikan dengan catatan", ["bold" => true, "size" => 7], ["align" => "center"]);
            } else {
                $cell_3_ttd->addText("Tidak Direkomendasikan", ["bold" => true, "size" => 7], ["align" => "center"]);
            }
        }
    }

    // $cell_2_ttd = $table_ttd->addCell(500);
    // // $cell_2_ttd->addText($now->translatedFormat("l, d F Y"), ["bold" => true], ["align" => "center"]);
    // $cell_2_ttd->addTextBreak(1);
    // $cell_2_ttd->addText("$" . "{ttdRekomendasi2}", ["bold" => false], ["align" => "center"]);
    // $cell_2_ttd->addText(User::find($rekomendator[0]->user_id)->name, ["bold" => true], ["align" => "center"]);
    // $cell_2_ttd->addText(User::find($rekomendator[0]->user_id)->Pegawai->Jabatan?->nama_jabatan, ["bold" => true], ["align" => "center"]);
    // $cell_2_ttd->addText("Tanggal: " . $now->translatedFormat("d F Y"), ["bold" => true, "size" => 7], ["align" => "center"]);
    
    // $cell_2_ttd = $table_ttd->addCell(500);
    // // $cell_2_ttd->addText($now->translatedFormat("l, d F Y"), ["bold" => true], ["align" => "center"]);
    // $cell_2_ttd->addTextBreak(1);
    // $cell_2_ttd->addText("$" . "{ttdRekomendasi3}", ["bold" => false], ["align" => "center"]);
    // $cell_2_ttd->addText(User::find($rekomendator[0]->user_id)->name, ["bold" => true], ["align" => "center"]);
    // $cell_2_ttd->addText(User::find($rekomendator[0]->user_id)->Pegawai->Jabatan?->nama_jabatan, ["bold" => true], ["align" => "center"]);
    // $cell_2_ttd->addText("Tanggal: " . $now->translatedFormat("d F Y"), ["bold" => true, "size" => 7], ["align" => "center"]);
    
    // $table_ttd->addRow();
    // $cell_2_ttd = $table_ttd->addCell(500);
    // // $cell_2_ttd->addText($now->translatedFormat("l, d F Y"), ["bold" => true], ["align" => "center"]);
    // $cell_2_ttd->addTextBreak(1);
    // $cell_2_ttd->addText("$" . "{ttdRekomendasi4}", ["bold" => false], ["align" => "center"]);
    // $cell_2_ttd->addText(User::find($rekomendator[0]->user_id)->name, ["bold" => true], ["align" => "center"]);
    // $cell_2_ttd->addText(User::find($rekomendator[0]->user_id)->Pegawai->Jabatan?->nama_jabatan, ["bold" => true], ["align" => "center"]);
    // $cell_2_ttd->addText("Tanggal: " . $now->translatedFormat("d F Y"), ["bold" => true, "size" => 7], ["align" => "center"]);

    // $cell_2_ttd = $table_ttd->addCell(500);
    // // $cell_2_ttd->addText($now->translatedFormat("l, d F Y"), ["bold" => true], ["align" => "center"]);
    // $cell_2_ttd->addTextBreak(4);
    // // $cell_2_ttd->addText("(.......................................................)", ["bold" => true], ["align" => "center"]);
    // // $cell_2_ttd->addText("SVP Risk Management", ["bold" => true], ["align" => "center"]);
    // // $cell_2_ttd->addText("Tanggal: ___________________" . $now->translatedFormat("Y"), ["bold" => true, "size" => 7], ["align" => "center"]);
    
    // $cell_2_ttd = $table_ttd->addCell(500);
    // // $cell_2_ttd->addText($now->translatedFormat("l, d F Y"), ["bold" => true], ["align" => "center"]);
    // $cell_2_ttd->addTextBreak(1);
    // $cell_2_ttd->addText("$" . "{ttdRekomendasi5}", ["bold" => false], ["align" => "center"]);
    // $cell_2_ttd->addText(User::find($rekomendator[0]->user_id)->name, ["bold" => true], ["align" => "center"]);
    // $cell_2_ttd->addText(User::find($rekomendator[0]->user_id)->Pegawai->Jabatan?->nama_jabatan, ["bold" => true], ["align" => "center"]);
    // $cell_2_ttd->addText("Tanggal: " . $now->translatedFormat("d F Y"), ["bold" => true, "size" => 7], ["align" => "center"]);
    
    $table_ttd->addRow();
    $header_cell = $table_ttd->addCell(3000, ["vMerge" => "restart", "gridSpan" => 2, "bgColor" => "F4B083"]);
    $header_cell->addText("Persetujuan oleh,", ["bold" => true], ["align" => "center"]);
    // $header_cell->addText(null, ["bold" => true]);

    // $unit_kerja = $proyek->UnitKerja;
    $table_ttd->addRow();
    if (!empty($penyetuju)) {
        foreach ($penyetuju as $key => $p) {
            $key++;
            $total_penyetuju = count($penyetuju);
            if ($total_penyetuju == 1) {
                $cell_4_ttd = $table_ttd->addCell(3000, ["vMerge" => "restart", "gridSpan" => 2]);
            } else {
                if ($total_penyetuju % 2 == 0) {
                    if ($key % 2 != 0) {
                        $table_ttd->addRow();
                    }
                    $cell_4_ttd = $table_ttd->addCell(3000, ["vMerge" => "restart", "gridSpan" => 1]);
                } else {
                    if ($key == 3 || $key == 5) {
                        $table_ttd->addRow();
                    }
                    if (($total_penyetuju == 3 && $key == 3) || ($total_penyetuju == 5 && $key == 5)) {
                        $cell_4_ttd = $table_ttd->addCell(3000, ["vMerge" => "restart", "gridSpan" => 2]);
                    } else {
                        $cell_4_ttd = $table_ttd->addCell(3000, ["vMerge" => "restart", "gridSpan" => 1]);
                    }
                }
            }
            $tanggal_ttd = Carbon\Carbon::create($p->tanggal);
            $cell_4_ttd->addTextBreak(1);
            $cell_4_ttd->addText("$" . "{ttdPersetujuan$key}", ["bold" => false], ["align" => "center"]);
            $cell_4_ttd->addTextBreak(1);
            $cell_4_ttd->addText(User::find($p->user_id)->name ?? Auth::user()->name, ["bold" => true], ["align" => "center"]);
            $cell_4_ttd->addText(User::find($p->user_id)->Pegawai->Jabatan?->nama_jabatan ?? Auth::user()->Pegawai->Jabatan?->nama_jabatan, ["bold" => true], ["align" => "center"]);
            $cell_4_ttd->addText("Tanggal: " . $tanggal_ttd->translatedFormat("d F Y"), ["bold" => true, "size" => 7], ["align" => "center"]);
            if ($p->status == "approved" && empty($p->catatan)) {
                $cell_4_ttd->addText("Direkomendasikan", ["bold" => true, "size" => 7], ["align" => "center"]);
            } elseif ($p->status == "approved" && !empty($p->catatan)) {
                $cell_4_ttd->addText("Direkomendasikan dengan catatan", ["bold" => true, "size" => 7], ["align" => "center"]);
            } else {
                $cell_4_ttd->addText("Tidak Direkomendasikan", ["bold" => true, "size" => 7], ["align" => "center"]);
            }
        }
    }
    // $cell_2_ttd->addText($now->translatedFormat("l, d F Y"), ["bold" => true], ["align" => "center"]);

    // $cell_2_ttd = $table_ttd->addCell(500);
    // $cell_2_ttd = $table_ttd->addCell(500);
    // // $cell_2_ttd->addText($now->translatedFormat("l, d F Y"), ["bold" => true], ["align" => "center"]);
    // $cell_2_ttd->addTextBreak(1);
    // $cell_2_ttd->addText("$" . "{ttdPersetujuan2}", ["bold" => false], ["align" => "center"]);
    // $cell_2_ttd->addTextBreak(1);
    // $cell_2_ttd->addText(User::find($penyetuju[0]->user_id)->name ?? Auth::user()->name, ["bold" => true], ["align" => "center"]);
    // $cell_2_ttd->addText(User::find($penyetuju[0]->user_id)->Pegawai->Jabatan?->nama_jabatan ?? Auth::user()->Pegawai->Jabatan?->nama_jabatan, ["bold" => true], ["align" => "center"]);
    // $cell_2_ttd->addText("Tanggal: " . $now->translatedFormat("d F Y"), ["bold" => true, "size" => 7], ["align" => "center"]);

    // $table_ttd->addRow();
    // $cell_2_ttd = $table_ttd->addCell(500);
    // // $cell_2_ttd->addText($now->translatedFormat("l, d F Y"), ["bold" => true], ["align" => "center"]);
    // $cell_2_ttd->addTextBreak(1);
    // $cell_2_ttd->addText("$" . "{ttdPersetujuan3}", ["bold" => false], ["align" => "center"]);
    // $cell_2_ttd->addTextBreak(1);
    // $cell_2_ttd->addText(User::find($penyetuju[0]->user_id)->name ?? Auth::user()->name, ["bold" => true], ["align" => "center"]);
    // $cell_2_ttd->addText(User::find($penyetuju[0]->user_id)->Pegawai->Jabatan?->nama_jabatan ?? Auth::user()->Pegawai->Jabatan?->nama_jabatan, ["bold" => true], ["align" => "center"]);
    // $cell_2_ttd->addText("Tanggal: " . $now->translatedFormat("d F Y"), ["bold" => true, "size" => 7], ["align" => "center"]);

    // $cell_2_ttd = $table_ttd->addCell(500);
    // $cell_2_ttd = $table_ttd->addCell(500);
    // // $cell_2_ttd->addText($now->translatedFormat("l, d F Y"), ["bold" => true], ["align" => "center"]);
    // $cell_2_ttd->addTextBreak(1);
    // $cell_2_ttd->addText("$" . "{ttdPersetujuan4}", ["bold" => false], ["align" => "center"]);
    // $cell_2_ttd->addTextBreak(1);
    // $cell_2_ttd->addText(User::find($penyetuju[0]->user_id)->name ?? Auth::user()->name, ["bold" => true], ["align" => "center"]);
    // $cell_2_ttd->addText(User::find($penyetuju[0]->user_id)->Pegawai->Jabatan?->nama_jabatan ?? Auth::user()->Pegawai->Jabatan?->nama_jabatan, ["bold" => true], ["align" => "center"]);
    // $cell_2_ttd->addText("Tanggal: " . $now->translatedFormat("d F Y"), ["bold" => true, "size" => 7], ["align" => "center"]);

    // Old TTD
    // if($is_proyek_mega) {
    // } else if($is_proyek_besar) {
    //     $table_ttd->addRow();
    //     $header_cell = $table_ttd->addCell(500, ["vMerge" => "restart", "gridSpan" => 3, "bgColor" => "F4B083"]);
    //     $header_cell->addText("Disusun oleh,", ["bold" => true], ["align" => "center"]);
    //     // $header_cell->addText(null, ["bold" => true]);

    //     $table_ttd->addRow();
    //     $cell_2_ttd = $table_ttd->addCell(500);
    //     // $cell_2_ttd->addText($now->translatedFormat("l, d F Y"), ["bold" => true], ["align" => "center"]);
    //     $cell_2_ttd->addTextBreak(1);
    //     $cell_2_ttd->addText("$" . "{ttdPenyusun1}", ["bold" => false], ["align" => "center"]);
    //     $cell_2_ttd->addText(User::find($penyusun[0]->user_id)->name, ["bold" => true], ["align" => "center"]);
    //     $cell_2_ttd->addText(User::find($penyusun[0]->user_id)->Pegawai->Jabatan?->nama_jabatan, ["bold" => true], ["align" => "center"]);
    //     $cell_2_ttd->addText("Tanggal: " . $now->translatedFormat("d F Y"), ["bold" => true, "size" => 7], ["align" => "center"]);

    //     $cell_2_ttd = $table_ttd->addCell(500);
    //     $cell_2_ttd = $table_ttd->addCell(500);
    //     // $cell_2_ttd->addText($now->translatedFormat("l, d F Y"), ["bold" => true], ["align" => "center"]);
    //     $cell_2_ttd->addTextBreak(1);
    //     $cell_2_ttd->addText("$" . "{ttdPenyusun2}", ["bold" => false], ["align" => "center"]);
    //     $cell_2_ttd->addText(User::find($penyusun[0]->user_id)->name, ["bold" => true], ["align" => "center"]);
    //     $cell_2_ttd->addText(User::find($penyusun[0]->user_id)->Pegawai->Jabatan?->nama_jabatan, ["bold" => true], ["align" => "center"]);
    //     $cell_2_ttd->addText("Tanggal: " . $now->translatedFormat("d F Y"), ["bold" => true, "size" => 7], ["align" => "center"]);

    //     $table_ttd->addRow();
    //     $header_cell = $table_ttd->addCell(500, ["vMerge" => "restart", "gridSpan" => 3, "bgColor" => "F4B083"]);
    //     $header_cell->addText("Direkomendasi oleh,", ["bold" => true], ["align" => "center"]);
    //     // $header_cell->addText(null, ["bold" => true]);

    //     $table_ttd->addRow();
    //     $cell_2_ttd = $table_ttd->addCell(500);
    //     // $cell_2_ttd->addText($now->translatedFormat("l, d F Y"), ["bold" => true], ["align" => "center"]);
    //     $cell_2_ttd->addTextBreak(1);
    //     $cell_2_ttd->addText("$" . "{ttdRekomendasi1}", ["bold" => false], ["align" => "center"]);
    //     $cell_2_ttd->addText(User::find($rekomendator[0]->user_id)->name, ["bold" => true], ["align" => "center"]);
    //     $cell_2_ttd->addText(User::find($rekomendator[0]->user_id)->Pegawai->Jabatan?->nama_jabatan, ["bold" => true], ["align" => "center"]);
    //     $cell_2_ttd->addText("Tanggal: " . $now->translatedFormat("d F Y"), ["bold" => true, "size" => 7], ["align" => "center"]);

    //     $cell_2_ttd = $table_ttd->addCell(500);
    //     // $cell_2_ttd->addText($now->translatedFormat("l, d F Y"), ["bold" => true], ["align" => "center"]);
    //     $cell_2_ttd->addTextBreak(1);
    //     $cell_2_ttd->addText("$" . "{ttdRekomendasi2}", ["bold" => false], ["align" => "center"]);
    //     $cell_2_ttd->addText(User::find($rekomendator[0]->user_id)->name, ["bold" => true], ["align" => "center"]);
    //     $cell_2_ttd->addText(User::find($rekomendator[0]->user_id)->Pegawai->Jabatan?->nama_jabatan, ["bold" => true], ["align" => "center"]);
    //     $cell_2_ttd->addText("Tanggal: " . $now->translatedFormat("d F Y"), ["bold" => true, "size" => 7], ["align" => "center"]);

    //     $cell_2_ttd = $table_ttd->addCell(500);
    //     // $cell_2_ttd->addText($now->translatedFormat("l, d F Y"), ["bold" => true], ["align" => "center"]);
    //     $cell_2_ttd->addTextBreak(1);
    //     $cell_2_ttd->addText("$" . "{ttdRekomendasi3}", ["bold" => false], ["align" => "center"]);
    //     $cell_2_ttd->addText(User::find($rekomendator[0]->user_id)->name, ["bold" => true], ["align" => "center"]);
    //     $cell_2_ttd->addText(User::find($rekomendator[0]->user_id)->Pegawai->Jabatan?->nama_jabatan, ["bold" => true], ["align" => "center"]);
    //     $cell_2_ttd->addText("Tanggal: " . $now->translatedFormat("d F Y"), ["bold" => true, "size" => 7], ["align" => "center"]);

    //     $table_ttd->addRow();
    //     $cell_2_ttd = $table_ttd->addCell(500);
    //     // $cell_2_ttd->addText($now->translatedFormat("l, d F Y"), ["bold" => true], ["align" => "center"]);
    //     $cell_2_ttd->addTextBreak(1);
    //     $cell_2_ttd->addText("$" . "{ttdRekomendasi4}", ["bold" => false], ["align" => "center"]);
    //     $cell_2_ttd->addText(User::find($rekomendator[0]->user_id)->name, ["bold" => true], ["align" => "center"]);
    //     $cell_2_ttd->addText(User::find($rekomendator[0]->user_id)->Pegawai->Jabatan?->nama_jabatan, ["bold" => true], ["align" => "center"]);
    //     $cell_2_ttd->addText("Tanggal: " . $now->translatedFormat("d F Y"), ["bold" => true, "size" => 7], ["align" => "center"]);

    //     $cell_2_ttd = $table_ttd->addCell(500);
    //     // $cell_2_ttd->addText($now->translatedFormat("l, d F Y"), ["bold" => true], ["align" => "center"]);
    //     $cell_2_ttd->addTextBreak(4);
    //     // $cell_2_ttd->addText("(.......................................................)", ["bold" => true], ["align" => "center"]);
    //     // $cell_2_ttd->addText("SVP Risk Management", ["bold" => true], ["align" => "center"]);
    //     // $cell_2_ttd->addText("Tanggal: ___________________" . $now->translatedFormat("Y"), ["bold" => true, "size" => 7], ["align" => "center"]);

    //     $cell_2_ttd = $table_ttd->addCell(500);
    //     // $cell_2_ttd->addText($now->translatedFormat("l, d F Y"), ["bold" => true], ["align" => "center"]);
    //     $cell_2_ttd->addTextBreak(1);
    //     $cell_2_ttd->addText("$" . "{ttdRekomendasi5}", ["bold" => false], ["align" => "center"]);
    //     $cell_2_ttd->addText(User::find($rekomendator[0]->user_id)->name, ["bold" => true], ["align" => "center"]);
    //     $cell_2_ttd->addText(User::find($rekomendator[0]->user_id)->Pegawai->Jabatan?->nama_jabatan, ["bold" => true], ["align" => "center"]);
    //     $cell_2_ttd->addText("Tanggal: " . $now->translatedFormat("d F Y"), ["bold" => true, "size" => 7], ["align" => "center"]);

    //     $table_ttd->addRow();
    //     $header_cell = $table_ttd->addCell(500, ["vMerge" => "restart", "gridSpan" => 3, "bgColor" => "F4B083"]);
    //     $header_cell->addText("Persetujuan oleh,", ["bold" => true], ["align" => "center"]);
    //     // $header_cell->addText(null, ["bold" => true]);

    //     $unit_kerja = $proyek->UnitKerja;
    //     $table_ttd->addRow();
    //     $cell_2_ttd = $table_ttd->addCell(500);
    //     // $cell_2_ttd->addText($now->translatedFormat("l, d F Y"), ["bold" => true], ["align" => "center"]);
    //     $cell_2_ttd->addTextBreak(1);
    //     $cell_2_ttd->addText("$" . "{ttdPersetujuan1}", ["bold" => false], ["align" => "center"]);
    //     $cell_2_ttd->addText(User::find($penyetuju[0]->user_id)->name ?? Auth::user()->name, ["bold" => true], ["align" => "center"]);
    //     $cell_2_ttd->addText(User::find($penyetuju[0]->user_id)->Pegawai->Jabatan?->nama_jabatan ?? Auth::user()->Pegawai->Jabatan?->nama_jabatan, ["bold" => true], ["align" => "center"]);
    //     $cell_2_ttd->addText("Tanggal: " . $now->translatedFormat("d F Y"), ["bold" => true, "size" => 7], ["align" => "center"]);

    //     $cell_2_ttd = $table_ttd->addCell(500);
    //     $cell_2_ttd = $table_ttd->addCell(500);
    //     // $cell_2_ttd->addText($now->translatedFormat("l, d F Y"), ["bold" => true], ["align" => "center"]);
    //     $cell_2_ttd->addTextBreak(1);
    //     $cell_2_ttd->addText("$" . "{ttdPersetujuan2}", ["bold" => false], ["align" => "center"]);
    //     $cell_2_ttd->addText(User::find($penyetuju[0]->user_id)->name ?? Auth::user()->name, ["bold" => true], ["align" => "center"]);
    //     $cell_2_ttd->addText(User::find($penyetuju[0]->user_id)->Pegawai->Jabatan?->nama_jabatan ?? Auth::user()->Pegawai->Jabatan?->nama_jabatan, ["bold" => true], ["align" => "center"]);
    //     $cell_2_ttd->addText("Tanggal: " . $now->translatedFormat("d F Y"), ["bold" => true, "size" => 7], ["align" => "center"]);
    // } else {
    //     $is_infra = false;
    //     $default_grid_span = 2;
    //     if(str_contains($proyek->UnitKerja->unit_kerja, "Infra")) {
    //         $is_infra = true;
    //         $default_grid_span = 3;
    //     }

    //     $table_ttd->addRow();
    //     $header_cell = $table_ttd->addCell(500, ["vMerge" => "restart", "gridSpan" => $default_grid_span,'borderSize' => 1, 'borderColor' => '999999', "bgColor" => "F4B083"]);
    //     $header_cell->addText("Disusun oleh,", ["bold" => true], ["align" => "center"]);
    //     // $header_cell->addText(null, ["bold" => true]);

    //     $table_ttd->addRow();
    //     $cell_2_ttd = $table_ttd->addCell(500);
    //     // $cell_2_ttd->addText($now->translatedFormat("l, d F Y"), ["bold" => true], ["align" => "center"]);
    //     $cell_2_ttd->addTextBreak(1);
    //     $cell_2_ttd->addText("$" . "{ttdPenyusun1}", ["bold" => false], ["align" => "center"]);
    //     $cell_2_ttd->addTextBreak(1);
    //     $cell_2_ttd->addText( User::find($penyusun[0]->user_id)->name , ["bold" => true], ["align" => "center"]);
    //     $cell_2_ttd->addText(User::find($penyusun[0]->user_id)->Pegawai->Jabatan?->nama_jabatan, ["bold" => true], ["align" => "center"]);
    //     $cell_2_ttd->addText("Tanggal: " . $now->translatedFormat("d F Y"), ["bold" => true, "size" => 7], ["align" => "center"]);

    //     if($is_infra) {
    //         $cell_2_ttd = $table_ttd->addCell(500);
    //     }
    //     $cell_2_ttd = $table_ttd->addCell(500);
    //     // $cell_2_ttd->addText($now->translatedFormat("l, d F Y"), ["bold" => true], ["align" => "center"]);
    //     $cell_2_ttd->addTextBreak(1);
    //     $cell_2_ttd->addText("$" . "{ttdPenyusun2}", ["bold" => false], ["align" => "center"]);
    //     $cell_2_ttd->addText(User::find($penyusun[0]->user_id)->name, ["bold" => true], ["align" => "center"]);
    //     $cell_2_ttd->addText(User::find($penyusun[0]->user_id)->Pegawai->Jabatan?->nama_jabatan, ["bold" => true], ["align" => "center"]);
    //     $cell_2_ttd->addText("Tanggal: " . $now->translatedFormat("d F Y"), ["bold" => true, "size" => 7], ["align" => "center"]);

    //     $table_ttd->addRow();
    //     $header_cell = $table_ttd->addCell(500, ["vMerge" => "restart", "gridSpan" => $default_grid_span, 'borderSize' => 1, 'borderColor' => '999999', "bgColor" => "F4B083"]);
    //     $header_cell->addText("Direkomendasi oleh,", ["bold" => true], ["align" => "center"]);
    //     // $header_cell->addText(null, ["bold" => true]);

    //     $table_ttd->addRow();
    //     $cell_2_ttd = $table_ttd->addCell(500);
    //     // $cell_2_ttd->addText($now->translatedFormat("l, d F Y"), ["bold" => true], ["align" => "center"]);
    //     $cell_2_ttd->addTextBreak(1);
    //     $cell_2_ttd->addText("$" . "{ttdRekomendasi1}", ["bold" => false], ["align" => "center"]);
    //     $cell_2_ttd->addText(User::find($rekomendator[0]->user_id)->name, ["bold" => true], ["align" => "center"]);
    //     $cell_2_ttd->addText(User::find($rekomendator[0]->user_id)->Pegawai->Jabatan?->nama_jabatan, ["bold" => true], ["align" => "center"]);
    //     $cell_2_ttd->addText("Tanggal: " . $now->translatedFormat("d F Y"), ["bold" => true, "size" => 7], ["align" => "center"]);

    //     if($is_infra) {
    //         $cell_2_ttd = $table_ttd->addCell(500);
    //     }
    //     $cell_2_ttd = $table_ttd->addCell(500);
    //     // $cell_2_ttd->addText($now->translatedFormat("l, d F Y"), ["bold" => true], ["align" => "center"]);
    //     $cell_2_ttd->addTextBreak(1);
    //     $cell_2_ttd->addText("$" . "{ttdRekomendasi2}", ["bold" => false], ["align" => "center"]);
    //     $cell_2_ttd->addText(User::find($rekomendator[0]->user_id)->name, ["bold" => true], ["align" => "center"]);
    //     $cell_2_ttd->addText(User::find($rekomendator[0]->user_id)->Pegawai->Jabatan?->nama_jabatan, ["bold" => true], ["align" => "center"]);
    //     $cell_2_ttd->addText("Tanggal: " . $now->translatedFormat("d F Y"), ["bold" => true, "size" => 7], ["align" => "center"]);

    //     $table_ttd->addRow();
    //     $header_cell = $table_ttd->addCell(500, ["vMerge" => "restart", "gridSpan" => $default_grid_span, 'borderSize' => 1, 'borderColor' => '999999', "bgColor" => "F4B083"]);
    //     $header_cell->addText("Persetujuan oleh,", ["bold" => true], ["align" => "center"]);
    //     // $header_cell->addText(null, ["bold" => true]);

    //     $table_ttd->addRow();
    //     $cell_2_ttd = $table_ttd->addCell(500);
    //     // $cell_2_ttd->addText($now->translatedFormat("l, d F Y"), ["bold" => true], ["align" => "center"]);
    //     $cell_2_ttd->addTextBreak(1);
    //     $cell_2_ttd->addText("$" . "{ttdPersetujuan1}", ["bold" => false], ["align" => "center"]);
    //     $cell_2_ttd->addText(User::find($penyetuju[0]->user_id)->name ?? Auth::user()->name, ["bold" => true], ["align" => "center"]);
    //     $cell_2_ttd->addText(User::find($penyetuju[0]->user_id)->Pegawai->Jabatan?->nama_jabatan ?? Auth::user()->Pegawai->Jabatan?->nama_jabatan, ["bold" => true], ["align" => "center"]);
    //     $cell_2_ttd->addText("Tanggal: " . $now->translatedFormat("d F Y"), ["bold" => true, "size" => 7], ["align" => "center"]);
    //     $cell_2_ttd = $table_ttd->addCell(500);
    //     // $cell_2_ttd = $table_ttd->addCell(500);
    //     // $cell_2_ttd->addText($now->translatedFormat("l, d F Y"), ["bold" => true], ["align" => "center"]);
    //     $cell_2_ttd->addTextBreak(1);
    //     $cell_2_ttd->addText("$" . "{ttdPersetujuan2}", ["bold" => false], ["align" => "center"]);
    //     $cell_2_ttd->addText(User::find($penyetuju[0]->user_id)->name ?? Auth::user()->name, ["bold" => true], ["align" => "center"]);
    //     $cell_2_ttd->addText(User::find($penyetuju[0]->user_id)->Pegawai->Jabatan?->nama_jabatan ?? Auth::user()->Pegawai->Jabatan?->nama_jabatan, ["bold" => true], ["align" => "center"]);
    //     $cell_2_ttd->addText("Tanggal: " . $now->translatedFormat("d F Y"), ["bold" => true, "size" => 7], ["align" => "center"]);

    //     if(str_contains($proyek->UnitKerja->unit_kerja, "Infra")) {
    //         // $table_ttd->addRow();
    //         // $cell_2_ttd = $table_ttd->addCell(500);
    //         $cell_2_ttd = $table_ttd->addCell(500);
    //         // $cell_2_ttd->addText($now->translatedFormat("l, d F Y"), ["bold" => true], ["align" => "center"]);
    //         $cell_2_ttd->addTextBreak(1);
    //         $cell_2_ttd->addText("$" . "{ttdPersetujuan3}", ["bold" => false], ["align" => "center"]);
    //         $cell_2_ttd->addText(User::find($penyetuju[0]->user_id)->name ?? Auth::user()->name, ["bold" => true], ["align" => "center"]);
    //         $cell_2_ttd->addText(User::find($penyetuju[0]->user_id)->Pegawai->Jabatan?->nama_jabatan ?? Auth::user()->Pegawai->Jabatan?->nama_jabatan, ["bold" => true], ["align" => "center"]);
    //         $cell_2_ttd->addText("Tanggal: " . $now->translatedFormat("d F Y"), ["bold" => true, "size" => 7], ["align" => "center"]);
    //     }
    // }

    // \PhpOffice\PhpWord\Settings::setPdfRendererPath("path/to/tcpdf");
    // \PhpOffice\PhpWord\Settings::setPdfRendererName('TCPDF');

    //Begin :: Catatan Rekomendasi
    $section3 = $phpWord->addSection();

    $table_comment = $section3->addTable('comment_table', array('borderSize' => 1, 'borderColor' => '999999', 'afterSpacing' => 0, 'Spacing' => 0, 'cellMargin' => 0));
    $table_comment->addRow();
    $header_cell = $table_comment->addCell(500, ["vMerge" => "restart", "gridSpan" => 2, "bgColor" => "F4B083"]);
    $header_cell->addText("Catatan dari Rekomendasi", ["bold" => true], ["align" => "center"]);

    if (!empty($rekomendator)) {
        foreach ($rekomendator as $key => $p) {
            $table_comment->addRow();

            $cell_1_note = $table_comment->addCell(200);
            $cell_2_note = $table_comment->addCell(200);
            // $cell_2_ttd->addText($now->translatedFormat("l, d F Y"), ["bold" => true], ["align" => "center"]);
            $cell_1_note->addText(User::find($p->user_id)->name, ["bold" => true], ["align" => "center"]);
            // $cell_1_note->addTextBreak(1);
            // $cell_2_note->addText(preg_replace('/&(?!#?[a-z0-9]+;)/', '&amp;', nl2br($p->catatan)), $fontStyle);
            // $cell_2_ttd->addText($now->translatedFormat("l, d F Y"), ["bold" => true], ["align" => "center"]);
            $catatan_list = preg_split("/\n|\r\n?/", htmlspecialchars($p->catatan, ENT_QUOTES));
            foreach ($catatan_list as $key => $catatan) {
                if ($key != 0 && $catatan == "") {
                    $cell_2_note->addTextBreak(1, ['size' => 5], ['afterSpacing' => 0, 'spacing' => 10]);
                }
                $cell_2_note->addText($catatan, ["bold" => false], ["align" => "left"]);
            }
        }
    }
    // foreach($rekomendator as $key => $p) {
    //     $key++;
    //     if($key > 3) {
    //         $table_comment->addRow();
    //     }

    //     $cell_1_note = $table_comment->addCell(500);
    //     // $cell_2_ttd->addText($now->translatedFormat("l, d F Y"), ["bold" => true], ["align" => "center"]);
    //     $cell_1_note->addText(User::find($p->user_id)->name, ["bold" => true], ["align" => "center"]);
    //     $cell_1_note->addTextBreak(1);
    //     $cell_1_note->addText(preg_replace('/&(?!#?[a-z0-9]+;)/', '&amp;', nl2br($p->catatan)), $fontStyle);
    // }
    //end :: Catatan Rekomendasi

    //Begin :: Catatan Persetujuan
    $section3->addTextBreak(1);
    $section4 = $phpWord->addSection();

    $table_comment_penyetuju = $section4->addTable('comment_table', array('borderSize' => 1, 'borderColor' => '999999', 'afterSpacing' => 0, 'Spacing' => 0, 'cellMargin' => 0));
    $table_comment_penyetuju->addRow();
    $header_cell = $table_comment_penyetuju->addCell(500, ["vMerge" => "restart", "gridSpan" => 2, "bgColor" => "F4B083"]);
    $header_cell->addText("Catatan dari Persetujuan", ["bold" => true], ["align" => "center"]);
    // $table_comment_penyetuju->addRow();
    if (!empty($penyetuju)) {
        foreach ($penyetuju as $key => $p) {
            if (!empty($p->catatan) || $p->catatan != null) {
                $table_comment_penyetuju->addRow();

                $cell_1_note = $table_comment_penyetuju->addCell(200);
                $cell_2_note = $table_comment_penyetuju->addCell(200);
                // $cell_2_ttd->addText($now->translatedFormat("l, d F Y"), ["bold" => true], ["align" => "center"]);
                $cell_1_note->addText(User::find($p->user_id)->name, ["bold" => true], ["align" => "center"]);
                // $cell_1_note->addTextBreak(1);
                $catatan_list = preg_split("/\n|\r\n?/", htmlspecialchars($p->catatan, ENT_QUOTES));
                foreach ($catatan_list as $key => $catatan) {
                    if ($key != 0 && $catatan == "") {
                        $cell_2_note->addTextBreak(1, ['size' => 5], ['afterSpacing' => 0, 'spacing' => 10]);
                    }
                    $cell_2_note->addText($catatan, ["bold" => false], ["align" => "left"]);
                }
            }
        }
    }
    // foreach($penyetuju as $key => $p) {
    //     $key++;
    //     if($key > 3) {
    //         $table_comment_penyetuju->addRow();
    //     }

    //     $cell_2_note = $table_comment_penyetuju->addCell(500);
    //     // $cell_2_ttd->addText($now->translatedFormat("l, d F Y"), ["bold" => true], ["align" => "center"]);
    //     $cell_2_note->addText(User::find($p->user_id)->name, ["bold" => true], ["align" => "center"]);
    //     $cell_2_note->addTextBreak(1);
    //     $cell_2_note->addText(preg_replace('/&(?!#?[a-z0-9]+;)/', '&amp;', nl2br($p->catatan)), $fontStyle);
    // }
    //end :: Catatan Rekomendasi

    //Begin::Footer
    // $footerSection = $phpWord->addSection();
    // $footer = $footerSection->addFooter(\PhpOffice\PhpWord\Element\Footer::FIRST);
    // $footerSection->setFooterHeight(50);
    // $footerTextRun = $footer->addTextRun();
    // $footerTextRun->addText("*Dokumen ini dibuat oleh sistem CRM", ['size' => 10, 'bold' => true], ['align' => 'right']);

    $section4->addTextBreak(1);
    $section4->addText("*Dokumen ini dibuat oleh sistem CRM", ['size' => 8, 'bold' => true], ['align' => 'right']);
    // $section4->addTextBreak(1);
    // $header = $section4->addHeader();
    // $footerTextRun = $header->addTextRun();
    // $footerTextRun->addText("*Dokumen ini dibuat oleh sistem CRM", ['size' => 10, 'bold' => true], ['align' => 'right']);
    //End::Footer


    // Begin :: Add Template docx withoutTTD
    $properties = $phpWord->getDocInfo();
    $properties->setTitle($file_name . ".docx");
    $properties->setDescription('Nota Pengajuan Persetujuan');
    PhpOffice\PhpWord\Settings::setOutputEscapingEnabled(true); 
    $phpWord->save(public_path($target_path . "/" . $file_name . ".docx"));
    // end :: Add Template docx withoutTTD


    // Begin :: SIGNED Template docx
    // New TTD Method
    $templateProcessor = new TemplateProcessor($target_path . "/" . $file_name . ".docx");
    if (!empty($penyusun)) {
        foreach ($penyusun as $key => $p) {
            $user = User::find($p->user_id);
            // $qrcode = generateQrCode($proyek->kode_proyek, $user->nip, $request->schemeAndHttpHost() . "?nip=" . $user->nip . "&redirectTo=/rekomendasi?open=kt_modal_view_dokumen_persetujuan_$proyek->kode_proyek");
            //Pake File TTD
            // $templateProcessor->setImageValue('ttdPenyusun' . ++$key, ["path" => "./file-ttd/" . $user->file_ttd, "width" => 10, "ratio" => true]);
            // $templateProcessor->setImageValue('ttdPenyusun' . ++$key, ["path" => public_path('file-ttd/ttd.png'), "width" => 10, "ratio" => true]);
            //Pake QRCode
            // $templateProcessor->setImageValue('ttdPenyusun' . ++$key, ["path" => public_path("/qr-code//$qrcode"), "width" => 10, "ratio" => true]);
        }
    }
    if (!empty($rekomendator)) {
        foreach ($rekomendator as $key => $p) {
            $user = User::find($p->user_id);
            // $qrcode = generateQrCode($proyek->kode_proyek, $user->nip, $request->schemeAndHttpHost() . "?nip=" . $user->nip . "&redirectTo=/rekomendasi?open=kt_modal_view_dokumen_persetujuan_$proyek->kode_proyek");
            //Pake File TTD
            // $templateProcessor->setImageValue('ttdRekomendasi' . ++$key, ["path" => "./file-ttd/" . $user->file_ttd, "width" => 10, "ratio" => true]);
            // $templateProcessor->setImageValue('ttdRekomendasi' . ++$key, ["path" => public_path('file-ttd/ttd.png'), "width" => 10, "ratio" => true]);
            //Pake QRCode
            // $templateProcessor->setImageValue('ttdRekomendasi' . ++$key, ["path" => public_path("/qr-code//$qrcode"), "width" => 10, "ratio" => true]);
        }
    }
    if (!empty($penyetuju)) {
        foreach ($penyetuju as $key => $p) {
            $user = User::find($p->user_id);
            // $qrcode = generateQrCode($proyek->kode_proyek, $user->nip, $request->schemeAndHttpHost() . "?nip=" . $user->nip . "&redirectTo=/rekomendasi?open=kt_modal_view_dokumen_persetujuan_$proyek->kode_proyek");
            //Pake FIle TTD
            // $templateProcessor->setImageValue('ttdPersetujuan' . ++$key, ["path" => "./file-ttd/" . $user->file_ttd, "width" => 10, "ratio" => true]);
            // $templateProcessor->setImageValue('ttdPersetujuan' . ++$key, ["path" => public_path('file-ttd/ttd.png'), "width" => 10, "ratio" => true]);
            //Pake QRCode
            // $templateProcessor->setImageValue('ttdPersetujuan' . ++$key, ["path" => public_path("/qr-code//$qrcode"), "width" => 10, "ratio" => true]);
        }
    }

    // Old TTD Method
    // if($is_proyek_mega) {
    //     // $templateProcessor->setImageValue('ttdRekomendasi2', ["path" => "./media/logos/sign.jpg", "width" => 75, "ratio" => true]);
    //     // $templateProcessor->setImageValue('ttdRekomendasi3', ["path" => "./media/logos/sign.jpg", "width" => 75, "ratio" => true]);
    //     // $templateProcessor->setImageValue('ttdRekomendasi4', ["path" => "./media/logos/sign.jpg", "width" => 75, "ratio" => true]);
    //     // $templateProcessor->setImageValue('ttdRekomendasi5', ["path" => "./media/logos/sign.jpg", "width" => 75, "ratio" => true]);
    //     $templateProcessor->setImageValue('ttdPersetujuan1', ["path" => "./media/logos/sign.jpg", "width" => 75, "ratio" => true]);
    //     $templateProcessor->setImageValue('ttdPersetujuan2', ["path" => "./media/logos/sign.jpg", "width" => 75, "ratio" => true]);
    //     $templateProcessor->setImageValue('ttdPersetujuan3', ["path" => "./media/logos/sign.jpg", "width" => 75, "ratio" => true]);
    //     $templateProcessor->setImageValue('ttdPersetujuan4', ["path" => "./media/logos/sign.jpg", "width" => 75, "ratio" => true]);
    // } else if($is_proyek_besar) {
    //     $templateProcessor->setImageValue('ttdPenyusun1', ["path" => "./media/logos/sign.jpg", "width" => 75, "ratio" => true]);
    //     $templateProcessor->setImageValue('ttdPenyusun2', ["path" => "./media/logos/sign.jpg", "width" => 75, "ratio" => true]);
    //     $templateProcessor->setImageValue('ttdRekomendasi1', ["path" => "./media/logos/sign.jpg", "width" => 75, "ratio" => true]);
    //     $templateProcessor->setImageValue('ttdRekomendasi2', ["path" => "./media/logos/sign.jpg", "width" => 75, "ratio" => true]);
    //     $templateProcessor->setImageValue('ttdRekomendasi3', ["path" => "./media/logos/sign.jpg", "width" => 75, "ratio" => true]);
    //     $templateProcessor->setImageValue('ttdRekomendasi4', ["path" => "./media/logos/sign.jpg", "width" => 75, "ratio" => true]);
    //     $templateProcessor->setImageValue('ttdRekomendasi5', ["path" => "./media/logos/sign.jpg", "width" => 75, "ratio" => true]);
    //     $templateProcessor->setImageValue('ttdPersetujuan1', ["path" => "./media/logos/sign.jpg", "width" => 75, "ratio" => true]);
    //     $templateProcessor->setImageValue('ttdPersetujuan2', ["path" => "./media/logos/sign.jpg", "width" => 75, "ratio" => true]);
    // } else {
    //     $templateProcessor->setImageValue('ttdPenyusun1', ["path" => "./media/logos/sign.jpg", "width" => 75, "ratio" => true]);
    //     $templateProcessor->setImageValue('ttdPenyusun2', ["path" => "./media/logos/sign.jpg", "width" => 75, "ratio" => true]);
    //     $templateProcessor->setImageValue('ttdRekomendasi1', ["path" => "./media/logos/sign.jpg", "width" => 75, "ratio" => true]);
    //     $templateProcessor->setImageValue('ttdRekomendasi2', ["path" => "./media/logos/sign.jpg", "width" => 75, "ratio" => true]);
    //     $templateProcessor->setImageValue('ttdPersetujuan1', ["path" => "./media/logos/sign.jpg", "width" => 75, "ratio" => true]);
    //     $templateProcessor->setImageValue('ttdPersetujuan2', ["path" => "./media/logos/sign.jpg", "width" => 75, "ratio" => true]);
    //     if(str_contains($proyek->UnitKerja->unit_kerja, "Infra")) {
    //         $templateProcessor->setImageValue('ttdPersetujuan3', ["path" => "./media/logos/sign.jpg", "width" => 75, "ratio" => true]);
    //     }
    // }

    $ttdFileName = $now->format("dmYHis") . "_signed-nota-persetujuan_$proyek->kode_proyek";
    $templateProcessor->saveAs(public_path($target_path . "/" . $ttdFileName . ".docx"));
    // end :: SIGNED Template docx

    File::delete(public_path($target_path . "/" . $file_name . ".docx"));
    // dd($files);

    // Begin :: CONVERT Template docx to PDF
    $templatePhpWord = \PhpOffice\PhpWord\IOFactory::load(public_path($target_path . "/" . $ttdFileName . ".docx"));
    // $rendererName = \PhpOffice\PhpWord\Settings::PDF_RENDERER_DOMPDF;
    $rendererName = \PhpOffice\PhpWord\Settings::PDF_RENDERER_TCPDF;
    // $rendererLibraryPath = realpath('../vendor/dompdf/dompdf');
    $rendererLibraryPath = realpath('../vendor/tecnickcom/tcpdf');
    \PhpOffice\PhpWord\Settings::setPdfRenderer($rendererName, $rendererLibraryPath);
    $xmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($templatePhpWord, 'PDF');
    $xmlWriter->save(public_path($target_path . "/" . $file_name . ".pdf"));

    // \PhpOffice\PhpWord\Settings::setPdfRendererName(\PhpOffice\PhpWord\Settings::PDF_RENDERER_TCPDF);
    // // Path to directory with tcpdf.php file.
    // // Rigth now `TCPDF` writer is depreacted. Consider to use `DomPDF` or `MPDF` instead.
    // \PhpOffice\PhpWord\Settings::setPdfRendererPath('../vendor/tecnickcom/tcpdf');

    // $xmlWriter = \PhpOffice\PhpWord\IOFactory::load(public_path($target_path . "/" . $ttdFileName . ".docx"));
    // $xmlWriter->save(public_path('/file-profile-risiko//' . $file_name . ".pdf"), 'PDF');
    // end :: CONVERT Template docx to PDF

    File::delete(public_path($target_path . "/" . $ttdFileName . ".docx"));

    // $properties = $phpWord->getDocInfo();
    // $properties->setTitle($file_name.".pdf");
    // $properties->setDescription('Nota Rekomendasi');
    // $rendererName = \PhpOffice\PhpWord\Settings::PDF_RENDERER_DOMPDF;
    // $rendererLibraryPath = realpath('../vendor/dompdf/dompdf');
    // \PhpOffice\PhpWord\Settings::setPdfRenderer($rendererName, $rendererLibraryPath);
    // $xmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'PDF');
    // $is_saved = $xmlWriter->save(public_path($target_path. "/".$file_name . ".pdf"));

    // Begin :: Merge PDF
    $pdf_merger = new PdfMerge();
    $pdf_merger->add(public_path($target_path. "/". $file_name.".pdf"));
    $pdf_merger->add(public_path("file-rekomendasi". "/". $proyek->file_rekomendasi));
    $pdf_merger->merge(public_path($target_path. "/". $file_name.".pdf"));
    // dd($pdf_merger);
    // End :: Merge PDF
    $proyek->file_persetujuan = $file_name . ".pdf";
    // dd("saved", $proyek->file_persetujuan);    
    $proyek->save();
    // $is_saved = $phpWord->save(public_path($target_path. "\\". $file_name));
}

function createWordPersetujuanOld2(App\Models\Proyek $proyek, \Illuminate\Support\Collection $hasil_assessment = new \Illuminate\Support\Collection(), $is_proyek_besar, $is_proyek_mega, \Illuminate\Http\Request $request)
{
    $phpWord = new \PhpOffice\PhpWord\PhpWord();
    $target_path = "file-persetujuan";
    $now = Carbon\Carbon::now();
    $file_name = $now->format("dmYHis") . "_nota-persetujuan_$proyek->kode_proyek";
    $notaRekomendasi = NotaRekomendasi::where('kode_proyek', $proyek->kode_proyek)->first();

    $internal_score = $hasil_assessment->sum(function ($ra) {
        if ($ra->kategori == "Internal") {
            return $ra->score;
        }
    });
    $eksternal_score = $hasil_assessment->sum(function ($ra) {
        if ($ra->kategori == "Eksternal") {
            return $ra->score;
        }
    });

    // $penyusun = collect(json_decode($proyek->approved_penyusun))->values()->toArray();
    // $penyusun = collect(json_decode($proyek->approved_verifikasi))->values()->toArray();
    // $rekomendator = json_decode($proyek->approved_rekomendasi_final);
    // $penyetuju = json_decode($proyek->approved_persetujuan);
    $penyusun = collect(json_decode($notaRekomendasi->approved_verifikasi))->values()->toArray();
    $rekomendator = json_decode($notaRekomendasi->approved_rekomendasi_final);
    $penyetuju = json_decode($notaRekomendasi->approved_persetujuan);
    $max_grid_span = collect([!empty($penyusun) ? count($penyusun) : 0, !empty($rekomendator) ? count($rekomendator) : 0, !empty($penyetuju) ? count($penyetuju) : 0])->max();
    // dd($penyusun, $rekomendator, $penyetuju, $max_grid_span);

    $section = $phpWord->addSection();
    $footer = $section->addFooter();
    $footer->addText("*Dokumen ini dibuat oleh sistem CRM", ['size' => 10, 'bold' => true], ['align' => 'right']);

    $section->addText("NOTA REKOMENDASI TAHAP I", ['size' => 12, "bold" => true], ['align' => "center"]);
    $section->addText("Seleksi Pengguna Jasa Non Green Lane", ['size' => 12, "bold" => true], ['align' => "center"]);

    if ($is_proyek_mega) {
        $section->addText("Proyek Mega", ['size' => 12, "bold" => true], ['align' => "center"]);
    } else if ($is_proyek_besar) {
        $section->addText("Proyek Besar", ['size' => 12, "bold" => true], ['align' => "center"]);
    } else {
        $section->addText("Proyek Kecil / Proyek Menengah", ['size' => 12, "bold" => true], ['align' => "center"]);
    }

    $section->addTextBreak(1);
    $table = $section->addTable('myOwnTableStyle', array('borderSize' => 1, 'borderColor' => '999999', 'afterSpacing' => 0, 'Spacing' => 0, 'cellMargin' => 0));
    $table->addRow(-0.5, array('exactHeight' => -5));

    $styleCell = array('borderTopSize' => 1, 'borderTopColor' => 'black', 'borderLeftSize' => 1, 'borderLeftColor' => 'black', 'borderRightSize' => 1, 'borderRightColor' => 'black', 'borderBottomSize' => 1, 'borderBottomColor' => 'black', 'textAlignment' => \PhpOffice\PhpWord\SimpleType\TextAlignment::CENTER);
    $TstyleCell = array("bgColor" => "F4B083", 'borderTopSize' => 1, 'borderTopColor' => 'black', 'borderLeftSize' => 1, 'borderLeftColor' => 'black', 'borderRightSize' => 1, 'borderRightColor' => 'black', 'borderBottomSize' => 1, 'borderBottomColor' => 'black');
    $TfontStyle = array('bold' => true, 'italic' => false, 'size' => 10, 'name' => 'Times New Roman', 'afterSpacing' => 0, 'Spacing' => 0, 'cellMargin' => 0, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::BOTH);
    $fontStyle = array('bold' => false, 'italic' => false, 'size' => 10, 'name' => 'Times New Roman', 'afterSpacing' => 0, 'Spacing' => 0, 'cellMargin' => 0, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::BOTH);
    $fontStyleTTD = array('bold' => true, 'italic' => false, 'size' => 10, 'name' => 'Times New Roman', 'afterSpacing' => 0, 'Spacing' => 0, 'cellMargin' => 0, 'alignment' => 'center');
    $columnStyle1 = array("bgColor" => "F4B083", 'borderTopSize' => 1, 'borderTopColor' => 'black', 'borderLeftSize' => 1, 'borderLeftColor' => 'black', 'borderRightSize' => 1, 'borderRightColor' => 'black', 'borderBottomSize' => 1, 'borderBottomColor' => 'black');
    $columnStyle2 = array("bgColor" => "F4B083", 'borderTopSize' => 1, 'borderTopColor' => 'black', 'borderLeftSize' => 1, 'borderLeftColor' => 'black', 'borderRightSize' => 1, 'borderRightColor' => 'black', 'borderBottomSize' => 1, 'borderBottomColor' => 'black', "gridSpan" => 4);
    $columnStyle3 = array("bgColor" => "F4B083", 'borderTopSize' => 1, 'borderTopColor' => 'black', 'borderLeftSize' => 1, 'borderLeftColor' => 'black', 'borderRightSize' => 1, 'borderRightColor' => 'black', 'borderBottomSize' => 1, 'borderBottomColor' => 'black', "gridSpan" => 6);
    $columnRowStyle1 = array('borderTopSize' => 1, 'borderTopColor' => 'black', 'borderLeftSize' => 1, 'borderLeftColor' => 'black', 'borderRightSize' => 1, 'borderRightColor' => 'black', 'borderBottomSize' => 1, 'borderBottomColor' => 'black', 'textAlignment' => \PhpOffice\PhpWord\SimpleType\TextAlignment::CENTER);
    $columnRowStyle2 = array('borderTopSize' => 1, 'borderTopColor' => 'black', 'borderLeftSize' => 1, 'borderLeftColor' => 'black', 'borderRightSize' => 1, 'borderRightColor' => 'black', 'borderBottomSize' => 1, 'borderBottomColor' => 'black', "gridSpan" => 4, 'textAlignment' => \PhpOffice\PhpWord\SimpleType\TextAlignment::CENTER);
    $columnRowStyle3 = array('borderTopSize' => 1, 'borderTopColor' => 'black', 'borderLeftSize' => 1, 'borderLeftColor' => 'black', 'borderRightSize' => 1, 'borderRightColor' => 'black', 'borderBottomSize' => 1, 'borderBottomColor' => 'black', "gridSpan" => 6, 'textAlignment' => \PhpOffice\PhpWord\SimpleType\TextAlignment::CENTER);

    $table->addCell(500, $columnStyle1)->addText('No', $TfontStyle);
    // $table->addCell(500,$TstyleCell)->addText('No',$TfontStyle);
    $table->addCell(2500, $columnStyle2)->addText("Item", $TfontStyle);
    // $table->addCell(2500,$TstyleCell)->addText("Item", $TfontStyle);
    $table->addCell(6000, $columnStyle3)->addText('Uraian', $TfontStyle);
    // $table->addCell(6000,$TstyleCell)->addText('Uraian',$TfontStyle);

    $nama_proyek = str_replace("&", "dan", $proyek->nama_proyek);
    $table->addRow();
    // $table->addCell(500,$styleCell)->addText('1', $fontStyle);
    $table->addCell(500, $columnRowStyle1)->addText('1', $fontStyle);
    // $table->addCell(2500,$styleCell)->addText("Nama Proyek", $fontStyle);
    $table->addCell(2500, $columnRowStyle2)->addText("Nama Proyek", $fontStyle);
    // $table->addCell(6000,$styleCell)->addText($nama_proyek, $fontStyle);
    $table->addCell(6000, $columnRowStyle3)->addText($nama_proyek, $fontStyle);
    $table->addRow();
    // $table->addCell(500,$styleCell)->addText('2', $fontStyle);
    $table->addCell(500, $columnRowStyle1)->addText('2', $fontStyle);
    // $table->addCell(2500,$styleCell)->addText("Lokasi Proyek", $fontStyle);
    $table->addCell(2500, $columnRowStyle2)->addText("Lokasi Proyek", $fontStyle);
    // $table->addCell(6000, $styleCell)->addText(Provinsi::find($proyek->provinsi)->province_name ?? "-", $fontStyle);
    $table->addCell(6000, $columnRowStyle3)->addText(Provinsi::find($proyek->provinsi)->province_name ?? "-", $fontStyle);
    $table->addRow();
    // $table->addCell(500,$styleCell)->addText('3', $fontStyle);
    $table->addCell(500, $columnRowStyle1)->addText('3', $fontStyle);
    // $table->addCell(2500, $styleCell)->addText("Nama Pengguna Jasa", $fontStyle);
    $table->addCell(2500, $columnRowStyle2)->addText("Nama Pengguna Jasa", $fontStyle);
    // $table->addCell(6000,$styleCell)->addText($proyek->proyekBerjalan->name_customer, $fontStyle);
    $table->addCell(6000, $columnRowStyle3)->addText($proyek->proyekBerjalan->name_customer, $fontStyle);
    $table->addRow();
    // $table->addCell(500,$styleCell)->addText('4', $fontStyle);
    $table->addCell(500, $columnRowStyle1)->addText('4', $fontStyle);
    // $table->addCell(2500, $styleCell)->addText("Instansi Pengguna Jasa", $fontStyle);
    $table->addCell(2500, $columnRowStyle2)->addText("Instansi Pengguna Jasa", $fontStyle);
    // $table->addCell(6000,$styleCell)->addText($proyek->proyekBerjalan->Customer->jenis_instansi, $fontStyle);
    $table->addCell(6000, $columnRowStyle3)->addText($proyek->proyekBerjalan->Customer->jenis_instansi, $fontStyle);
    $table->addRow();
    // $table->addCell(500,$styleCell)->addText('5', $fontStyle);
    $table->addCell(500, $columnRowStyle1)->addText('5', $fontStyle);
    // $table->addCell(2500,$styleCell)->addText("Sumber Pendanaan Proyek", $fontStyle);
    $table->addCell(2500, $columnRowStyle2)->addText("Sumber Pendanaan Proyek", $fontStyle);
    // $table->addCell(6000,$styleCell)->addText($proyek->sumber_dana, $fontStyle);
    $table->addCell(6000, $columnRowStyle3)->addText($proyek->sumber_dana, $fontStyle);
    $table->addRow();
    // $table->addCell(500,$styleCell)->addText('6', $fontStyle);
    $table->addCell(500, $columnRowStyle1)->addText('6', $fontStyle);
    // $table->addCell(2500, $styleCell)->addText("Perkiraan Nilai Proyek", $fontStyle);
    $table->addCell(2500, $columnRowStyle2)->addText("Perkiraan Nilai Proyek", $fontStyle);
    // $table->addCell(6000,$styleCell)->addText(number_format($proyek->nilaiok_awal, 0, ".", "."), $fontStyle);
    $table->addCell(6000, $columnRowStyle3)->addText(number_format($proyek->nilaiok_awal, 0, ".", "."), $fontStyle);
    $table->addRow();
    // $table->addCell(500,$styleCell)->addText('7', $fontStyle);
    $table->addCell(500, $columnRowStyle1)->addText('7', $fontStyle);
    // $table->addCell(2500,$styleCell)->addText("Kategori Proyek", $fontStyle);
    $table->addCell(2500, $columnRowStyle2)->addText("Kategori Proyek", $fontStyle);
    // $table->addCell(6000,$styleCell)->addText($proyek->klasifikasi_pasdin ?? "-", $fontStyle);
    $table->addCell(6000, $columnRowStyle3)->addText($proyek->klasifikasi_pasdin ?? "-", $fontStyle);
    $table->addRow();
    // $table->addCell(500,$styleCell)->addText('8', $fontStyle);
    $table->addCell(500, $columnRowStyle1)->addText('8', $fontStyle);
    // $table->addCell(2500,$styleCell)->addText("Assessment Eksternal Atas Pengguna Jasa", $fontStyle);
    $table->addCell(2500, $columnRowStyle2)->addText("Assessment Eksternal Atas Pengguna Jasa", $fontStyle);
    // $table->addCell(6000,$styleCell)->addText($eksternal_score ?? "-", $fontStyle);
    $table->addCell(6000, $columnRowStyle3)->addText($eksternal_score ?? "-", $fontStyle);
    $table->addRow();
    // $table->addCell(500,$styleCell)->addText('9', $fontStyle);
    $table->addCell(500, $columnRowStyle1)->addText('9', $fontStyle);
    // $table->addCell(2500,$styleCell)->addText("Assessment Internal Atas Pengguna Jasa ", $fontStyle);
    $table->addCell(2500, $columnRowStyle2)->addText("Assessment Internal Atas Pengguna Jasa ", $fontStyle);
    // $table->addCell(6000,$styleCell)->addText($internal_score ?? "-", $fontStyle);
    $table->addCell(6000, $columnRowStyle3)->addText($internal_score ?? "-", $fontStyle);
    $table->addRow();
    // $table->addCell(500,$styleCell)->addText('10', $fontStyle);
    $table->addCell(500, $columnRowStyle1)->addText('10', $fontStyle);
    // $table->addCell(2500,$styleCell)->addText("Catatan", $fontStyle);
    $table->addCell(2500, $columnRowStyle2)->addText("Catatan", $fontStyle);
    // $cell_catatan = $table->addCell(6000, $styleCell);
    $cell_catatan = $table->addCell(6000, $columnRowStyle3);
    // $catatan_list = preg_split("/\n|\r\n?/", htmlspecialchars($proyek->catatan_nota_rekomendasi, ENT_QUOTES));
    $catatan_list = preg_split("/\n|\r\n?/", htmlspecialchars($notaRekomendasi->catatan_nota_rekomendasi, ENT_QUOTES));
    foreach ($catatan_list as $key => $catatan) {
        $cell_catatan->addText($catatan, $fontStyle);
        if ($catatan == "") {
            // $cell_catatan->addTextBreak(1);
            // $cell_catatan->addText("<w:br/>");
        }
    }

    $section->addText("Berdasarkan informasi di atas, mengajukan untuk mengikuti aktifitas Perolehan Kontrak (tender) tersebut di atas.");

    $section->addTextBreak(2);
    // $section->addTextBreak(10);
    // $section->addPageBreak();
    $section2 = $phpWord->addSection();
    $footer2 = $section2->addFooter();
    $footer2->addText("*Dokumen ini dibuat oleh sistem CRM", ['size' => 10, 'bold' => true], ['align' => 'right']);

    $table_ttd = $section2->addTable('ttd_table', array('borderSize' => 1, 'borderColor' => '999999', 'afterSpacing' => 0, 'Spacing' => 0, 'cellMargin' => 0));
    // $table_ttd->addRow();
    $table_ttd->addRow();

    // $header_cell = $table_ttd->addCell(3000, ["vMerge" => "restart", "gridSpan" => 2, "bgColor" => "F4B083"]);
    $header_cell = $table_ttd->addCell(3000, ["vMerge" => "restart", "gridSpan" => 2, "bgColor" => "F4B083"]);
    $header_cell->addText("Disusun oleh,", ["bold" => true], ["align" => "center"]);
    // $header_cell->addText(null, ["bold" => true]);

    // New TTD Method
    $table_ttd->addRow();
    if (!empty($penyusun)) {
        // dd($penyusun);
        $total_penyusun = count($penyusun);
        foreach ($penyusun as $key => $p) {

            $key++;
            $total_penyusun = count($penyusun);

            if ($total_penyusun == 1) {
                $cell_2_ttd = $table_ttd->addCell(3000, ["vMerge" => "restart", "gridSpan" => 2]);
            } else {
                if ($total_penyusun % 2 == 0) {
                    if ($key == 3 || $key == 5 || $key == 7 || $key == 9) {
                        $table_ttd->addRow();
                    }
                    $cell_2_ttd = $table_ttd->addCell(3000, ["vMerge" => "restart", "gridSpan" => 1]);
                } else {
                    if ($key == 3 || $key == 5) {
                        $table_ttd->addRow();
                    }
                    if (($total_penyusun == 3 && $key == 3) || ($total_penyusun == 5 && $key == 5) || ($total_penyusun == 7 && $key == 7) || ($total_penyusun == 9 && $key == 9)) {
                        $cell_2_ttd = $table_ttd->addCell(3000, ["vMerge" => "restart", "gridSpan" => 2]);
                    } else {
                        $cell_2_ttd = $table_ttd->addCell(3000, ["vMerge" => "restart", "gridSpan" => 1]);
                    }
                }
            }
            // dd($cell_2_ttd);


            $tanggal_ttd = Carbon\Carbon::create($p->tanggal);
            // $cell_2_ttd->addText($now->translatedFormat("l, d F Y"), ["bold" => true], ["align" => "center"]);
            $cell_2_ttd->addTextBreak(5);
            // $cell_2_ttd->addText("$" . "{ttdPenyusun$key}", ["bold" => false], ["align" => "center"]);
            // $cell_2_ttd->addText(User::find($p->user_id)->name, $fontStyleTTD, ['alignment' => 'center', 'afterSpacing' => 0]);
            $cell_2_ttd->addText(User::find($p->user_id)->name, ['bold' => true, 'size' => 8], ['alignment' => 'center', 'spacing' => 10]);
            $cell_2_ttd->addText(User::find($p->user_id)->Pegawai->Jabatan?->nama_jabatan, ['bold' => true, 'size' => 8], ['alignment' => 'center', 'spacing' => 10]);
            // $cell_2_ttd->addText(User::find($p->user_id)->name, $fontStyleTTD, ['alignment' => 'center', 'afterSpacing' => 0]);
            // $cell_2_ttd->addText(User::find($p->user_id)->Pegawai->Jabatan?->nama_jabatan, $fontStyleTTD, ['alignment' => 'center', 'afterSpacing' => 0]);
            $cell_2_ttd->addText("Tanggal: " . $tanggal_ttd->translatedFormat("d F Y"), ["bold" => true, "size" => 7], ["align" => "center"]);
        }
    }

    $table_ttd->addRow();
    $header_cell = $table_ttd->addCell(3000, ["vMerge" => "restart", "gridSpan" => 2, "bgColor" => "F4B083"]);
    $header_cell->addText("Direkomendasi oleh,", ["bold" => true], ["align" => "center"]);
    // $header_cell->addText(null, ["bold" => true]);

    $table_ttd->addRow();
    if (!empty($rekomendator)) {
        foreach ($rekomendator as $key => $p) {
            $key++;
            $total_rekomendator = count($rekomendator);
            if ($total_rekomendator == 1) {
                $cell_3_ttd = $table_ttd->addCell(3000, ["vMerge" => "restart", "gridSpan" => 2]);
            } else {
                if ($total_rekomendator % 2 == 0) {
                    if ($key == 3 || $key == 5 || $key == 7 || $key == 9) {
                        $table_ttd->addRow();
                    }
                    $cell_3_ttd = $table_ttd->addCell(3000, ["vMerge" => "restart", "gridSpan" => 1]);
                } else {
                    if ($key == 3 || $key == 5) {
                        $table_ttd->addRow();
                    }
                    if (($total_rekomendator == 3 && $key == 3) || ($total_rekomendator == 5 && $key == 5) || ($total_rekomendator == 7 && $key == 7) || ($total_rekomendator == 9 && $key == 9)) {
                        $cell_3_ttd = $table_ttd->addCell(3000, ["vMerge" => "restart", "gridSpan" => 2]);
                    } else {
                        $cell_3_ttd = $table_ttd->addCell(3000, ["vMerge" => "restart", "gridSpan" => 1]);
                    }
                }
            }
            $tanggal_ttd = Carbon\Carbon::create($p->tanggal);
            // $cell_3_ttd->addText($now->translatedFormat("l, d F Y"), ["bold" => true], ["align" => "center"]);
            $cell_3_ttd->addTextBreak(5);
            // $cell_3_ttd->addText("$" . "{ttdRekomendasi$key}", ["bold" => false], ["align" => "center"]);
            $cell_3_ttd->addText(User::find($p->user_id)->name, ['bold' => true, 'size' => 8], ['alignment' => 'center', 'spacing' => 10]);
            $cell_3_ttd->addText(User::find($p->user_id)->Pegawai->Jabatan?->nama_jabatan, ['bold' => true, 'size' => 8], ['alignment' => 'center', 'spacing' => 10]);
            // $cell_3_ttd->addText(User::find($p->user_id)->name, $fontStyleTTD, ['alignment' => 'center', 'afterSpacing' => 0]);
            // $cell_3_ttd->addText(User::find($p->user_id)->Pegawai->Jabatan?->nama_jabatan, $fontStyleTTD, ['alignment' => 'center', 'afterSpacing' => 0]);
            $cell_3_ttd->addText("Tanggal: " . $tanggal_ttd->translatedFormat("d F Y"), ["bold" => true, "size" => 7], ["align" => "center"]);
            if ($p->status == "approved" && empty($p->catatan)) {
                $cell_3_ttd->addText("Direkomendasikan", ["bold" => true, "size" => 7], ["align" => "center"]);
            } elseif ($p->status == "approved" && !empty($p->catatan)) {
                $cell_3_ttd->addText("Direkomendasikan dengan catatan", ["bold" => true, "size" => 7], ["align" => "center"]);
            } else {
                $cell_3_ttd->addText("Tidak Direkomendasikan", ["bold" => true, "size" => 7], ["align" => "center"]);
            }
        }
    }

    $table_ttd->addRow();
    $header_cell = $table_ttd->addCell(3000, ["vMerge" => "restart", "gridSpan" => 2, "bgColor" => "F4B083"]);
    $header_cell->addText("Persetujuan oleh,", ["bold" => true], ["align" => "center"]);
    // $header_cell->addText(null, ["bold" => true]);

    $table_ttd->addRow();
    if (!empty($penyetuju)) {
        foreach ($penyetuju as $key => $p) {
            $key++;
            $total_penyetuju = count($penyetuju);
            if ($total_penyetuju == 1) {
                $cell_4_ttd = $table_ttd->addCell(3000, ["vMerge" => "restart", "gridSpan" => 2]);
            } else {
                if ($total_penyetuju % 2 == 0) {
                    if ($key == 3 || $key == 5 || $key == 7 || $key == 9) {
                        $table_ttd->addRow();
                    }
                    $cell_4_ttd = $table_ttd->addCell(3000, ["vMerge" => "restart", "gridSpan" => 1]);
                } else {
                    if ($key == 3 || $key == 5) {
                        $table_ttd->addRow();
                    }
                    if (($total_penyetuju == 3 && $key == 3) || ($total_penyetuju == 5 && $key == 5) || ($total_rekomendator == 7 && $key == 7) || ($total_rekomendator == 9 && $key == 9)) {
                        $cell_4_ttd = $table_ttd->addCell(3000, ["vMerge" => "restart", "gridSpan" => 2]);
                    } else {
                        $cell_4_ttd = $table_ttd->addCell(3000, ["vMerge" => "restart", "gridSpan" => 1]);
                    }
                }
            }
            $tanggal_ttd = Carbon\Carbon::create($p->tanggal);
            $cell_4_ttd->addTextBreak(5);
            // $cell_4_ttd->addText("$" . "{ttdPersetujuan$key}", ["bold" => false], ["align" => "center"]);
            $cell_4_ttd->addText(User::find($p->user_id)->name ?? Auth::user()->name, ['bold' => true, 'size' => 8], ['alignment' => 'center', 'spacing' => 10]);
            $cell_4_ttd->addText(User::find($p->user_id)->Pegawai->Jabatan?->nama_jabatan ?? Auth::user()->Pegawai->Jabatan?->nama_jabatan, ['bold' => true, 'size' => 8], ['alignment' => 'center', 'spacing' => 10]);
            // $cell_4_ttd->addText(User::find($p->user_id)->name ?? Auth::user()->name, $fontStyleTTD, ['alignment' => 'center', 'afterSpacing' => 0]);
            // $cell_4_ttd->addText(User::find($p->user_id)->Pegawai->Jabatan?->nama_jabatan ?? Auth::user()->Pegawai->Jabatan?->nama_jabatan, $fontStyleTTD, ['alignment' => 'center', 'afterSpacing' => 0]);
            $cell_4_ttd->addText("Tanggal: " . $tanggal_ttd->translatedFormat("d F Y"), ["bold" => true, "size" => 7], ["align" => "center"]);
            if ($p->status == "approved" && empty($p->catatan)) {
                $cell_4_ttd->addText("Direkomendasikan", ["bold" => true, "size" => 7], ["align" => "center"]);
            } elseif ($p->status == "approved" && !empty($p->catatan)) {
                $cell_4_ttd->addText("Direkomendasikan dengan catatan", ["bold" => true, "size" => 7], ["align" => "center"]);
            } else {
                $cell_4_ttd->addText("Tidak Direkomendasikan", ["bold" => true, "size" => 7], ["align" => "center"]);
            }
        }
    }
    $section2->addTextBreak(2);
    //Begin :: Catatan Rekomendasi
    $section3 = $phpWord->addSection();
    $footer3 = $section3->addFooter();
    $footer3->addText("*Dokumen ini dibuat oleh sistem CRM", ['size' => 10, 'bold' => true], ['align' => 'right']);

    $table_comment = $section3->addTable('comment_table', array('borderSize' => 1, 'borderColor' => '999999', 'afterSpacing' => 0, 'Spacing' => 0, 'cellMargin' => 0));
    $table_comment->addRow();
    $header_cell = $table_comment->addCell(500, ["vMerge" => "restart", "gridSpan" => 2, "bgColor" => "F4B083"]);
    $header_cell->addText("Catatan dari Rekomendasi", ["bold" => true], ["align" => "center"]);

    if (!empty($rekomendator)) {
        foreach ($rekomendator as $key => $p) {
            $table_comment->addRow();

            $cell_1_note = $table_comment->addCell(200);
            $cell_2_note = $table_comment->addCell(200);
            // $cell_2_ttd->addText($now->translatedFormat("l, d F Y"), ["bold" => true], ["align" => "center"]);
            $cell_1_note->addText(User::find($p->user_id)->name, ["bold" => true], ["align" => "center"]);
            // $cell_1_note->addTextBreak(1);
            // $cell_2_note->addText(preg_replace('/&(?!#?[a-z0-9]+;)/', '&amp;', nl2br($p->catatan)), $fontStyle);
            // $cell_2_ttd->addText($now->translatedFormat("l, d F Y"), ["bold" => true], ["align" => "center"]);
            $catatan_list = preg_split("/\n|\r\n?/", htmlspecialchars($p->catatan, ENT_QUOTES));
            foreach ($catatan_list as $key => $catatan) {
                if ($key != 0 && $catatan == "") {
                    $cell_2_note->addTextBreak(1, ['size' => 5], ['afterSpacing' => 0, 'spacing' => 10]);
                }
                $cell_2_note->addText($catatan, ["bold" => false], ["align" => "left"]);
            }
        }
    }
    // //end :: Catatan Rekomendasi

    //Begin :: Catatan Persetujuan
    $section3->addTextBreak(1);
    $section4 = $phpWord->addSection();
    $footer4 = $section4->addFooter();
    $footer4->addText("*Dokumen ini dibuat oleh sistem CRM", ['size' => 10, 'bold' => true], ['align' => 'right']);

    $table_comment_penyetuju = $section4->addTable('comment_table', array('borderSize' => 1, 'borderColor' => '999999', 'afterSpacing' => 0, 'Spacing' => 0, 'cellMargin' => 0));
    $table_comment_penyetuju->addRow();
    $header_cell = $table_comment_penyetuju->addCell(500, ["vMerge" => "restart", "gridSpan" => 2, "bgColor" => "F4B083"]);
    $header_cell->addText("Catatan dari Persetujuan", ["bold" => true], ["align" => "center"]);
    // $table_comment_penyetuju->addRow();
    if (!empty($penyetuju)) {
        foreach ($penyetuju as $key => $p) {
            if (!empty($p->catatan) || $p->catatan != null) {
                $table_comment_penyetuju->addRow();

                $cell_1_note = $table_comment_penyetuju->addCell(200);
                $cell_2_note = $table_comment_penyetuju->addCell(200);
                // $cell_2_ttd->addText($now->translatedFormat("l, d F Y"), ["bold" => true], ["align" => "center"]);
                $cell_1_note->addText(User::find($p->user_id)->name, ["bold" => true], ["align" => "center"]);
                // $cell_1_note->addTextBreak(1);
                $catatan_list = preg_split("/\n|\r\n?/", htmlspecialchars($p->catatan, ENT_QUOTES));
                foreach ($catatan_list as $key => $catatan) {
                    if ($key != 0 && $catatan == "") {
                        $cell_2_note->addTextBreak(1, ['size' => 5], ['afterSpacing' => 0, 'spacing' => 10]);
                    }
                    $cell_2_note->addText($catatan, ["bold" => false], ["align" => "left"]);
                }
            }
        }
    }

    //end :: Catatan Rekomendasi

    //Begin::Footer

    // $section4->addTextBreak(1);
    // $section4->addText("*Dokumen ini dibuat oleh sistem CRM", ['size' => 6, 'bold' => false, 'name' => 'Times New Roman'], ['align' => 'right']);

    //End::Footer


    // Begin :: Add Template docx withoutTTD
    $properties = $phpWord->getDocInfo();
    $properties->setTitle($file_name . ".docx");
    $properties->setDescription('Nota Pengajuan Persetujuan');
    $phpWord->save(public_path($target_path . "/" . $file_name . ".docx"));
    // dd("Tes");
    // end :: Add Template docx withoutTTD


    // Begin :: SIGNED Template docx
    // end :: SIGNED Template docx

    // File::delete(public_path($target_path . "/" . $file_name . ".docx"));
    // dd($files);

    // Begin :: CONVERT Template docx to PDF
    $templatePhpWord = \PhpOffice\PhpWord\IOFactory::load(public_path($target_path . "/" . $file_name . ".docx"));
    $rendererName = \PhpOffice\PhpWord\Settings::PDF_RENDERER_DOMPDF;
    // $rendererName = \PhpOffice\PhpWord\Settings::PDF_RENDERER_TCPDF;
    $rendererLibraryPath = realpath('../vendor/dompdf/dompdf');
    // $rendererLibraryPath = realpath('../vendor/tecnickcom/tcpdf');
    \PhpOffice\PhpWord\Settings::setPdfRenderer($rendererName, $rendererLibraryPath);
    $xmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($templatePhpWord, 'PDF');
    $xmlWriter->save(public_path($target_path . "/" . $file_name . ".pdf"));

    // \PhpOffice\PhpWord\Settings::setPdfRendererName(\PhpOffice\PhpWord\Settings::PDF_RENDERER_TCPDF);
    // // Path to directory with tcpdf.php file.
    // // Rigth now `TCPDF` writer is depreacted. Consider to use `DomPDF` or `MPDF` instead.
    // \PhpOffice\PhpWord\Settings::setPdfRendererPath('../vendor/tecnickcom/tcpdf');

    // $xmlWriter = \PhpOffice\PhpWord\IOFactory::load(public_path($target_path . "/" . $file_name . ".docx"));
    // $xmlWriter->save(public_path('/file-persetujuan//' . $file_name . ".pdf"), 'PDF');
    // end :: CONVERT Template docx to PDF

    File::delete(public_path($target_path . "/" . $file_name . ".docx"));
    // dd("Tes");

    // $properties = $phpWord->getDocInfo();
    // $properties->setTitle($file_name.".pdf");
    // $properties->setDescription('Nota Rekomendasi');
    // $rendererName = \PhpOffice\PhpWord\Settings::PDF_RENDERER_DOMPDF;
    // $rendererLibraryPath = realpath('../vendor/dompdf/dompdf');
    // \PhpOffice\PhpWord\Settings::setPdfRenderer($rendererName, $rendererLibraryPath);
    // $xmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'PDF');
    // $is_saved = $xmlWriter->save(public_path($target_path. "/".$file_name . ".pdf"));

    // Begin :: Merge PDF
    $pdf_merger = new PdfMerge();
    $pdf_merger->add(public_path($target_path . "/" . $file_name . ".pdf"));
    $pdf_merger->add(public_path("file-rekomendasi" . "/" . $notaRekomendasi->file_rekomendasi));
    $pdf_merger->merge(public_path($target_path . "/" . $file_name . ".pdf"));
    // dd($pdf_merger);
    // End :: Merge PDF
    // dd("saved", $proyek->file_persetujuan);    
    // $proyek->file_persetujuan = $file_name . ".pdf";
    // $proyek->save();
    $notaRekomendasi->file_persetujuan = $file_name . ".pdf";
    $notaRekomendasi->save();
    // $is_saved = $phpWord->save(public_path($target_path. "\\". $file_name));
}


function createWordPersetujuan(App\Models\Proyek $proyek, \Illuminate\Support\Collection $hasil_assessment = new \Illuminate\Support\Collection(), $is_proyek_besar, $is_proyek_mega, \Illuminate\Http\Request $request)
{
    $phpWord = new \PhpOffice\PhpWord\PhpWord();
    $target_path = "file-persetujuan";
    $now = Carbon\Carbon::now();
    $file_name = $now->format("dmYHis") . "_nota-persetujuan_$proyek->kode_proyek";
    $notaRekomendasi = NotaRekomendasi::where('kode_proyek', $proyek->kode_proyek)->first();

    $internal_score = $hasil_assessment->sum(function ($ra) {
        if ($ra->kategori == "Internal") {
            return $ra->score;
        }
    });
    $eksternal_score = $hasil_assessment->sum(function ($ra) {
        if ($ra->kategori == "Eksternal") {
            return $ra->score;
        }
    });

    // $penyusun = collect(json_decode($proyek->approved_penyusun))->values()->toArray();
    // $penyusun = collect(json_decode($proyek->approved_verifikasi))->values()->toArray();
    // $rekomendator = json_decode($proyek->approved_rekomendasi_final);
    // $penyetuju = json_decode($proyek->approved_persetujuan);
    $penyusun = collect(json_decode($notaRekomendasi->approved_verifikasi))->values()->toArray();
    $rekomendator = json_decode($notaRekomendasi->approved_rekomendasi_final);
    $penyetuju = json_decode($notaRekomendasi->approved_persetujuan);
    $max_grid_span = collect([!empty($penyusun) ? count($penyusun) : 0, !empty($rekomendator) ? count($rekomendator) : 0, !empty($penyetuju) ? count($penyetuju) : 0])->max();
    // dd($penyusun, $rekomendator, $penyetuju, $max_grid_span);

    $section = $phpWord->addSection();
    $footer = $section->addFooter();
    $footer->addText("*Dokumen ini dibuat oleh sistem CRM", ['size' => 10, 'bold' => true], ['align' => 'right']);

    $section->addText("NOTA REKOMENDASI TAHAP I", ['size' => 12, "bold" => true], ['align' => "center"]);
    $section->addText("Seleksi Pengguna Jasa Non Green Lane", ['size' => 12, "bold" => true], ['align' => "center"]);

    if ($is_proyek_mega) {
        $section->addText("Proyek Mega", ['size' => 12, "bold" => true], ['align' => "center"]);
    } else if ($is_proyek_besar) {
        $section->addText("Proyek Besar", ['size' => 12, "bold" => true], ['align' => "center"]);
    } else {
        $section->addText("Proyek Kecil / Proyek Menengah", ['size' => 12, "bold" => true], ['align' => "center"]);
    }

    $section->addTextBreak(1);
    $table = $section->addTable('myOwnTableStyle', array('borderSize' => 1, 'borderColor' => '999999', 'afterSpacing' => 0, 'Spacing' => 0, 'cellMargin' => 0));
    $table->addRow(-0.5, array('exactHeight' => -5));

    $styleCell = array('borderTopSize' => 1, 'borderTopColor' => 'black', 'borderLeftSize' => 1, 'borderLeftColor' => 'black', 'borderRightSize' => 1, 'borderRightColor' => 'black', 'borderBottomSize' => 1, 'borderBottomColor' => 'black', 'textAlignment' => \PhpOffice\PhpWord\SimpleType\TextAlignment::CENTER);
    $TstyleCell = array("bgColor" => "F4B083", 'borderTopSize' => 1, 'borderTopColor' => 'black', 'borderLeftSize' => 1, 'borderLeftColor' => 'black', 'borderRightSize' => 1, 'borderRightColor' => 'black', 'borderBottomSize' => 1, 'borderBottomColor' => 'black');
    $TfontStyle = array('bold' => true, 'italic' => false, 'size' => 10, 'name' => 'Times New Roman', 'afterSpacing' => 0, 'Spacing' => 0, 'cellMargin' => 0, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::BOTH);
    $fontStyle = array('bold' => false, 'italic' => false, 'size' => 10, 'name' => 'Times New Roman', 'afterSpacing' => 0, 'Spacing' => 0, 'cellMargin' => 0, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::BOTH);
    $fontStyleTTD = array('bold' => true, 'italic' => false, 'size' => 10, 'name' => 'Times New Roman', 'afterSpacing' => 0, 'Spacing' => 0, 'cellMargin' => 0, 'alignment' => 'center');
    $columnStyle1 = array("bgColor" => "F4B083", 'borderTopSize' => 1, 'borderTopColor' => 'black', 'borderLeftSize' => 1, 'borderLeftColor' => 'black', 'borderRightSize' => 1, 'borderRightColor' => 'black', 'borderBottomSize' => 1, 'borderBottomColor' => 'black');
    $columnStyle2 = array("bgColor" => "F4B083", 'borderTopSize' => 1, 'borderTopColor' => 'black', 'borderLeftSize' => 1, 'borderLeftColor' => 'black', 'borderRightSize' => 1, 'borderRightColor' => 'black', 'borderBottomSize' => 1, 'borderBottomColor' => 'black', "gridSpan" => 4);
    $columnStyle3 = array("bgColor" => "F4B083", 'borderTopSize' => 1, 'borderTopColor' => 'black', 'borderLeftSize' => 1, 'borderLeftColor' => 'black', 'borderRightSize' => 1, 'borderRightColor' => 'black', 'borderBottomSize' => 1, 'borderBottomColor' => 'black', "gridSpan" => 6);
    $columnRowStyle1 = array('borderTopSize' => 1, 'borderTopColor' => 'black', 'borderLeftSize' => 1, 'borderLeftColor' => 'black', 'borderRightSize' => 1, 'borderRightColor' => 'black', 'borderBottomSize' => 1, 'borderBottomColor' => 'black', 'textAlignment' => \PhpOffice\PhpWord\SimpleType\TextAlignment::CENTER);
    $columnRowStyle2 = array('borderTopSize' => 1, 'borderTopColor' => 'black', 'borderLeftSize' => 1, 'borderLeftColor' => 'black', 'borderRightSize' => 1, 'borderRightColor' => 'black', 'borderBottomSize' => 1, 'borderBottomColor' => 'black', "gridSpan" => 4, 'textAlignment' => \PhpOffice\PhpWord\SimpleType\TextAlignment::CENTER);
    $columnRowStyle3 = array('borderTopSize' => 1, 'borderTopColor' => 'black', 'borderLeftSize' => 1, 'borderLeftColor' => 'black', 'borderRightSize' => 1, 'borderRightColor' => 'black', 'borderBottomSize' => 1, 'borderBottomColor' => 'black', "gridSpan" => 6, 'textAlignment' => \PhpOffice\PhpWord\SimpleType\TextAlignment::CENTER);

    $table->addCell(500, $columnStyle1)->addText('No', $TfontStyle);
    // $table->addCell(500,$TstyleCell)->addText('No',$TfontStyle);
    $table->addCell(2500, $columnStyle2)->addText("Item", $TfontStyle);
    // $table->addCell(2500,$TstyleCell)->addText("Item", $TfontStyle);
    $table->addCell(6000, $columnStyle3)->addText('Uraian', $TfontStyle);
    // $table->addCell(6000,$TstyleCell)->addText('Uraian',$TfontStyle);

    // $nama_proyek = str_replace("&", "dan", $proyek->nama_proyek);
    $table->addRow();
    // $table->addCell(500,$styleCell)->addText('1', $fontStyle);
    $table->addCell(500, $columnRowStyle1)->addText('1', $fontStyle);
    // $table->addCell(2500,$styleCell)->addText("Nama Proyek", $fontStyle);
    $table->addCell(2500, $columnRowStyle2)->addText("Nama Proyek", $fontStyle);
    // $table->addCell(6000,$styleCell)->addText($nama_proyek, $fontStyle);
    $table->addCell(6000, $columnRowStyle3)->addText(htmlspecialchars($proyek->nama_proyek, ENT_QUOTES), $fontStyle);
    $table->addRow();
    // $table->addCell(500,$styleCell)->addText('2', $fontStyle);
    $table->addCell(500, $columnRowStyle1)->addText('2', $fontStyle);
    // $table->addCell(2500,$styleCell)->addText("Lokasi Proyek", $fontStyle);
    $table->addCell(2500, $columnRowStyle2)->addText("Lokasi Proyek", $fontStyle);
    // $table->addCell(6000, $styleCell)->addText(Provinsi::find($proyek->provinsi)->province_name ?? "-", $fontStyle);
    $table->addCell(6000, $columnRowStyle3)->addText(Provinsi::find($proyek->provinsi)->province_name ?? "-", $fontStyle);
    $table->addRow();
    // $table->addCell(500,$styleCell)->addText('3', $fontStyle);
    $table->addCell(500, $columnRowStyle1)->addText('3', $fontStyle);
    // $table->addCell(2500, $styleCell)->addText("Nama Pengguna Jasa", $fontStyle);
    $table->addCell(2500, $columnRowStyle2)->addText("Nama Pengguna Jasa", $fontStyle);
    // $table->addCell(6000,$styleCell)->addText($proyek->proyekBerjalan->name_customer, $fontStyle);
    $table->addCell(6000, $columnRowStyle3)->addText(htmlspecialchars($proyek->proyekBerjalan->name_customer, ENT_QUOTES), $fontStyle);
    $table->addRow();
    // $table->addCell(500,$styleCell)->addText('4', $fontStyle);
    $table->addCell(500, $columnRowStyle1)->addText('4', $fontStyle);
    // $table->addCell(2500, $styleCell)->addText("Instansi Pengguna Jasa", $fontStyle);
    $table->addCell(2500, $columnRowStyle2)->addText("Instansi Pengguna Jasa", $fontStyle);
    // $table->addCell(6000,$styleCell)->addText($proyek->proyekBerjalan->Customer->jenis_instansi, $fontStyle);
    $table->addCell(6000, $columnRowStyle3)->addText($proyek->proyekBerjalan->Customer->jenis_instansi, $fontStyle);
    $table->addRow();
    // $table->addCell(500,$styleCell)->addText('5', $fontStyle);
    $table->addCell(500, $columnRowStyle1)->addText('5', $fontStyle);
    // $table->addCell(2500,$styleCell)->addText("Sumber Pendanaan Proyek", $fontStyle);
    $table->addCell(2500, $columnRowStyle2)->addText("Sumber Pendanaan Proyek", $fontStyle);
    // $table->addCell(6000,$styleCell)->addText($proyek->sumber_dana, $fontStyle);
    $table->addCell(6000, $columnRowStyle3)->addText($proyek->sumber_dana, $fontStyle);
    $table->addRow();
    // $table->addCell(500,$styleCell)->addText('6', $fontStyle);
    $table->addCell(500, $columnRowStyle1)->addText('6', $fontStyle);
    // $table->addCell(2500, $styleCell)->addText("Perkiraan Nilai Proyek", $fontStyle);
    $table->addCell(2500, $columnRowStyle2)->addText("Perkiraan Nilai Proyek", $fontStyle);
    // $table->addCell(6000,$styleCell)->addText(number_format($proyek->nilaiok_awal, 0, ".", "."), $fontStyle);
    $table->addCell(6000, $columnRowStyle3)->addText(number_format($proyek->nilaiok_awal, 0, ".", "."), $fontStyle);
    $table->addRow();
    // $table->addCell(500,$styleCell)->addText('7', $fontStyle);
    $table->addCell(500, $columnRowStyle1)->addText('7', $fontStyle);
    // $table->addCell(2500,$styleCell)->addText("Kategori Proyek", $fontStyle);
    $table->addCell(2500, $columnRowStyle2)->addText("Kategori Proyek", $fontStyle);
    // $table->addCell(6000,$styleCell)->addText($proyek->klasifikasi_pasdin ?? "-", $fontStyle);
    $table->addCell(6000, $columnRowStyle3)->addText($proyek->klasifikasi_pasdin ?? "-", $fontStyle);
    $table->addRow();
    // $table->addCell(500,$styleCell)->addText('8', $fontStyle);
    $table->addCell(500, $columnRowStyle1)->addText('8', $fontStyle);
    // $table->addCell(2500,$styleCell)->addText("Assessment Eksternal Atas Pengguna Jasa", $fontStyle);
    $table->addCell(2500, $columnRowStyle2)->addText("Assessment Eksternal Atas Pengguna Jasa", $fontStyle);
    // $table->addCell(6000,$styleCell)->addText($eksternal_score ?? "-", $fontStyle);
    $table->addCell(6000, $columnRowStyle3)->addText($eksternal_score ?? "-", $fontStyle);
    $table->addRow();
    // $table->addCell(500,$styleCell)->addText('9', $fontStyle);
    $table->addCell(500, $columnRowStyle1)->addText('9', $fontStyle);
    // $table->addCell(2500,$styleCell)->addText("Assessment Internal Atas Pengguna Jasa ", $fontStyle);
    $table->addCell(2500, $columnRowStyle2)->addText("Assessment Internal Atas Pengguna Jasa ", $fontStyle);
    // $table->addCell(6000,$styleCell)->addText($internal_score ?? "-", $fontStyle);
    $table->addCell(6000, $columnRowStyle3)->addText($internal_score ?? "-", $fontStyle);
    $table->addRow();
    // $table->addCell(500,$styleCell)->addText('10', $fontStyle);
    $table->addCell(500, $columnRowStyle1)->addText('10', $fontStyle);
    // $table->addCell(2500,$styleCell)->addText("Catatan", $fontStyle);
    $table->addCell(2500, $columnRowStyle2)->addText("Catatan", $fontStyle);
    // $cell_catatan = $table->addCell(6000, $styleCell);
    $cell_catatan = $table->addCell(6000, $columnRowStyle3);
    // $catatan_list = preg_split("/\n|\r\n?/", htmlspecialchars($proyek->catatan_nota_rekomendasi, ENT_QUOTES));
    $cell_catatan->addText(str_replace("\r\n", '</w:t><w:br/><w:t>', htmlspecialchars($notaRekomendasi->catatan_nota_rekomendasi, ENT_QUOTES)), $fontStyle, ["spacing" => 0, "spaceAfter" => 0, "spaceBefore" => 0]);
    // $catatan_list = preg_split("/\n|\r\n?/", htmlspecialchars($notaRekomendasi->catatan_nota_rekomendasi, ENT_QUOTES));
    // foreach ($catatan_list as $key => $catatan) {
    //     $cell_catatan->addText($catatan, $fontStyle);
    //     if ($catatan == "") {
    //         // $cell_catatan->addTextBreak(1);
    //         // $cell_catatan->addText("<w:br/>");
    //     }
    // }

    $section->addText("Berdasarkan informasi di atas, mengajukan untuk mengikuti aktifitas Perolehan Kontrak (tender) tersebut di atas.");

    $section->addTextBreak(2);
    // $section->addTextBreak(10);
    // $section->addPageBreak();
    $section2 = $phpWord->addSection();
    $footer2 = $section2->addFooter();
    $footer2->addText("*Dokumen ini dibuat oleh sistem CRM", ['size' => 10, 'bold' => true], ['align' => 'right']);

    $table_ttd = $section2->addTable('ttd_table', array('borderSize' => 1, 'borderColor' => '999999', 'afterSpacing' => 0, 'Spacing' => 0, 'cellMargin' => 0));
    // $table_ttd->addRow();
    $table_ttd->addRow();

    // $header_cell = $table_ttd->addCell(3000, ["vMerge" => "restart", "gridSpan" => 2, "bgColor" => "F4B083"]);
    $header_cell = $table_ttd->addCell(3000, ["vMerge" => "restart", "gridSpan" => 2, "bgColor" => "F4B083"]);
    $header_cell->addText("Disusun oleh,", ["bold" => true], ["align" => "center"]);
    // $header_cell->addText(null, ["bold" => true]);

    // New TTD Method
    $table_ttd->addRow();
    if (!empty($penyusun)) {
        // dd($penyusun);
        $total_penyusun = count($penyusun);
        foreach ($penyusun as $key => $p) {

            $key++;
            $total_penyusun = count($penyusun);

            if ($total_penyusun == 1) {
                $cell_2_ttd = $table_ttd->addCell(3000, ["vMerge" => "restart", "gridSpan" => 2]);
            } else {
                if ($total_penyusun % 2 == 0) {
                    if ($key == 3 || $key == 5 || $key == 7 || $key == 9) {
                        $table_ttd->addRow();
                    }
                    $cell_2_ttd = $table_ttd->addCell(3000, ["vMerge" => "restart", "gridSpan" => 1]);
                } else {
                    if ($key == 3 || $key == 5) {
                        $table_ttd->addRow();
                    }
                    if (($total_penyusun == 3 && $key == 3) || ($total_penyusun == 5 && $key == 5) || ($total_penyusun == 7 && $key == 7) || ($total_penyusun == 9 && $key == 9)) {
                        $cell_2_ttd = $table_ttd->addCell(3000, ["vMerge" => "restart", "gridSpan" => 2]);
                    } else {
                        $cell_2_ttd = $table_ttd->addCell(3000, ["vMerge" => "restart", "gridSpan" => 1]);
                    }
                }
            }
            // dd($cell_2_ttd);


            $tanggal_ttd = Carbon\Carbon::create($p->tanggal);
            // $cell_2_ttd->addText($now->translatedFormat("l, d F Y"), ["bold" => true], ["align" => "center"]);
            $cell_2_ttd->addTextBreak(5);
            // $cell_2_ttd->addText("$" . "{ttdPenyusun$key}", ["bold" => false], ["align" => "center"]);
            // $cell_2_ttd->addText(User::find($p->user_id)->name, $fontStyleTTD, ['alignment' => 'center', 'afterSpacing' => 0]);
            $cell_2_ttd->addText(User::find($p->user_id)->name, ['bold' => true, 'size' => 8], ['alignment' => 'center', 'spacing' => 10]);
            $cell_2_ttd->addText(User::find($p->user_id)->Pegawai->Jabatan?->nama_jabatan, ['bold' => true, 'size' => 8], ['alignment' => 'center', 'spacing' => 10]);
            // $cell_2_ttd->addText(User::find($p->user_id)->name, $fontStyleTTD, ['alignment' => 'center', 'afterSpacing' => 0]);
            // $cell_2_ttd->addText(User::find($p->user_id)->Pegawai->Jabatan?->nama_jabatan, $fontStyleTTD, ['alignment' => 'center', 'afterSpacing' => 0]);
            $cell_2_ttd->addText("Tanggal: " . $tanggal_ttd->translatedFormat("d F Y"), ["bold" => true, "size" => 7], ["align" => "center"]);
        }
    }

    $table_ttd->addRow();
    $header_cell = $table_ttd->addCell(3000, ["vMerge" => "restart", "gridSpan" => 2, "bgColor" => "F4B083"]);
    $header_cell->addText("Direkomendasi oleh,", ["bold" => true], ["align" => "center"]);
    // $header_cell->addText(null, ["bold" => true]);

    $table_ttd->addRow();
    if (!empty($rekomendator)) {
        foreach ($rekomendator as $key => $p) {
            $key++;
            $total_rekomendator = count($rekomendator);
            if ($total_rekomendator == 1) {
                $cell_3_ttd = $table_ttd->addCell(3000, ["vMerge" => "restart", "gridSpan" => 2]);
            } else {
                if ($total_rekomendator % 2 == 0) {
                    if ($key == 3 || $key == 5 || $key == 7 || $key == 9) {
                        $table_ttd->addRow();
                    }
                    $cell_3_ttd = $table_ttd->addCell(3000, ["vMerge" => "restart", "gridSpan" => 1]);
                } else {
                    if ($key == 3 || $key == 5) {
                        $table_ttd->addRow();
                    }
                    if (($total_rekomendator == 3 && $key == 3) || ($total_rekomendator == 5 && $key == 5) || ($total_rekomendator == 7 && $key == 7) || ($total_rekomendator == 9 && $key == 9)) {
                        $cell_3_ttd = $table_ttd->addCell(3000, ["vMerge" => "restart", "gridSpan" => 2]);
                    } else {
                        $cell_3_ttd = $table_ttd->addCell(3000, ["vMerge" => "restart", "gridSpan" => 1]);
                    }
                }
            }
            $tanggal_ttd = Carbon\Carbon::create($p->tanggal);
            // $cell_3_ttd->addText($now->translatedFormat("l, d F Y"), ["bold" => true], ["align" => "center"]);
            $cell_3_ttd->addTextBreak(5);
            // $cell_3_ttd->addText("$" . "{ttdRekomendasi$key}", ["bold" => false], ["align" => "center"]);
            $cell_3_ttd->addText(User::find($p->user_id)->name, ['bold' => true, 'size' => 8], ['alignment' => 'center', 'spacing' => 10]);
            $cell_3_ttd->addText(User::find($p->user_id)->Pegawai->Jabatan?->nama_jabatan, ['bold' => true, 'size' => 8], ['alignment' => 'center', 'spacing' => 10]);
            // $cell_3_ttd->addText(User::find($p->user_id)->name, $fontStyleTTD, ['alignment' => 'center', 'afterSpacing' => 0]);
            // $cell_3_ttd->addText(User::find($p->user_id)->Pegawai->Jabatan?->nama_jabatan, $fontStyleTTD, ['alignment' => 'center', 'afterSpacing' => 0]);
            $cell_3_ttd->addText("Tanggal: " . $tanggal_ttd->translatedFormat("d F Y"), ["bold" => true, "size" => 7], ["align" => "center"]);
            if ($p->status == "approved" && empty($p->catatan)) {
                $cell_3_ttd->addText("Direkomendasikan", ["bold" => true, "size" => 7], ["align" => "center"]);
            } elseif ($p->status == "approved" && !empty($p->catatan)) {
                $cell_3_ttd->addText("Direkomendasikan dengan catatan", ["bold" => true, "size" => 7], ["align" => "center"]);
            } else {
                $cell_3_ttd->addText("Tidak Direkomendasikan", ["bold" => true, "size" => 7], ["align" => "center"]);
            }
        }
    }

    $table_ttd->addRow();
    $header_cell = $table_ttd->addCell(3000, ["vMerge" => "restart", "gridSpan" => 2, "bgColor" => "F4B083"]);
    $header_cell->addText("Persetujuan oleh,", ["bold" => true], ["align" => "center"]);
    // $header_cell->addText(null, ["bold" => true]);

    $table_ttd->addRow();
    if (!empty($penyetuju)) {
        foreach ($penyetuju as $key => $p) {
            $key++;
            $total_penyetuju = count($penyetuju);
            if ($total_penyetuju == 1) {
                $cell_4_ttd = $table_ttd->addCell(3000, ["vMerge" => "restart", "gridSpan" => 2]);
            } else {
                if ($total_penyetuju % 2 == 0) {
                    if ($key == 3 || $key == 5 || $key == 7 || $key == 9) {
                        $table_ttd->addRow();
                    }
                    $cell_4_ttd = $table_ttd->addCell(3000, ["vMerge" => "restart", "gridSpan" => 1]);
                } else {
                    if ($key == 3 || $key == 5) {
                        $table_ttd->addRow();
                    }
                    if (($total_penyetuju == 3 && $key == 3) || ($total_penyetuju == 5 && $key == 5) || ($total_rekomendator == 7 && $key == 7) || ($total_rekomendator == 9 && $key == 9)) {
                        $cell_4_ttd = $table_ttd->addCell(3000, ["vMerge" => "restart", "gridSpan" => 2]);
                    } else {
                        $cell_4_ttd = $table_ttd->addCell(3000, ["vMerge" => "restart", "gridSpan" => 1]);
                    }
                }
            }
            $tanggal_ttd = Carbon\Carbon::create($p->tanggal);
            $cell_4_ttd->addTextBreak(5);
            // $cell_4_ttd->addText("$" . "{ttdPersetujuan$key}", ["bold" => false], ["align" => "center"]);
            $cell_4_ttd->addText(User::find($p->user_id)->name ?? Auth::user()->name, ['bold' => true, 'size' => 8], ['alignment' => 'center', 'spacing' => 10]);
            $cell_4_ttd->addText(User::find($p->user_id)->Pegawai->Jabatan?->nama_jabatan ?? Auth::user()->Pegawai->Jabatan?->nama_jabatan, ['bold' => true, 'size' => 8], ['alignment' => 'center', 'spacing' => 10]);
            // $cell_4_ttd->addText(User::find($p->user_id)->name ?? Auth::user()->name, $fontStyleTTD, ['alignment' => 'center', 'afterSpacing' => 0]);
            // $cell_4_ttd->addText(User::find($p->user_id)->Pegawai->Jabatan?->nama_jabatan ?? Auth::user()->Pegawai->Jabatan?->nama_jabatan, $fontStyleTTD, ['alignment' => 'center', 'afterSpacing' => 0]);
            $cell_4_ttd->addText("Tanggal: " . $tanggal_ttd->translatedFormat("d F Y"), ["bold" => true, "size" => 7], ["align" => "center"]);
            if ($p->status == "approved" && empty($p->catatan)) {
                $cell_4_ttd->addText("Direkomendasikan", ["bold" => true, "size" => 7], ["align" => "center"]);
            } elseif ($p->status == "approved" && !empty($p->catatan)) {
                $cell_4_ttd->addText("Direkomendasikan dengan catatan", ["bold" => true, "size" => 7], ["align" => "center"]);
            } else {
                $cell_4_ttd->addText("Tidak Direkomendasikan", ["bold" => true, "size" => 7], ["align" => "center"]);
            }
        }
    }
    $section2->addTextBreak(2);
    //Begin :: Catatan Rekomendasi
    $section3 = $phpWord->addSection();
    $footer3 = $section3->addFooter();
    $footer3->addText("*Dokumen ini dibuat oleh sistem CRM", ['size' => 10, 'bold' => true], ['align' => 'right']);

    $table_comment = $section3->addTable('comment_table', array('borderSize' => 1, 'borderColor' => '999999', 'afterSpacing' => 0, 'Spacing' => 0, 'cellMargin' => 0));
    $table_comment->addRow();
    $header_cell = $table_comment->addCell(500, ["vMerge" => "restart", "gridSpan" => 2, "bgColor" => "F4B083"]);
    $header_cell->addText("Catatan dari Rekomendasi", ["bold" => true], ["align" => "center"]);

    if (!empty($rekomendator)) {
        foreach ($rekomendator as $key => $p) {
            $table_comment->addRow();

            $cell_1_note = $table_comment->addCell(200);
            $cell_2_note = $table_comment->addCell(200);
            // $cell_2_ttd->addText($now->translatedFormat("l, d F Y"), ["bold" => true], ["align" => "center"]);
            $cell_1_note->addText(User::find($p->user_id)->name, ["bold" => true], ["align" => "center"]);
            // $cell_1_note->addTextBreak(1);
            // $cell_2_note->addText(preg_replace('/&(?!#?[a-z0-9]+;)/', '&amp;', nl2br($p->catatan)), $fontStyle);
            // $cell_2_ttd->addText($now->translatedFormat("l, d F Y"), ["bold" => true], ["align" => "center"]);
            $catatan_list = preg_split("/\n|\r\n?/", htmlspecialchars($p->catatan, ENT_QUOTES));
            foreach ($catatan_list as $key => $catatan) {
                if ($key != 0 && $catatan == "") {
                    $cell_2_note->addTextBreak(1, ['size' => 5], ['afterSpacing' => 0, 'spacing' => 10]);
                }
                $cell_2_note->addText($catatan, ["bold" => false], ["align" => "left"]);
            }
        }
    }
    // //end :: Catatan Rekomendasi

    //Begin :: Catatan Persetujuan
    $section3->addTextBreak(1);
    $section4 = $phpWord->addSection();
    $footer4 = $section4->addFooter();
    $footer4->addText("*Dokumen ini dibuat oleh sistem CRM", ['size' => 10, 'bold' => true], ['align' => 'right']);

    $table_comment_penyetuju = $section4->addTable('comment_table', array('borderSize' => 1, 'borderColor' => '999999', 'afterSpacing' => 0, 'Spacing' => 0, 'cellMargin' => 0));
    $table_comment_penyetuju->addRow();
    $header_cell = $table_comment_penyetuju->addCell(500, ["vMerge" => "restart", "gridSpan" => 2, "bgColor" => "F4B083"]);
    $header_cell->addText("Catatan dari Persetujuan", ["bold" => true], ["align" => "center"]);
    // $table_comment_penyetuju->addRow();
    if (!empty($penyetuju)) {
        foreach ($penyetuju as $key => $p) {
            if (!empty($p->catatan) || $p->catatan != null) {
                $table_comment_penyetuju->addRow();

                $cell_1_note = $table_comment_penyetuju->addCell(200);
                $cell_2_note = $table_comment_penyetuju->addCell(200);
                // $cell_2_ttd->addText($now->translatedFormat("l, d F Y"), ["bold" => true], ["align" => "center"]);
                $cell_1_note->addText(User::find($p->user_id)->name, ["bold" => true], ["align" => "center"]);
                // $cell_1_note->addTextBreak(1);
                $catatan_list = preg_split("/\n|\r\n?/", htmlspecialchars($p->catatan, ENT_QUOTES));
                foreach ($catatan_list as $key => $catatan) {
                    if ($key != 0 && $catatan == "") {
                        $cell_2_note->addTextBreak(1, ['size' => 5], ['afterSpacing' => 0, 'spacing' => 10]);
                    }
                    $cell_2_note->addText($catatan, ["bold" => false], ["align" => "left"]);
                }
            }
        }
    }

    //end :: Catatan Rekomendasi

    //Begin::Footer

    // $section4->addTextBreak(1);
    // $section4->addText("*Dokumen ini dibuat oleh sistem CRM", ['size' => 6, 'bold' => false, 'name' => 'Times New Roman'], ['align' => 'right']);

    //End::Footer


    // Begin :: Add Template docx withoutTTD
    $properties = $phpWord->getDocInfo();
    $properties->setTitle($file_name . ".docx");
    $properties->setDescription('Nota Pengajuan Persetujuan');
    $phpWord->save(public_path($target_path . "/" . $file_name . ".docx"));
    // dd("Tes");
    // end :: Add Template docx withoutTTD


    // Begin :: SIGNED Template docx
    // end :: SIGNED Template docx

    // File::delete(public_path($target_path . "/" . $file_name . ".docx"));
    // dd($files);

    // Begin :: CONVERT Template docx to PDF
    $templatePhpWord = \PhpOffice\PhpWord\IOFactory::load(public_path($target_path . "/" . $file_name . ".docx"));
    $rendererName = \PhpOffice\PhpWord\Settings::PDF_RENDERER_DOMPDF;
    // $rendererName = \PhpOffice\PhpWord\Settings::PDF_RENDERER_TCPDF;
    $rendererLibraryPath = realpath('../vendor/dompdf/dompdf');
    // $rendererLibraryPath = realpath('../vendor/tecnickcom/tcpdf');
    \PhpOffice\PhpWord\Settings::setPdfRenderer($rendererName, $rendererLibraryPath);
    $xmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($templatePhpWord, 'PDF');
    $xmlWriter->save(public_path($target_path . "/" . $file_name . ".pdf"));

    // \PhpOffice\PhpWord\Settings::setPdfRendererName(\PhpOffice\PhpWord\Settings::PDF_RENDERER_TCPDF);
    // // Path to directory with tcpdf.php file.
    // // Rigth now `TCPDF` writer is depreacted. Consider to use `DomPDF` or `MPDF` instead.
    // \PhpOffice\PhpWord\Settings::setPdfRendererPath('../vendor/tecnickcom/tcpdf');

    // $xmlWriter = \PhpOffice\PhpWord\IOFactory::load(public_path($target_path . "/" . $file_name . ".docx"));
    // $xmlWriter->save(public_path('/file-persetujuan//' . $file_name . ".pdf"), 'PDF');
    // end :: CONVERT Template docx to PDF

    // File::delete(public_path($target_path . "/" . $file_name . ".docx"));
    // dd("Tes");

    // $properties = $phpWord->getDocInfo();
    // $properties->setTitle($file_name.".pdf");
    // $properties->setDescription('Nota Rekomendasi');
    // $rendererName = \PhpOffice\PhpWord\Settings::PDF_RENDERER_DOMPDF;
    // $rendererLibraryPath = realpath('../vendor/dompdf/dompdf');
    // \PhpOffice\PhpWord\Settings::setPdfRenderer($rendererName, $rendererLibraryPath);
    // $xmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'PDF');
    // $is_saved = $xmlWriter->save(public_path($target_path. "/".$file_name . ".pdf"));

    // Begin :: Merge PDF
    $pdf_merger = new PdfMerge();
    $pdf_merger->add(public_path($target_path . "/" . $file_name . ".pdf"));
    $pdf_merger->add(public_path("file-rekomendasi" . "/" . $notaRekomendasi->file_rekomendasi));
    $pdf_merger->merge(public_path($target_path . "/" . $file_name . ".pdf"));
    // dd($pdf_merger);
    // End :: Merge PDF
    // dd("saved", $proyek->file_persetujuan);    
    // $proyek->file_persetujuan = $file_name . ".pdf";
    // $proyek->save();
    // $notaRekomendasi->file_persetujuan = $file_name . ".pdf";
    // $notaRekomendasi->save();
    // $is_saved = $phpWord->save(public_path($target_path. "\\". $file_name));
}

function performAssessment(App\Models\Customer $customer, App\Models\Proyek $proyek) {
    $kriteria_assessments = KriteriaAssessment::all();
    $result_assessments = collect();
    $bowheer = collect();
    $kriteria_assessments->groupBy("kriteria_penilaian")->each(function ($ka, $kriteria) use ($customer, $result_assessments, $bowheer, $kriteria_assessments) {
        // if($customer->proyekBerjalans->where("stage", "=", 8)->count() > 0) {
        if ($customer->Piutang->where('kategori', '!=', 1)->count() > 0 || $customer->MasalahHukum->count() > 0) {
            foreach($ka as $k) {
                if($kriteria == "Piutang") {
                    // dd($customer->Piutang);
                    $is_assessment_piutang_exist = $result_assessments->where("kriteria_penilaian", "=", $kriteria)->count() > 0;
                    // dump($is_assessment_piutang_exist);
                    if(!$is_assessment_piutang_exist) {
                        // if($customer->Piutang->count() > 0) {
                        // $is_piutang_91_day_exist = $customer->Piutang->where("day_91", ">", 0)->count() > 0;
                        $is_piutang_91_day_exist = $customer->Piutang->where("kategori", 3)->count() > 0;
                            if($is_piutang_91_day_exist) {
                                $result = collect(["kategori" => "Internal", "kriteria_penilaian" => $kriteria, "score" => (float) 5]);
                                $result_assessments->push($result);
                        } elseif ($customer->Piutang->where("kategori", 2)->count() > 0) {
                                $result = collect(["kategori" => "Internal", "kriteria_penilaian" => $kriteria, "score" => (float) 7.5]);
                            $result_assessments->push($result);
                        } else {
                            $result = collect(["kategori" => "Internal", "kriteria_penilaian" => $kriteria, "score" => (float) 10]);
                            $result_assessments->push($result);
                        }
                        // } else {
                            // $result = collect(["kategori" => "Internal", "kriteria_penilaian" => $kriteria, "score" => (float) 10]);
                            // $result_assessments->push($result);
                        // }
                    }
                } else if($kriteria == "Bowheer Bermasalah") {
                    if($customer->MasalahHukum->isNotEmpty()) {
                        $group_bowheer = $kriteria_assessments->where('kriteria_penilaian', $kriteria)->keyBy('isi');
                        // dump($group_bowheer);
                        $highest_score = $customer->MasalahHukum->map(function ($mh) use ($k, $bowheer, $kriteria_assessments, $kriteria, $result_assessments) {
                            $new_class = new stdClass();
                            $new_class->isi = $mh->status;
                            // $group_bowheer->map(function($item, $key)use($mh, $new_class){
                            //     if(str_contains($key, $mh->status)) {
                            //         $new_class->score = (float) $item->nilai;
                            //     } else {
                            //         $new_class->score = 0.0;
                            //     }
                            // });
                            if (str_contains($k->isi, $mh->status)) {
                                $new_class->score = (float) $k->nilai;
                                $bowheer->push($new_class);
                                // $final_score = $highest_score->where('score', $highest_score->min('score'))->first();
                                // dd($final_score);
                                $result = collect(["kategori" => "Internal", "kriteria_penilaian" => "Pemberi Kerja bermasalah", "score" => (float)$new_class->score]);
                                $result_assessments->push($result);
                            } else {
                                $new_class->score = 0.0;
                            }
                            // // dump(str_contains($k->isi, $mh->status));
                            // $filter = $group_bowheer->where(function($item, $key)use($mh){
                            //     // dump($key);
                            //     return stripos($key, $mh->status);
                            // })->values()->first();
                            // $new_class->score = (float)$filter->nilai;
                            // // dump($filter);
                            return $new_class;
                        });
                    }
                    // else{
                    //     $result = collect(["kategori" => "Internal", "kriteria_penilaian" => "Pemberi Kerja bermasalah", "score" => (float)$k->nilai]);
                    //     $result_assessments->push($result);
                    // }
                } else if($kriteria == "Key Client") {
                    if($customer->key_client) {
                        $result = collect(["kategori" => "Internal", "kriteria_penilaian" => $kriteria, "score" => (float) $k->nilai]);
                        $result_assessments->push($result);
                    }
                } else if($kriteria == "Top 100 Perusahan Besar di Indonesia") {
                    if (!empty($customer->forbes_rank)) {
                        $forbes_rank = preg_replace("/[^(0-9{2}|\-|0-9{2})]/i", "",  $customer->forbes_rank);
                        if (str_contains($k->isi, $forbes_rank) && $customer->forbes_rank != "Diluar Top 100") {
                            $result = collect(["kategori" => "Eksternal", "kriteria_penilaian" => $kriteria, "score" => (float) $k->nilai]);
                            $result_assessments->push($result);
                        } else if ($customer->forbes_rank == "Diluar Top 100" && $k->isi == "Perusahaan tidak berada pada daftar Top Perusahaan") {
                            $result = collect(["kategori" => "Eksternal", "kriteria_penilaian" => $kriteria, "score" => (float) $k->nilai]);
                            $result_assessments->push($result);
                        }
                    } else {
                        if ($result_assessments->where("kriteria_penilaian", "=", $kriteria)->count() < 1) {
                            $result = collect(["kategori" => "Eksternal", "kriteria_penilaian" => $kriteria, "score" => (float) 5]);
                            $result_assessments->push($result);
                        }
                    }
                } else if($kriteria == "Lembaga Lain yang mengeluarkan rating perusahaan di Indonesia") {
                    if (!empty($customer->lq_rank)) {
                        $lq_rank = preg_replace("/[^(0-9{2}|\-|0-9{2})]/i", "", $customer->lq_rank);
                        // dump($lq_rank, $k->isi);
                        if (str_contains($k->isi, $lq_rank) && $customer->lq_rank != "Diluar Top 45") {
                            $result = collect(["kategori" => "Eksternal", "kriteria_penilaian" => $kriteria, "score" => (float) $k->nilai]);
                            $result_assessments->push($result);
                        } else if ($customer->lq_rank == "Diluar Top 45" && $k->isi == "Perusahaan tidak berada pada daftar Rating Perusahaan") {
                            $result = collect(["kategori" => "Eksternal", "kriteria_penilaian" => $kriteria, "score" => (float) $k->nilai]);
                            $result_assessments->push($result);
                        }
                    } else {
                        if ($result_assessments->where("kriteria_penilaian", "=", $kriteria)->count() < 1) {
                            $result = collect(["kategori" => "Eksternal", "kriteria_penilaian" => $kriteria, "score" => (float) 5]);
                            $result_assessments->push($result);
                        }
                    }
                } else if($kriteria == "Industry Attractive") {
                    $industry_owner = IndustryOwner::find($customer->industry_sector);
                    if(!empty($industry_owner) && $industry_owner->owner_attractiveness == $k->isi) {
                        $result = collect(["kategori" => "Eksternal", "kriteria_penilaian" => $kriteria, "score" => (float) $k->nilai]);
                        $result_assessments->push($result);
                    }
                    // if($industry_owner->owner_attractiveness == "Menarik" || $industry_owner->owner_attractiveness == "Cenderung Menarik") {
                    //     $result = collect(["kategori" => "Internal", "kriteria_penilaian" => $kriteria, "score" => "10"]);
                    // } else if($industry_owner->owner_attractiveness == "Netral" || $industry_owner->owner_attractiveness == "Cenderung Waspada") {
                    //     $result = collect(["kriteria_penilaian" => $kriteria, "score" => "7.5"]);
                    // } else if($industry_owner->owner_attractiveness == "Waspada") {
                    // }
                }
            }
        } else {
            foreach($ka as $k) {
                if($kriteria == "Top 100 Perusahan Besar di Indonesia") {
                    if(!empty($customer->forbes_rank)) {
                        $forbes_rank = preg_replace("/[^(0-9{2}|\-|0-9{2})]/i", "",  $customer->forbes_rank);
                        if(str_contains($k->isi, $forbes_rank) && $customer->forbes_rank != "Diluar Top 100") {
                            $result = collect(["kategori" => "Eksternal", "kriteria_penilaian" => $kriteria, "score" => (float) $k->nilai]);
                            $result_assessments->push($result);
                        } else if($customer->forbes_rank == "Diluar Top 100" && $k->isi == "Perusahaan tidak berada pada daftar Top Perusahaan") {
                            $result = collect(["kategori" => "Eksternal", "kriteria_penilaian" => $kriteria, "score" => (float) $k->nilai]);
                            $result_assessments->push($result);
                        }
                    } else {
                        if($result_assessments->where("kriteria_penilaian", "=", $kriteria)->count() < 1 ) {
                            $result = collect(["kategori" => "Eksternal", "kriteria_penilaian" => $kriteria, "score" => (float) 5]);
                            $result_assessments->push($result);
                        }
                    }
                } else if($kriteria == "Lembaga Lain yang mengeluarkan rating perusahaan di Indonesia") {
                    if(!empty($customer->lq_rank)) {
                        $lq_rank = preg_replace("/[^(0-9{2}|\-|0-9{2})]/i", "", $customer->lq_rank);
                        // dump($lq_rank, $k->isi);
                        if(str_contains($k->isi, $lq_rank) && $customer->lq_rank != "Diluar Top 45") {
                            $result = collect(["kategori" => "Eksternal", "kriteria_penilaian" => $kriteria, "score" => (float) $k->nilai]);
                            $result_assessments->push($result);
                        } else if($customer->lq_rank == "Diluar Top 45" && $k->isi == "Perusahaan tidak berada pada daftar Rating Perusahaan") {
                            $result = collect(["kategori" => "Eksternal", "kriteria_penilaian" => $kriteria, "score" => (float) $k->nilai]);
                            $result_assessments->push($result);
                        }
                    } else {
                        if($result_assessments->where("kriteria_penilaian", "=", $kriteria)->count() < 1 ) {
                            $result = collect(["kategori" => "Eksternal", "kriteria_penilaian" => $kriteria, "score" => (float) 5]);
                            $result_assessments->push($result);
                        }
                    }
                } else if($kriteria == "Industry Attractive") {
                    $industry_owner = IndustryOwner::find($customer->industry_sector);
                    if(!empty($industry_owner) && $industry_owner->owner_attractiveness == $k->isi) {
                        $result = collect(["kategori" => "Eksternal", "kriteria_penilaian" => $kriteria, "score" => (float) $k->nilai]);
                        $result_assessments->push($result);
                    }
                    // if($industry_owner->owner_attractiveness == "Menarik" || $industry_owner->owner_attractiveness == "Cenderung Menarik") {
                    //     $result = collect(["kategori" => "Internal", "kriteria_penilaian" => $kriteria, "score" => "10"]);
                    // } else if($industry_owner->owner_attractiveness == "Netral" || $industry_owner->owner_attractiveness == "Cenderung Waspada") {
                    //     $result = collect(["kriteria_penilaian" => $kriteria, "score" => "7.5"]);
                    // } else if($industry_owner->owner_attractiveness == "Waspada") {
                    // }
                }
            }
        }
    });
    // dd($result_assessments, $bowheer);
    
    return $result_assessments;
}

function mergeFileLampiranRisiko($kode_proyek)
{
    $proyek = Proyek::find($kode_proyek);
    if (empty($proyek)) {
        return null;
    }

    $now = Carbon\Carbon::now();
    $file_name = $now->format("dmYHis") . "_lampiran-kriteria_" . $proyek->kode_proyek;

    // if ($proyek->is_penyusun_approved && !empty($proyek->approved_penyusun)) {
    $kriteria_detail = KriteriaPenggunaJasaDetail::where('kode_proyek', $proyek->kode_proyek)->get();
    // dd($kriteria_detail);
    $collectFileKriteria = $kriteria_detail->map(function ($kf) {
        $collectArr = collect([]);
        if ($kf->id_document != null || $kf->id_document != "[]") {
            $collectArr->push(json_decode($kf->id_document));
        }
        return $collectArr;
    })
        ->flatten()
        ->filter(function ($k) {
            return $k != null;
        })
        ->values();
    if ($collectFileKriteria->isEmpty()) {
        return null;
    }

    $pdfMerger = new PdfMerge();

    $collectFileKriteria->each(function ($cf) use ($pdfMerger) {
        $pdfMerger->add(public_path('file-kriteria-pengguna-jasa' . '/' . $cf));
    });
    try {
        $pdfMerger->merge(public_path("file-kriteria-pengguna-jasa" . "/" . $file_name . ".pdf"));
        return $file_name . ".pdf";
    } catch (\Exception $e) {
        dd($e);
    }
    // } else {
    //     return null;
    // }
}

function sendNotifEmail($user, $subject, $message, $activatedEmailToUser, $isNotaRekomendasi = true): bool
{
    if (!$isNotaRekomendasi) {
        $emailTarget = $activatedEmailToUser ? $user : env("EMAIL_DEFAULT");
    } else {
        $emailTarget = $activatedEmailToUser ? $user->email : env("EMAIL_DEFAULT");
    }

    $requestBody = [
        "subject" => $subject,
        "to" => $emailTarget,
        "cc" => "",
        "bcc" => "",
        "message" => $message
    ];

    $newLog = new IntegrationLog();
    $newLog->category = 'Email';
    $newLog->request_body = collect($requestBody)->toJson();

    try {

        $response = Http::withBasicAuth(env("EMAIL_USERNAME_AUTH"), env("EMAIL_PASSWORD_AUTH"))->post(env("EMAIL_URL_AUTH"), $requestBody);

        $data = $response->collect();
        $data = $data->prepend($emailTarget, 'to');

        $newLog->response_header = collect($response->headers())->toJson();

        if ($response->successful()) {
            if (!$data["status"]) {
                $newLog->status_code = $response->status();
                $newLog->status = 'failed';
                $newLog->response_body = $data->toJson();
                $newLog->error_message = $data['message'];
                $newLog->save();
                Alert::error('Error', $data["message"]);
                return false;
            } else {
                $newLog->status_code = $response->status();
                $newLog->status = 'success';
                $newLog->response_body = $data->toJson();
                $newLog->save();
                return true;
            }
        } else {
            $newLog->status_code = $response->status();
            $newLog->status = 'failed';
            $newLog->response_body = $data->toJson();
            $newLog->error_message = $data['message'];
            $newLog->save();
            Alert::error('Error', "Tidak dapat mengirim Email saat ini. Mohon hubungi Admin!");
            return false;
        }
    } catch (\Exception $e) {
        $newLog->status_code = 500;
        $newLog->status = 'failed';
        $newLog->response_header = '[]';
        $newLog->response_body = '[]';
        $newLog->error_message = 'Internal Server Error';
        $newLog->save();
        Alert::error('Error', $e->getMessage());
        return false;
    }
}

function createWordNotaRekomendasiPengajuan(\App\Models\NotaRekomendasi $proyekRekomendasi, \Illuminate\Http\Request $request)
{
    try {
        $proyek = $proyekRekomendasi->Proyek;
        $target_path = "file-pengajuan";
        $file_name = date('dmYHis') . "_nota-pengajuan_$proyek->kode_proyek";

        $templateProcessor = new TemplateProcessor(storage_path("/template/DokumenNota1/Pengajuan/Nota Pengajuan.docx"));

        // Set Value Detail Proyek
        $templateProcessor->setValue('NamaProyek', htmlspecialchars($proyek->nama_proyek));
        $templateProcessor->setValue('LokasiProyek', Provinsi::find($proyek->provinsi)->province_name ?? "-");
        $templateProcessor->setValue('NamaPenggunaJasa', htmlspecialchars($proyek->proyekBerjalan->name_customer, ENT_QUOTES) ?? "-");
        $templateProcessor->setValue('InstansiPenggunaJasa', $proyek->proyekBerjalan->Customer->jenis_instansi ?? "-");
        $templateProcessor->setValue('SumberPendanaan', $proyek->sumber_dana ?? "-");
        $templateProcessor->setValue('PerkiraanNilai', number_format($proyek->nilaiok_awal, 0, ".", ".") ?? "-");
        $templateProcessor->setValue('KategoriProyek', $proyek->klasifikasi_pasdin ?? "-");

        //Set Value Tanda Tangan
        $collectPengajuan = collect(json_decode($proyekRekomendasi->approved_rekomendasi));
        // $qrNamePenyusun = date('dmYHis_') . "penyusun_" . Auth::user()->nip . "-" . $proyek->kode_proyek . ".png";
        $qrNamePenyusun = date('dmYHis_') . "penyusun_" . User::find($collectPengajuan->first()->user_id)->nip . "-" . $proyek->kode_proyek . ".png";
        $qrPath = storage_path("template/temp/" . $qrNamePenyusun);
        // $urlPenyusun = $request->schemeAndHttpHost() . "?nip=" . Auth::user()->nip . "&redirectTo=/rekomendasi/" . $proyek->kode_proyek . "/" . Auth::user()->nip . "/view-qr?kategori=pengajuan";
        // $urlPenyusun = $request->schemeAndHttpHost() . "/rekomendasi/" . $proyek->kode_proyek . "/" . Auth::user()->nip . "/view-qr?kategori=pengajuan";
        $urlPenyusun = $request->schemeAndHttpHost() . "/rekomendasi/" . $proyek->kode_proyek . "/" . User::find($collectPengajuan->first()->user_id)->nip . "/view-qr?kategori=pengajuan";
        $generateQRPenyusun = generateQrCode($qrNamePenyusun, $qrPath, $urlPenyusun);

        $templateProcessor->setImageValue("tandaTangan", ["path" => $qrPath, "height" => 90, "ratio" => false]);
        // $templateProcessor->setValue("namaTandaTangan", Auth::user()?->name ?? "-");
        $templateProcessor->setValue("namaTandaTangan", User::find($collectPengajuan->first()->user_id)->name ?? "-");
        $templateProcessor->setValue("jabatanTandaTangan", User::find($collectPengajuan->first()->user_id)->Pegawai->Jabatan?->nama_jabatan ?? "-");
        $templateProcessor->setValue("tanggalTandaTangan", Carbon\Carbon::now()->translatedFormat("d F Y") ?? "-");

        File::delete($qrPath);

        $templateProcessor->saveAs(storage_path('template/temp/' . $file_name . '.docx'));

        $templatePhpWord = \PhpOffice\PhpWord\IOFactory::load(storage_path('template/temp/' . $file_name . '.docx'));
        $rendererName = \PhpOffice\PhpWord\Settings::PDF_RENDERER_DOMPDF;
        // $rendererName = \PhpOffice\PhpWord\Settings::PDF_RENDERER_TCPDF;
        $rendererLibraryPath = realpath('../vendor/dompdf/dompdf');
        // $rendererLibraryPath = realpath('../vendor/tecnickcom/tcpdf');
        \PhpOffice\PhpWord\Settings::setPdfRenderer($rendererName, $rendererLibraryPath);
        $xmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($templatePhpWord, 'PDF');
        // $xmlWriter->save(storage_path('template/temp/' . $file_name . '.pdf'));
        $xmlWriter->save(public_path($target_path . "/" . $file_name . ".pdf"));

        $pdfMerge = new PdfMerge();
        $pdfMerge->add(public_path($target_path . "/" . $file_name . ".pdf"));

        // if (!empty($proyek->DokumenPendukungPasarDini)) {
        //     foreach ($proyek->DokumenPendukungPasarDini as $dokumen) {
        //         $pdfMerge->add(public_path('dokumen-pendukung-pasdin/' . $dokumen->id_document));
        //     }
        // }

        // $pdfMerge->merge(public_path($target_path . "/" . $file_name . ".pdf"));

        $proyekRekomendasi->file_pengajuan = $file_name . ".pdf";
        $proyekRekomendasi->save();
    } catch (\Exception $e) {
        throw $e;
    }
}

function createWordNotaRekomendasiSetuju(\App\Models\NotaRekomendasi $proyekRekomendasi, \Illuminate\Support\Collection $hasil_assessment = new \Illuminate\Support\Collection(), \Illuminate\Http\Request $request)
{
    try {
        $proyek = $proyekRekomendasi->Proyek;
        $target_path = "file-persetujuan";
        $file_name = date('dmYHis') . "_nota-persetujuan_$proyek->kode_proyek";
        $penyusun = collect(json_decode($proyekRekomendasi->approved_verifikasi))->values()->toArray();
        $rekomendator = json_decode($proyekRekomendasi->approved_rekomendasi_final);
        $penyetuju = json_decode($proyekRekomendasi->approved_persetujuan);

        if (str_contains($proyek->klasifikasi_pasdin, "Kecil")) {
            $templateProcessor = new TemplateProcessor(storage_path("/template/DokumenNota1/Persetujuan/Nota Persetujuan Proyek Kecil.docx"));
        } elseif (str_contains($proyek->klasifikasi_pasdin, "Menengah")) {
            $templateProcessor = new TemplateProcessor(storage_path("/template/DokumenNota1/Persetujuan/Nota Persetujuan Proyek Menengah.docx"));
        } elseif (str_contains($proyek->klasifikasi_pasdin, "Besar")) {
            $templateProcessor = new TemplateProcessor(storage_path("/template/DokumenNota1/Persetujuan/Nota Persetujuan Proyek Besar.docx"));
        } else {
            $templateProcessor = new TemplateProcessor(storage_path("/template/DokumenNota1/Persetujuan/Nota Persetujuan Proyek Mega.docx"));
        }

        $internal_score = $hasil_assessment->sum(function ($ra) {
            if ($ra->kategori == "Internal") {
                return $ra->score;
            }
        });
        $eksternal_score = $hasil_assessment->sum(function ($ra) {
            if ($ra->kategori == "Eksternal") {
                return $ra->score;
            }
        });

        $variables = $templateProcessor->getVariables();
        // dd($variables);

        // Set Value Detail Proyek
        $templateProcessor->setValue('NamaProyek', htmlspecialchars($proyek->nama_proyek));
        $templateProcessor->setValue('LokasiProyek', Provinsi::find($proyek->provinsi)->province_name ?? "-");
        $templateProcessor->setValue('NamaPenggunaJasa', htmlspecialchars($proyek->proyekBerjalan->name_customer, ENT_QUOTES) ?? "-");
        $templateProcessor->setValue('InstansiPenggunaJasa', $proyek->proyekBerjalan->Customer->jenis_instansi ?? "-");
        $templateProcessor->setValue('SumberPendanaan', $proyek->sumber_dana ?? "-");
        $templateProcessor->setValue('PerkiraanNilai', number_format($proyek->nilaiok_awal, 0, ".", ".") ?? "-");
        $templateProcessor->setValue('KategoriProyek', $proyek->klasifikasi_pasdin ?? "-");
        $templateProcessor->setValue('AssessmentEksternal', $eksternal_score ?? "-");
        $templateProcessor->setValue('AssessmentInternal', $internal_score ?? "-");
        $templateProcessor->setValue('Catatan', str_replace("\r\n", '</w:t><w:br/><w:t>', htmlspecialchars($proyekRekomendasi->catatan_nota_rekomendasi, ENT_QUOTES)) ?? "-");

        //Set Value Tanda Tangan
        if (!empty($penyusun)) {
            foreach ($penyusun as $key => $p) {
                $qrNamePenyusun = date('dmYHis_') . "penyusun_" . User::find($p->user_id)->nip . "-" . $proyek->kode_proyek . ".png";
                $qrPath = storage_path("template/temp/" . $qrNamePenyusun);
                // $urlPenyusun = $request->schemeAndHttpHost() . "?nip=" . User::find($p->user_id)->nip . "&redirectTo=/rekomendasi/" . $proyek->kode_proyek . "/" . User::find($p->user_id)->nip . "/view-qr?kategori=penyusun";
                $urlPenyusun = $request->schemeAndHttpHost() . "/rekomendasi/" . $proyek->kode_proyek . "/" . User::find($p->user_id)->nip . "/view-qr?kategori=penyusun";
                $generateQRPenyusun = generateQrCode($qrNamePenyusun, $qrPath, $urlPenyusun);

                $templateProcessor->setImageValue("tandaTanganPenyusun$key", ["path" => $qrPath, "height" => 90, "ratio" => false]);
                $templateProcessor->setValue("namaTandaTanganPenyusun$key", User::find($p->user_id)?->name ?? "-");
                $templateProcessor->setValue("jabatanTandaTanganPenyusun$key", User::find($p->user_id)->Pegawai->Jabatan?->nama_jabatan ?? "-");
                $templateProcessor->setValue("tanggalTandaTanganPenyusun$key", Carbon\Carbon::parse($p->tanggal)->translatedFormat("d F Y") ?? "-");

                File::delete($qrPath);
            }
        }

        if (!empty($rekomendator)) {
            foreach ($rekomendator as $key => $p) {
                $qrNameRekomendasi = date('dmYHis_') . "rekomendasi_" . User::find($p->user_id)->nip . "-" . $proyek->kode_proyek . ".png";
                $qrPath = storage_path("template/temp/" . $qrNameRekomendasi);
                // $urlRekomendasi = $request->schemeAndHttpHost() . "?nip=" . User::find($p->user_id)->nip . "&redirectTo=/rekomendasi/" . $proyek->kode_proyek . "/" . User::find($p->user_id)->nip . "/view-qr?kategori=rekomendasi";
                $urlRekomendasi = $request->schemeAndHttpHost() . "/rekomendasi/" . $proyek->kode_proyek . "/" . User::find($p->user_id)->nip . "/view-qr?kategori=rekomendasi";
                $generateQRRekomendasi = generateQrCode($qrNameRekomendasi, $qrPath, $urlRekomendasi);

                $templateProcessor->setImageValue("tandaTanganRekomendasi$key", ["path" => $qrPath, "height" => 90, "ratio" => false]);
                $templateProcessor->setValue("namaTandaTanganRekomendasi$key", User::find($p->user_id)?->name ?? "-");
                $templateProcessor->setValue("jabatanTandaTanganRekomendasi$key", User::find($p->user_id)->Pegawai->Jabatan?->nama_jabatan ?? "-");
                $templateProcessor->setValue("tanggalTandaTanganRekomendasi$key", Carbon\Carbon::parse($p->tanggal)->translatedFormat("d F Y") ?? "-");

                $templateProcessor->setValue("catatanRekomendasi$key", !empty($p->catatan) ? htmlspecialchars($p->catatan, ENT_QUOTES) : "Tidak Ada");


                if ($p->status == "approved" && empty($p->catatan)) {
                    // $templateProcessor->setCheckbox("checkbox$key"."1", true);
                    $templateProcessor->setValue("checkbox$key" . "1", "☑");
                    $templateProcessor->setValue("checkbox$key" . "2", "□");
                    $templateProcessor->setValue("checkbox$key" . "3", "□");
                    // $templateProcessor->setValue("hasilRekomendasi$key", "Direkomendasikan");
                } elseif ($p->status == "approved" && !empty($p->catatan)) {
                    // $templateProcessor->setCheckbox("checkbox$key"."2", true);
                    $templateProcessor->setValue("checkbox$key" . "2", "☑");
                    $templateProcessor->setValue("checkbox$key" . "1", "□");
                    $templateProcessor->setValue("checkbox$key" . "3", "□");
                    // $templateProcessor->setValue("hasilRekomendasi$key", "Direkomendasikan dengan catatan");
                } else {
                    // $templateProcessor->setCheckbox("checkbox$key"."3", true);
                    $templateProcessor->setValue("checkbox$key" . "3", "☑");
                    $templateProcessor->setValue("checkbox$key" . "1", "□");
                    $templateProcessor->setValue("checkbox$key" . "2", "□");
                    // $templateProcessor->setValue("hasilRekomendasi$key", "Tidak Direkomendasikan");
                }

                File::delete($qrPath);
            }
        }

        if (!empty($penyetuju)) {
            foreach ($penyetuju as $key => $p) {
                $qrNamePersetujuan = date('dmYHis_') . "persetujuan_" . User::find($p->user_id)->nip . "-" . $proyek->kode_proyek . ".png";
                $qrPath = storage_path("template/temp/" . $qrNamePersetujuan);
                // $urlPersetujuan = $request->schemeAndHttpHost() . "?nip=" . User::find($p->user_id)->nip . "&redirectTo=/rekomendasi/" . $proyek->kode_proyek . "/" . User::find($p->user_id)->nip . "/view-qr?kategori=persetujuan";
                $urlPersetujuan = $request->schemeAndHttpHost() . "/rekomendasi/" . $proyek->kode_proyek . "/" . User::find($p->user_id)->nip . "/view-qr?kategori=persetujuan";
                $generateQRPersetujuan = generateQrCode($qrNamePersetujuan, $qrPath, $urlPersetujuan);

                $templateProcessor->setImageValue("tandaTanganSetuju$key", ["path" => $qrPath, "height" => 90, "ratio" => false]);
                $templateProcessor->setValue("namaTandaTanganSetuju$key", User::find($p->user_id)?->name ?? "-");
                $templateProcessor->setValue("jabatanTandaTanganSetuju$key", User::find($p->user_id)->Pegawai->Jabatan?->nama_jabatan ?? "-");
                $templateProcessor->setValue("tanggalTandaTanganSetuju$key", Carbon\Carbon::parse($p->tanggal)->translatedFormat("d F Y") ?? "-");

                $templateProcessor->setValue("catatanSetuju$key", !empty($p->catatan) ? htmlspecialchars($p->catatan, ENT_QUOTES) : "Tidak Ada");

                if ($p->status == "approved") {
                    $templateProcessor->setValue("checkboxSetuju$key" . "1", "☑");
                    $templateProcessor->setValue("checkboxSetuju$key" . "2", "□");
                } else {
                    $templateProcessor->setValue("checkboxSetuju$key" . "2", "☑");
                    $templateProcessor->setValue("checkboxSetuju$key" . "1", "□");
                }

                File::delete($qrPath);
            }
        }

        $templateProcessor->saveAs(storage_path('template/temp/' . $file_name . '.docx'));
        // dd("Finish");

        $templatePhpWord = \PhpOffice\PhpWord\IOFactory::load(storage_path('template/temp/' . $file_name . '.docx'));
        $rendererName = \PhpOffice\PhpWord\Settings::PDF_RENDERER_DOMPDF;
        // $rendererName = \PhpOffice\PhpWord\Settings::PDF_RENDERER_TCPDF;
        $rendererLibraryPath = realpath('../vendor/dompdf/dompdf');
        // $rendererLibraryPath = realpath('../vendor/tecnickcom/tcpdf');
        \PhpOffice\PhpWord\Settings::setPdfRenderer($rendererName, $rendererLibraryPath);
        $xmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($templatePhpWord, 'PDF');
        // $xmlWriter->save(storage_path('template/temp/' . $file_name . '.pdf'));
        $xmlWriter->save(public_path($target_path . "/" . $file_name . ".pdf"));
        File::delete(storage_path('template/temp/' . $file_name . '.docx'));

        $proyekRekomendasi->file_persetujuan = $file_name . ".pdf";
        $proyekRekomendasi->save();
    } catch (\Exception $e) {
        throw $e;
    }
}

// function generateQrCode($kode_proyek, $nip, $url, $nota_rekomendasi, string $imageName = "", string $path = "")
// {
//     $now = Carbon\Carbon::now();
//     $imageName = $now->format("dmYHis") . "_$nip" . "_$kode_proyek" . ".png";
//     if ($nota_rekomendasi == 1) {
//         $qrcode = QrCode::format('png')->size(110)->merge('/public/media/logos/logo-wika.png')->errorCorrection('H')->generate($url, public_path('qr-code/' . $imageName));
//     } else {
//         $qrcode = QrCode::format('png')->size(110)->merge('/public/media/logos/logo-wika.png')->errorCorrection('H')->generate($url, public_path('file-nota-rekomendasi-2/qr-code/' . $imageName));
//     }

//     return $imageName;
// }

function generateQrCode(string $imageName, string $path, string $url)
{
    try {
        $qrcode = QrCode::format('png')->size(100)->merge('/public/media/logos/logo-wika.png')->errorCorrection('M')->generate($url, $path);
        return true;
    } catch (\Exception $e) {
        // throw new Exception("Error :" . $e->getMessage() ', Hubungi Admin!', 1, $e);
        throw $e;
    }
}


/**
 * Display Error Page
 * @param int $status_code
 * @param mixed $title
 * @param mixed $headline
 * @param string $sub_headline
 * 
 * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
 */
function errorPage($status_code = 404, $title, $headline, $sub_headline = "", $is_add_link = false, $action_form = "", $button_value = "", $user = null) {
    return view("errorPage/error", compact(["status_code", "title", "headline", "sub_headline", "is_add_link", "action_form", "button_value", "user"]));
}
?>