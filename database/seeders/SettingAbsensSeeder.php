<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class SettingAbsensSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = DB::table('users')->where('role_id', 2)->get();
        $hari = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        foreach ($users as $key => $user) {
            for ($i=1; $i <= 6; $i++) { 
                DB::table('setting_absens')->insert([
                    'status' => 1,
                    'hari' => $hari[$i],
                    'jam' => '07:00:00',
                    'user_id' => $user->id
                ]);
            }
        }
    }
}
