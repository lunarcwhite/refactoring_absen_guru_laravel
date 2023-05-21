<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class KsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'username' => 'ks',
            'email' => 'ks@mail.com',
            'password' => bcrypt('gbghfd65#2w4512345sdghgh^$^'),
            'role_id' => 3
        ];
        DB::table('users')->insert($data);
    }
}
