<?php

namespace App\Repositories;

use App\{User,Task,Status,SubStatus,Location,Treatment,Address,Client,History,Todo};
use Spatie\Permission\Models\Role;
use App\Repositories\Interfaces\BackendRepositoryInterface;
use DB;

class BackendRepository implements BackendRepositoryInterface
{


    /////////////////////////////////////////////////////////////////////////////////TODO
    public function getTodoById($id){
        return Todo::where('id', '=', $id)
                   ->with('users')
                   ->first(); 
    }
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
		           ->with('locations')
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
                  orderBy('created_at', 'desc')                  
				  ->get();
    }
	
    /////////////////////////////////////////////////////////////////////////////////TASKS
    public function getAllTasks(){
        return Task::  
                  orderBy('created_at', 'desc')
                  ->with('locations')
                  ->with('statuses')
                  ->with('photos')    
                  ->with('users')    
                  ->paginate(10); 
    }
    public function getUnassignedTasks(){
        return Task::  
                  with('locations','statuses','users') 
				  ->where('status_id_n', '=', 1)
				  //->whereNull('start_t')
				  //->whereNull('end_t')                 				 
                  ->doesntHave('users')    
                  ->get(); 
    }
	public function getUnassignedTasksForPeriod($start,$end){
        return Task::  
                  //orderBy('created_at', 'desc')
                  with('locations','statuses','users')
				  ->where('status_id_n', '=', 1)
				  //->whereNull('start_t')
				  //->whereNull('end_t')
				  ->where('created_at', '>=', $start)
                  ->where('created_at', '<', $end)
                  ->with('statuses')				 
                  ->doesntHave('users')    
                  ->get(); 
    }
	public function getAssignedTasksForPeriod($start,$end){
        return Task::
                  with('locations')				 
				  ->whereNotNull('start_t')
				  ->whereNotNull('end_t')
				  ->where('start_t', '>=', $start)
                  ->where('end_t', '<', $end)                  
                  ->with('users')                     
                  ->get(); 
    }
    public function getAssignedTasks(){
        return Task::  
                    whereNotNull('start_t')
				  ->whereNotNull('end_t')
                  ->with('locations')
                  ->with('statuses')
                  ->with('users')  //display users array
                  ->has('users')   //only act as filter   
                  ->get(); 
    }
	
	public function getAssignedFilteredTasks($id){
        return Task::where('location_id', '=', $id)
                  ->with('locations')
                  ->with('statuses')  
				  ->with('users')  //display users array
                  ->has('users')    
                  ->get(); 
    }
	
	
    public function getTaskById($id){
        return Task::where('id', '=', $id) 
                   ->with('locations.treatments')
                   ->with('statuses')
                   ->with('users')
                   ->first(); 
    }
	public function getAllUsersTasks(){ 
		   return Task::with(['users'])                        
            ->whereHas('users',function($query) {                
                 $query->where('user_id', '=', \Auth::user()->id);                    
            })            
            ->get(); 
			
			
    }
	public function getAllUsersTasksByStatus($id){ 
		return	Task::with(['users'])                        
            ->whereHas('users',function($query) use($id){                
                 $query->where('user_id', '=', \Auth::user()->id);
				 $query->where('status_id_n', '=', $id);
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
        return SubStatus::where('status_id_n', '=', $id)   
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
				       ->WhereDoesntHave('selectedTasks', function($q) use($date) {				   
				       $q->where('start_t','LIKE', '%'.$date.'%'); 
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
     
		/* return History::with('users')                                    
                  ->get();  */
				  
		return History::all();                             
                 		  
    }   
    
    
}
