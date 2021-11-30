<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmpresaMoneda extends Model
{
    protected $table = 'empresamoneda';
	protected $fillable = [
		'id',
		'Cambio',
		'Activo',
		'FechaRegistro',
		'IdEmpresa',
		'IdMonedaPrincipal',
		'IdMonedaAlternativa',
		'IdUsuario'
	];
}
