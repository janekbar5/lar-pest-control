<?php

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    
    public function run()
    {
        DB::table('roles')->insert(['name' => 'Admin','guard_name' => 'web']);
        DB::table('roles')->insert(['name' => 'Desk User','guard_name' => 'web']);
        DB::table('roles')->insert(['name' => 'Field User','guard_name' => 'web']);
		/////////////////////////////
		DB::table('model_has_roles')->insert(['role_id' => 1,'model_type' => 'App\User','model_id' => 1]);
		//DB::table('model_has_roles')->insert(['role_id' => 2,'model_type' => 'App\User','model_id' => 1]);
		//DB::table('model_has_roles')->insert(['role_id' => 3,'model_type' => 'App\User','model_id' => 1]);
        
        for($i=2; $i<=20; $i++):
        DB::table('model_has_roles')->insert(['role_id' => 3,'model_type' => 'App\User','model_id' => $i]);
        endfor;
        ///////////////////////////1-4 Role
		DB::table('permissions')->insert(['name' => 'role-list','guard_name' => 'web']);
		DB::table('permissions')->insert(['name' => 'role-create','guard_name' => 'web']);
		DB::table('permissions')->insert(['name' => 'role-edit','guard_name' => 'web']);
		DB::table('permissions')->insert(['name' => 'role-delete','guard_name' => 'web']);		
	 	///////////////////////////5-8 User				
		DB::table('permissions')->insert(['name' => 'user-list','guard_name' => 'web']);
		DB::table('permissions')->insert(['name' => 'user-create','guard_name' => 'web']);
		DB::table('permissions')->insert(['name' => 'user-edit','guard_name' => 'web']);
		DB::table('permissions')->insert(['name' => 'user-delete','guard_name' => 'web']);
		///////////////////////////9-12 Permission	
		DB::table('permissions')->insert(['name' => 'permission-list','guard_name' => 'web']);
		DB::table('permissions')->insert(['name' => 'permission-create','guard_name' => 'web']);
		DB::table('permissions')->insert(['name' => 'permission-edit','guard_name' => 'web']);
        DB::table('permissions')->insert(['name' => 'permission-delete','guard_name' => 'web']);
        ///////////13-16 Tasks
        DB::table('permissions')->insert(['name' => 'task-list','guard_name' => 'web']);
		DB::table('permissions')->insert(['name' => 'task-create','guard_name' => 'web']);
		DB::table('permissions')->insert(['name' => 'task-edit','guard_name' => 'web']);
		DB::table('permissions')->insert(['name' => 'task-delete','guard_name' => 'web']);
		///////////17-20 History
        DB::table('permissions')->insert(['name' => 'history-list','guard_name' => 'web']);
		DB::table('permissions')->insert(['name' => 'history-create','guard_name' => 'web']);
		DB::table('permissions')->insert(['name' => 'history-edit','guard_name' => 'web']);
        DB::table('permissions')->insert(['name' => 'history-delete','guard_name' => 'web']);
        ///////////21-24 Status
        DB::table('permissions')->insert(['name' => 'status-list','guard_name' => 'web']);
		DB::table('permissions')->insert(['name' => 'status-create','guard_name' => 'web']);
		DB::table('permissions')->insert(['name' => 'status-edit','guard_name' => 'web']);
        DB::table('permissions')->insert(['name' => 'status-delete','guard_name' => 'web']);
        ///////////25-28 Substatus
        DB::table('permissions')->insert(['name' => 'substatus-list','guard_name' => 'web']);
		DB::table('permissions')->insert(['name' => 'substatus-create','guard_name' => 'web']);
		DB::table('permissions')->insert(['name' => 'substatus-edit','guard_name' => 'web']);
        DB::table('permissions')->insert(['name' => 'substatus-delete','guard_name' => 'web']);
        ///////////29-32 Calendar
        DB::table('permissions')->insert(['name' => 'calendar-list','guard_name' => 'web']);
		DB::table('permissions')->insert(['name' => 'calendar-create','guard_name' => 'web']);
		DB::table('permissions')->insert(['name' => 'calendar-edit','guard_name' => 'web']);
        DB::table('permissions')->insert(['name' => 'calendar-delete','guard_name' => 'web']);
        ///////////33-36 Location
        DB::table('permissions')->insert(['name' => 'location-list','guard_name' => 'web']);
		DB::table('permissions')->insert(['name' => 'location-create','guard_name' => 'web']);
		DB::table('permissions')->insert(['name' => 'location-edit','guard_name' => 'web']);
        DB::table('permissions')->insert(['name' => 'location-delete','guard_name' => 'web']);
        ///////////37-40 Treatment
        DB::table('permissions')->insert(['name' => 'treatment-list','guard_name' => 'web']);
		DB::table('permissions')->insert(['name' => 'treatment-create','guard_name' => 'web']);
		DB::table('permissions')->insert(['name' => 'treatment-edit','guard_name' => 'web']);
		DB::table('permissions')->insert(['name' => 'treatment-delete','guard_name' => 'web']);
		///////////41-44 Client
        DB::table('permissions')->insert(['name' => 'client-list','guard_name' => 'web']);
		DB::table('permissions')->insert(['name' => 'client-create','guard_name' => 'web']);
		DB::table('permissions')->insert(['name' => 'client-edit','guard_name' => 'web']);
		DB::table('permissions')->insert(['name' => 'client-delete','guard_name' => 'web']);
		
		//////////////////////////////////Admin		
        DB::table('role_has_permissions')->insert(['permission_id' => 1,'role_id' => 1]);  		
		DB::table('role_has_permissions')->insert(['permission_id' => 2,'role_id' => 1]);
		DB::table('role_has_permissions')->insert(['permission_id' => 3,'role_id' => 1]);
        DB::table('role_has_permissions')->insert(['permission_id' => 4,'role_id' => 1]);
        
		DB::table('role_has_permissions')->insert(['permission_id' => 5,'role_id' => 1]);		
		DB::table('role_has_permissions')->insert(['permission_id' => 6,'role_id' => 1]);
		DB::table('role_has_permissions')->insert(['permission_id' => 7,'role_id' => 1]);
        DB::table('role_has_permissions')->insert(['permission_id' => 8,'role_id' => 1]);

		DB::table('role_has_permissions')->insert(['permission_id' => 9,'role_id' => 1]);       
        DB::table('role_has_permissions')->insert(['permission_id' => 10,'role_id' => 1]);  
        DB::table('role_has_permissions')->insert(['permission_id' => 11,'role_id' => 1]);  
        DB::table('role_has_permissions')->insert(['permission_id' => 12,'role_id' => 1]);  

        DB::table('role_has_permissions')->insert(['permission_id' => 13,'role_id' => 1]);  
        DB::table('role_has_permissions')->insert(['permission_id' => 14,'role_id' => 1]);  
        DB::table('role_has_permissions')->insert(['permission_id' => 15,'role_id' => 1]);  
        DB::table('role_has_permissions')->insert(['permission_id' => 16,'role_id' => 1]); 
        
        DB::table('role_has_permissions')->insert(['permission_id' => 17,'role_id' => 1]);  
        DB::table('role_has_permissions')->insert(['permission_id' => 18,'role_id' => 1]);  
        DB::table('role_has_permissions')->insert(['permission_id' => 19,'role_id' => 1]);  
        DB::table('role_has_permissions')->insert(['permission_id' => 20,'role_id' => 1]); 

        DB::table('role_has_permissions')->insert(['permission_id' => 21,'role_id' => 1]);  
        DB::table('role_has_permissions')->insert(['permission_id' => 22,'role_id' => 1]);  
        DB::table('role_has_permissions')->insert(['permission_id' => 23,'role_id' => 1]);  
        DB::table('role_has_permissions')->insert(['permission_id' => 24,'role_id' => 1]); 

        DB::table('role_has_permissions')->insert(['permission_id' => 25,'role_id' => 1]);  
        DB::table('role_has_permissions')->insert(['permission_id' => 26,'role_id' => 1]);  
        DB::table('role_has_permissions')->insert(['permission_id' => 27,'role_id' => 1]);  
        DB::table('role_has_permissions')->insert(['permission_id' => 28,'role_id' => 1]); 
        ///////////29-32 Calendar
        DB::table('role_has_permissions')->insert(['permission_id' => 29,'role_id' => 1]);  
        DB::table('role_has_permissions')->insert(['permission_id' => 30,'role_id' => 1]);  
        DB::table('role_has_permissions')->insert(['permission_id' => 31,'role_id' => 1]);  
        DB::table('role_has_permissions')->insert(['permission_id' => 32,'role_id' => 1]); 
        ///////////33-36 Location
        DB::table('role_has_permissions')->insert(['permission_id' => 33,'role_id' => 1]);  
        DB::table('role_has_permissions')->insert(['permission_id' => 34,'role_id' => 1]);  
        DB::table('role_has_permissions')->insert(['permission_id' => 35,'role_id' => 1]);  
        DB::table('role_has_permissions')->insert(['permission_id' => 36,'role_id' => 1]);
       ///////////37-40 Location
       DB::table('role_has_permissions')->insert(['permission_id' => 37,'role_id' => 1]);  
       DB::table('role_has_permissions')->insert(['permission_id' => 38,'role_id' => 1]);  
       DB::table('role_has_permissions')->insert(['permission_id' => 39,'role_id' => 1]);  
       DB::table('role_has_permissions')->insert(['permission_id' => 40,'role_id' => 1]);
       ///////////41-44 Clients
       DB::table('role_has_permissions')->insert(['permission_id' => 41,'role_id' => 1]);  
       DB::table('role_has_permissions')->insert(['permission_id' => 42,'role_id' => 1]);  
       DB::table('role_has_permissions')->insert(['permission_id' => 43,'role_id' => 1]);  
       DB::table('role_has_permissions')->insert(['permission_id' => 44,'role_id' => 1]);
		
		
		
		
		
		
        /////////////////////////////////////Desk User
        DB::table('role_has_permissions')->insert(['permission_id' => 13,'role_id' => 2]);
        DB::table('role_has_permissions')->insert(['permission_id' => 14,'role_id' => 2]);
        DB::table('role_has_permissions')->insert(['permission_id' => 15,'role_id' => 2]);
        /////////////////////////////////////Field User
		DB::table('role_has_permissions')->insert(['permission_id' => 13,'role_id' => 3]);
        DB::table('role_has_permissions')->insert(['permission_id' => 14,'role_id' => 3]);
        DB::table('role_has_permissions')->insert(['permission_id' => 15,'role_id' => 3]);
    }
}
