<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SubmitAbsenPerhari extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'submit:absen';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $absen = Absen::where('tgl_absensi')->where('user_id')->first();
    }
}
