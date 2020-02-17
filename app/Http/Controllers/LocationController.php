<?php

namespace App\Http\Controllers;

use App\Location;
use App\Treatment;
use Illuminate\Http\Request;
use App\Repositories\ValidationRepository;
use App\Repositories\Interfaces\BackendRepositoryInterface;

class LocationController extends Controller
{
    function __construct(ValidationRepository $vr, BackendRepositoryInterface $br, ImageController $im)
    {       
        $this->middleware('permission:location-list');
        $this->middleware('permission:location-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:location-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:location-delete', ['only' => ['destroy']]); 
        $this->br = $br;
        $this->vr = $vr;
        $this->im = $im;
    }    
    /**/////////////////////////////////////////////////////////////////////////////////////////////1 INDEX
    public function index(Request $request)
    {       
		
	    $locations = Location::with(['address','clients'])->get();
		return response()
               ->json([ 
			   'rows' => $locations,			   
			   ]);	   
				
		
    }
    /**/////////////////////////////////////////////////////////////////////////////////////////////2 EDIT
    public function edit($id)
    {        
        $location = $this->br->getLocationsById($id); 
        $alltreatments = Treatment::withTrashed()->get();
        $allclients = $this->br->getAllClients();
        return response()
               ->json([ 
			   'form' => $location,
			   'address' => $location->address,
			   'alltreatments' => $alltreatments,
			   'allclients' => $allclients,
			   ]);   
        
    }
    /**/////////////////////////////////////////////////////////////////////////////////////////////3 CREATE
    public function create()
    {       
       $alltreatments = Treatment::withTrashed()->get();  
	   $allclients = $this->br->getAllClients();
       return response()->json([
           'form' => '',
           'alltreatments' => $alltreatments, 
		   'allclients' => $allclients,
           ]);
    }
   /**/////////////////////////////////////////////////////////////////////////////////////////////4 CREATE POST
   public function store(Request $request)
    {       
        //dd($request->all());
        $fv = $this->validate($request, $this->vr->locationUpdate());        
        $location = Location::create(array_merge($request->all(), ['user_id' => \Auth::user()->id]));
		
        if($request->has('selectedTreatments')){
            $location->treatments()->sync($request->input('selectedTreatments'));
        }       
        return ['created' => 'true','id' => $location->id];             
    }
   /**/////////////////////////////////////////////////////////////////////////////////////////////5 UPDATE POST
   public function update(Request $request, $id)
   {
       //dd($request->all()['clients']['id']);
	   //dd($request->all());
       //$property = Property::findOrFail($id);
       $location = $this->br->getLocationsById($id);
       $fv = $this->validate($request, $this->vr->locationUpdate());       
       
       $location->update($request->all());
       //$location->update(array_merge($request->all(), ['client_id' => $request->all()['clients']['id']]));
       
       $address = $this->br->getUserAddressById($type='App\Location',$id);
       $address->update($request->all()['address']);
       
      
	  /* aleady made in vue script in objectToArray()
	  "selectedTreatments" => array:3 [
		0 => 2
		1 => 6
		2 => 10
	  ] */	  
       $location->treatments()->sync($request->input('selectedTreatments'));
	   
	   
	   //////////here we do the same but in php
	   $array_clients = [];
        foreach($request->input('clients') as $client){           
            $array_clients[] = $client['id'];
        }		
        $location->clients()->sync($array_clients);	
		
		
       
       return ['saved' => 'true','id' => $location->id];        
   }
   /**/////////////////////////////////////////////////////////////////////////////////////////////6 DESTROY   
   public function destroy($id)
   {
       $location = $this->br->getLocationsById($id);
       $this->im->destroyAllImages($type='App\User',$id);
       $location->delete();
       return response()
           ->json(['deleted' => true]);
   }
    
   /**/////////////////////////////////////////////////////////////////////////////////////////////FILTER
    public function filter(Request $request)
    {      
       
	   $locations_pre = Location::
								select('locations.*')
								->orderBy('created_at', 'desc');								
	    if ($request->input('loc'))
        {
            $locations_pre = $locations_pre->where('client_id', '=', $request->input('loc'));			
        }		
				
		$total = $locations_pre->get()->count();		
		return $locations_pre->paginate($request->input('perpage'));		 	
		
    }
	/**/////////////////////////////////////////////////////////////////////////////////////////////7 SEARCH LOCATIONS
    public function searchLocations()
    {
        $results = Location::with('treatments')->orderBy('title')		    
            ->when(request('q'), function($query) {
                $query->where('title', 'like', '%'.request('q').'%')				        
					  //->orWhere('person_name', 'like', '%'.request('q').'%')
                      //->orWhere('email', 'like', '%'.request('q').'%')
					  ;                   
                    
        })            
        ->get();

        return response()
            ->json(['results' => $results]);
    }
}
