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
    //////////////////////////////////////////////////////////
    protected $appends = [
        //'color','firstPhoto','extendedProps','textColor',
		//'color','firstPhoto','location','start','end','title'
		'color','firstPhoto','start','end','title'
		//'color','firstPhoto',
    ];	
    function getColorAttribute() { // must be US color !!!
        return $this->statuses->colour;   
    } 
    function getfirstPhotoAttribute()
    {        
        return $this->photos->first();	  
    }
	/* function getLocationAttribute() {
        return $this->locations->id;
    }  */
	function getTitleAttribute() {
        return $this->title_t;
    }
	function getStartAttribute() {
        return $this->start_t;
    }
	function getEndAttribute() {
        return $this->end_t;
    }
		    
    protected $fillable = [
	    'location_id',
        'user_id', 
		'status_id_n',
		'substatus_id_n',
		'price_id_n',
		'title_t',
		'description',
        'comment',
		'price_n',
		'start_t',
		'end_t',
		'last_service_t',
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
        return $this->belongsTo('App\Status', 'status_id_n');		
    }
    /////////////////////////////////////////////////////////////////HASMANY    //    
    public function photos()
    {
        return $this->morphMany('App\Image', 'photoable');
    }
    

   
}
