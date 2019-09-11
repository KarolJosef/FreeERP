<?php

namespace Modules\Estoque\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Estoque extends Model
{
    use SoftDeletes;
    protected $fillable = ['quantidade','tipo_unidade_id'];
    protected $table = 'estoque';

    public function produtos()
    {
        return $this->belongsToMany('Modules\Estoque\Entities\Produto', 'estoque_has_produto','estoque_id','produto_id');
    }
    public function tipoUnidade()
    {
        return $this->belongsTo('Modules\Estoque\Entities\TipoUnidade');
    }

    public function movimentacaoEstoque()
    {
        return $this->hasMany('Modules\Estoque\Entities\MovimentacaoEstoque' );
    }
}