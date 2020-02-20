<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//
use Spatie\Searchable\Search;
use App\{User,Treatment,Location,Client,Task};

use App\Repositories\ValidationRepository;
use App\Repositories\Interfaces\BackendRepositoryInterface;
use Carbon\Carbon;

class HomeController extends Controller
{
    function __construct(ValidationRepository $vr, BackendRepositoryInterface $br, ImageController $im)
    {       
        //$this->middleware('permission:treatment-list');
        //$this->middleware('permission:treatment-create', ['only' => ['create', 'store']]);
        //$this->middleware('permission:treatment-edit', ['only' => ['edit', 'update']]);
        //$this->middleware('permission:treatment-delete', ['only' => ['destroy']]); 
        $this->br = $br;
        $this->vr = $vr;
        $this->im = $im;
    }   
	/////////////////////////////////////////////////////////////////////////////////////////////////GLOBAL SETTINGS
	public function globalsettings()
    {
        $treatments = $this->br->getAllTreatments();
		$statuses = $this->br->getAllStatuses();  
		$substatuses = $this->br->getAllSubStatuses(); 
		
        return response()->json([
		'treatments' => $treatments,
		'statuses' => $statuses,
		'substatuses' => $substatuses,
		]);
    }
   
	public function index()
    {
        return view('home');
    }
	
    /////////////////////////////////////////////////////////////////////////////////////////////////MAIN SEARCH BOX
    public function searchBox()
    {
        $input = request('q');
		if($input != '' || $input != null){
			$results = (new Search())
			->registerModel(User::class, ['name', 'email'])
			->registerModel(Treatment::class, ['title'])
			->registerModel(Location::class, ['title'])	
			->registerModel(Client::class, ['name'])	
			->search($input);  
		}	
		return response()->json(['results' => $results]);
			
    }
    /////////////////////////////////////////////////////////////////////////////////////////////////Load statistics
    public function loadStatistics()
    {        		
		
		$unassignedtasks = $this->br->getUnassignedTasksForPeriod(request('start'),request('end'));				   
		$assignedtasks = $this->br->getAssignedTasksForPeriod(request('start'),request('end'));					   
      

		return response()->json([
			//'dueTasksCount' => $dueTasks->count(),
			'unassignedtasks' => $unassignedtasks,
			//'unassignedtasksCount' => $unassignedtasks->sum("price"),
			'unassignedtasksCount' => $unassignedtasks->count(),
			'assignedtasks' => $assignedtasks,
			'assignedtasksCount' => $assignedtasks->count(),
		]);			
    }
    /**///////////////////////////////////////////////////////////////////////////////////////////// ADMINCALENDAR
    public function adminCalendar()    {       
        $assignedtasks = $this->br->getAssignedTasksForPeriod(request('start'),request('end'));	
        /* $assignedtasks =  Task::where('start', '>=', request('start'))
                  ->where('end', '<', request('end'))
                  ->with('locations')
                  ->with('statuses')                    
                  ->get();  */
        return response()->json([  
            'assignedtasks' => $assignedtasks, 
        ]);
    }
    
}
