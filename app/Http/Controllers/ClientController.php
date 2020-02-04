<?php

namespace App\Http\Controllers;

use App\Client;
use Illuminate\Http\Request;
use App\Repositories\ValidationRepository;
use App\Repositories\Interfaces\BackendRepositoryInterface;

class ClientController extends Controller
{
    function __construct(ValidationRepository $vr, BackendRepositoryInterface $br, ImageController $im)
    {       
        $this->middleware('permission:client-list');
        $this->middleware('permission:client-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:client-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:client-delete', ['only' => ['destroy']]); 
        $this->br = $br;
        $this->vr = $vr;
        $this->im = $im;
    }    
    /**/////////////////////////////////////////////////////////////////////////////////////////////1 INDEX
    public function index()
    {       
        $clients = $this->br->getClients();       
        return response()->json(['results' => $clients]);
    }
     /**/////////////////////////////////////////////////////////////////////////////////////////////2 EDIT
     public function edit($id)
     {        
           
         $client = $this->br->getClientById($id); 
         return response()
             ->json([ 'form' => $client]);   
         
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
        $fv = $this->validate($request, $this->vr->clientUpdate()); 
        $client = Client::create($request->all());    
        return ['saved' => 'Saved the client info','id' => $client->id];    
    }
   /**/////////////////////////////////////////////////////////////////////////////////////////////5 UPDATE POST
    public function update(Request $request, $id){
        $client = $this->br->getClientById($id);
        $fv = $this->validate($request, $this->vr->clientUpdate());
        $client->update($request->all());         
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
   /**/////////////////////////////////////////////////////////////////////////////////////////////
    public function searchClients()
    {
        $results = Client::orderBy('name')
		    //->with('address')
            ->when(request('q'), function($query) {
                $query->where('name', 'like', '%'.request('q').'%')
                    ->orWhere('last_name', 'like', '%'.request('q').'%')
                    //->orWhere('email', 'like', '%'.request('q').'%')
                    ;
            })
            //->limit(6)
            ->get();

        return response()
            ->json(['results' => $results]);
    }
}
