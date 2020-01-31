<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Validator;

class ValidationRepository
{


    
    /////////////////////////////////////////////////////////////////////////////////////////////////TREATMENT
    public function treatmentUpdate()
     {        
         $rules = array(
            'title' => 'required',
            'description' => 'required',          
         );        
         return $rules;
     }
    /////////////////////////////////////////////////////////////////////////////////////////////////TASKS
    public function taskUpdate()
     {        
         $rules = array(
            'title' => 'required',
            //'description' => 'required',          
         );        
         return $rules;
     }
     /////////////////////////////////////////////////////////////////////////////////////////////////LOCATIONS
     public function locationUpdate()
     {        
         $rules = array(
            'title' => 'required',
            'description' => 'required',          
         );        
         return $rules;
     }
     /////////////////////////////////////////////////////////////////////////////////////////////////Status
    public function statusUpdate()
    {        
        $rules = array(
           'title' => 'required',          
        );        
        return $rules;
    }
     /////////////////////////////////////////////////////////////////////////////////////////////////SubStatus
     public function substatusUpdate()
     {        
         $rules = array(
            'status_id' => 'required',
            'title' => 'required',          
         );        
         return $rules;
     }

    /////////////////////////////////////////////////////////////////////////////////////////////////ADMIN USERS   
    public function newAdminUsers()
     {        
         $rules = array(
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm_password',
            'roles' => 'required'
         );        
         return $rules;
     }
     /////////////////////////////////////////////////////////////////////////////////////////////////ADMIN PERMISSIONS   
    public function permissionUpdate()
    {        
        $rules = array(
           'name' => 'required',
           'guard_name' => 'required',          
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
