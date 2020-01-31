<?php

use Illuminate\Database\Seeder;

class LocationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
		for($i=1; $i<=20; $i++):
            DB::table('locations')
                ->insert([ 
                    'user_id' => 1,                     
					'client_id' => $i,
					'title' => 'Location name '.$i,
                    'description' =>'jkbjkb kuguig',
                    //'address'
                    //'lat' => 51.483,
                    //'lng' => -0.132,
                    

                ]);
        endfor;
		
		
		
    }
}
