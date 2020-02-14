<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//
use OwenIt\Auditing\Contracts\Auditable;
//
use Illuminate\Database\Eloquent\SoftDeletes;
//
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;


class Task extends Model implements Auditable, Searchable
{
    use \OwenIt\Auditing\Auditable;  //Audit Log
	use SoftDeletes;
    
   
    
    //////////////////////////////////////////Soft delete	
    protected $dates = ['deleted_at'];
	////////////////////////////////////////////Multiple search models
    public function getSearchResult(): SearchResult
    {
       $url = route('home.search', $this->id);         
       return new SearchResult($this, $this->company_name, $url);
    }
    //////////////////////////////////////////
    protected $appends = [
        //'color','firstPhoto','extendedProps','textColor',
		//'color','firstPhoto',
    ];
	
    function getColorAttribute() {
        return $this->statuses->colour;   
    }
    function getfirstPhotoAttribute()
    {        
        return $this->photos->first();	  
    }
	
	
	
	
	/* function getextendedPropsAttribute()
    {        
        return [            
            'department' => 'BioChemistry',            
        ];	  
    } */
	
	
	/* function gettextColorAttribute()
    {        
        return '#ffffff';	  
    } */

    
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
    public function users()
    {
        //return $this->belongsToMany(User::class, 'task_user', 'task_id', 'user_id');
        return $this->belongsToMany(User::class);
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
