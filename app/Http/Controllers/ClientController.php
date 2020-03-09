<?php

namespace App\Http\Controllers;

use App\{Client,Reccurence};
use Illuminate\Http\Request;
use App\Repositories\ValidationRepository;
use App\Repositories\Interfaces\BackendRepositoryInterface;

class ClientController extends Controller
{
    function __construct(ValidationRepository $vr, BackendRepositoryInterface $br, ImageController $im)
    {       
        $this->middleware('permission:client-list',['only' => ['index']]);
        $this->middleware('permission:client-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:client-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:client-delete', ['only' => ['destroy']]); 
        $this->br = $br;
        $this->vr = $vr;
        $this->im = $im;
    }    
    /**/////////////////////////////////////////////////////////////////////////////////////////////1 INDEX
    
	public function index(Request $request)
    {      
		 $clients = Client::query();
		///////////////////////foreighn
		if(request('country')){
            $clients = $clients->whereHas('countries',function($query) { $query->where('title','LIKE', '%'.request('country').'%');});       
        }
		if(request('city')){
            $clients = $clients->whereHas('cities',function($query) { $query->where('title','LIKE', '%'.request('city').'%');});       
        }
		if(request('attractiontype')){
            $clients = $clients->whereHas('attractiontypes',function($query) { $query->where('title','LIKE', '%'.request('attractiontype').'%');});       
        } 
		/////////////////Own Sorting
		if(request('field')=='id'){
            $clients = $clients->orderBy(request('field'),request('sort'));           
        }
		if(request('field')=='active'){
            $clients = $clients->orderBy(request('field'),request('sort'));           
        }
        if(request('field')=='name'){
            $clients = $clients->orderBy(request('field'),request('sort'));           
        }
        if(request('field')=='email'){
            $clients = $clients->orderBy(request('field'),request('sort'));           
        }
        if(request('field')=='phone'){
            $clients = $clients->orderBy(request('field'),request('sort'));           
        }
		if(request('field')=='person_name'){
            $clients = $clients->orderBy(request('field'),request('sort'));           
        }
		if(request('field')=='contract_number'){
            $clients = $clients->orderBy(request('field'),request('sort'));           
        }
		if(request('field')=='vat_number'){
            $clients = $clients->orderBy(request('field'),request('sort'));           
        }
		if(request('field')=='contract_start'){
            $clients = $clients->orderBy(request('field'),request('sort'));           
        }
		if(request('field')=='contract_end'){
            $clients = $clients->orderBy(request('field'),request('sort'));           
        } 
		/////////////////Own Filter
		if(request('contract_start')){
            $clients = $clients->where('contract_start','LIKE', '%'.request('contract_start').'%');       
        }
		if(request('contract_end')){
            $clients = $clients->where('contract_end','LIKE', '%'.request('contract_end').'%');       
        }
		/* if(request('active') == 0 || request('active') == 1){
            $clients = $clients->where('active','=',request('active'));
        } */
        if(request('active')){
            $clients = $clients->where('active','=',request('active'));
        }
        //////////////Sorting foreign
        /* if(request('field')=='country'){
            $clients = $clients
            ->join('countries','countries.id','=','clients.country_id')->select('countries.title as regionName','clients.*')
            ->orderBy('regionName',request('sort'));
        }
        if(request('field')=='city'){
            $clients = $clients
            ->join('cities','cities.id','=','clients.city_id')->select('cities.title as regionName','clients.*')
            ->orderBy('regionName',request('sort'));
        }
        if(request('field')=='attractiontype'){
            $clients = $clients
            ->join('attraction_types','attraction_types.id','=','clients.attractiontype_id')->select('attraction_types.title as regionName','clients.*')
            ->orderBy('regionName',request('sort'));
        } */
        
        $clients = $clients->paginate(request('perPage'));  
        return response()->json(['results' => $clients]);
    }
     /**/////////////////////////////////////////////////////////////////////////////////////////////2 EDIT
     public function edit($id)
     {    
         $client = $this->br->getClientById($id); 
		 $alllocations = $this->br->getAllLocations();
		 $reccurences = Reccurence::all();
         return response()
             ->json([ 
			 'form' => $client,
			 'alllocations' => $alllocations,
			 'reccurences' => $reccurences,
			 
			 ]);   
         
     }
     /**/////////////////////////////////////////////////////////////////////////////////////////////3 CREATE
    public function create()
    {       
       $alllocations = $this->br->getAllLocations();
       return response()->json([
           'form' => '',
		   'alllocations' => $alllocations,
           ]);
    }
   /**/////////////////////////////////////////////////////////////////////////////////////////////4 CREATE POST
   public function store(Request $request)
    {
        $fv = $this->validate($request, $this->vr->clientUpdate()); 
        $client = Client::create($request->all());    
        return ['saved' => 'Saved the client info','id' => $client->id];    
    }
   /**/////////////////////////////////////////////////////////////////////////////////////////////5 UPDATE POST
    public function update(Request $request, $id){
        $client = $this->br->getClientById($id);
        $fv = $this->validate($request, $this->vr->clientUpdate());
        $client->update($request->all());   
		///
		$array_locations = [];
        foreach($request->input('locations') as $location){           
            $array_locations[] = $location['id'];
        }		
        $client->locations()->sync($array_locations);
		
        return ['saved' => 'Saved the client info','id' => $client->id];
    }
   /**/////////////////////////////////////////////////////////////////////////////////////////////6 DESTROY   
   public function destroy($id)
   {
       $client = $this->br->getClientById($id);      
       $client->delete();
       return response()
           ->json(['deleted' => true]);
   }
    /**/////////////////////////////////////////////////////////////////////////////////////////////7 SEARCH CLIENTS
    public function searchClients()
    {
        $results = Client::orderBy('company_name')
		    //->with('address')
            ->when(request('q'), function($query) {
                $query->where('company_name', 'like', '%'.request('q').'%')				        
					  ->orWhere('person_name', 'like', '%'.request('q').'%')
                      ->orWhere('email', 'like', '%'.request('q').'%');
                      //->orWhere('email', 'like', '%'.request('q').'%')
                    
            })
            //->limit(6)
            ->get();

        return response()
            ->json(['results' => $results]);
    }
}
