<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;
use App\Repositories\ValidationRepository;
use App\Repositories\Interfaces\BackendRepositoryInterface;

class RoleController extends Controller
{
    
    // function __construct()
    // {
    //      $this->middleware('permission:role-list');
    //      $this->middleware('permission:role-create', ['only' => ['create','store']]);
    //      $this->middleware('permission:role-edit', ['only' => ['edit','update']]);
    //      $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    // }
    function __construct(ValidationRepository $vr, BackendRepositoryInterface $br, ImageController $im)
    {        
        $this->middleware('permission:role-list');
        $this->middleware('permission:role-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:role-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:role-delete', ['only' => ['destroy']]);        
        $this->br = $br;
        $this->vr = $vr;
        $this->im = $im;
    }
   /**/////////////////////////////////////////////////////////////////////////////////////////////1 INDEX
   public function index()
   {       
       $roles = $this->br->getAdminRoles();       
       return response()->json(['results' => $roles]);
   }
   /**/////////////////////////////////////////////////////////////////////////////////////////////2 EDIT
   public function edit($id)
   {                      
       $role = $this->br->getAdminRolesById($id);
       $permisions = Role::findByName($role->name)->permissions;
       $role->grantedPermissions = $permisions;
       $role->allPermissions = Permission::all();        
       return response()->json([
           'form' => $role,       
           ]);         
   }
    /**/////////////////////////////////////////////////////////////////////////////////////////////3 CREATE
    public function create()
    {           
    $allpermisions = Permission::all(); 
    $role = new Role();
    $role->grantedPermissions = [];
    $role->allPermissions = Permission::all();
    return response()->json([
        'form' => $role,            
        ]);
    }
    /**/////////////////////////////////////////////////////////////////////////////////////////////4 CREATE POST
    public function store(Request $request)
    {        
        
        $fv = $this->validate($request, $this->vr->permissionUpdate());  
        $role = Role::create(['name' => $request->input('name'),'guard_name' => 'web']);
        if($request->has('grantedPermissions')){            
            $role->syncPermissions($request->input('grantedPermissions'));
        }
        
        return ['created' => 'true','id' => $role->id];
    }
    /**/////////////////////////////////////////////////////////////////////////////////////////////5 UPDATE POST
    public function update(Request $request, $id)
    {       
        $role = $this->br->getAdminRolesById($id);
        $fv = $this->validate($request, $this->vr->permissionUpdate());       
        $role->update(['name' => $request->input('name'),'guard_name' => $request->input('guard_name')]);
        $role->syncPermissions($request->input('grantedPermissions'));
        // $property->inventories()->sync($request->input('selectedInventories'));
        // $property->advantages()->sync($request->input('selectedAdvantages'));
        return ['saved' => 'true','id' => $role->id];        
    }
    /**/////////////////////////////////////////////////////////////////////////////////////////////6 DESTROY 
    public function destroy($id)
    {
        $role = $this->br->getAdminRolesById($id);        
        $role->delete();
        return response()
            ->json(['deleted' => true]);
    }


    
}
