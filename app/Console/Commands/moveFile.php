<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class moveFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'move:files';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Get all records from dokumen_pendukungs table
        $documents = DB::table('dokumen_pendukungs')->get();

        foreach ($documents as $document) {
            $idDocument = $document->id_document;
            $sourcePath = public_path('words/' . $idDocument);

            // Check if the file exists
            if (!File::exists($sourcePath)) {
                // Handle case with dot before .pdf
                $deleteExtension = substr($idDocument, 0, -4);
                if (str_contains($deleteExtension, '.')) {
                    $explodeName = explode(".", $deleteExtension);
                    $idDocumentNew = $explodeName[0] . ".pdf";
                    $sourcePath = public_path('words/' . $idDocumentNew);
                }
            }

            if (File::exists($sourcePath)) {
                $destinationPath = public_path('contract-managements/dokumen-pendukung-change/' . $idDocument);

                // Move the file
                File::move($sourcePath, $destinationPath);

                $this->info("Moved: $sourcePath to $destinationPath");
            } else {
                $this->error("File not found: $idDocument or with variant");
            }
        }
        return Command::SUCCESS;
    }
}
