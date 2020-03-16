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

class Location extends Model implements Auditable, Searchable
{
    use \OwenIt\Auditing\Auditable;
	use SoftDeletes;
	//////////////////////////////////////////
	protected $dates = ['deleted_at'];
	//////////////////////////////////////////////////////////////Multiple searches
    public function getSearchResult(): SearchResult
    {
       $url = route('home.search', $this->id);         
       return new SearchResult($this, $this->title, $url);
    }
    /////////////////////////////////////////////////////////////For loocation typehead search
    protected $appends = [
	'text','address_line1','address_line2','city','postcode','lat','lng'
	];
    public function getTextAttribute()
	{        
		return $this->title_t;
    }
	public function getAddressline1Attribute()
	{        
		return $this->address->address_line1;
    }
	public function getAddressline2Attribute()
	{        
		return $this->address->address_line2;
    }
	public function getCityAttribute()
	{        
		return $this->address->city;
    }
	public function getPostcodeAttribute()
	{        
		return $this->address->postcode;
    }
	public function getLatAttribute()
	{        
		return $this->address->lat;
    }
	public function getLngAttribute()
	{        
		return $this->address->lng;
    }
	
	

    protected $fillable = [  
                'user_id',
                'client_id',
                'title_t',
                'description',
				'surface_n',
				'price_n',
                
    ];
    ////////////////////////////////////////////////////////////////BELONGSTOMANY PIVOT
    // Location-->belongsToMany-->Treatment   <==>  Treatment-->belongsToMany-->Location
    public function treatments()
    {
        return $this->belongsToMany(Treatment::class, 'location_treatment', 'location_id', 'treatment_id');
        //return $this->belongsToMany(Treatment::class);
    }
	public function clients()
    {
        //return $this->belongsToMany(Task::class, 'task_user', 'task_id', 'user_id');
        return $this->belongsToMany(Client::class, 'client_location', 'client_id', 'location_id');
    }
	 
    ////////////////////////////////////////////////////////////////HASMANY
    // Task-->hasMany-->Location   <==>  Location-->belongsTo-->Task
    public function tasks()
    {
	return $this->HasMany('App\Task');	
    }
    
    ////////////////////////////////////////////////////////////////BELONGSTO
    // Location-->belongsTo-->Client   <==>  Client-->hasMany-->Location
    /* public function clients()
    {
        return $this->belongsTo('App\Client', 'client_id');		
    } */

    /////////////////////////////////////////////////////////////Address
    public function address()
    {
        return $this->morphOne('App\Address', 'addressable');
    }
   
}
