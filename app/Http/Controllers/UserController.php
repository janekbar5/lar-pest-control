<?php



namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use App\Repositories\ValidationRepository;
use App\Repositories\Interfaces\BackendRepositoryInterface;

class UserController extends Controller

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
        $users = User::query();
		$this->br->ownFilterLoop($_GET,$users);
		$users = $users->orderBy(request('field'),request('order'));
		
		$users = $users->paginate(request('perPage'));  
        return response()->json(['rows' => $users]);
    }
    /**/////////////////////////////////////////////////////////////////////////////////////////////2 EDIT
    public function edit($id)
    {        
        //$user = $this->br->getAdminUsersById($id);   
        $user = User::with('roles')->findOrFail($id);
        $allroles = Role::all();
        return response()
            ->json([ 'form' => $user,'allroles' => $allroles->toArray(['name']) ]);   
        
    }
    /**/////////////////////////////////////////////////////////////////////////////////////////////3 CREATE
    public function create()
    {       
       $allroles = Role::all();  
       return response()->json([
           'form' => '',
           'allroles' => $allroles,           
           ]);
    }
   /**/////////////////////////////////////////////////////////////////////////////////////////////4 CREATE POST
   public function store(Request $request)
    {
        $fv = $this->validate($request, $this->vr->newAdminUsers());        
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $user = User::create($input);       
        foreach($request->input('roles') as $role){ 
            $user->assignRole($role['name']);
        }  
        return ['saved' => 'Saved the user info','id' => $user->id];
        
        
    }
   /**/////////////////////////////////////////////////////////////////////////////////////////////5 UPDATE POST
    public function update(Request $request, $id){
	// dd($request->all());
    $user = User::findOrFail($id);    
	$fv = $this->validate($request, $this->vr->newAdminUsers());
   
	$user->update(array_merge($request->all(), ['password' => bcrypt($request->input('password'))]));
	
    DB::table('model_has_roles')->where('model_id', $id)->delete();       
    foreach($request->input('roles') as $role){ 
        $user->assignRole($role['name']);
    }   
		return ['saved' => 'true','id' => $user->id];
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
	/**/////////////////////////////////////////////////////////////////////////////////////////////7 SEARCH Users
    public function searchUsers()
    {
        $results = User::orderBy('name')		    
            ->when(request('q'), function($query) {
                $query->where('name', 'like', '%'.request('q').'%')				        
					  ->orWhere('last_name', 'like', '%'.request('q').'%')
                      //->orWhere('email', 'like', '%'.request('q').'%')			  

					  ;                   
                    
        })            
        ->get();

        return response()
            ->json(['results' => $results]);
    }
	
	/////////////////////////////////////////////////////////////////////////////////////////////////////Filter users
    public function filterUsers()
    {     		
		$users = User::with('roles')->get();
		return response()
               ->json([ 
			   'results' => $users,			   
			   ]);
    }
	/////////////////////////////////////////////////////////////////////////////////////////////////////// userSettings
	
	public function userSettings()
    {     		
		$user = User::with('roles','photos')->where('id','=',\Auth::user()->id)->first();
		return response()
               ->json([ 
			   'results' => $user,			   
			   ]);
    }
	public function updateSettings(Request $request, $id){
    $user = User::findOrFail($id);
    $this->validate($request,[
        'name' => 'required|string|max:191',           
        'email' => 'required|string|email|max:191|unique:users,email,'.$user->id,
        //'password' => 'sometimes|min:6',
		//'password' => 'required|confirm_password|min:6',
		'password' => 'min:6|required_with:confirm_password|same:confirm_password',
		'confirm_password' => 'min:6',
        'roles' => 'required'
    ]);
    //$user->update($request->all());
	$user->update(array_merge($request->all(), ['password' => bcrypt($request->input('password'))]));
	
    DB::table('model_has_roles')->where('model_id', $id)->delete();       
    foreach($request->input('roles') as $role){ 
        $user->assignRole($role['name']);
    }      
		return ['saved' => 'Saved the user info','id' => $user->id];
	}

    

}