<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comprobante extends Model
{
    protected $table = 'comprobante';
	protected $fillable = [
		'id',
		'Serie',
		'Glosa',
		'Fecha',
		'TipoCambio',
		'Estado',
		'TipoComprobante',
		'IdMoneda',
		'IdUsuario',
		'IdEmpresa'
	];
}
