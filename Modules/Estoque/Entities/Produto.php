<?php

namespace Modules\Estoque\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Produto extends Model
{
    use softDeletes;

    protected $table = 'produto';
    protected $fillable = ['nome', 'preco_venda', 'descricao', 'categoria_id', 'unidade_id'];

    public function categoria(){
        return $this->hasOne('Modules\Estoque\Entities\Categoria');
    }

    public function unidade() {
        return $this->hasOne('Modules\Estoque\Entities\UnidadeProduto');
    }

}