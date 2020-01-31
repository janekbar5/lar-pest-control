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
    public function index()
    {      
        
        $locations = $this->br->getLocations(\Auth::user()->id);  
        return response()->json(['results' => $locations]);
    }
    /**/////////////////////////////////////////////////////////////////////////////////////////////2 EDIT
    public function edit($id)
    {        
        $location = $this->br->getLocationsById($id); 
        $alltreatments = Treatment::withTrashed()->get();

        return response()
            ->json([ 'form' => $location,'alltreatments' => $alltreatments ]);   
        
    }
    /**/////////////////////////////////////////////////////////////////////////////////////////////3 CREATE
    public function create()
    {       
       $alltreatments = Treatment::withTrashed()->get();  
       return response()->json([
           'form' => '',
           'alltreatments' => $alltreatments,           
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
        return ['created' => 'true','id' => $property->id];             
    }
   /**/////////////////////////////////////////////////////////////////////////////////////////////5 UPDATE POST
   public function update(Request $request, $id)
   {
       //dd($request->all());
       //$property = Property::findOrFail($id);
       $location = $this->br->getLocationsById($id);
       $fv = $this->validate($request, $this->vr->locationUpdate());       
       $location->update($request->all());   
       
       $address = $this->br->getUserAddressById($type='App\Location',$id);
       $address->update($request->all()['address']);

       $location->treatments()->sync($request->input('selectedTreatments'));
       return ['saved' => 'true','id' => $location->id];        
   }
   /**/////////////////////////////////////////////////////////////////////////////////////////////6 DESTROY   
   public function destroy($id)
   {
       $user = $this->br->getAdminUsersById($id);
       $this->im->destroyAllImages($type='App\User',$id);
       $user->delete();
       return response()
           ->json(['deleted' => true]);
   }
    
    /**/////////////////////////////////////////////////////////////////////////////////////////////
}
