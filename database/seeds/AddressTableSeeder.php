<?php

use Illuminate\Database\Seeder;

class AddressesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
		for($i=1; $i<=20; $i++):
            DB::table('addresses')
                ->insert([                    
					'addressable_type' => 'App\Location',
					'addressable_id' => $i,	
                    'user_id' => 1, 
                    'address_line1' => $faker->streetName,
                    'address_line2' => $faker->streetAddress,
                    'city' => $faker->city,
                    'post_code'=> $faker->postcode,
                    'lat'=> 50.8224867,
                    'lng'=> 16.2737286,
                    

                ]);
        endfor;
		
		/*for($i=0; $i<=50; $i++):
            DB::table('addresses')
                ->insert([
                    'user_id' => 2, 
					'first_name' => $faker->firstName,
					'last_name' => $faker->lastName,					
                ]);
        endfor;*/
		
    }
}
