<?php

namespace App\Console\Commands;

use App\Jobs\GetSKASKT;
use Illuminate\Console\Command;

class RunningJobGetSKASKT extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:getSKASKT';

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
        GetSKASKT::dispatch();
        return Command::SUCCESS;
    }
}
