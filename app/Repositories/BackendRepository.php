<?php

namespace App\Repositories;

use App\{User,Task,Status,SubStatus,Location,Treatment,Address};
use Spatie\Permission\Models\Role;
use App\Repositories\Interfaces\BackendRepositoryInterface;
use DB;

class BackendRepository implements BackendRepositoryInterface
{

    
    /////////////////////////////////////////////////////////////////////////////////TREATMENT    
    public function getTreatmentById($id){
        return Treatment::where('id', '=', $id)
                   ->first(); 
    }    
    public function getAllTreatments(){  //Admin only
        return Treatment::
                   //where('user_id', '=', $user_id)  
                  orderBy('created_at', 'desc')
                  //->withTrashed()
                  ->paginate(10); 
    }
    /////////////////////////////////////////////////////////////////////////////////ADMIN TASKS
    public function getAllTasks(){
        return Task::  
                  orderBy('created_at', 'desc')
                  ->with('locations')
                  ->with('statuses')
                  ->with('selectedUsers')    
                  ->paginate(10); 
    }
    public function getUnassignedTasks(){
        return Task::  
                  //orderBy('created_at', 'desc')
                  with('locations')
                  ->with('statuses')
                  //->with('selectedUsers') 
                  ->doesntHave('selectedUsers')    
                  ->get(); 
    }
    public function getAssignedTasks(){
        return Task::  
                  //orderBy('created_at', 'desc')
                  with('locations')
                  ->with('statuses')
                  //->with('selectedUsers') 
                  ->has('selectedUsers')    
                  ->get(); 
    }
    public function getTaskById($id){
        return Task::where('id', '=', $id) 
                   ->with('locations')
                   ->with('statuses')
                   ->with('selectedUsers')
                   ->first(); 
    }
    /////////////////////////////////////////////////////////////////////////////////Address    
    public function getUserAddressById($type,$id){         
        return Address::where('addressable_id', '=', $id) 
                    ->where('addressable_type', '=', $type)                  
                    ->first();
      }
     /////////////////////////////////////////////////////////////////////////////////Locations
     public function getLocations($user_id){
        return Location::where('user_id', '=', $user_id) 
                  ->with('address') 
                  ->with('clients') 
                  ->orderBy('created_at', 'desc')                  
                  ->paginate(10); 
    }
    public function getLocationsById($id){
        return Location::where('id', '=', $id) 
                   ->with('address')
                   //->with('treatments')
                   ->with(['treatments' => function ($q) {
                    $q->withTrashed();
                   }])
                   //->withTrashed()
                   ->first(); 
    }
    /////////////////////////////////////////////////////////////////////////////////STATUSES
    public function getAllStatuses(){
        return Status::  
                  orderBy('created_at', 'desc')
                  ->paginate(10); 
    }
    public function getStatusesById($id){
        return Status::where('id', '=', $id) 
                   ->first(); 
    }
    /////////////////////////////////////////////////////////////////////////////////SUBSTATUSES
    public function getAllSubStatuses(){
        return SubStatus::with('status')  
                  ->orderBy('created_at', 'desc')
                  ->paginate(10); 
    }
    public function getSubStatusesByStatus(){
        return SubStatus::where('status_id', '=', $id)   
                  ->orderBy('created_at', 'desc')
                  ->paginate(10); 
    }
    public function getSubStatusesById($id){
        return SubStatus::where('id', '=', $id) 
                   ->first(); 
    }    
    /////////////////////////////////////////////////////////////////////////////////ADMIN USERS
    public function getAdminUsers(){
        return User::
                  with('roles')
                  ->with('photos')
                  ->orderBy('created_at', 'desc')
                  ->paginate(10); 
    }
    public function getAdminUsersById($id){         
        return User::where('id', '=', $id) 
                    ->with('photos')                  
                    ->first();
    }
     /////////////////////////////////////////////////////////////////////////////////ADMIN ROLES
     public function getAdminRoles(){
        return Role::  
                  orderBy('created_at', 'desc')
                  ->with('permissions')
                  ->paginate(10); 
    }
    public function getAdminRolesById($id){         
        return Role::where('id', '=', $id)                                    
                    ->first();
      }
    /////////////////////////////////////////////////////////////////////////////////HISTORY   
    public function getHistory(){
        return DB::table('audits')  
                  ->orderBy('created_at', 'desc')                  
                  ->paginate(10); 
    }   
    
    
}
