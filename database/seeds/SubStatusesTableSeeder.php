<?php

use Illuminate\Database\Seeder;

class SubStatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //DB::table('sub_statuses')->insert(['status_id' => 1,'title' => 'New Substatus','description' => '']);
        //DB::table('sub_statuses')->insert(['status_id' => 2,'title' => 'Done Substatus','description' => '']);
        DB::table('sub_statuses')->insert(['status_id' => 3,'title' => 'Not Done Substatus 1','description' => '','colour' => '#fcba03']);
        DB::table('sub_statuses')->insert(['status_id' => 3,'title' => 'Not Done Substatus 2','description' => '','colour' => '#adfc03']);
        DB::table('sub_statuses')->insert(['status_id' => 3,'title' => 'Not Done Substatus 3','description' => '','colour' => '#03fcbe']);
    }
}
