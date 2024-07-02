<?php

namespace App\Console\Commands;

use App\Jobs\GetDataPegawai;
use Illuminate\Console\Command;

class RunningJobGetPegawai extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:getPegawai';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetching Data Pegawai';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        GetDataPegawai::dispatch();
        return Command::SUCCESS;
    }
}
