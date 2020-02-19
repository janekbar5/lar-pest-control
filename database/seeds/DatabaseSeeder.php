<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call(UsersTableSeeder::class);		 
         $this->call(PermissionsTableSeeder::class);
		 $this->call(TasksTableSeeder::class);	
		 $this->call(TreatmentsTableSeeder::class);
		 $this->call(ClientsTableSeeder::class);
		 $this->call(LocationsTableSeeder::class);
		 $this->call(AddressesTableSeeder::class);
		 $this->call(StatusesTableSeeder::class);
         $this->call(SubStatusesTableSeeder::class);
		 
		 $this->call(PivotsTableSeeder::class);
         
	 
    }
}
