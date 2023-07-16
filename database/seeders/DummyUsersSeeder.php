<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Faker\Factory as faker;

class DummyUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        for ($i=0; $i < 24; $i++) { 
            $data = [
                'username' => 'user'.$i,
                'email' => 'user1'.$i.'@mail.com',
                'password' => bcrypt('gbghfd65#2w4512345sdghgh^$^'),
                'role_id' => 2,
                'nuptk' => rand(0000000000000000,9999999999999999),
                'nama' => $faker->name,
                'photo' => null,
                'no_hp' => rand(000000000000, 999999999999)
            ];
            User::create($data);
        }
    }
}
