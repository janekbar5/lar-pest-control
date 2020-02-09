<?php

namespace App\Repositories;

use App\{User,Task,Status,SubStatus,Location,Treatment,Address,Client};
use Spatie\Permission\Models\Role;
use App\Repositories\Interfaces\BackendRepositoryInterface;
use DB;

class BackendRepository implements BackendRepositoryInterface
{

    /////////////////////////////////////////////////////////////////////////////////CLIENTS    
	public function getClients(){
        return Client::  
                  orderBy('created_at', 'desc')
                  ->with('locations')
                  //->with('statuses')
                  //->with('selectedUsers')    
                  ->paginate(10); 
    }
	public function getClientById($id){
        return Client::where('id', '=', $id)
                   ->first(); 
    } 
	public function getAllClients(){
        return Client::all(); 
                
    }
    /////////////////////////////////////////////////////////////////////////////////TREATMENTS    
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
	
    /////////////////////////////////////////////////////////////////////////////////TASKS
    public function getAllTasks(){
        return Task::  
                  orderBy('created_at', 'desc')
                  ->with('locations')
                  ->with('statuses')
                  ->with('photos')    
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
                  ->with('selectedUsers')  //display users array
                  ->has('selectedUsers')   //only act as filter   
                  ->get(); 
    }
	
	public function getAssignedFilteredTasks($id){
        return Task::where('location_id', '=', $id)
                  ->with('locations')
                  ->with('statuses')  
				  ->with('selectedUsers')  //display users array
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
	public function getUsersTasks($id){
        //return Task::where('user_id', '=', $id)                    
                  //->with('locations')
                  //->with('statuses')
                  //->with('selectedUsers')
				  //->orderBy('created_at', 'desc')
                  //->get(); 
				  
		return	Task::with(['selectedUsers'])
            //->where("status","=",1)            
            ->whereHas('selectedUsers',function($query) use($id){                
                 $query->where('user_id', '=', $id);
                    
            })            
            ->get();
    }
	
    /////////////////////////////////////////////////////////////////////////////////ADDRESSES    
    public function getUserAddressById($type,$id){         
        return Address::where('addressable_id', '=', $id) 
                    ->where('addressable_type', '=', $type)                  
                    ->first();
      }
     /////////////////////////////////////////////////////////////////////////////////LOCATIONS
     public function getLocations($user_id,$perpage){
        return Location::where('user_id', '=', $user_id) 
                  ->with('address') 
                  ->with('clients') 
                  ->orderBy('created_at', 'desc')                  
                  ->paginate($perpage); 
    }
    public function getLocationsById($id){
        return Location::where('id', '=', $id) 
                   ->with('address')
                   ->with('clients')
                   ->with(['treatments' => function ($q) {
                    $q->withTrashed();
                   }])
                   //->withTrashed()
                   ->first(); 
    }
	public function getAllLocations(){
        return Location::all(); 
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
	public function getAllStatuses2(){
        return Status::all(); 
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
	public function getFreeFieldUsersForDate($date){  
		 return	User::with('selectedTasks')
		           ->whereHas("roles", function($q){ $q->where("name", "Field User"); })   
				   ->wheredoesnthave('selectedTasks', function($q) use($date) {				   
				     $q->where('start','LIKE', '%'.$date.'%'); 
				   })				
				  ->get(); 
    }
	public function getAllFieldUsers(){
		return User::whereHas("roles", function($q){ $q->where("name", "Field User"); })->get();
	}
	 
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
