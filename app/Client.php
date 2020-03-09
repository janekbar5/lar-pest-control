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

class Client extends Model implements Auditable, Searchable
//class Client extends Authenticatable implements Auditable, Searchable
{
    use \OwenIt\Auditing\Auditable;  //Audit Log
    use SoftDeletes;
	/////////////////////////////////////////////////////////////
	
	protected $fillable = [  
        //'user_id',
        //'client_id',        
        'active','phone','name','email','client_type','contract_number','vat_number','person_name','contract_start','contract_end',
		'description','reccurence',
		
		
		
    ];
    /////////////////////////////////////////////////////////////For typehead search
    protected $appends = ['text','locationscount','reccurence'];
    public function getTextAttribute()
    {
        return $this->attributes['name']. ' - '
		.$this->attributes['person_name']. ' - '
		.$this->attributes['email']. ' - '
		.$this->attributes['contract_number']. ' - '
		.$this->attributes['vat_number'];
    }
	//////////////////////////////////////////Soft delete	
    protected $dates = ['deleted_at'];
	////////////////////////////////////////////Multiple search models
    public function getSearchResult(): SearchResult
    {
       $url = route('home.search', $this->id);         
       return new SearchResult($this, $this->company_name, $url);
    }
	
	
	function getLocationscountAttribute() {
		return $this->locations->count();
	}
	function getReccurenceAttribute() {
		return $this->reccurences->title;
	}
	
	
	
	public function locations()
    {
        //return $this->belongsToMany(Task::class, 'task_user', 'task_id', 'user_id');
        return $this->belongsToMany(Location::class,'client_location', 'client_id', 'location_id');
    }
	////////////////////////////////////////////////////////////////belongsTo
    
    public function reccurences()
    {
        return $this->belongsTo('App\Reccurence', 'reccurence_id');		
    }
}
