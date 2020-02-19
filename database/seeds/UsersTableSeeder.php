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
       
        //    $table->boolean('status');
        //     $table->string('name');
        //     $table->string('surname');
        //     $table->string('email')->unique();
        //     $table->string('work_phone');
        //     $table->string('leaves_day');
        //     $table->string('personal_phone');
        //     $table->timestamp('email_verified_at')->nullable();
        //     $table->string('password');

            App\User::create([
                'status' => 1,
                'name' => 'jan',
                'last_name' => 'janowski',
                'email' => 'janekbar5@interia.pl',
                'password' => bcrypt('janekbar5@interia.pl'),
                'email_verified_at'=>'2019-09-17 00:00:00',
                'work_phone'=>'123456789',
                'leaves_day'=>'5',
                'personal_phone'=>'987654321',                 
                ]);
            App\User::create([
                'status' => 1,
                'name' => 'janekbar3',
                'last_name' => 'gmx',
                'email' => 'janekbar3@gmx.com',
                'password' => bcrypt('janekbar3@gmx.com'),
                'email_verified_at'=>'2019-09-17 00:00:00',
                'work_phone'=>'123456789',
                'leaves_day'=>'5',
                'personal_phone'=>'987654321',                 
                ]);
            App\User::create([
                'status' => 1,
                'name' => 'janekbar4',
                'last_name' => 'gmx',
                'email' => 'janekbar4@gmx.com',
                'password' => bcrypt('janekbar4@gmx.com'),
                'email_verified_at'=>'2019-09-17 00:00:00',
                'work_phone'=>'123456789',
                'leaves_day'=>'5',
                'personal_phone'=>'987654321',                 
                ]);

            App\User::create([
                'status' => 1,
                'name' => 'janekbar5',
                'last_name' => 'gmx',
                'email' => 'janekbar5@gmx.com',
                'password' => bcrypt('janekbar5@gmx.com'),
                'email_verified_at'=>'2019-09-17 00:00:00',
                'work_phone'=>'123456789',
                'leaves_day'=>'5',
                'personal_phone'=>'987654321',                 
                ]);


            $faker = Factory::create();    
            //$prices = [200,210,250,270,290,300,310];
             ////////////////////////////////////////////////////////////////////////////////////////user 1
             for($i=0; $i<=22; $i++):
             //$startDate = Carbon::createFromTimeStamp($faker->dateTimeBetween('-1 month', '+1 month')->getTimestamp());
			 $email = $faker->unique()->email;
                 DB::table('users')
                     ->insert([
                         'status' => 1, 
                         'name' => $faker->firstName,
                         'last_name' => $faker->lastName,	
                         'email' => $email,
                         'password' => bcrypt($email),  
                         'email_verified_at'=>'2019-09-17 00:00:00',  
                         'work_phone'=> $faker->phoneNumber,    
                         'leaves_day'=>'5',   
                         'personal_phone'=> $faker->phoneNumber,                
                         

                     ]);
             endfor;     

        //App\User::create(['name' => 'jan 1','email' => 'janekbar5@interia.pl','password' => bcrypt('janekbar5@interia.pl'),'email_verified_at'=>'2019-09-17 00:00:00' ]);
        //App\User::create(['name' => 'jan 2','email' => 'janekbar5@gmx.com','password' => bcrypt('janekbar5@gmx.com'),'email_verified_at'=>'2019-09-17 00:00:00']);
        //App\User::create(['name' => 'jan 3','email' => 'janekbarski@wp.pl','password' => bcrypt('janekbarski@wp.pl'),'email_verified_at'=>'2019-09-17 00:00:00']);


    }
}
