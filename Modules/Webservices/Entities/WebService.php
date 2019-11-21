<?php

namespace Modules\Webservices\Entities;

use Illuminate\Database\Eloquent\Model;

class WebService extends Model
{	
	protected $table = 'web_service';
    public $timestamps = true;
    protected $fillable = ['id','codigo'];

    public function emailweb(){
     return $this->belongsToMany('Modules\Webservices\Entities\WebEmail','web_service_has_web_email');
 }

   

}
