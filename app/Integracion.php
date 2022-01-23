<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Integracion extends Model
{
    protected $table = 'integracion';
	protected $fillable = [
		'id',
		'Caja',
		'Credito_Fiscal',
		'Debito_Fiscal',
		'Compras',
		'IT',
		'IT_por_pagar',
		'Ventas',
		'estado',
		'FechaRegistro',
		'IdEmpresa',
		'IdUsuario'
	];
}
