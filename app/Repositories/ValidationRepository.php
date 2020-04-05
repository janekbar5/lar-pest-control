<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Validator;

class ValidationRepository
{

     /////////////////////////////////////////////////////////////////////////////////////////////////CLIENTS
    public function todoUpdate()
     {        
         $rules = array(
            //'company_name' => 'required',
            'title' => 'required',
			'user_id' => 'required',
			//'phone' => 'required|email|unique:clients,email',
			//'is_company' => 'required',
			
			
			
         );        
         return $rules;
     }
    /////////////////////////////////////////////////////////////////////////////////////////////////CLIENTS
    public function clientUpdate()
     {        
         $rules = array(
            'name_t' => 'required',
            'email_t' => 'required',
			'phone_n' => 'required',
			'client_type_n' => 'required',
			//'phone' => 'required|email|unique:clients,email',
			//'is_company' => 'required',
			//'contract_number' => 'required',
			//'vat_number' => 'required',
			'contract_start_t' => 'required',
			'contract_end_t' => 'required',
			//'person_name' => 'required',
			'reccurence_id_n' => 'required',
			
			
         );        
         return $rules;
     }
    /////////////////////////////////////////////////////////////////////////////////////////////////TREATMENT
    public function treatmentUpdate()
     {        
         $rules = array(
            'title' => 'required',
            //'description' => 'required',          
         );        
         return $rules;
     }
    /////////////////////////////////////////////////////////////////////////////////////////////////TASKS
    public function taskUpdate()
     {        
         $rules = array(
            'title_t' => 'required',
            'price_n' => 'required|regex:/^\d+(\.\d{1,2})?$/', 
			//'start' => 'required|date',			
			//'end' => 'required|date|after:start|date_format:YYYY-MM-DD H:i',
			//'end' => 'required|date|after:start',
			'location_id' => 'required',
			'status_id_n' => 'required',
			'users' => 'required',
			
         );        
         return $rules;
     }
	 public function taskUpdateFromCalendar()
     {        
         $rules = array(
			'start' => 'required',
			'end' => 'required',
			'location_id' => 'required',
			'users' => 'required',			
         );        
         return $rules;
     }
     /////////////////////////////////////////////////////////////////////////////////////////////////LOCATIONS
     public function locationUpdate()
     {        
         $rules = array(
            'title_t' => 'required',
			'surface_n' => 'required|numeric',
			'price_n' => 'required|numeric',
			'description' => 'required',
			//
			'address_line1' => 'required',
			'city' => 'required',			
			'postcode' => 'required',
			
			
         );        
         return $rules;
     }
     /////////////////////////////////////////////////////////////////////////////////////////////////Status
    public function statusUpdate()
    {        
        $rules = array(
           'title' => 'required',
		   'colour' => 'required',
        );        
        return $rules;
    }
     /////////////////////////////////////////////////////////////////////////////////////////////////SubStatus
     public function substatusUpdate()
     {        
         $rules = array(
            'status_id' => 'required',
			'colour' => 'required',
            'title' => 'required',          
         );        
         return $rules;
     }

    /////////////////////////////////////////////////////////////////////////////////////////////////USERS   
    public function newAdminUsers()
     {        
         $rules = array(
            'name_t' => 'required',
            //'email' => 'required|email|unique:users,email',
			'email' => 'required|email',
            //'password' => 'required|same:confirm_password',
            'roles' => 'required'
         );        
         return $rules;
     }
     /////////////////////////////////////////////////////////////////////////////////////////////////PERMISSIONS   
    public function permissionUpdate()
    {        
        $rules = array(
           'name' => 'required',
           //'guard_name' => 'required',          
        );        
        return $rules;
    }    
    
    public function bookingValidator(array $data)
    {
        $messsages = array(
            'email.required' => 'You cant leave email field empty',
            'name.required' => 'You cant leave name field empty',
        );
        $rules = array(
            'email' => 'required',
            'name' => 'required',
        );
        return Validator::make($data, $rules, $messsages);
    }     
   
     /**/////////////////////////////////////////////////////////////////////////////////////////////CUSTOMER
    public function customerValidator(array $data)
    {
        $messsages = array(
            'first_name.required' => 'You cant leave first name empty',
            'last_name.required' => 'You cant leave last name field empty',
        );
        $rules = array(
            'first_name' => 'required|max:255',
            'last_name' => 'required',
        );
        return Validator::make($data, $rules, $messsages);
    }
     /**/////////////////////////////////////////////////////////////////////////////////////////////USERS
    public function userValidator(array $data)
    {
        $messsages = array(
            'name.required' => 'You cant leave name empty',
            'email.required' => 'You cant leave email empty',
            'password.required' => 'You cant leave password empty',
            'roles.required' => 'You cant leave roles empty',
        );
        $rules = array(
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required'
        );
        return Validator::make($data, $rules, $messsages);
    }

       
}
