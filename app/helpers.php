<?php 

// if(!function_exists("url_encode")) {
// }

use App\Models\IndustryOwner;
use App\Models\KriteriaAssessment;
use App\Models\Provinsi;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpWord\PhpWord;
use RealRashid\SweetAlert\Facades\Alert;

use function Aws\filter;

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

function checkGreenLine($proyek) {
    if($proyek instanceof App\Models\Proyek) {
        $customer = $proyek->proyekBerjalan->Customer ?? null;
        $results = collect();
        if(!empty($proyek->sumber_dana)) {
            $results->push(App\Models\KriteriaGreenLine::where("isi", "=", $proyek->sumber_dana)->where("item", "=", "Sumber Dana")->count() > 0);
        }
        if(!empty($customer->jenis_instansi)) {
            if((str_contains($customer->jenis_instansi, "BUMN") || str_contains($customer->jenis_instansi, "APBD") || str_contains($customer->jenis_instansi, "Provinsi"))) {
                if(!empty($customer->group_tier)) {
                    $results->push(App\Models\KriteriaGreenLine::where("item", "=", "Instansi")->where("isi", "=", $customer->jenis_instansi)->where("sub_isi", "=", $customer->group_tier)->count() > 0);
                } else {
                    $provinsi = Provinsi::find($customer->provinsi) ?? $customer->provinsi; 
                    $results->push(App\Models\KriteriaGreenLine::where("item", "=", "Instansi")->where("isi", "=", $customer->jenis_instansi)->where("sub_isi", "=", $provinsi)->count() > 0);
                }
            } else {
                $results->push(App\Models\KriteriaGreenLine::where("item", "=", "Instansi")->where("isi", "=", $customer->jenis_instansi)->count() > 0);
            }
        } else {
            $results->push(false);
        }
        return $results->count() > 1 && $results->every(function($item) {
            return $item === true;
        });
    }
    return false;
}

function validateInput($data, $rules) {
    $is_validated = Validator::make($data, $rules);
    $errors = $is_validated->errors();
    if($errors->isNotEmpty()) {
        $fields = collect($errors->toArray())->map(function($item, $field) {
            if(str_contains($field, "-")) {
                return ucwords(str_replace("-", " ", $field));
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
    $customer = $proyek->proyekBerjalan->Customer;
    $target_path = "file-rekomendasi";
    $now = Carbon\Carbon::now();
    $file_name = $now->format("dmYHis") . "_nota-rekomendasi_$proyek->kode_proyek.pdf";
    if($customer->proyekBerjalans->where("stage", "=", 8)->count() > 0) {
        $internal_score = $hasil_assessment->sum(function($ra) {
            if($ra["kategori"] == "Internal") {
                return $ra["score"];
            }
        });
        $eksternal_score = $hasil_assessment->sum(function($ra) {
            if($ra["kategori"] == "Eksternal") {
                return $ra["score"];
            }
        });
    } else {
    }
    $total_score = $hasil_assessment->sum(function($ra) {
        if($ra["kategori"] == "Eksternal") {
            return $ra["score"];
        }
    });
    $hasil_assessment = $hasil_assessment->where("kategori", "=", "Eksternal");
    $top_100 = $hasil_assessment->where("kriteria_penilaian", "=", "Top 100 Perusahan Besar di Indonesia")->first();
    $rating = $hasil_assessment->where("kriteria_penilaian", "=", "Lembaga Lain yang mengeluarkan rating perusahaan di Indonesia")->first();
    $industry_attractive = $hasil_assessment->where("kriteria_penilaian", "=", "Industry Attractive")->first();
    // dd($top_100, $rating, $industry_attractive);

    $section = $phpWord->addSection();
    $section_2 = $phpWord->addSection();
    $section->addText("Hasil Assessment", ['size'=>12, "bold" => true], ['align' => "center"]);
    $section->addText($proyek->nama_proyek, ['size'=>12, "bold" => true], ['align' => "center"]);

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
    $table->addRow(null, $cellCategoryStyle);
    $table->addCell(null, $cellCategoryStyle);
    $table->addCell(4000, $cellCategoryStyle)->addText("Eksternal");
    $table->addCell(null, $cellCategoryStyle);
    $table->addCell(null, $cellCategoryStyle);
    $table->addCell(null, $cellCategoryStyle);
    $table->addCell(null, $cellCategoryStyle);
    $table->addCell(null, $cellCategoryStyle);
    
    $table->addRow();
    $table->addCell(2000)->addText("1");
    $table->addCell(4000)->addText("Industry Attractive
    (Industry Rating untuk melihat industri yang menjadi sasaran)");
    $table->addCell(2000)->addText("Industri Menarik dan Cenderung Menarik");
    $table->addCell(2000)->addText("Industri Netral dan Cenderung Waspada");
    $table->addCell(2000)->addText("Industri Waspada");
    $table->addCell(2000)->addText($industry_attractive["score"]);
    $table->addCell(2000)->addText("-");
    
    $table->addRow();
    $table->addCell(2000)->addText("2");
    $table->addCell(4000)->addText("Top 100  Perusahaan terbesar di Indonesia
    (dikeluarkan oleh lembaga terpercaya)");
    $table->addCell(2000)->addText("Perusahaan berada pada urutan 1 - 50");
    $table->addCell(2000)->addText("Perusahaan berada pada urutan 51 - 100");
    $table->addCell(2000)->addText("Perusahaan tidak berada pada daftar Top Perusahaan");
    $table->addCell(2000)->addText($top_100["score"]);
    $table->addCell(2000)->addText("-");
    
    $table->addRow();
    $table->addCell(2000)->addText("3");
    $table->addCell(4000)->addText("Lembaga lain yang mengeluarkan rating perusahaan di indonesia
    (misal: LQ45)");
    $table->addCell(2000)->addText("Perusahaan berada pada urutan 1 - 20");
    $table->addCell(2000)->addText("Perusahaan berada pada urutan 21 - 45");
    $table->addCell(2000)->addText("Perusahaan tidak berada pada daftar rating Perusahaan");
    $table->addCell(2000)->addText($rating["score"]);
    $table->addCell(2000)->addText("-");

    $table->addRow();
    $table->addCell(null, $cellCategoryStyle);
    $table->addCell(4000, $cellCategoryStyle)->addText("Total");
    $table->addCell(null, $cellCategoryStyle);
    $table->addCell(null, $cellCategoryStyle);
    $table->addCell(null, $cellCategoryStyle);
    $table->addCell(2000, $cellCategoryStyle)->addText($total_score);
    $table->addCell(2000, $cellCategoryStyle)->addText("A");

    $section->addTextBreak(1);

    // End :: Body
    $section->addText("Rumusan Tier dari Kolom Nilai dengan ketentuan:", ['size'=>10, "bold" => true], ['align' => "left"]);
    $section->addText("A: X > 22.5", ['size'=>10, "bold" => true], ['align' => "left"]);
    $section->addText(htmlspecialchars("B: 15 =< X =< 22.5"), ['size'=>10, "bold" => true], ['align' => "left"]);
    $section->addText(htmlspecialchars("C: 0 =< X =< 15"), ['size'=>10, "bold" => true], ['align' => "left"]);
    // Begin :: Footer
    
    // End :: Footer

    // ('Klasifikasi A',$TfontStyle);
    // $table->addCell(500,$styleCell)->addText('1', $fontStyle);
    // $table->addCell(2500,$styleCell)->addText("Nama Proyek", $fontStyle);
    // $table->addCell(6000,$styleCell)->addText($proyek->nama_proyek, $fontStyle);
    // $table->addRow();
    // $table->addCell(500,$styleCell)->addText('2', $fontStyle);
    // $table->addCell(2500,$styleCell)->addText("Lokasi Proyek", $fontStyle);
    // $table->addCell(6000,$styleCell)->addText(Provinsi::find($proyek->nama_proyek)->province_name ?? "-", $fontStyle);
    // $table->addRow();
    // $table->addCell(500,$styleCell)->addText('3', $fontStyle);
    // $table->addCell(2500,$styleCell)->addText("Nama Pemberi kerja", $fontStyle);
    // $table->addCell(6000,$styleCell)->addText($proyek->proyekBerjalan->name_customer, $fontStyle);
    // $table->addRow();
    // $table->addCell(500,$styleCell)->addText('4', $fontStyle);
    // $table->addCell(2500,$styleCell)->addText("Instansi Pemberi Kerja", $fontStyle);
    // $table->addCell(6000,$styleCell)->addText($proyek->proyekBerjalan->Customer->jenis_instansi, $fontStyle);
    // $table->addRow();
    // $table->addCell(500,$styleCell)->addText('5', $fontStyle);
    // $table->addCell(2500,$styleCell)->addText("Sumber Pendanaan Proyek", $fontStyle);
    // $table->addCell(6000,$styleCell)->addText($proyek->sumber_dana, $fontStyle);
    // $table->addRow();
    // $table->addCell(500,$styleCell)->addText('6', $fontStyle);
    // $table->addCell(2500,$styleCell)->addText("Nilai Proyek", $fontStyle);
    // $table->addCell(6000,$styleCell)->addText(number_format($proyek->nilaiok_awal, 0, ".", "."), $fontStyle);
    // $table->addRow();
    // $table->addCell(500,$styleCell)->addText('7', $fontStyle);
    // $table->addCell(2500,$styleCell)->addText("Kategori Proyek", $fontStyle);
    // $table->addCell(6000,$styleCell)->addText($proyek->klasifikasi_pasdin ?? "-", $fontStyle);
    // $table->addRow();
    // $table->addCell(500,$styleCell)->addText('8', $fontStyle);
    // $table->addCell(2500,$styleCell)->addText("Assessment Eksternal Atas Pengguna Jasa", $fontStyle);
    // $table->addCell(6000,$styleCell)->addText($eksternal_score ?? "-", $fontStyle);
    // $table->addRow();
    // $table->addCell(500,$styleCell)->addText('9', $fontStyle);
    // $table->addCell(2500,$styleCell)->addText("Assessment Internal Atas Pengguna Jasa ", $fontStyle);
    // $table->addCell(6000,$styleCell)->addText($internal_score ?? "-", $fontStyle);
    // $table->addRow();
    // $table->addCell(500,$styleCell)->addText('10', $fontStyle);
    // $table->addCell(2500,$styleCell)->addText("Catatan", $fontStyle);
    // $table->addCell(6000,$styleCell)->addText($proyek->recommended_with_note ?? "-", $fontStyle);

    // $section->addText("Berdasarkan informasi di atas, mengajukan untuk mengikuti aktifitas Perolehan Kontrak (tender) tersebut di atas.");

    $section->addTextBreak(20);

    // $table_ttd = $section->addTable('ttd_table',array('borderSize' => 1, 'borderColor' => '999999', 'afterSpacing' => 0, 'Spacing'=> 0, 'cellMargin'=>0  ));
    // $table_ttd->addRow();
    // if($is_proyek_mega) {
    //     $cell_1_ttd = $table_ttd->addCell(700);
    //     // $textbox_ttd_2 = $section_2->addTextBox(["align" => "left", "borderColor" => "white", "height" => 200, "width" => 300]);
    //     $cell_1_ttd->addText("..........,..................... " . $now->translatedFormat("Y"), ["bold" => true], ["align" => "center"]);
    //     $cell_1_ttd->addText("Yang Mengusulkan", ["bold" => true], ["align" => "center"]);
    //     $cell_1_ttd->addTextBreak(4);
    //     $cell_1_ttd->addText("(.......................................................)", ["bold" => true], ["align" => "center"]);
    //     $cell_1_ttd->addText("GM Manrisk Operasi", ["bold" => true], ["align" => "center"]);
        
    //     $cell_2_ttd = $table_ttd->addCell(500);
    //     // $textbox_ttd = $section_2->addTextBox(["align" => "right", "borderColor" => "white", "height" => 200, "width" => 200]);
    //     $cell_2_ttd->addText("..........,..................... " . $now->translatedFormat("Y"), ["bold" => true], ["align" => "center"]);
    //     $cell_2_ttd->addText("Yang Mengusulkan", ["bold" => true], ["align" => "center"]);
    //     $cell_2_ttd->addTextBreak(4);
    //     $cell_2_ttd->addText("(.......................................................)", ["bold" => true], ["align" => "center"]);
    //     $cell_2_ttd->addText("GM Pemasaran Operasi", ["bold" => true], ["align" => "center"]);
    // } else {
    //     $cell_2_ttd = $table_ttd->addCell(500);
    //     // $cell_2_ttd->addText($now->translatedFormat("l, d F Y"), ["bold" => true], ["align" => "center"]);
    //     $cell_2_ttd->addText("..........,..................... " . $now->translatedFormat("Y"), ["bold" => true], ["align" => "center"]);
    //     $cell_2_ttd->addText("Yang Mengusulkan", ["bold" => true], ["align" => "center"]);
    //     $cell_2_ttd->addTextBreak(4);
    //     $cell_2_ttd->addText("(.......................................................)", ["bold" => true], ["align" => "center"]);
    //     $cell_2_ttd->addText("GM Pemasaran Operasi", ["bold" => true], ["align" => "center"]);
    // }

    // \PhpOffice\PhpWord\Settings::setPdfRendererPath("path/to/tcpdf");
    // \PhpOffice\PhpWord\Settings::setPdfRendererName('TCPDF');
    $properties = $phpWord->getDocInfo();
    $properties->setTitle($file_name);
    $properties->setDescription('Nota Rekomendasi');

    $rendererName = \PhpOffice\PhpWord\Settings::PDF_RENDERER_DOMPDF;
    $rendererLibraryPath = realpath('../vendor/dompdf/dompdf');
    \PhpOffice\PhpWord\Settings::setPdfRenderer($rendererName, $rendererLibraryPath);

    $xmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'PDF');
    $is_saved = $xmlWriter->save(public_path($target_path. "/". $file_name));
    // dd("saved");
    $proyek->file_rekomendasi = $file_name;
    $proyek->save();
    // $is_saved = $phpWord->save(public_path($target_path. "\\". $file_name));
}

function createWordPersetujuan(App\Models\Proyek $proyek, \Illuminate\Support\Collection $hasil_assessment = new \Illuminate\Support\Collection(), $is_proyek_mega) {
    $phpWord = new \PhpOffice\PhpWord\PhpWord();
    $target_path = "file-persetujuan";
    $now = Carbon\Carbon::now();
    $file_name = $now->format("dmYHis") . "_nota-persetujuan_$proyek->kode_proyek.pdf";
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

    $section = $phpWord->addSection();
    $section_2 = $phpWord->addSection();
    $section->addText("Form Pengajuan Rekomendasi", ['size'=>12, "bold" => true]);
    $section->addTextBreak(1);
    $section->addText("Pengajuan Rekomendasi Proses Tender", ['size'=>12, "bold" => true], ['align' => "center"]);

    if($is_proyek_mega) {
        $section->addText("Proyek Mega", ['size'=>12, "bold" => true], ['align' => "center"]);
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
    $table->addRow();
    $table->addCell(500,$styleCell)->addText('1', $fontStyle);
    $table->addCell(2500,$styleCell)->addText("Nama Proyek", $fontStyle);
    $table->addCell(6000,$styleCell)->addText($proyek->nama_proyek, $fontStyle);
    $table->addRow();
    $table->addCell(500,$styleCell)->addText('2', $fontStyle);
    $table->addCell(2500,$styleCell)->addText("Lokasi Proyek", $fontStyle);
    $table->addCell(6000,$styleCell)->addText(Provinsi::find($proyek->nama_proyek)->province_name ?? "-", $fontStyle);
    $table->addRow();
    $table->addCell(500,$styleCell)->addText('3', $fontStyle);
    $table->addCell(2500,$styleCell)->addText("Nama Pemberi kerja", $fontStyle);
    $table->addCell(6000,$styleCell)->addText($proyek->proyekBerjalan->name_customer, $fontStyle);
    $table->addRow();
    $table->addCell(500,$styleCell)->addText('4', $fontStyle);
    $table->addCell(2500,$styleCell)->addText("Instansi Pemberi Kerja", $fontStyle);
    $table->addCell(6000,$styleCell)->addText($proyek->proyekBerjalan->Customer->jenis_instansi, $fontStyle);
    $table->addRow();
    $table->addCell(500,$styleCell)->addText('5', $fontStyle);
    $table->addCell(2500,$styleCell)->addText("Sumber Pendanaan Proyek", $fontStyle);
    $table->addCell(6000,$styleCell)->addText($proyek->sumber_dana, $fontStyle);
    $table->addRow();
    $table->addCell(500,$styleCell)->addText('6', $fontStyle);
    $table->addCell(2500,$styleCell)->addText("Nilai Proyek", $fontStyle);
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
    $table->addCell(6000,$styleCell)->addText($proyek->recommended_with_note ?? "-", $fontStyle);

    $section->addText("Berdasarkan informasi di atas, mengajukan untuk mengikuti aktifitas Perolehan Kontrak (tender) tersebut di atas.");

    $section->addTextBreak(20);

    $table_ttd = $section->addTable('ttd_table',array('borderSize' => 1, 'borderColor' => '999999', 'afterSpacing' => 0, 'Spacing'=> 0, 'cellMargin'=>0  ));
    $table_ttd->addRow();
    if($is_proyek_mega) {
        $cell_1_ttd = $table_ttd->addCell(700);
        // $textbox_ttd_2 = $section_2->addTextBox(["align" => "left", "borderColor" => "white", "height" => 200, "width" => 300]);
        $cell_1_ttd->addText("..........,..................... " . $now->translatedFormat("Y"), ["bold" => true], ["align" => "center"]);
        $cell_1_ttd->addText("Yang Mengusulkan", ["bold" => true], ["align" => "center"]);
        $cell_1_ttd->addTextBreak(4);
        $cell_1_ttd->addText("(.......................................................)", ["bold" => true], ["align" => "center"]);
        $cell_1_ttd->addText("GM Manrisk Operasi", ["bold" => true], ["align" => "center"]);
        
        $cell_2_ttd = $table_ttd->addCell(500);
        // $textbox_ttd = $section_2->addTextBox(["align" => "right", "borderColor" => "white", "height" => 200, "width" => 200]);
        $cell_2_ttd->addText("..........,..................... " . $now->translatedFormat("Y"), ["bold" => true], ["align" => "center"]);
        $cell_2_ttd->addText("Yang Mengusulkan", ["bold" => true], ["align" => "center"]);
        $cell_2_ttd->addTextBreak(4);
        $cell_2_ttd->addText("(.......................................................)", ["bold" => true], ["align" => "center"]);
        $cell_2_ttd->addText("GM Pemasaran Operasi", ["bold" => true], ["align" => "center"]);
    } else {
        $cell_2_ttd = $table_ttd->addCell(500);
        // $cell_2_ttd->addText($now->translatedFormat("l, d F Y"), ["bold" => true], ["align" => "center"]);
        $cell_2_ttd->addText("..........,..................... " . $now->translatedFormat("Y"), ["bold" => true], ["align" => "center"]);
        $cell_2_ttd->addText("Yang Mengusulkan", ["bold" => true], ["align" => "center"]);
        $cell_2_ttd->addTextBreak(4);
        $cell_2_ttd->addText("(.......................................................)", ["bold" => true], ["align" => "center"]);
        $cell_2_ttd->addText("GM Pemasaran Operasi", ["bold" => true], ["align" => "center"]);
    }

    // \PhpOffice\PhpWord\Settings::setPdfRendererPath("path/to/tcpdf");
    // \PhpOffice\PhpWord\Settings::setPdfRendererName('TCPDF');
    $properties = $phpWord->getDocInfo();
    $properties->setTitle($file_name);
    $properties->setDescription('Nota Rekomendasi');

    $rendererName = \PhpOffice\PhpWord\Settings::PDF_RENDERER_DOMPDF;
    $rendererLibraryPath = realpath('../vendor/dompdf/dompdf');
    \PhpOffice\PhpWord\Settings::setPdfRenderer($rendererName, $rendererLibraryPath);

    $xmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'PDF');

    $is_saved = $xmlWriter->save(public_path($target_path. "/". $file_name));
    $proyek->file_rekomendasi = $file_name;
    $proyek->save();
    // $is_saved = $phpWord->save(public_path($target_path. "\\". $file_name));
}

function performAssessment(App\Models\Customer $customer, App\Models\Proyek $proyek) {
    $kriteria_assessments = KriteriaAssessment::all();
    $result_assessments = collect();
    $bowheer = collect();
    $kriteria_assessments->groupBy("kriteria_penilaian")->each(function($ka, $kriteria) use($customer, $result_assessments, $bowheer) {
        if($customer->proyekBerjalans->where("stage", "=", 8)->count() > 0) {
            foreach($ka as $k) {
                if($kriteria == "Piutang") {
                    // dd($customer->Piutang);
                    $is_assessment_piutang_exist = $result_assessments->where("kriteria_penilaian", "=", $kriteria)->count() > 0;
                    // dump($is_assessment_piutang_exist);
                    if(!$is_assessment_piutang_exist) {
                        if($customer->Piutang->count() > 0) {
                            $is_piutang_91_day_exist = $customer->Piutang->where("day_91", ">", 0)->count() > 0;
                            if($is_piutang_91_day_exist) {
                                $result = collect(["kategori" => "Internal", "kriteria_penilaian" => $kriteria, "score" => (float) 5]);
                                $result_assessments->push($result);
                            } else {
                                $result = collect(["kategori" => "Internal", "kriteria_penilaian" => $kriteria, "score" => (float) 7.5]);
                                $result_assessments->push($result);
                            }
                        } else {
                            $result = collect(["kategori" => "Internal", "kriteria_penilaian" => $kriteria, "score" => (float) 10]);
                            $result_assessments->push($result);
                        }
                    }
                } else if($kriteria == "Bowheer Bermasalah") {
                    if($customer->MasalahHukum->isNotEmpty()) {
                        $highest_score = $customer->MasalahHukum->map(function($mh) use($k, $bowheer) {
                            $new_class = new stdClass();
                            $new_class->isi = $mh->status;
                            if(str_contains($k->isi, $mh->status)) {
                                $new_class->score = (float) $k->nilai;
                            } else {
                                $new_class->score = 0.0;
                            }
                            return $new_class;
                        });
                        $bowheer->push($highest_score);
                    }
                } else if($kriteria == "Key Client") {
                    if($customer->key_client) {
                        $result = collect(["kategori" => "Internal", "kriteria_penilaian" => $kriteria, "score" => (float) $k->nilai]);
                        $result_assessments->push($result);
                    }
                } else if($kriteria == "Top 100 Perusahan Besar di Indonesia") {
                    $forbes_rank = preg_replace("/[^(0-9{2}|\-|0-9{2})]/i", "",  $customer->forbes_rank);
                    if(str_contains($k->isi, $forbes_rank) && $customer->forbes_rank != "Diluar Top 100") {
                        $result = collect(["kategori" => "Eksternal", "kriteria_penilaian" => $kriteria, "score" => (float) $k->nilai]);
                        $result_assessments->push($result);
                    } else if($customer->forbes_rank == "Diluar Top 100" && $k->isi == "Perusahaan tidak berada pada daftar Top Perusahaan") {
                        $result = collect(["kategori" => "Eksternal", "kriteria_penilaian" => $kriteria, "score" => (float) $k->nilai]);
                        $result_assessments->push($result);
                    }
                } else if($kriteria == "Lembaga Lain yang mengeluarkan rating perusahaan di Indonesia") {
                    $lq_rank = preg_replace("/[^(0-9{2}|\-|0-9{2})]/i", "", $customer->lq_rank);
                    // dump($lq_rank, $k->isi);
                    if(str_contains($k->isi, $lq_rank) && $customer->lq_rank != "Diluar Top 45") {
                        $result = collect(["kategori" => "Eksternal", "kriteria_penilaian" => $kriteria, "score" => (float) $k->nilai]);
                        $result_assessments->push($result);
                    } else if($customer->lq_rank == "Diluar Top 45" && $k->isi == "Perusahaan tidak berada pada daftar Rating Perusahaan") {
                        $result = collect(["kategori" => "Eksternal", "kriteria_penilaian" => $kriteria, "score" => (float) $k->nilai]);
                        $result_assessments->push($result);
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
                    $forbes_rank = preg_replace("/[^(0-9{2}|\-|0-9{2})]/i", "",  $customer->forbes_rank);
                    if(str_contains($k->isi, $forbes_rank) && $customer->forbes_rank != "Diluar Top 100") {
                        $result = collect(["kategori" => "Eksternal", "kriteria_penilaian" => $kriteria, "score" => (float) $k->nilai]);
                        $result_assessments->push($result);
                    } else if($customer->forbes_rank == "Diluar Top 100" && $k->isi == "Perusahaan tidak berada pada daftar Top Perusahaan") {
                        $result = collect(["kategori" => "Eksternal", "kriteria_penilaian" => $kriteria, "score" => (float) $k->nilai]);
                        $result_assessments->push($result);
                    }
                } else if($kriteria == "Lembaga Lain yang mengeluarkan rating perusahaan di Indonesia") {
                    $lq_rank = preg_replace("/[^(0-9{2}|\-|0-9{2})]/i", "", $customer->lq_rank);
                    // dump($lq_rank, $k->isi);
                    if(str_contains($k->isi, $lq_rank) && $customer->lq_rank != "Diluar Top 45") {
                        $result = collect(["kategori" => "Eksternal", "kriteria_penilaian" => $kriteria, "score" => (float) $k->nilai]);
                        $result_assessments->push($result);
                    } else if($customer->lq_rank == "Diluar Top 45" && $k->isi == "Perusahaan tidak berada pada daftar Rating Perusahaan") {
                        $result = collect(["kategori" => "Eksternal", "kriteria_penilaian" => $kriteria, "score" => (float) $k->nilai]);
                        $result_assessments->push($result);
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
    $proyek->hasil_assessment = $result_assessments->toJson();
    $proyek->save();
    return $result_assessments;
}
?>