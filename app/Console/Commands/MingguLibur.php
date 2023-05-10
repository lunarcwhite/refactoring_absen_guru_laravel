<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Carbon\Carbon;

class MingguLibur extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'minggu:libur';

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
        // Setiap Minggu Absen Diisi Dengan Status 5 == LIBUR
        $users = DB::table('users')->where('role_id', 2)->get();
        foreach($users as $user){
            $data = [
                'status_absensi' => 5,
                'user_id' => $user->id,
                'tgl_absensi' => date("Y-m-d"),
                'created_at' => Carbon::now()
            ];
            DB::table('absensis')->insert($data);
        }
    }
}
