<?php

use Illuminate\Database\Seeder;

class ClientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

	 /*
            $table->string('person_title');
			$table->string('person_name');
			$table->string('name');
			 
            $table->string('email');  
            $table->boolean('is_company');  
            $table->string('contract_number');              
            $table->string('vat_number');
			           			
			$table->date('contract_start');
            $table->date('contract_end');            
            $table->text('description');
*/
public function run()
    {
        $faker = \Faker\Factory::create();
        $months = [01,02,03,04,05,06,07];
		//$randomcontract = [651651,651651,651651,04,05,06,07];
        $titles = ['Miss','Mr','Mrs'];
		for($i=1; $i<=100; $i++):
            DB::table('clients')
                ->insert([ 
				    
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
                    //'address'
                    //'lat' => 51.483,
                    //'lng' => -0.132,
                    

                ]);
        endfor;
		
		
		
    }
}
