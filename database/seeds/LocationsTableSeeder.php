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
		
		for($i=1; $i<=100; $i++):	
            DB::table('locations')
                ->insert([ 
                    'user_id' => 1,
					'title' => 'Location name '.$i,
                    'description' => $faker->text,
					'surface' => $faker->randomElement($surfaces),
					'price' => $faker->numberBetween($min = 100, $max = 150),

                ]);
        endfor;
		
		
		
		
    }
}
