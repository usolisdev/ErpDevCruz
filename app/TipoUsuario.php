<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoUsuario extends Model
{
    protected $table = 'tipousuario';
	protected $fillable = [
		'id',
		'Tipo'
	];
}
