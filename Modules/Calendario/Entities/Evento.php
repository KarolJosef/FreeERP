<?php

namespace Modules\Calendario\Entities;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Carbon;

class Evento extends Model
{
    protected $table = 'evento';
    protected $dates = [
        'data_inicio', 'data_fim'
    ];

    public function agenda(){
        return $this->belongsTo('Modules\Calendario\Entities\Agenda');
    }

    public function notificacao(){
        return $this->hasOne('Modules\Calendario\Entities\Notificacao');
    }

    public function convites(){
        return $this->hasMany('Modules\Calendario\Entities\Convite');
    }
}
