<?php

namespace App\Http\Controllers;

use App\Treatment;
use Illuminate\Http\Request;
use App\Repositories\ValidationRepository;
use App\Repositories\Interfaces\BackendRepositoryInterface;

class TreatmentController extends Controller
{
    function __construct(ValidationRepository $vr, BackendRepositoryInterface $br, ImageController $im)
    {       
        $this->middleware('permission:treatment-list');
        $this->middleware('permission:treatment-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:treatment-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:treatment-delete', ['only' => ['destroy']]); 
        $this->br = $br;
        $this->vr = $vr;
        $this->im = $im;
    }    

    /**/////////////////////////////////////////////////////////////////////////////////////////////1 INDEX
    public function index()    {       
       $treatments = Treatment::query();
		////////////////////////////////////////////////////////////Own Order ALWAYS EXIST
		$treatments = $treatments->orderBy(request('field'),request('order'));
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
        $treatments = $treatments->paginate(request('perPage'));  
        return response()->json(['rows' => $treatments]);
    }
    /**/////////////////////////////////////////////////////////////////////////////////////////////2 EDIT
    public function edit($id)
    {        
        $treatment = $this->br->getTreatmentById($id);           
        return response()->json([
            'form' => $treatment,           
            ]);         
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
        //dd($request->all());
        $fv = $this->validate($request, $this->vr->treatmentUpdate());        
        $treatment = Treatment::create(array_merge($request->all(), ['user_id' => \Auth::user()->id]));        
        return ['created' => 'true','id' => $treatment->id];
    }
    /**/////////////////////////////////////////////////////////////////////////////////////////////5 UPDATE POST
    public function update(Request $request, $id)
    {
        //dd($request->all());
        //$property = Property::findOrFail($id);
        $treatment = $this->br->getTreatmentById($id);
        $fv = $this->validate($request, $this->vr->treatmentUpdate());       
        $treatment->update($request->all());      
        return ['saved' => 'true','id' => $treatment->id];        
    }
    /**/////////////////////////////////////////////////////////////////////////////////////////////6 DESTROY 
    public function destroy($id)
    {
        $treatment = $this->br->getTreatmentById($id);        
        $treatment->delete();
        return response()
            ->json(['deleted' => true]);
    }
}
