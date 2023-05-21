<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class LokasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('setting_lokasi')->insert([
            'lokasi' => '-6.94352,107.58045',
            'radius' => 50,
            'status' => 1
        ]);
    }
}
