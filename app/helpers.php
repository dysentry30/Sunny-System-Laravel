<?php 

// if(!function_exists("url_encode")) {
// }

use App\Models\Provinsi;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpWord\PhpWord;
use RealRashid\SweetAlert\Facades\Alert;

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
            return ucwords(str_replace("-", " ", $field));
        })->values();
        $fields = $fields->join(", ", " dan ");
        return $fields;
    }
    return false;
}
?>