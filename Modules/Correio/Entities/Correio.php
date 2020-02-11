<?php

namespace Modules\Correio\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Notifications\newWasPublished;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\Correio as Authenticatable;
use NotificationChannels\Twitter\TwitterDirectMessage;




class Correio extends Model
{	
	protected $table = 'correio';
    public $timestamps = true;
    protected $fillable = ['id','objeto','descricao','linhas','isToNotify','ultimaAtualizacao','isToNotifyTw'];



    
}
