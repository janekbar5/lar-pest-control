<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
//jan
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    //use Notifiable;
    use HasRoles, Notifiable;
    
    ////////////////////////////////////////////first photo  Assesors setAttribute
    protected $appends = [
        'firstPhoto',
    ];
    function getfirstPhotoAttribute()
    {        
        return $this->photos->first();	  
    }




    protected $fillable = [
        'name', 'email', 'password',
    ];

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

}
