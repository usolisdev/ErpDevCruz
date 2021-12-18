<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $table = 'users';
	protected $fillable = [
		'id',
		'idempresa',
		'name',
		'nombre',
		'apellido',
		'telefono',
		'cargo',
		'email',
		'Password',
		'TipoUsuario'
	];
}
