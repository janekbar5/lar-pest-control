<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Validator;

class ValidationRepository
{

     /////////////////////////////////////////////////////////////////////////////////////////////////Status
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
     /**/////////////////////////////////////////////////////////////////////////////////////////////BOOKINGS
     public function newBookings()
     {        
         $rules = array(
            'first_name' => 'required',
            'last_name' => 'required',
            'time_from' => 'required',
            'time_to' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'address_line1' => 'required',
            'address_line2' => 'required',
            'city' => 'required',
            'post_code' => 'required',
            'status_id' => 'required',
            'payment_id' => 'required',
 
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

    
    /**/////////////////////////////////////////////////////////////////////////////////////////////PROPERTIES
    public function propertyUpdate()
    {        
        $rules = array(
            'title' => 'required',
            'area' => 'required',
            'room_nubr' => 'required',
            'max_pers' => 'required',
            'title' => 'required',
            'description' => 'required',
            'group_id' => 'required|integer',
            'seasongroup_id' => 'required|integer',
            'price' => 'required|regex:/^\d+(\.\d{1,2})?$/', //double
        );        
        return $rules;
    }
     public function peopertyValidator(array $data)
    {
        $messsages = array(
            'title.required' => 'You cant leave title empty',
            'description.required' => 'You cant leave description empty',
            'seasongroup_id.required' => 'You cant leave seasongroup empty',
            'price.required' => 'You cant leave price empty',
        );
        $rules = array(
            'title' => 'required',
            'description' => 'required',
            'seasongroup_id' => 'required',
            'price' => 'required',
        );
        return Validator::make($data, $rules, $messsages);
    }
    /**/////////////////////////////////////////////////////////////////////////////////////////////GROUPS
    public function groupUpdate()
    {        
        $rules = array(
            'title' => 'required',            
            'description' => 'required',      
        );        
        return $rules;
    }
    /**/////////////////////////////////////////////////////////////////////////////////////////////SEASON GROUPS    
    public function seasongroupValidator()
    {
        $rules = array(
            'title' => 'required',            
            'description' => 'required',      
        );        
        return $rules;
        
    }
     /**/////////////////////////////////////////////////////////////////////////////////////////////SEASONs    
     public function seasonupdate()
     {
         $rules = array(
             'title' => 'required',            
             'start_date' => 'required',
             'end_date' => 'required',
             'price' => 'required',
             //'colour' => 'required',
            );
         return $rules;
         
     }
    /**/////////////////////////////////////////////////////////////////////////////////////////////INVENTORIES
    public function inventoryUpdate()
    {        
        $rules = array(
            'title' => 'required',            
            //'description' => 'required',      
        );        
        return $rules;
    }
     /**/////////////////////////////////////////////////////////////////////////////////////////////BOOKING STATUSES
     public function bookingStatusUpdate() 
     {        
         $rules = array(
             'title' => 'required',
             'colour' => 'required',              
             //'description' => 'required',      
         );        
         return $rules;
     }
}
