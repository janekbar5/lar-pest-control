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
		//////////////////////////////////////First Client has 3 locations
		/* for($i=1; $i<=3; $i++):
            DB::table('locations')
                ->insert([ 
                    'user_id' => 1,                     
					'client_id' => 1,
					'title' => 'Location name '.$i,
                    'description' =>'jkbjkb kuguig',

                ]);
        endfor; */
		//////////////////////////////////////Second Client has 2 locations
		/* for($i=1; $i<=2; $i++):
            DB::table('locations')
                ->insert([ 
                    'user_id' => 1,                     
					'client_id' => 2,
					'title' => 'Location name '.$i,
                    'description' =>'jkbjkb kuguig',
					
                ]);
        endfor; */
		//////////////////////////////////////Rest of the Clients has 1 locations
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
