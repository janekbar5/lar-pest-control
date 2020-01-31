<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;
use App\Repositories\ValidationRepository;
use App\Repositories\Interfaces\BackendRepositoryInterface;


class TaskController extends Controller
{
    
     function __construct(ValidationRepository $vr, BackendRepositoryInterface $br, ImageController $im)
    {       
        $this->middleware('permission:task-list');
        $this->middleware('permission:task-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:task-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:task-delete', ['only' => ['destroy']]); 
        $this->br = $br;
        $this->vr = $vr;
        $this->im = $im;
    }    

    /**/////////////////////////////////////////////////////////////////////////////////////////////1 INDEX
    public function index()    {       
        $tasks = $this->br->getAllTasks();       
        return response()->json(['results' => $tasks]);
    }
    /**/////////////////////////////////////////////////////////////////////////////////////////////2 EDIT
    public function edit($id)
    {        
        $task = $this->br->getTaskById($id);           
        return response()->json([
            'form' => $task,           
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
        $fv = $this->validate($request, $this->vr->taskUpdate());        
        $task = Task::create(array_merge($request->all(), ['user_id' => \Auth::user()->id]));        
        return ['created' => 'true','id' => $task->id];
    }
    /**/////////////////////////////////////////////////////////////////////////////////////////////5 UPDATE POST
    public function update(Request $request, $id)
    {
        //dd($request->all());
        //$property = Property::findOrFail($id);
        $task = $this->br->getTaskById($id);
        $fv = $this->validate($request, $this->vr->taskUpdate());       
        $task->update($request->all());      
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

  
}
