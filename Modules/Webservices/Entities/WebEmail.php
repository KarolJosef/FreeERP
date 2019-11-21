<?php

namespace Modules\Webservices\Entities;

use Illuminate\Database\Eloquent\Model;

class WebEmail extends Model
{  protected $table = 'web_email';
   public $timestamps = true;
   protected $fillable = ['id','email'];

   public function webservice(){
     return $this->belongsToMany('App\Webservices\Entities\WebService','web_service_has_web_mail');
    }
}
