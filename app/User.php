<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
//jan
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;
//
use OwenIt\Auditing\Contracts\Auditable;
//
use Illuminate\Database\Eloquent\SoftDeletes;
//
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class User extends Authenticatable implements Auditable, Searchable
{
    //use Notifiable;
    use HasRoles, Notifiable;
	use \OwenIt\Auditing\Auditable;  //Audit Log
    use SoftDeletes;
	
	
	protected $fillable = [
        'name', 'email', 'password',
    ];
	
    ////////////////////////////////////////////first photo  Assesors setAttribute
    protected $appends = [
        'firstPhoto','text',
    ];
    function getfirstPhotoAttribute()
    {        
        return $this->photos->first();	  
    }
	//////////////////////////////////////////Soft delete	
    protected $dates = ['deleted_at'];
	////////////////////////////////////////////Multiple search models
    public function getSearchResult(): SearchResult
    {
       $url = route('home.search', $this->id);         
       return new SearchResult($this, $this->name, $url);
    }
     /////////////////////////////////////////////////////////////For typehead search     
     public function getTextAttribute()
     {
         return $this->attributes['name']. ' - '.$this->attributes['last_name'];
     }




    
	
	
	
	

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /////////////////////////////////////////////////////////////////HASMANY    //    
    public function photos()
    {
        return $this->morphMany('App\Image', 'photoable');
    }
	////////////////////////////////////////////////////////////////BELONGSTOMANY PIVOT
    // User-->belongsToMany-->Task   <==>  Task-->belongsToMany-->User
    public function selectedTasks()
    {
        return $this->belongsToMany(Task::class, 'task_user', 'task_id', 'user_id');
    }

	
	
	
	
	
	
	
    ////////////////////////////////////////////////Vue Permissions
    public function getAllPermissionsAttribute() {
        $permissions = [];
          foreach (Permission::all() as $permission) {
            if (Auth::user()->can($permission->name)) {
              $permissions[] = $permission->name;
            }
          }
          return $permissions;
      }
	////////////////////////////////////////////////Vue Roles
	 public function getAllRolesAttribute() {       
        return Auth::user()->getRoleNames();
    }

}
