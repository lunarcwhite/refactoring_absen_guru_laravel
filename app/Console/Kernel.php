<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected $commands = [
        Commands\MingguLibur::class,
        Commands\DeletePendingPengajuan::class,
        Commands\SubmitAbsenPerhari::class,
    ];
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->everyMinute();
        $schedule->command('minggu:libur')->sundays('00:01');
        $schedule->command('delete:pending')->monthly();
        $schedule->command('submit:absen')->days([1,2,3,4,5])->runInBackground()->at('21:00');
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
