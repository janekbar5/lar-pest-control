<?php

namespace App\Http\Controllers;

use App\Status;
use Illuminate\Http\Request;
use App\Repositories\ValidationRepository;
use App\Repositories\Interfaces\BackendRepositoryInterface;


class StatusController extends Controller
{
    function __construct(ValidationRepository $vr, BackendRepositoryInterface $br, ImageController $im)
    {       
        $this->middleware('permission:status-list');
        $this->middleware('permission:status-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:status-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:status-delete', ['only' => ['destroy']]); 
        $this->br = $br;
        $this->vr = $vr;
        $this->im = $im;
    }    
    /**/////////////////////////////////////////////////////////////////////////////////////////////1 INDEX
    public function index()
    {       
        $statuses = Status::query();
		////////////////////////////////////////////////////////////Own Order ALWAYS EXIST
		$statuses = $statuses->orderBy(request('field'),request('order'));
		////////////////////////////////////////////////////////////Own Filter Loop
		/* $count = 0;
		foreach($_GET as $key => $value){
		$count++;
			if($count > 2){ //skipping first 2 and last 2 only filters needed
				if($key=='perPage' || $key=='page'){
				}elseif(strpos($key, '-')){
				$statuses = $statuses->where($key,'LIKE', '%'.$value.'%');				
				}				
			}
		} */
		////////////////////////////////////////////////////////////Foreign Filters
		/* if(request('location_id')){
            $statuses = $statuses->whereHas('locations',function($query) { $query->where('title','LIKE', '%'.request('location_id').'%');});       
        } */
        /////////////////////////////////////////////////////////////Foreign Order
       /*  if(request('field')=='location_id'){
            $statuses = $statuses
            ->join('locations','locations.id','=','statuses.location_id')->select('locations.title as regionName','statuses.*')
            ->orderBy('regionName',request('order'));
        }	 */
        $statuses = $statuses->paginate(request('perPage'));  
        return response()->json(['rows' => $statuses]);
    }
     /**/////////////////////////////////////////////////////////////////////////////////////////////2 EDIT
     public function edit($id)
     {        
         //$user = $this->br->getAdminUsersById($id);   
         $status = $this->br->getStatusesById($id); 
         return response()
             ->json([ 'form' => $status]);   
         
     }
     /**/////////////////////////////////////////////////////////////////////////////////////////////3 CREATE
    public function create()
    {       
       
       return response()->json([
           'form' => '',                
           ]);
    }
   /**/////////////////////////////////////////////////////////////////////////////////////////////4 CREATE POST
   public function store(Request $request)
    {
        $fv = $this->validate($request, $this->vr->statusUpdate()); 
        $status = Status::create($request->all());    
        return ['created' => 'true','id' => $status->id];    
    }
   /**/////////////////////////////////////////////////////////////////////////////////////////////5 UPDATE POST
    public function update(Request $request, $id){
        $status = $this->br->getStatusesById($id);
        $fv = $this->validate($request, $this->vr->statusUpdate());
        $status->update($request->all());         
        return ['saved' => 'true','id' => $status->id];
    }
   /**/////////////////////////////////////////////////////////////////////////////////////////////6 DESTROY   
   public function destroy($id)
   {
       $status = $this->br->getStatusesById($id);      
       $status->delete();
       return response()
           ->json(['deleted' => true]);
   }

    
}
