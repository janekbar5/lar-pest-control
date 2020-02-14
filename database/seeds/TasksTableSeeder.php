<?php

use Illuminate\Database\Seeder;
use App\Task;
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
        $days = ['05','06','07','08','09','10','11','12','13','14','15','16','17','18','19'];
        $months = ['01','01','03','04','05','06','07','08','09','10','11','12'];

        for($i=0; $i<=200; $i++):
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


		////////////////////////////////////////////////////////////////////////////////////////user 1
        for($i=201; $i<=300; $i++):
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
					
                ]);
        endfor;     

        /* for($i=5; $i<=100; $i++):           
                DB::table('task_user')
                    ->insert([                        
						'task_id' => $i,
                        'user_id' => $i,
                    ]);
        endfor;   */   
            

           
        }
    }

