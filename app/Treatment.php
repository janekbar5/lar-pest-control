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

class Treatment extends Model implements Auditable, Searchable
//class Treatment extends Model implements Searchable
{

   
    use \OwenIt\Auditing\Auditable;  //Audit Log
    use SoftDeletes;
	//////////////////////////////////////////
	protected $dates = ['deleted_at'];

	//////////////////////////////////////////////////////////////Multiple searches
    public function getSearchResult(): SearchResult
    {
       $url = route('home.search', $this->id);         
       return new SearchResult($this, $this->title, $url);
    }
    /////////////////////////////////////////////////////////////For typehead search
    protected $appends = ['text'];
    public function getTextAttribute()
    {
        return $this->attributes['title'];
    }
	
	
	
	
	
	
	
    protected $fillable = [
	    'user_id',        
		'title',
		//'description',       
    ];
}
