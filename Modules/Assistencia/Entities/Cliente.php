<?php

namespace Modules\Assistencia\Entities;

use Illuminate\Database\Eloquent\Model;

class cliente extends Model
{
  protected $table = 'cliente';
  protected $fillable = ['id','nome','cpf','email','data_nascimento','sexo','celnumero','telefonenumero'];
}
