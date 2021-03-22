<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'first_name' => 'test',
            'last_name' => 'test',
            'email_address' => 'test@test.com',
            'email_verified_at' => date('Y-m-d H:i:s'),
            'number_of_ghosts' => 0,
            'phone_number' => '6041234567',
            'phone_verified_at' => date('Y-m-d H:i:s'),
            'username' => 'test',
            'password' => Hash::make('test'),
            'sexuality' => 'straight',
            'looking_for' => 'anything',
            'likes' => 'everything',
            'about_me' => 'average',
            'birthdate' => date('Y-m-d'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }
}
