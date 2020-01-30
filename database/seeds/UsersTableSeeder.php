<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\User::create(['name' => 'jan 1','email' => 'janekbar5@interia.pl','password' => bcrypt('janekbar5@interia.pl'),'email_verified_at'=>'2019-09-17 00:00:00' ]);
        App\User::create(['name' => 'jan 2','email' => 'janekbar5@gmx.com','password' => bcrypt('janekbar5@gmx.com'),'email_verified_at'=>'2019-09-17 00:00:00']);
        App\User::create(['name' => 'jan 3','email' => 'janekbarski@wp.pl','password' => bcrypt('janekbarski@wp.pl'),'email_verified_at'=>'2019-09-17 00:00:00']);
    }
}
