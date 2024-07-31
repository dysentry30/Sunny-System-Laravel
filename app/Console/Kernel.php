<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Artisan;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        $schedule->command('schedule:forecast')->monthlyOn(1, '1:00')->runInBackground()->onSuccess(function () {
            Artisan::call("schedule:contract");
        })->onFailure(function () {
            sendNotifEmail("fathur.rohman2353@gmail.com", "FAILED RUNNING JOB OTORISASI CONTRACT", "Otorisasi otomatis gagal dijalankan pada tanggal : " . date("d-M-Y") . " . Mohon periksa kembali", true, false);
        });

        $schedule->command('schedule:forecast-anak')->monthlyOn(3, '1:00')->onFailure(function () {
            sendNotifEmail("fathur.rohman2353@gmail.com", "FAILED RUNNING JOB OTORISASI FORECASTS", "Otorisasi otomatis gagal dijalankan pada tanggal : " . date("d-M-Y") . " . Mohon periksa kembali", true, false);
        });
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
