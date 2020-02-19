<?php

use Illuminate\Database\Seeder;
use Faker\Factory;
use App\User;
class TodosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       
      
            


            $faker = Factory::create();    
            //$prices = [200,210,250,270,290,300,310];
             ////////////////////////////////////////////////////////////////////////////////////////user 1
             for($i=0; $i<=10; $i++):
                 DB::table('todos')
                     ->insert([
                         'user_id' => 4, 
                         'title' => $faker->text(50),
                         'description' => '',

                     ]);
             endfor;  
			 
			 for($i=0; $i<=100; $i++):
             $users = User::all()->pluck('id')->toArray();
			 			 
                 DB::table('todos')
                     ->insert([
                         'user_id' => $faker->randomElement($users), 
                         'title' => $faker->text(50),
                         'description' => '',

                     ]);
             endfor;

       


    }
}
