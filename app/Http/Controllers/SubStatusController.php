<?php

namespace App\Http\Controllers;

use App\SubStatus;
use App\Status;
use Illuminate\Http\Request;
use App\Repositories\ValidationRepository;
use App\Repositories\Interfaces\BackendRepositoryInterface;

class SubStatusController extends Controller
{
    function __construct(ValidationRepository $vr, BackendRepositoryInterface $br, ImageController $im)
    {       
        $this->middleware('permission:substatus-list');
        $this->middleware('permission:substatus-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:substatus-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:substatus-delete', ['only' => ['destroy']]); 
        $this->br = $br;
        $this->vr = $vr;
        $this->im = $im;
    }    
    /**/////////////////////////////////////////////////////////////////////////////////////////////1 INDEX
    public function index()
    {       
        $substatuses = $this->br->getAllSubStatuses();       
        return response()->json(['results' => $substatuses]);
    }
     /**/////////////////////////////////////////////////////////////////////////////////////////////2 EDIT
     public function edit($id)     {        
          
         $substatus = $this->br->getSubStatusesById($id);
         $allstatuses = $this->br->getAllStatuses(); 
         return response()
             ->json([
                 'form' => $substatus,
                 'allstatuses' => $allstatuses, 
                 ]);   
         
     }
     /**/////////////////////////////////////////////////////////////////////////////////////////////3 CREATE
    public function create()
    {       
        $allstatuses = $this->br->getAllStatuses(); 
       return response()->json([
           'form' => '',
           'allstatuses' => $allstatuses,                 
           ]);
    }
   /**/////////////////////////////////////////////////////////////////////////////////////////////4 CREATE POST
   public function store(Request $request)
    {
        $fv = $this->validate($request, $this->vr->substatusUpdate()); 
        $status = SubStatus::create($request->all());    
        return ['saved' => 'Saved the status info','id' => $status->id];    
    }
   /**/////////////////////////////////////////////////////////////////////////////////////////////5 UPDATE POST
    public function update(Request $request, $id){
        $substatus = $this->br->getSubStatusesById($id);
        $fv = $this->validate($request, $this->vr->substatusUpdate());
        $substatus->update($request->all());         
        return ['saved' => 'Saved the status info','id' => $substatus->id];
    }
   /**/////////////////////////////////////////////////////////////////////////////////////////////6 DESTROY   
   public function destroy($id)
   {
       $substatus = $this->br->getSubStatusesById($id);      
       $substatus->delete();
       return response()
           ->json(['deleted' => true]);
   }
}
