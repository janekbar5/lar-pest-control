<?php

namespace App\Http\Controllers;

use App\{Task,User,Status};

use Illuminate\Http\Request;
use App\Repositories\ValidationRepository;
use App\Repositories\Interfaces\BackendRepositoryInterface;
use Carbon\Carbon;

class TaskController extends Controller
{
    
     function __construct(ValidationRepository $vr, BackendRepositoryInterface $br, ImageController $im)
    {       
       /*  $this->middleware('permission:task-list');
        $this->middleware('permission:task-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:task-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:task-delete', ['only' => ['destroy']]);  */
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
	public function index()
    {       
		$filterAllLocations = $this->br->getAllLocations(); 
		$filterAllStatuses = $this->br->getAllStatuses2(); 
						
		$tasks_pre = Task::select('tasks.*')
		          ->where('user_id', '=', \Auth::user()->id) 
                  ->with('locations')
                  ->with('statuses')
                  ->with('photos')    
                  ->with('selectedUsers');   
                  	
								
	    if (request('loc'))
        {
            $tasks_pre = $tasks_pre->where('location_id', '=', request('loc'));			
        }		
		if (request('stat'))
        {
            $tasks_pre = $tasks_pre->where('status_id', '=', request('stat'));			
        }
		
		$total = $tasks_pre->get()->count();		
		
		$tasks_ok = $tasks_pre->paginate(request('perpage'));		
		
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
		$statuses = $this->br->getAllStatuses2();
        return response()->json([
            'form' => $task, 
            //'fieldusers' => $fieldusers->toArray(['name','last_name']) 
			'fieldusers' => $fieldusers,
			'statuses' => $statuses,
            ]);         
    }
    /**/////////////////////////////////////////////////////////////////////////////////////////////3 CREATE
     public function create()
     {        
        $fieldusers = User::whereHas("roles", function($q){ $q->where("name", "Field User"); })->get();  
		$statuses = $this->br->getAllStatuses2();
        return response()->json([
            'form' => '',  
			'fieldusers' => $fieldusers->toArray(['name']),
			'statuses' => $statuses,
            ]);
     }
    /**/////////////////////////////////////////////////////////////////////////////////////////////4 CREATE POST
    public function store(Request $request)
    {        
        //dd( $request->all() );
        $fv = $this->validate($request, $this->vr->taskUpdate());        
        $task = Task::create(array_merge($request->all(), [
		'user_id' => \Auth::user()->id,
		//'location_id' => $request->input('location'),
		//'status_id' => 1,
		//'price' => 100,
		]));    
		
        return ['created' => 'true','id' => $task->id];
    }
    /**/////////////////////////////////////////////////////////////////////////////////////////////5 UPDATE POST
    public function update(Request $request, $id)
    {
        //dd($request->all());       
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
	public function updateFromCalendar(Request $request, $id)
    {
        //dd($request->all());       
        $task = $this->br->getTaskById($id);
        $fv = $this->validate($request, $this->vr->taskUpdateFromCalendar());       
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
	/**///////////////////////////////////////////////////////////////////////////////////////////// FIELD USER CALENDAR
	public function userCalendar()    {
        $userstasks = $this->br->getAllUsersTasks();
		$statuses = array();
		foreach(Status::all() as $status){			
			$statuses[] = array("title"=>$status->title,"count"=>$this->br->getAllUsersTasksByStatus($status->id)->count());			
		}
		//dd($userstasks);
        return response()->json([            
            'userstasks' => $userstasks,
			'statuses' => $statuses,			
           
        ]);
    }
    
    
    public function indexFieldUser()
    {       
        /*
        $days2 = Task::where('user_id', '=', \Auth::user()->id) 
        ->orderBy('start')
        ->get()
        ->groupBy(function ($val) {
            return Carbon::parse($val->start)->format('d-m');
        });  */ 

        /* $days = Task::whereBetween('start', [now(), now()->addDays(300)])
        //$days = Task::where('user_id', '=', \Auth::user()->id)
        //->orwhere('user_id', '=', \Auth::user()->id) 
        ->orderBy('start','asc')
        ->get()
        ->groupBy(function ($val) {
            return Carbon::parse($val->start)->format('d');
        }); */
		
		
		 
		/* $days = Task::
		with(['selectedUsers'])                        
            ->whereHas('selectedUsers',function($query) {                
            $query->where('user_id', '=', \Auth::user()->id);                    
        })
		->whereBetween('start', [now(), now()->addDays(30)])
		->orderBy('start','asc')		 
		->get(['status_id','title','start','end'])
		//->get()
		->groupBy(function($date) {
			return Carbon::parse($date->start)->format('d-m-y'); // grouping by years			
		});  */
		
		
		$days = Task::with('locations')                   
         ->whereHas('selectedUsers',function($query) {                
            $query->where('user_id', '=', \Auth::user()->id);                    
         })
		->whereBetween('start', [now(), now()->addDays(60)])
		->orderBy('start','asc')		 
		//->get(['status_id','title','start','end'])
		->get()		
		->groupBy(function($date) {
			return Carbon::parse($date->start)->format('d-m-y'); // grouping by years			
		});  
		
		
		
		
			
        return response()
               ->json([ 
               'results' => $days,
               //'filterAllLocations'=> $filterAllLocations,
               //'filterAllStatuses'=> $filterAllStatuses,
               ]);
                
        
    }
	
	

  
}
