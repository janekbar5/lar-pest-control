<?php

use Illuminate\Database\Seeder;
use Faker\Factory;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       
      
            //////////////////////////////////////////////////////// ID 1
            App\User::create([
                'status' => 1,
                'name_t' => 'jan',
                'last_name_t' => 'janowski',
                'email' => 'janekbar5@interia.pl',
                'password' => bcrypt('janekbar5@interia.pl'),
                'email_verified_at'=>'2019-09-17 00:00:00',
                'work_phone_t'=>'123456789',
                'leaves_day_n'=>'5',
                'personal_phone_t'=>'987654321',                 
                ]);
			//////////////////////////////////////////////////////// ID 2	
            App\User::create([
                'status' => 1,
                'name_t' => 'janekbar2',
                'last_name_t' => 'gmx',
                'email' => 'janekbar2@gmx.com',
                'password' => bcrypt('janekbar3@gmx.com'),
                'email_verified_at'=>'2019-09-17 00:00:00',
                'work_phone_t'=>'123456789',
                'leaves_day_n'=>'5',
                'personal_phone_t'=>'987654321',                 
                ]);
			//////////////////////////////////////////////////////// ID 3	
            App\User::create([
                'status' => 1,
                'name_t' => 'janekbar3',
                'last_name_t' => 'gmx',
                'email' => 'janekbar3@gmx.com',
                'password' => bcrypt('janekbar4@gmx.com'),
                'email_verified_at'=>'2019-09-17 00:00:00',
                'work_phone_t'=>'123456789',
                'leaves_day_n'=>'5',
                'personal_phone_t'=>'987654321',                 
                ]);
            //////////////////////////////////////////////////////// ID 4	
            App\User::create([
                'status' => 1,
                'name_t' => 'janekbar4',
                'last_name_t' => 'gmx',
                'email' => 'janekbar4@gmx.com',
                'password' => bcrypt('janekbar5@gmx.com'),
                'email_verified_at'=>'2019-09-17 00:00:00',
                'work_phone_t'=>'123456789',
                'leaves_day_n'=>'5',
                'personal_phone_t'=>'987654321',                 
                ]);
			//////////////////////////////////////////////////////// ID 5	
            App\User::create([
                'status' => 1,
                'name_t' => 'janekbar5',
                'last_name_t' => 'gmx',
                'email' => 'janekbar5@gmx.com',
                'password' => bcrypt('janekbar5@gmx.com'),
                'email_verified_at'=>'2019-09-17 00:00:00',
                'work_phone_t'=>'123456789',
                'leaves_day_n'=>'5',
                'personal_phone_t'=>'987654321',                 
                ]);	


            $faker = Factory::create();    
            $leaves = [23,12,14,9,5,8,9];
             ////////////////////////////////////////////////////////////////////////////////////////user 1
             for($i=0; $i<=22; $i++):
             //$startDate = Carbon::createFromTimeStamp($faker->dateTimeBetween('-1 month', '+1 month')->getTimestamp());
			 $email = $faker->unique()->email;
                 DB::table('users')
                     ->insert([
                         'status' => 1, 
                         'name_t' => $faker->firstName,
                         'last_name_t' => $faker->lastName,	
                         'email' => $email,
                         'password' => bcrypt($email),  
                         'email_verified_at'=>'2019-09-17 00:00:00',  
                         'work_phone_t'=> $faker->phoneNumber,    
                         'leaves_day_n'=>$faker->randomElement($leaves),   
                         'personal_phone_t'=> $faker->phoneNumber,                
                         

                     ]);
             endfor;     

       


    }
}
