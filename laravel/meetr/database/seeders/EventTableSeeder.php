<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('events')->insert([
            'title' => 'test event',
            'description' => 'test description',
            'category' => 'food',
            'datetime_starts' => now(),
            'datetime_ends' => now(),
            'payer' => 'host',
            'romantic_intentions' => true,
            'location' => '123 abc street',
            'expected_guest_cost' => 0.0,
            'expected_total_cost' => 10.0,
            'host_id' => 1,
            'guest_id' => null
        ]);
    }
}
