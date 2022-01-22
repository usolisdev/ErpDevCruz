<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Moneda extends Model
{
    protected $table = 'moneda';
	protected $fillable = [
		'id',
		'Nombre',
		'Descripcion',
		'Abreviatura',
		'IdUsuario'
	];
}
