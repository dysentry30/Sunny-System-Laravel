<?php

namespace App\Imports;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\HeadingRowImport;
use App\Models\AnalisaHargaSatuanDetail;
use App\Models\MasterAnalisaHargaSatuan;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use PhpOffice\PhpSpreadsheet\Calculation\Calculation;

HeadingRowFormatter::default('none');

class AhsImport implements ToModel, WithHeadingRow
{

    public $request;
    public $count;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return self::generateInsertData($row);
    }

    public function generateInsertData($row)
    {
        $headings = (new HeadingRowImport)->toArray($this->request->file("file"));

        // Indeks yang ingin diabaikan
        $ignoredIndices = [0, 1, 2, 3];

        // Dapatkan indeks terakhir
        $lastIndex = array_key_last($headings[0][0]);
        $ignoredIndices[] = $lastIndex; // Tambahkan indeks terakhir ke dalam array yang diabaikan

        // Hapus elemen berdasarkan indeks yang diabaikan
        $headerANDynamic = collect(array_diff_key($headings[0][0], array_flip($ignoredIndices)));

        $countANDynamic = $headerANDynamic->filter(function ($item) {
            $newKey = explode('_', $item);
            if (str_contains("NILAI", $newKey[1])) {
                return $newKey[0];
            }
        })->values();

        if (empty($row['KODE SUMBER DAYA'])) {
            return new MasterAnalisaHargaSatuan([
                'kode_ahs' => $row['KODE AHS'],
                'uraian' => $row['URAIAN PEKERJAAN'],
                'satuan' => $row['SATUAN'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        } else {

            $formula = "";
            $koef = null;
            $dataFormula = collect([]);

            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $calculation = Calculation::getInstance($spreadsheet);

            if (!empty($row["KOEF"])) {
                $formula = str_replace(['Table1[[#This Row],[', '_NILAI', ']]'], '', $row["KOEF"]);
            }

            $countANDynamic->each(function ($value) use ($row, $dataFormula, $formula, $sheet, &$koef) {
                $newKey = explode('_', $value);

                $nilai = $newKey[0] . '_NILAI';
                $satuan = $newKey[0] . '_SATUAN';
                $deskripsi = $newKey[0] . '_DESKRIPSI';


                if (!empty($row[$value])) {
                    $dataFormula->push([
                        'parameter' => $newKey[0],
                        'deskripsi' => $row[$deskripsi],
                        'nilai' => (float)$row[$nilai],
                        'satuan' => $row[$satuan],
                        'formula' => $formula
                    ]);

                    if (strlen($formula) <= 6) {
                        $koef = (float)$row[$nilai];
                    } else {
                        $sheet->setCellValue($newKey[0], (float)$row[$nilai]);
                    }
                }
            });

            if (!empty($row["KOEF"]) && empty($koef)) {
                $koef = $calculation->calculateFormula($formula, null, null);
            }

            return new AnalisaHargaSatuanDetail([
                'kode_ahs' => $row['KODE AHS'],
                'resource_code' => $row['KODE SUMBER DAYA'],
                'formula' => $dataFormula->toJson(),
                'koef' => $koef,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
