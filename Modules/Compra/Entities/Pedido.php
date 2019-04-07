<?php


namespace Modules\Compra\Entities;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $table = 'pedido';
    public $timestamps = true;
    protected $fillable = array('id','status');

    //Relação com a tabela ListaCompra
    public function itens(){
        return $this->belongsToMany('Modules\Compra\Entities\ItemCompra','item_compra_has_pedido');

    }

    //Relação com a tabela Orcamento
    
    public function orcamentos(){
        return $this->belongsToMany('Modules\Compra\Entities\Orcamento','orcamento_has_pedido');
    }

    
   

}
