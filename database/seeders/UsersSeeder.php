<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'username' => 'admin',
                'email' => 'admin@mail.com',
                'password' => bcrypt('gbghfd65#2w4512345sdghgh^$^'),
                'role_id' => 1
            ],
            [
                'username' => 'ks',
                'nama' => 'Agus Shalim S.T',
                'email' => 'ks@mail.com',
                'password' => bcrypt('gbghfd65#2w4512345sdghgh^$^'),
                'role_id' => 3
            ]
        ];
        DB::table('users')->insert($data);

    }
}
