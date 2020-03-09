<?php

use Illuminate\Database\Seeder;
use App\Location;
use App\Client;
class ClientsTableSeeder extends Seeder
{
    
public function run()
    {
        $faker = \Faker\Factory::create();
        $months = [01,02,03,04,05,06,07];
		$client_types = [1,2];
		
		
		
		
		$reccurence = ['2 months','3 months','4 months','6 months','on request'];
		
        $titles = ['Miss','Mr','Mrs'];
		for($i=1; $i<=100; $i++):
		
		$client_types_ok = rand(1,2);
		
		if($client_types_ok == 1){
		 $name = $faker->name;
		}elseif($client_types_ok == 2){
		 $name = $faker->company;
		}
		
            DB::table('clients')
                ->insert([ 
				    'active' => $faker->numberBetween($min = 1, $max = 2),
					'reccurence_id' => $faker->numberBetween($min = 1, $max = 8),
                    'person_title' => $faker->randomElement($titles),
					'client_type' => $client_types_ok,
					'name' => $name,
					'person_name' => $faker->name,
					'email' => $faker->email,
					'phone' => $faker->phoneNumber, 
					
                    'contract_number' => '751651'.$i,                    
                    'contract_start' => '2020-'.$faker->randomElement($months).'-01',
                    'vat_number' => 'vat-651651'.$i,                    
                    'contract_end' => '2021-'.$faker->randomElement($months).'-01',
                    'description' => $faker->text,
					
                    //'address'
                    //'lat' => 51.483,
                    //'lng' => -0.132,
                    

                ]);
        endfor;
		
		
		
		
		

		
		
    }
}
