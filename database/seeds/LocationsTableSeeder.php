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
		
		for($i=1; $i<=100; $i++):
            DB::table('locations')
                ->insert([ 
                    'user_id' => 1,                     
					'client_id' => 2,
					'title' => 'Location name '.$i,
                    'description' =>'jkbjkb kuguig',

                ]);
        endfor;
		
		for($i=1; $i<=100; $i++):
            DB::table('locations')
                ->insert([ 
                    'user_id' => 1,                     
					'client_id' => 3,
					'title' => 'Location name '.$i,
                    'description' =>'jkbjkb kuguig',

                ]);
        endfor;
		
		for($i=1; $i<=100; $i++):
            DB::table('locations')
                ->insert([ 
                    'user_id' => 1,                     
					'client_id' => $i,
					'title' => 'Location name '.$i,
                    'description' =>'jkbjkb kuguig',

                ]);
        endfor;
		
		
		
    }
}
