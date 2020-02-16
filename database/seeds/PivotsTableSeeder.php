<?php

use Illuminate\Database\Seeder;
use Faker\Factory;
use App\Location;
use App\Client;
use App\Task;

class PivotsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        $locations = Location::all()->pluck('id')->toArray();
		$clients = Client::all()->pluck('id')->toArray();
		$surfaces = [200,210,250,270,290,300,310];
		
		//$clients = Client::all()->pluck('id')->toArray();
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
		
		
		$locations = Location::all()->pluck('id')->toArray();
		$clients = Client::all()->pluck('id')->toArray();
		
        for($i=1; $i<=10; $i++):           
                DB::table('client_location')
                    ->insert([
                        //'client_id' => $i,
						'client_id' => $faker->randomElement($clients),
						//'task_id' => $faker->randomElement($tasks),
                        //'location_id' => 4,
                         'location_id' => $faker->randomElement($locations),
                    ]);
        endfor; 
		
		
		
        for($i=1; $i<=10; $i++):           
                DB::table('client_location')
                    ->insert([
                        //'client_id' => $i,
						'client_id' => $faker->randomElement($clients),
						//'task_id' => $faker->randomElement($tasks),
                        //'location_id' => 4,
                         'location_id' => $faker->randomElement($locations),
                    ]);
        endfor; 
		
		
		
		
		$tasks = Task::all()->pluck('id')->toArray();
		
        for($i=1; $i<=100; $i++):           
                DB::table('task_user')
                    ->insert([
                        'task_id' => $i,
						//'task_id' => $faker->randomElement($tasks),
                        'user_id' => 4,
                       
                    ]);
        endfor; 

		
		
		
		
		

    }
}
