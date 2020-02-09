<?php

namespace App\Http\Controllers;

use App\{Task,User};

use Illuminate\Http\Request;
use App\Repositories\ValidationRepository;
use App\Repositories\Interfaces\BackendRepositoryInterface;


class TaskController extends Controller
{
    
     function __construct(ValidationRepository $vr, BackendRepositoryInterface $br, ImageController $im)
    {       
        $this->middleware('permission:task-list');
        $this->middleware('permission:task-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:task-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:task-delete', ['only' => ['destroy']]); 
		//
		//$this->middleware('permission:task-delete', ['only' => ['destroy']]);
		
        $this->br = $br;
        $this->vr = $vr;
        $this->im = $im;
    }    
    	
    /**/////////////////////////////////////////////////////////////////////////////////////////////1 INDEX
    /* public function index()    {       
        $tasks = $this->br->getAllTasks();       
        return response()->json(['results' => $tasks]);
       
    } */
	public function index(Request $request)
    {       
		$filterAllLocations = $this->br->getAllLocations(); 
		$filterAllStatuses = $this->br->getAllStatuses2(); 
		
		$tasks_pre = Task::select('tasks.*')
		          ->where('user_id', '=', \Auth::user()->id) 
                  ->with('locations')
                  ->with('statuses')
                  ->with('photos')    
                  ->with('selectedUsers');   
                  	
								
	    if ($request->input('loc'))
        {
            $tasks_pre = $tasks_pre->where('location_id', '=', $request->input('loc'));			
        }		
		if ($request->input('stat'))
        {
            $tasks_pre = $tasks_pre->where('status_id', '=', $request->input('stat'));			
        }
		
		$total = $tasks_pre->get()->count();		
		
		$tasks_ok = $tasks_pre->paginate($request->input('perpage'));		
		
		return response()
               ->json([ 
			   'results' => $tasks_ok,
			   'filterAllLocations'=> $filterAllLocations,
			   'filterAllStatuses'=> $filterAllStatuses,
			   ]);
				
		
    }
    /**/////////////////////////////////////////////////////////////////////////////////////////////2 EDIT
    public function edit($id)
    {        
        $task = $this->br->getTaskById($id); 
        $fieldusers = $this->br->getAllFieldUsers(); 
		
        return response()->json([
            'form' => $task, 
            //'fieldusers' => $fieldusers->toArray(['name','last_name']) 
			'fieldusers' => $fieldusers 
            ]);         
    }
    /**/////////////////////////////////////////////////////////////////////////////////////////////3 CREATE
     public function create()
     {        
        $fieldusers = User::whereHas("roles", function($q){ $q->where("name", "Field User"); })->get();  
        return response()->json([
            'form' => '',  
			'fieldusers' => $fieldusers->toArray(['name'])
            ]);
     }
    /**/////////////////////////////////////////////////////////////////////////////////////////////4 CREATE POST
    public function store(Request $request)
    {        
        //dd(\Auth::user()->id);
        $fv = $this->validate($request, $this->vr->taskUpdate());        
        $task = Task::create(array_merge($request->all(), [
		'user_id' => \Auth::user()->id,
		'location_id' => $request->input('location'),
		'status_id' => 1,
		'price' => 100,
		]));    
		
        return ['created' => 'true','id' => $task->id];
    }
    /**/////////////////////////////////////////////////////////////////////////////////////////////5 UPDATE POST
    public function update(Request $request, $id)
    {
        //dd($request->all());
        //$property = Property::findOrFail($id);
        $task = $this->br->getTaskById($id);
        $fv = $this->validate($request, $this->vr->taskUpdate());       
        $task->update($request->all());   
        $array_users = [];
        foreach($request->input('selected_users') as $user){
           
            $array_users[] = $user['id'];
        }
        $task->selectedUsers()->sync($array_users);
            
       
        return ['saved' => 'true','id' => $task->id];        
    }
    /**/////////////////////////////////////////////////////////////////////////////////////////////6 DESTROY 
    public function destroy($id)
    {
        $task = $this->br->getTaskById($id);        
        $task->delete();
        return response()
            ->json(['deleted' => true]);
    }
	
	/**/////////////////////////////////////////////////////////////////////////////////////////////6 getTasksByDate 
    public function getTasksByDate(Request $request)
    {
        $date = $request->input('date');        
        $tasksbydate = Task::
							with('selectedUsers')
							->where('start','LIKE', '%'.$date.'%')
							->get();
		$freefieldusers = $this->br->getFreeFieldUsersForDate($date);					
							
        return response()
            ->json([
			'tasksbydate' => $tasksbydate,	
			'freefieldusers' => $freefieldusers,	
			]);
    }
	/**///////////////////////////////////////////////////////////////////////////////////////////// CALENDAR
    public function calendar(Request $request)    { 
	
        $unassignedtasks = $this->br->getUnassignedTasks();
		if($request->input('location')){
		  $assignedtasks = $this->br->getAssignedFilteredTasks($request->input('location'));
		}else{
		  $assignedtasks = $this->br->getAssignedTasks();
		} 
	    $alllocations = $this->br->getAllLocations(); 
        return response()->json([            
            'unassignedtasks' => $unassignedtasks,
            'assignedtasks' => $assignedtasks,
			'alllocations' => $alllocations,
			
        ]);
    }
	
	public function userCalendar()    {
        $userstasks = $this->br->getUsersTasks(\Auth::user()->id);
		//dd($userstasks);
        return response()->json([            
            'userstasks' => $userstasks,
           
        ]);
    }
	
	

  
}
