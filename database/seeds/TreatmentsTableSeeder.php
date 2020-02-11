<?php

use Illuminate\Database\Seeder;
use App\Task;
use Faker\Factory;
use Faker\Provider\dateTimeThisMonth;
/*use dateTime;   
use Carbon\Carbon;*/


class TreatmentsTableSeeder extends Seeder
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
        for($i=0; $i<=12; $i++):
        //$startDate = Carbon::createFromTimeStamp($faker->dateTimeBetween('-1 month', '+1 month')->getTimestamp());
            DB::table('treatments')
                ->insert([
                    'user_id' => 1, 
					'title' => "Treatment title ".$i,
					//'description' => $faker->text,	
                    //'deadline' => '2020-04-29 20:38:49',    
                ]);
        endfor;     
            

           
        }
    }

