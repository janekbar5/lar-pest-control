<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Image extends Model
//class Image extends Model implements Auditable
{

    
    // public function Auditable::audits();
    // public function Auditable::setAuditEvent(); 
    // public function Auditable::getAuditEvent();

    protected $fillable = [
//        'property_id',
//        'user_id',
//        'file_name',
//        'file_size',
//        'file_mime',
//        'file_path',
//        'image_order',
        'photoable_type',
        'photoable_id',
        'user_id',
        'user_id',
        'path',
        'image_order',
        
    ];

    public function properties()
    {
        return $this->belongsTo('App\Image');
    }

}
