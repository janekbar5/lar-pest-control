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
        DB::table('statuses')->insert(['title' => 'New','colour' => '#98fc03']); // yellow
        DB::table('statuses')->insert(['title' => 'Done','colour' => '#02bd3d']); // green
        DB::table('statuses')->insert(['title' => 'Not Done','colour' => '#ff2605']); // red
    }
}
