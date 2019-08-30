<?php

namespace Modules\OrdemServico\Entities;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tecnico extends Model
{
    Use SoftDeletes;
    protected $table = 'tecnico';
    public $timestamps = true;
    protected $fillable = array('nome');

    public function ordem_servico(){
        return $this->hasMany('Modules\OrdemServico\Entities\OrdemServico');
    }

}
