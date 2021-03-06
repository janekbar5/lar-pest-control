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
	public function index()    { 
		$clients = Client::with('locations');		
		////////////////////////////////////////////////////////////Own Filter Loop	
		$this->br->ownFilterLoop($_GET,$clients);		
		////////////////////////////////////////////////////////////Own Order ALWAYS EXIST
		$clients = $clients->orderBy(request('field'),request('order'));		
        /////////////////////////////////////////////////////////////Foreign Order
        if(request('field')=='reccurence_id_n'){
            $clients = $clients
            ->join('reccurences','reccurences.id','=','clients.reccurence_id_n')->select('reccurences.title as regionName','clients.*')
            ->orderBy('regionName',request('order'));
        }	
		
		
        $clients = $clients->paginate(request('perPage'));  
        return response()->json(['rows' => $clients]);		
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
	   $reccurences = Reccurence::all();
       return response()->json([
           'form' => '',
		   'alllocations' => $alllocations,
		   'reccurences' => $reccurences,
           ]);
    }
   /**/////////////////////////////////////////////////////////////////////////////////////////////4 CREATE POST
   public function store(Request $request)
    {
        $fv = $this->validate($request, $this->vr->clientUpdate()); 
        $client = Client::create($request->all());    
        return ['saved' =>'true','id' => $client->id];    
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
		
        return ['saved' =>'true','id' => $client->id];
    }
   /**/////////////////////////////////////////////////////////////////////////////////////////////6 DESTROY   
   public function destroy($id)
   {
       $client = $this->br->getClientById($id);      
       $client->delete();
       return response()
           ->json(['deleted' =>'true']);
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
