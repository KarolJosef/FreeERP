<?php

namespace Modules\Compra\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fornecedor extends Model
{
    Use SoftDeletes;
    protected $table = 'fornecedor';
    public $timestamps = true;
    protected $fillable = array('id', 'nome_fornecedor', 'email', 'endereco', 'telefone');


    //Relação com a tabela Orcamento
    public function orcamentos(){
        return $this->hasMany('Modules\Compra\Entities\Orcamento');
    }
}