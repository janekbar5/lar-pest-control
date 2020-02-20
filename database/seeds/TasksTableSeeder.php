<?php

use Illuminate\Database\Seeder;
use Faker\Factory;
use Faker\Provider\dateTimeThisMonth;
/*use dateTime;   
use Carbon\Carbon;*/


class TasksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    
    public function run()
    {
        
        $faker = Factory::create();   
        $days = ['02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22'];
        $months = ['02','03','04','05','06','07','08','09','10','11','12'];

		
		
		
		///////////////////////////////////////////////////////////////////////////////////////Assigned
        for($i=0; $i<=50; $i++):
        $day = $faker->randomElement($days);
        $month = $faker->randomElement($months);
        $status_id = $faker->numberBetween($min = 2, $max = 3);
            DB::table('tasks')
                ->insert([
                    'location_id' => $faker->numberBetween($min = 1, $max = 4),
                    'user_id' => 1,
                    'status_id' => $status_id,
                    'substatus_id' => $status_id == 3 ? $faker->numberBetween($min = 3, $max = 5) : null,
                    'price' => $faker->numberBetween($min = 100, $max = 150),
                    'title' => "Task title ".$i,
                    'description' => $faker->text,  
                    'comment' => $faker->text,                    
                    'start' => '2020-'.$month.'-'.$day.' 0'.$faker->numberBetween($min = 7, $max = 11).':30',
                    'end' => '2020-'.$month.'-'.$day.' '.$faker->numberBetween($min = 12, $max = 20).':30',  
					'last_service' => '2019-'.$month.'-'.$day.' '.$faker->numberBetween($min = 12, $max = 20).':30',  
					'created_at'=> '2020-02-02 18:30:00',
                ]);
        endfor; 	
		
		/////////////////////////////////////////////////////////////////////////////////////// Not Assigned
        for($i=0; $i<=20; $i++):
        $day = $faker->randomElement($days);
        $month = $faker->randomElement($months);
        
            DB::table('tasks')
                ->insert([
                    'location_id' => $faker->numberBetween($min = 1, $max = 4),
                    'user_id' => 1,
                    'status_id' => 1,
                    'substatus_id' => null,
                    'price' => $faker->numberBetween($min = 100, $max = 150),
                    'title' => "Task title ".$i,
                    'description' => $faker->text,  
                    'comment' => $faker->text,                    
                    'start' => null,
                    'end' => null,  
					'last_service' => '2018-'.$month.'-'.$day.' '.$faker->numberBetween($min = 12, $max = 20).':30',  
					'created_at'=> '2020-02-02 18:30:00',
                ]);
        endfor;
		
		
		////////////////////////////////////////////////////////////////////////////////////////for user 1
       /*  for($i=0; $i<=20; $i++):
        $day = $faker->randomElement($days);
        $month = $faker->randomElement($months);
		$status_id = $faker->numberBetween($min = 1, $max = 3);
            DB::table('tasks')
                ->insert([
                    'location_id' => $faker->numberBetween($min = 1, $max = 4),
                    'user_id' => 1,
					'status_id' => $status_id,
					'substatus_id' => $status_id == 3 ? $faker->numberBetween($min = 3, $max = 5) : null,
					'price' => $faker->numberBetween($min = 100, $max = 150),
					'title' => "Task title ".$i,
					'description' => $faker->text,	
                    'comment' => $faker->text,                    
                    'start' => '2020-'.$month.'-'.$day.' 07:30',
                    'end' => '2020-'.$month.'-'.$day.' 10:30', 
					'last_service' => '2019-'.$month.'-'.$day.' '.$faker->numberBetween($min = 12, $max = 20).':30',
					
                ]);
        endfor;    */  

            

           
        }
    }

