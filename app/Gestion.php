<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gestion extends Model
{
    protected $table = 'gestion';
	protected $fillable = [
		'id',
		'Nombre',
		'FechaInicio',
		'FechaFin',
		'Estado',
		'IdUsuario',
		'IdEmpresa'
	];
}
