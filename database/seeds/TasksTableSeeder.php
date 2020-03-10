<?php

use Illuminate\Database\Seeder;
use Faker\Factory;
use Faker\Provider\dateTimeThisMonth;
use App\Location;
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
        $locations = Location::all()->pluck('id')->toArray();
		
		
		
		///////////////////////////////////////////////////////////////////////////////////////Assigned
        for($i=1; $i<=50; $i++):
        $day = $faker->randomElement($days);
        $month = $faker->randomElement($months);
        $status_id = $faker->numberBetween($min = 2, $max = 3);
            DB::table('tasks')
                ->insert([
                    //'location_id' => $faker->numberBetween($min = 1, $max = 4),
					'location_id' =>$faker->randomElement($locations),
					//'location_id' =>$i,
                    'user_id' => 1,
                    'status_id_n' => $status_id,
                    'substatus_id_n' => $status_id == 3 ? $faker->numberBetween($min = 3, $max = 5) : null,
                    'price_n' => $faker->numberBetween($min = 100, $max = 150),
                    'title_t' => "Task title ".$i,
                    'description' => $faker->text,  
                    'comment' => $faker->text,                    
                    'start_t' => '2020-'.$month.'-'.$day.' 0'.$faker->numberBetween($min = 7, $max = 11).':30',
                    'end_t' => '2020-'.$month.'-'.$day.' '.$faker->numberBetween($min = 12, $max = 20).':30',  
					'last_service_t' => '2019-'.$month.'-'.$day.' '.$faker->numberBetween($min = 12, $max = 20).':30',  
					'created_at'=> '2020-02-02 18:30:00',
                ]);
        endfor; 	
		
		/////////////////////////////////////////////////////////////////////////////////////// Not Assigned
        for($i=1; $i<=20; $i++):
        $day = $faker->randomElement($days);
        $month = $faker->randomElement($months);
        
            DB::table('tasks')
                ->insert([
                    //'location_id' => $faker->numberBetween($min = 1, $max = 4),
					'location_id' =>$faker->randomElement($locations),
					//'location_id' =>$i,
                    'user_id' => 1,
                    'status_id_n' => 1,
                    'substatus_id_n' => null,
                    'price_n' => $faker->numberBetween($min = 100, $max = 150),
                    'title_t' => "Task title ".$i,
                    'description' => $faker->text,  
                    'comment' => $faker->text,                    
                    'start_t' => null,
                    'end_t' => null,  
					'last_service_t' => '2018-'.$month.'-'.$day.' '.$faker->numberBetween($min = 12, $max = 20).':30',  
					'created_at'=> '2020-02-02 18:30:00',
                ]);
        endfor;
		
		
		////////////////////////////////////////////////////////////////////////////////////////for user 1
      

            

           
        }
    }

