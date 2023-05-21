<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

class DeletePendingPengajuan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:pending';

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
        $pendings = DB::table('izins')->where('status_approval', 2)->get();
        foreach ($pendings as $key => $pending) {
            DB::table('absensis')->insert([
                'created_at' => $pending->tanggal_untuk_pengajuan.' 06:00:00',
                'updated_at' => $pending->tanggal_untuk_pengajuan.' 06:00:00',
                'tgl_absensi' => $pending->tanggal_untuk_pengajuan,
                'user_id' => $pending->user_id,
                'status_absensi' => '0'
            ]);
            DB::table('izins')->where('id', $pending->id)->delete();
        }
    }
}
