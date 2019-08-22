<?php

namespace Modules\Cliente\Entities;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = "cliente";    
    protected $fillable = ['nome', 'tipo_cliente_id','documento_id', 'endereco_id', 'email_id'];
    

    public function tipo(){
        return $this->belongsTo('Modules\Cliente\Entities\TipoCliente');
    }

    public function telefones(){
        return $this->belongsToMany('App\Entities\Telefone', 'cliente_has_telefone');
    }

    public function documento(){
        return $this->belongsTo('App\Entities\Documento');
    }

    public function email(){
        return $this->belongsTo('App\Entities\Email');
    }

    public function endereco(){
        return $this->belongsTo('App\Entities\Endereco');
    }

    public function pedido(){
        return $this->hasMany('Modules\Cliente\Entities\Pedido');
    }

    

}
