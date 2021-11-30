<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $table = 'empresa';
	protected $fillable = [
		'id',
		'Nombre',
		'Nit',
		'Sigla',
		'Telefono',
		'Correo',
		'Direccion',
		'Niveles',
		'Session',
		'estado',
		'IdUsuario'
	];
}
