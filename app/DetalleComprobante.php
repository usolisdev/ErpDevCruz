<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleComprobante extends Model
{
    protected $table = 'detallecomprobante';
	protected $fillable = [
		'id',
		'Numero',
		'Glosa',
		'MontoDebe',
		'MontoHacer',
		'MontoDebeAlt',
		'MontoHacerAlt',
		'TipoCambio',
		'IdCuenta',
		'IdUsuario',
		'IdComprobante'
	];
}
