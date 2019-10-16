<?php

namespace Modules\OrdemServico\Entities;

use Illuminate\Database\Eloquent\Model;

class Solicitante extends Model
{
    public $timestamps = false;
    protected $table = 'solicitante';
    protected $fillable = array('nome','email','endereco_id');

    //relaçoes
    public function ordens_servico(){
        return $this->hasMany('Modules\OrdemServico\Entities\OrdemServico');
    }

    public function endereco(){
        return $this->hasOne('Modules\OrdemServico\Entities\Endereco');
    }

    public function telefones(){
        return $this->hasMany('Modules\OrdemServico\Entities\Telefone');
    }   
}
