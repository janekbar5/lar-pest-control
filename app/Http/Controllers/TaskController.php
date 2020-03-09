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
    /* public function index()    {       
        $tasks = $this->br->getAllTasks();       
        return response()->json(['results' => $tasks]);
       
    } */
	public function index()    {       
		
		$tasks = Task::with('photos');
		////////////////////////////////////////////////////////////Own Order ALWAYS EXIST
		$tasks = $tasks->orderBy(request('field'),request('order'));
		////////////////////////////////////////////////////////////Own Filter Loop
		$count = 0;
		foreach($_GET as $key => $value){
		$count++;
			if($count > 2){ //skipping first 2 and last 2 only filters needed
				if($key=='perPage' || $key=='page'){
				}elseif(strpos($key, '-')){
				$tasks = $tasks->where($key,'LIKE', '%'.$value.'%');				
				}				
			}
		}
		////////////////////////////////////////////////////////////Foreign Filters
		if(request('location_id')){
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
		               ->whereIn('status_id', array(2))
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
		'user_id' => \Auth::user()->id,		
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
                               $q->where('start','LIKE', '%'.$date.'%'); 
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
		  //$assignedtasks = $this->br->getAssignedFilteredTasks($request->input('location'));		
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
		->whereBetween('start', [now(), now()->addDays(60)])
		->orderBy('start','asc')		 
		//->get(['status_id','title','start','end'])
		->get()		
		->groupBy(function($date) {
			return Carbon::parse($date->start)->format('yy-m-d'); // grouping by years			
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
               //'statuses'=> $statuses,
               //'filterAllStatuses'=> $filterAllStatuses,
               ]);
	 
	}
	/////////////////////////////////////////////////////////////////////////////////////////////////
	//  http://www.lar-pest-control.test/v1/api/tasks/getfreefieldusersfordate?start=2020-02-17 07:21&end=2020-02-17 15:21
	public function getFreeFieldUsersForDate(){ 
	      $startTime = request('start');
		  $endTime = request('end');
		 
		   $allAvailableFieldUsers =	User::with('tasks')
		           ->whereHas("roles", function($q){ $q->where("name", "Field User"); })   
				       /* ->WhereDoesntHave('tasks', function($q) {
					   $q->where('start','>=', request('start'))->where('end','<=', request('end'));					   
				       }) */
					   ->WhereDoesntHave('tasks', function ($q) use ( $startTime, $endTime) {
						$q
						->whereRaw("start >= '$startTime' AND start < '$endTime'")
						->orwhereRaw("start <= '$startTime' AND end > '$endTime'")
						->orwhereRaw("end > '$startTime' AND end <= '$endTime'")
						->orwhereRaw("start >= '$startTime' AND end <= '$endTime'")
						;
					})
				   ->get(); 
			return response()
               ->json([ 
			   'count'=> $allAvailableFieldUsers->count(),
               'allAvailableFieldUsers' => $allAvailableFieldUsers,
               //'statuses'=> $statuses,
               //'filterAllStatuses'=> $filterAllStatuses,
               ]);	   

    }
	
	

  
}
