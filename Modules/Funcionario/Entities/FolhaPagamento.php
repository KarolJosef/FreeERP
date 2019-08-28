<?php

namespace Modules\Funcionario\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FolhaPagamento extends Model
{
    use SoftDeletes;

    protected $table = 'folha_pagamento';

    protected $fillable = ['salario', 'horas_extras', 'adicional_noturno', 
                           'inss', 'faltas', 'emissao', 'tipo_pagamento', 'funcionario_id'];

    public $timestamps = false;

    public function funcionario()
    {
        return $this->belongsTo('Modules\Funcionario\Entities\Funcionario','funcionario_id');
    }


}