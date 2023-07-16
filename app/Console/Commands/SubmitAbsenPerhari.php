<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use App\Models\Absensi;
use App\Models\SettingAbsen;
use App\Models\Izin;

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
        $users = DB::table('users')->where('role_id', 2)->get();
        foreach($users as $user){
            $absen = Absensi::where('user_id', $user->id)->first();
            $jadwal = SettingAbsen::where('hari', date('l'))->where('user_id', $user->id)->first();
            if(!$absen && $jadwal){
                $data = [
                    'status_absensi' => 0,
                    'user_id' => $user->id,
                    'tanggal_absensi' => date("Y-m-d"),
                ];          
            }else if(!$jadwal){
                $data = [
                    'status_absensi' => 6,
                    'user_id' => $user->id,
                    'tanggal_absensi' => date("Y-m-d"),
                ];
            }
            Absensi::create($data);
        }
    }
}
