<?php

namespace App\Http\Controllers;

use App\{Task,User,Status,Location,Treatment,Todo};

use Illuminate\Http\Request;
use App\Repositories\ValidationRepository;
use App\Repositories\Interfaces\BackendRepositoryInterface;
use Carbon\Carbon;

class TaskController extends Controller
{
    
     function __construct(ValidationRepository $vr, BackendRepositoryInterface $br, ImageController $im)
    {       
        $this->middleware('permission:task-list',['only' => ['index']]);
        $this->middleware('permission:task-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:task-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:task-delete', ['only' => ['destroy']]); 
		
		$this->middleware('permission:user-usersettings', ['only' => ['usertasksEdit','indexFieldUser']]);
		//
		//$this->middleware('permission:task-delete', ['only' => ['destroy']]);
		
        $this->br = $br;
        $this->vr = $vr;
        $this->im = $im;
    }    
    	
    /**/////////////////////////////////////////////////////////////////////////////////////////////1 INDEX    
	public function index()    {       
		
		$tasks = Task::with('photos','statuses');
		////////////////////////////////////////////////////////////Own Order ALWAYS EXIST
		$tasks = $tasks->orderBy(request('field'),request('order'));
		////////////////////////////////////////////////////////////Own Filter Loop
		$count = 0;
		foreach($_GET as $key => $value){
		$count++;
			if($count > 4){ //skipping first 4 				
				if(strpos($key, '_t') || strpos($key, '_n') ){
				$tasks = $tasks->where($key,'LIKE', '%'.$value.'%');				
				}				
			}
		}
		////////////////////////////////////////////////////////////Foreign Filters NO -
		if(request('location_id')){ //foreach $_GET if contain _id
            $tasks = $tasks->whereHas('locations',function($query) { $query->where('title','LIKE', '%'.request('location_id').'%');});       
        }
        /////////////////////////////////////////////////////////////Foreign Order
        if(request('field')=='location_id'){
            $tasks = $tasks
            ->join('locations','locations.id','=','tasks.location_id')->select('locations.title as regionName','tasks.*')
            ->orderBy('regionName',request('order'));
        }	
        $tasks = $tasks->paginate(request('perPage'));  
        return response()->json(['rows' => $tasks]);		
    }
	
	
	
	
	public function taskHistory()
    {       
		$tasks = Task::with('locations.clients')
		               ->whereIn('status-id', array(2))
					   ->get();
		return response()
               ->json([ 
			   'rows' => $tasks,			   
			   ]);
		
				
		
    }
    /**/////////////////////////////////////////////////////////////////////////////////////////////2 EDIT
    public function edit($id)
    {        
        $task = $this->br->getTaskById($id); 
        $fieldusers = $this->br->getAllFieldUsers(); 
		$statuses = $this->br->getAllStatuses2();
		$substatuses = $this->br->getAllSubStatuses();
		$alltreatments = Treatment::withTrashed()->get();
        return response()->json([
            'form' => $task, 
            'alltreatments' => $alltreatments,
			'fieldusers' => $fieldusers,
			'statuses' => $statuses,
			'substatuses' => $substatuses,
            ]);         
    }
	public function usertasksEdit($id)
    {        
        
		//get all user tasks id
		$userstasksid = $this->br->getAllUsersTasks()->pluck('id')->toArray();		

		 if(in_array( $id, $userstasksid)){ 
		   
		    $task = $this->br->getTaskById($id); 
		    //$fieldusers = $this->br->getAllFieldUsers(); 
			$statuses = $this->br->getAllStatuses2();
			$substatuses = $this->br->getAllSubStatuses();
			$alltreatments = Treatment::withTrashed()->get();
			
			return response()->json([
				'form' => $task, 
				'alltreatments' => $alltreatments,
				//'fieldusers' => $fieldusers,
				'statuses' => $statuses,
				'substatuses' => $substatuses,
				]);  
		}else{
		  //return redirect('usertasks');
		  return ['created' => 'true'];
		}	 
		
		
    }
	
	
    /**/////////////////////////////////////////////////////////////////////////////////////////////3 CREATE
     public function create()
     {        
        //$fieldusers = User::whereHas("roles", function($q){ $q->where("name", "Field User"); })->get();  
		$statuses = $this->br->getAllStatuses2();
		$alltreatments = Treatment::withTrashed()->get();
		$substatuses = $this->br->getAllSubStatuses();
        return response()->json([
            'form' => '', 
			'alltreatments' => $alltreatments,
			'substatuses' => $substatuses,
			'statuses' => $statuses,
            ]);
     }
    /**/////////////////////////////////////////////////////////////////////////////////////////////4 CREATE POST
    public function store(Request $request)
    {        
        //dd( $request->all() );
        $fv = $this->validate($request, $this->vr->taskUpdate());        
        $task = Task::create(array_merge($request->all(), [
		'user-id' => \Auth::user()->id,		
		]));    
		
        return ['created' => 'true','id' => $task->id];
    }
    /**/////////////////////////////////////////////////////////////////////////////////////////////5 UPDATE POST FROM CRUD
    public function update(Request $request, $id)
    {
        //dd($request->all());       
        $task = $this->br->getTaskById($id);
        $fv = $this->validate($request, $this->vr->taskUpdate()); 
		$task->update(array_merge($request->all(), ['user_id' => \Auth::user()->id ]));
        $array_users = [];
        foreach($request->input('users') as $user){           
            $array_users[] = $user['id'];
        }		
        $task->users()->sync($array_users); 
		
		$task->locations->treatments()->sync($request->input('selectedTreatments'));	    
		
        return ['saved' => 'true','id' => $task->id,'array_users' =>$array_users];        
    }

    /////////////////////////////////////////////////////////////////////////////////////////////5 UPDATE POST FROM CALENDAR
	public function updateFromCalendar(Request $request, $id)
    {
        //dd($request->all());       
        $task = $this->br->getTaskById($id);
        $fv = $this->validate($request, $this->vr->taskUpdateFromCalendar());       
        $task->update($request->all());   
        $array_users = [];
        foreach($request->input('users') as $user){           
            $array_users[] = $user['id'];
        }		
        $task->users()->sync($array_users);  
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
    public function getTasksByDate()
    {
        $date = request('date'); 
		
        //$tasks = Task::with('users')->get();
        //$users = User::with('tasks')->get();
        $allfieldusers = User::with('tasks')
                            ->whereHas("roles", function($q){ $q->where("name", "Field User"); })   
                            ->get();
        $freefieldusers = User::with('tasks')
                            //->whereDoesntHave('tasks') //whereDoesntHave whereHas
                            //->has('tasks')
                            //->doesnthave('tasks')
                            //->whereDoesntHave('tasks')
                            ->whereDoesntHave('tasks', function($q) use($date) {                   
                               $q->where('start_t','LIKE', '%'.$date.'%'); 
                            })
                            ->whereHas("roles", function($q){ $q->where("name", "Field User"); })   
                            ->get();
												
        return response()
            ->json([			
            'freefieldusersCount' => $freefieldusers->count(),
			'freefieldusers' => $freefieldusers,
			'allfieldusers' => $allfieldusers,
			
			]);
    }
	/**///////////////////////////////////////////////////////////////////////////////////////////// CALENDAR
    public function calendar(Request $request)    { 
	
        $unassignedtasks = $this->br->getUnassignedTasks();		  		
		$assignedtasks = $this->br->getAssignedTasks();
		
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
		$todos = Todo::where('user_id', '=', \Auth::user()->id)->get();
		
		$statuses = array();
		
		foreach(Status::all() as $status){			
			$statuses[] = array("title"=>$status->title,"count"=>$this->br->getAllUsersTasksByStatus($status->id)->count());			
		}
		//dd($userstasks);
        return response()->json([            
            'userstasks' => $userstasks,
			'statuses' => $statuses,
			'todos' => $todos,
			
           
        ]);
    }
    
    /**///////////////////////////////////////////////////////////////////////////////////////////// indexFieldUser
    public function indexFieldUser()
    {       
		$statuses = Status::all();
		
		$days = Task::with('locations')                   
         ->whereHas('users',function($query) {                
            $query->where('user_id', '=', \Auth::user()->id);                    
         })
		->whereBetween('start_t', [now(), now()->addDays(60)])
		->orderBy('start_t','asc')		 
		//->get(['status_id','title','start','end'])
		->get()		
		->groupBy(function($date) {
			return Carbon::parse($date->start-t)->format('yy-m-d'); // grouping by years			
		});  
		
		
        return response()
               ->json([ 
               'results' => $days,
               'statuses'=> $statuses,
               //'filterAllStatuses'=> $filterAllStatuses,
               ]);
                
        
    }
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////// updateStatus
	
	 public function updateStatus(Request $request)
    {
	 //dd($request->input('taskid'));
	 
	 if($request->has('taskid') && $request->has('statusid')){	    
		 $task = Task::where('id','=',$request->input('taskid'))->first();
		 //dd($task);
		 $task->status_id = request('statusid');
		 $task->update();
		 $saved = true;
	 }else{
	     $saved = 'problems';
	 }
	 
	 return response()
               ->json([ 
               'saved' => $saved,              
               ]);
	 
	}
	/////////////////////////////////////////////////////////////////////////////////////////////////
	//  http://www.lar-pest-control.test/v1/api/tasks/getfreefieldusersfordate?start=2020-02-17 07:21&end=2020-02-17 15:21
	public function getFreeFieldUsersForDate(){ 
	       $startTime = request('start-t');
		   $endTime = request('end-t');	
           //dd($startTime);
		   $allAvailableFieldUsers = User::with('tasks')
		           ->whereHas("roles", function($q){ $q->where("name", "Field User"); })
					   ->WhereDoesntHave('tasks', function ($q) use ( $startTime, $endTime) {
						$q
						  /*->whereRaw("start_t >= '$startTime' AND start_t < '$endTime'")
						->orwhereRaw("start_t <= '$startTime' AND end_t > '$endTime'")
						->orwhereRaw("end_t > '$startTime' AND end_t <= '$endTime'")
						->orwhereRaw("start_t >= '$startTime' AND end_t <= '$endTime'");*/
                          ->where('start_t', '>=', $startTime)->orwhere('start_t', '<', $endTime)
                        ->orwhere('start_t', '<=', $startTime)->orwhere('end_t', '>', $endTime)
                        ->orwhere('end_t'   ,'>' , $startTime)->orwhere('end_t', '<=', $endTime)    
                        ->orwhere('start_t', '>=', $startTime)->orwhere('end_t', '<=', $endTime); 
                            
                            
						/*->orwhere("start_t <= '$startTime' AND end_t > '$endTime'")
						->orwhere("end_t > '$startTime' AND end_t <= '$endTime'")
						->orwhere("start_t >= '$startTime' AND end_t <= '$endTime'");*/
					})
				   ->get(); 
       
			return response()
               ->json([ 
			   'count'=> $allAvailableFieldUsers->count(),
               'allAvailableFieldUsers' => $allAvailableFieldUsers,               
               ]);	   

    }
	
	

  
}
