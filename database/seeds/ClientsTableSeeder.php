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
		$reccurence = ['2 months','3 months','4 months','6 months','on request'];
		//$randomcontract = [651651,651651,651651,04,05,06,07];
        $titles = ['Miss','Mr','Mrs'];
		for($i=1; $i<=100; $i++):
            DB::table('clients')
                ->insert([ 
				    'active' => $faker->numberBetween($min = 0, $max = 1),
                    'person_title' => $faker->randomElement($titles),
					'person_name' => $faker->name,  
                    'company_name' => $faker->company,                     
					'email' => $faker->email,
					'phone' => $faker->phoneNumber, 
					'is_company' => $faker->numberBetween($min = 0, $max = 1),
                    'contract_number' => '751651'.$i,                    
                    'contract_start' => '2020-'.$faker->randomElement($months).'-01',
                    'vat_number' => 'vat-651651'.$i,                    
                    'contract_end' => '2021-'.$faker->randomElement($months).'-01',
                    'description' => $faker->text,
					'reccurence' => $faker->randomElement($reccurence),
                    //'address'
                    //'lat' => 51.483,
                    //'lng' => -0.132,
                    

                ]);
        endfor;
		
		
		
		
		

		
		
    }
}
