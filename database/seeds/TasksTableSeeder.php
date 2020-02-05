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
		////////////////////////////////////////////////////////////////////////////////////////user 1
        for($i=0; $i<=25; $i++):
        $day = $faker->randomElement($days);
            DB::table('tasks')
                ->insert([
                    'location_id' => $faker->numberBetween($min = 1, $max = 4),
                    'user_id' => 1,
					'status_id' => $faker->numberBetween($min = 1, $max = 3),
					'price' => $faker->numberBetween($min = 100, $max = 150),
					'title' => "Task title ".$i,
					'description' => $faker->text,	
                    'comment' => $faker->text,
                    
                    'start' => '2020-02-'.$day.' 07:30',
                    'end' => '2020-02-'.$day.' 10:30',                  
					
                ]);
        endfor;     

        for($i=1; $i<=20; $i++):           
                DB::table('task_user')
                    ->insert([
                        'task_id' => $faker->numberBetween($min = 1, $max = 20),
                        'user_id' => $faker->numberBetween($min = 1, $max = 20),
                    ]);
        endfor;     
            

           
        }
    }

