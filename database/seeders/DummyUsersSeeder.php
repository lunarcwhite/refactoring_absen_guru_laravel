<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class DummyUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i=0; $i < 20; $i++) { 
            $data = [
                'username' => 'user'.$i,
                'email' => 'user'.$i.'@mail.com',
                'password' => bcrypt('gbghfd65#2w4512345sdghgh^$^'),
                'role_id' => 2
            ];
            User::create($data);
        }
    }
}
