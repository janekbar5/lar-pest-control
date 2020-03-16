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
		$phones = ['4578-0203-555','6546416165','075-656566','5615614114','1451545554','434534534'];
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
				    'active_n' => $faker->numberBetween($min = 1, $max = 2),
					'reccurence_id_n' => $faker->numberBetween($min = 1, $max = 8),
                    'person_title' => $faker->randomElement($titles),
					'client_type_n' => $client_types_ok,
					'name_t' => $name,
					'person_name_t' => $faker->name,
					'email_t' => $faker->email,
					'phone_n' => $faker->randomElement($phones),					
                    'contract_number_n' => '751651'.$i,                    
                    'contract_start_t' => '2020-'.$faker->randomElement($months).'-01',
                    'vat_number_t' => 'vat-651651'.$i,                    
                    'contract_end_t' => '2021-'.$faker->randomElement($months).'-01',
                    'description' => $faker->text,
					
                    //'address'
                    //'lat' => 51.483,
                    //'lng' => -0.132,
                    

                ]);
        endfor;
		
		
		
		
		

		
		
    }
}
