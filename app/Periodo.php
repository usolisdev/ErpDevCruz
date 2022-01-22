<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Periodo extends Model
{
    protected $table = 'periodo';
	protected $fillable = [
		'id',
		'Nombre',
		'FechaInicio',
		'FechaFin',
		'Estado',
		'IdUsuario',
		'IdGestion'
	];
}
