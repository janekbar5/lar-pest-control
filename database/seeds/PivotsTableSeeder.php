<?php

use Illuminate\Database\Seeder;
use Faker\Factory;
use App\{Location,Treatment,Client,Task};


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
		
		//////////////////////////////////////////////////////////////////////////////////////Clients 100
		
		
		/////////////////////////////////////////////////////////////////////////////////////Clients Locatons 100
		$locations = Location::all()->pluck('id')->toArray();
		$clients = Client::all()->pluck('id')->toArray();
		$treatments = Treatment::all()->pluck('id')->toArray();
        for($i=1; $i<=100; $i++):           
                DB::table('client_location')
                    ->insert([                       
						 //'client_id' => $faker->randomElement($clients),						
                         //'location_id' => $faker->randomElement($locations),
						 'client_id' => $i,						
                         'location_id' => $i,
                    ]);
        endfor; 
		
			
		
		////////////////////////////////////////////////////////////////////////////////////Task for user 5 janekbat5@
		$tasks = Task::all()->pluck('id')->toArray();		
        for($i=1; $i<=50; $i++):           
                DB::table('task_user')
                    ->insert([
                        'task_id' => $i,						
                        'user_id' => 5,
						//'user_id' => $i,
                       
                    ]);
        endfor; 
		
		
		////////////////////////////////////////////////////////////////////////////////////Task for user 5 janekbat5@
		$tasks = Task::all()->pluck('id')->toArray();		
        for($i=1; $i<=50; $i++):           
                DB::table('location_treatment')
                    ->insert([
                        //'location_id' => $i,
						//'treatment_id' => $i,
						'location_id' => $faker->randomElement($locations),
						'treatment_id' => $faker->randomElement($treatments),
                       
                    ]);
        endfor; 

		
		
		
		
		

    }
}
