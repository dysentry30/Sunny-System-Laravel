<?php

namespace App\Console\Commands;

use App\Models\IntegrationLog;
use Illuminate\Console\Command;
use App\Models\MasterSumberDaya;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class GetSumberDaya extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:sumber-daya';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get Data Sumber Daya From E - Catalogue';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        DB::beginTransaction();
        $newLog = new IntegrationLog();
        $newLog->category = 'GET SUMBER DAYA';
        $newLog->request_body = "";

        try {

            $getResponse = Http::get('https://e-catalogue.wika.co.id/index.php/api/resources_code');


            if ($getResponse->successful()) {
                $newLog->status_code = $getResponse->status();
                $newLog->status = 'success';
                $newLog->response_body = "Success";
                $newLog->error_message = null;
                $newLog->save();

                $data = $getResponse->collect();

                foreach ($data as $item) {
                    $sumberDaya = MasterSumberDaya::updateOrCreate(
                        [
                            'resources_code_id' => $item["resources_code_id"],
                            'code' => $item["code"]
                        ],
                        [
                            "parent_code" => $item["parent_code"],
                            "material_id" => $item["material_id"],
                            "material_class" => $item["material_class"],
                            "uoms_id" => $item["uoms_id"],
                            "name" => $item["name"],
                            "unspsc" => $item["unspsc"],
                            "unspsc_name" => $item["unspsc_name"],
                            "description" => $item["description"],
                            "status" => $item["status"],
                            "sts_matgis" => $item["sts_matgis"],
                            "sts_cm" => $item["sts_cm"],
                            "material_ap" => $item["material_ap"],
                            "level" => $item["level"],
                            "image" => $item["image"],
                            "approve_date" => $item["approve_date"],
                            "approve_by" => $item["approve_by"],
                            "created_by" => $item["created_by"],
                            "cinput_date" => $item["input_date"],
                            "keterangan" => $item["keterangan"],
                            "uoms_name" => $item["uoms_name"],
                            "jenis_material" => $item["jenis_material"],
                            "material_code" => $item["material_code"],
                            "material_name" => $item["material_name"],
                            "valuation_class_code" => $item["valuation_class_code"],
                            "valuation_class_name" => $item["valuation_class_name"],
                        ]
                    );
                }
            } else {
                $newLog->status_code = $getResponse->status();
                $newLog->status = 'failed';
                $newLog->response_body = "Failed";
                $newLog->save();
            }

            DB::commit();
            return Command::SUCCESS;
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error("ERROR GET SUMBER DAYA => " . $th->getMessage());
            return Command::FAILURE;
        }
    }
}
