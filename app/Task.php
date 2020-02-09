<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Task extends Model
{
    use SoftDeletes;
    
   
    
    //////////////////////////////////////////
    protected $dates = ['deleted_at'];    
    //////////////////////////////////////////
    protected $appends = [
        'color','firstPhoto','extendedProps','textColor',
    ];
	
    function getColorAttribute() {
        return $this->statuses->colour;   
    }
    function getfirstPhotoAttribute()
    {        
        return $this->photos->first();	  
    }
	function getextendedPropsAttribute()
    {        
        return [            
            'department' => 'BioChemistry',            
        ];	  
    }
	function gettextColorAttribute()
    {        
        return '#ffffff';	  
    }

    
    protected $fillable = [
	    'location_id',
        'user_id', 
		'status_id',
		'price_id',
		'title',
		'description',
        'comment',		
        'deadline',
		'price',
		'start',
		'end',
    ];
    ////////////////////////////////////////////////////////////////BELONGSTOMANY PIVOT
    // User-->belongsToMany-->Task   <==>  Task-->belongsToMany-->User
    public function selectedUsers()
    {
        return $this->belongsToMany(User::class, 'task_user', 'task_id', 'user_id');
    }
    ////////////////////////////////////////////////////////////////belongsTo
    // Task-->belongsTo-->Location   <==>  Location-->hasMany-->Task
    public function locations()
    {
        return $this->belongsTo('App\Location', 'location_id');		
    }
    public function statuses()
    {
        return $this->belongsTo('App\Status', 'status_id');		
    }
    /////////////////////////////////////////////////////////////////HASMANY    //    
    public function photos()
    {
        return $this->morphMany('App\Image', 'photoable');
    }
    

   
}
