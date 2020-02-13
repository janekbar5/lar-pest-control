<?php

use Illuminate\Database\Seeder;
use App\Client;
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
		$surfaces = [200,210,250,270,290,300,310];
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
		$clients = Client::all()->pluck('id')->toArray();
		for($i=1; $i<=100; $i++):	
            DB::table('locations')
                ->insert([ 
                    'user_id' => 1,                     
					'client_id' => $faker->randomElement($clients),
					'title' => 'Location name '.$i,
                    'description' => $faker->text,
					'surface' => $faker->randomElement($surfaces),

                ]);
        endfor;
		
		
		
    }
}
