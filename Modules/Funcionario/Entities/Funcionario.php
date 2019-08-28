<?php
namespace Modules\Funcionario\Entities;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Funcionario\Entities\Cargo;


class Funcionario extends Model {
    
    protected $table = 'funcionario';
    protected $fillable = ['nome', 'data_nascimento', 'sexo', 'data_admissao', 'estado_civil_id', 'email_id', 'endereco_id'];
    use SoftDeletes;
    public function estado_civil(){
        return $this->belongsTo('App\Entities\EstadoCivil');
    }
    public function email(){
        return $this->belongTo('App\Entities\Email');
    }
    public function endereco(){
        return $this->belongsTo('App\Entities\Endereco');
    }
    public function dependente(){
        return $this->hasMany('Modules\Entities\Dependente');
    }
    public function telefone(){
        return $this->hasMany('Modules\Entities\Telefone');
    }
    public function documento(){
        return $this->hasMany('App\Entities\Documento');
    }
    public function cargos(){
        return $this->belongsToMany('Modules\Funcionario\Entities\Cargo', 'historico_cargo')->withPivot('data_entrada');
    }

}