<?php

use Illuminate\Database\Seeder;

class StatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('statuses')->insert(['title' => 'New','description' => '','colour' => '#c9b606']); // yellow
        DB::table('statuses')->insert(['title' => 'Done','description' => '','colour' => '#0c6924']); // green
        DB::table('statuses')->insert(['title' => 'Not Done','description' => '','colour' => '#9c0505']); // red
    }
}
