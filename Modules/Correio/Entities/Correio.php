<?php

namespace Modules\Correio\Entities;

use Illuminate\Database\Eloquent\Model;

class Correio extends Model
{	
	protected $table = 'correio';
    public $timestamps = true;
    protected $fillable = ['id','objeto','descricao','linhas','isToNotify'];
}
