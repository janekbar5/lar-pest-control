<?php

namespace App\Http\Controllers;

use App\Todo;
use Illuminate\Http\Request;
use App\Repositories\ValidationRepository;
use App\Repositories\Interfaces\BackendRepositoryInterface;


class TodoController extends Controller
{
    function __construct(ValidationRepository $vr, BackendRepositoryInterface $br, ImageController $im)
    {       
        $this->middleware('permission:user-list',['only' => ['index']]);
        $this->middleware('permission:user-create', ['only' => ['create', 'store']]);
		$this->middleware('permission:user-edit', ['only' => ['edit', 'update']]);
		$this->middleware('permission:user-delete', ['only' => ['destroy']]); 
		$this->middleware('permission:user-usersettings', ['only' => ['userSettings','updateSettings']]);
		
        $this->br = $br;
        $this->vr = $vr;
        $this->im = $im;
    }  
	/**/////////////////////////////////////////////////////////////////////////////////////////////1 INDEX
    public function index()
    {       
        $todos = Todo::with('users')->orderBy('id', 'desc')->get(); 
        $fieldusers = $this->br->getAllFieldUsers();
		
        return response()->json([
		'todos' => $todos,
		'fieldusers' => $fieldusers
		]);
    }
	/**/////////////////////////////////////////////////////////////////////////////////////////////3 CREATE
    public function create()
    {       
       $todos = Todo::with('users')->get(); 
       return response()->json([
           'form' => '',
           'allroles' => $allroles,           
           ]);
    }
	/**/////////////////////////////////////////////////////////////////////////////////////////////4 CREATE POST
    public function store(Request $request)
    {        
        //dd($request->all());
        $fv = $this->validate($request, $this->vr->todoUpdate());        
        $treatment = Todo::create($request->all());        
        return ['created' => 'true','id' => $treatment->id];
    }
    /**/////////////////////////////////////////////////////////////////////////////////////////////5 UPDATE POST
    public function update(Request $request, $id)
    {
        //dd($request->all());
        $todo = $this->br->getTodoById($id);
        $fv = $this->validate($request, $this->vr->todoUpdate());       
        $todo->update($request->all());      
        return ['saved' => 'true','id' => $todo->id];        
    }
	/**/////////////////////////////////////////////////////////////////////////////////////////////6 DESTROY 
    public function destroy($id)
    {
        //$todo = $this->br->getTodoById($id);   
		$todo = Todo::where('id', '=', $id)->first();
        $todo->delete();
        return response()
            ->json(['deleted' => true]);
    }
	
    
}
